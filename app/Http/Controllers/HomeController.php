<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\RecommendationService;

class HomeController extends Controller
{
    protected RecommendationService $recommendationService;

    public function __construct(
        RecommendationService $recommendationService
    ) {
        $this->recommendationService = $recommendationService;
    }

    public function index(Request $request)
    {
        // Ambil kategori
        $kategoris = Kategori::all();
/*
|--------------------------------------------------------------------------
| Destinasi Populer
|--------------------------------------------------------------------------
*/

$query = Destinasi::query();

/*
|--------------------------------------------------------------------------
| Filter Kota
|--------------------------------------------------------------------------
*/

if ($request->filled('kota')) {

    $query->whereIn(
        'kota',
        $request->kota
    );

}

/*
|--------------------------------------------------------------------------
| Filter Kategori
|--------------------------------------------------------------------------
*/

if ($request->filled('kategori')) {

    $query->whereIn(
        'kategori',
        $request->kategori
    );

}

/*
|--------------------------------------------------------------------------
| Filter Budget
|--------------------------------------------------------------------------
*/

if ($request->filled('budget')) {

    switch ($request->budget) {

        case 'Gratis':

            $query->where('harga', 0);

            break;

        case 'Murah':

            $query
                ->where('harga', '>', 0)
                ->where('harga', '<=', 50000);

            break;

        case 'Sedang':

            $query
                ->where('harga', '>', 50000)
                ->where('harga', '<=', 150000);

            break;

        case 'Mahal':

            $query
                ->where('harga', '>', 150000);

            break;

    }

}

/*
|--------------------------------------------------------------------------
| Filter Hidden Gem
|--------------------------------------------------------------------------
*/

if ($request->filled('hidden_gem')) {

    $query->where(
        'hidden_gem',
        1
    );

}

/*
|--------------------------------------------------------------------------
| Ambil Destinasi
|--------------------------------------------------------------------------
*/

$destinasiPopuler = $query
    ->withAvg('ratings', 'skor_rating')
    ->withCount('ratings')
    ->inRandomOrder()
    ->limit(6)
    ->get();




    
        // Default jika belum login
        $recommendations = collect();

        if (Auth::check()) {

            $userId = Auth::id();

            // STEP 1 - Corpus
            $corpus = $this->recommendationService
                ->buildCorpus($userId);

            // STEP 2 - Tokenisasi
            $documents = $this->recommendationService
                ->tokenizeCorpus($corpus);

            // STEP 3 - Vocabulary
            $vocabulary = $this->recommendationService
                ->buildVocabulary($documents);

            // STEP 4 - Word Frequency
            $wordFrequency = $this->recommendationService
                ->calculateWordFrequency($documents);

            // STEP 5 - TF
            $tf = $this->recommendationService
                ->calculateTermFrequency($wordFrequency);

            // STEP 6 - DF
            $df = $this->recommendationService
                ->calculateDocumentFrequency(
                    $documents,
                    $vocabulary
                );

            // STEP 7 - IDF
            $idf = $this->recommendationService
                ->calculateInverseDocumentFrequency(
                    $df,
                    count($documents)
                );

            // STEP 8 - TF-IDF
            $tfidf = $this->recommendationService
                ->calculateTfIdfMatrix(
                    $tf,
                    $idf
                );

            // STEP 9 - Cosine Similarity
            $similarity = $this->recommendationService
                ->calculateAllCosineSimilarity(
                    $tfidf
                );

            // STEP 10 - Ranking
            $ranking = $this->recommendationService
                ->rankRecommendations(
                    $similarity
                );

            // STEP 11 - Top 6 Recommendation
            $topRecommendations = $this->recommendationService
                ->getTopRecommendations(
                    $ranking,
                    6
                );

            // STEP 12 - Ambil data lengkap destinasi
            $recommendations = $this->recommendationService
                ->getRecommendationResults(
                    $topRecommendations
                );
        }

        return view(
            'home',
            compact(
                'kategoris',
                'destinasiPopuler',
                'recommendations'
            )
        );
    }
}