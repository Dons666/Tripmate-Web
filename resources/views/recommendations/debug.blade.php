<x-app-layout>

<div class="max-w-7xl mx-auto py-8 px-6">

    <h1 class="text-3xl font-bold mb-8">
        TripMate Recommendation Debug Engine
    </h1>

    <!-- STEP 1 -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Query User
        </h2>

        <div class="bg-gray-100 rounded-lg p-4">

            {{ $query }}

        </div>

    </div>


<!-- STEP 2 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        Candidate Filtering
    </h2>

    <p>
        Total Kandidat :
        <strong>{{ count($candidateFiltering) }}</strong>
    </p>

    <table class="table-auto w-full mt-4 border">

        <thead class="bg-gray-200">
            <tr>
                <th class="border px-2 py-2">ID</th>
                <th class="border px-2 py-2">Nama Destinasi</th>
                <th class="border px-2 py-2">Fitur CBF</th>
            </tr>
        </thead>

       <tbody>

@foreach($candidateFiltering->take(5) as $item)

<tr>

    <td class="border px-2 py-2">
        {{ $item->id }}
    </td>

    <td class="border px-2 py-2">
        {{ $item->nama_destinasi }}
    </td>

    <td class="border px-2 py-2">
        {{ Str::limit($item->fitur_cbf,100) }}
    </td>

</tr>

@endforeach

</tbody>

    </table>

</div>


    <!-- STEP 3 -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Corpus
        </h2>

        <p>
            Total Dokumen :
            <strong>{{ count($corpus) }}</strong>
        </p>

        <table class="table-auto w-full mt-4 border">

            <thead class="bg-gray-200">

                <tr>

                    <th class="border px-2 py-2">ID</th>

                    <th class="border px-2 py-2">Nama</th>

                    <th class="border px-2 py-2">Fitur CBF</th>

                </tr>

            </thead>

            <tbody>

            @foreach(array_slice($corpus,0,5) as $item)

                <tr>

                    <td class="border px-2 py-2">
                        {{ $item['id'] }}
                    </td>

                    <td class="border px-2 py-2">
                        {{ $item['nama_destinasi'] }}
                    </td>

                    <td class="border px-2 py-2">
                        {{ Str::limit($item['fitur_cbf'],100) }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

    <!-- STEP 3 -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <h2 class="text-xl font-bold mb-4">
            Vocabulary
        </h2>

        <p>

            Total Vocabulary :

            <strong>

                {{ count($vocabulary) }}

            </strong>

        </p>

    </div>

    <!-- STEP 4 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        Term Frequency (TF)
    </h2>

    <table class="table-auto w-full border">

        <thead class="bg-gray-200">

            <tr>

                <th class="border px-2 py-2">
                    Dokumen
                </th>

                <th class="border px-2 py-2">
                    Total Kata
                </th>

                <th class="border px-2 py-2">
                    Preview TF
                </th>

            </tr>

        </thead>

        <tbody>

        @foreach(array_slice($tf,0,3) as $item)

            <tr>

                <td class="border px-2 py-2">

                    {{ $item['nama_destinasi'] }}

                </td>

                <td class="border px-2 py-2">

                    {{ $item['total_terms'] }}

                </td>

                <td class="border px-2 py-2">

                    @foreach(array_slice($item['tf'],0,5,true) as $word=>$value)

                        <div>

                            {{ $word }}

                            :

                            {{ number_format($value,6) }}

                        </div>

                    @endforeach

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>


<!-- STEP 5 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        Inverse Document Frequency (IDF)
    </h2>

    <table class="table-auto w-full border">

        <thead class="bg-gray-200">

            <tr>

                <th class="border px-2 py-2">
                    Kata
                </th>

                <th class="border px-2 py-2">
                    Nilai IDF
                </th>

            </tr>

        </thead>

        <tbody>

        @foreach(array_slice($idf,0,20,true) as $word=>$value)

            <tr>

                <td class="border px-2 py-2">

                    {{ $word }}

                </td>

                <td class="border px-2 py-2">

                    {{ number_format($value,6) }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<!-- STEP 6 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">
        TF-IDF Matrix
    </h2>

    @foreach(array_slice($tfidf,0,2) as $document)

        <div class="mb-6">

            <h3 class="font-semibold mb-2">

                {{ $document['nama_destinasi'] }}

            </h3>

            <table class="table-auto w-full border">

                <thead class="bg-gray-200">

                    <tr>

                        <th class="border px-2 py-2">

                            Kata

                        </th>

                        <th class="border px-2 py-2">

                            TF-IDF

                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach(array_slice($document['tfidf'],0,10,true) as $word=>$value)

                    <tr>

                        <td class="border px-2 py-2">

                            {{ $word }}

                        </td>

                        <td class="border px-2 py-2">

                            {{ number_format($value,6) }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    @endforeach

</div>

<!-- STEP 7 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">

        Cosine Similarity

    </h2>

    <table class="table-auto w-full border">

        <thead class="bg-gray-200">

            <tr>

                <th class="border px-2 py-2">

                    Destinasi

                </th>

                <th class="border px-2 py-2">

                    Similarity

                </th>

            </tr>

        </thead>

        <tbody>

        @foreach(array_slice($similarity,0,15) as $item)

            <tr>

                <td class="border px-2 py-2">

                    {{ $item['nama_destinasi'] }}

                </td>

                <td class="border px-2 py-2">

                    {{ number_format($item['score'],6) }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

<!-- STEP 8 -->
<div class="bg-white rounded-xl shadow p-6 mb-8">

    <h2 class="text-xl font-bold mb-4">

        Ranking & Top Recommendation

    </h2>

    <table class="table-auto w-full border">

        <thead class="bg-gray-200">

            <tr>

                <th class="border px-2 py-2">

                    Ranking

                </th>

                <th class="border px-2 py-2">

                    Destinasi

                </th>

                <th class="border px-2 py-2">

                    Similarity

                </th>

            </tr>

        </thead>

        <tbody>

      @foreach($top as $index => $item)

<tr>

    <td class="border px-2 py-2">
        {{ $index + 1 }}
    </td>

    <td class="border px-2 py-2">
        {{ $item['nama_destinasi'] }}
    </td>

    <td class="border px-2 py-2">
        {{ number_format($item['score'],6) }}
    </td>

</tr>

@endforeach

        </tbody>

    </table>

</div>

</div>

</x-app-layout>