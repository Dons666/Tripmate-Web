<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiFilterService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    /**
     * Analyze a comment text using Google Gemini AI.
     *
     * @param string|null $text
     * @return array{is_safe: bool, category: string, reason: ?string, confidence: float}
     */
    public function analyzeComment(?string $text): array
    {
        if (empty($text) || trim($text) === '') {
            return [
                'is_safe' => true,
                'category' => 'aman',
                'reason' => null,
                'confidence' => 1.0,
            ];
        }

        if (empty($this->apiKey)) {
            Log::warning('GeminiFilterService: API key is not configured.');
            return $this->fallbackCheck($text);
        }

        $prompt = "Kamu adalah sistem filter dan moderasi komentar otomatis untuk aplikasi TripMate (platform wisata, kuliner, dan penginapan).
Tugasmu adalah menganalisis apakah teks ulasan/komentar berikut layak dipublikasikan atau mengandung konten berbahaya/tidak pantas seperti: toksisitas tinggi, ujaran kebencian, kata-kata sangat kasar/penghinaan berlebihan, spam/iklan penipuan, atau promosi ilegal.

Teks komentar: \"" . addslashes($text) . "\"

Jawab DALAM FORMAT JSON SAJA (tanpa codeblock markdown):
{
  \"is_safe\": true,
  \"category\": \"aman\",
  \"reason\": null,
  \"confidence\": 1.0
}
Catatan:
- Jika aman, 'is_safe' = true, 'category' = 'aman', 'reason' = null.
- Jika terdeteksi tidak pantas/spam/kasar, 'is_safe' = false, 'category' = salah satu dari: ('spam', 'toksisitas', 'ujaran_kebencian', 'bahasa_kasar', 'penipuan'), 'reason' = 'Penjelasan singkat maks 1 kalimat dalam Bahasa Indonesia'.";

        try {
            // Models to try: gemini-2.5-flash, fallback to gemini-1.5-flash
            $models = ['gemini-2.5-flash', 'gemini-1.5-flash'];
            $response = null;

            foreach ($models as $model) {
                $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$this->apiKey}";
                $res = Http::timeout(10)->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ]
                ]);

                if ($res->successful()) {
                    $response = $res;
                    break;
                } else {
                    Log::warning("GeminiFilterService: Model {$model} HTTP error: " . $res->status() . " - " . $res->body());
                }
            }

            if (!$response || !$response->successful()) {
                return $this->fallbackCheck($text);
            }

            $data = $response->json();
            $rawText = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Clean json markdown delimiters if present
            $cleanJson = trim($rawText);
            if (str_starts_with($cleanJson, '```json')) {
                $cleanJson = substr($cleanJson, 7);
            }
            if (str_starts_with($cleanJson, '```')) {
                $cleanJson = substr($cleanJson, 3);
            }
            if (str_ends_with($cleanJson, '```')) {
                $cleanJson = substr($cleanJson, 0, -3);
            }
            $cleanJson = trim($cleanJson);

            $parsed = json_decode($cleanJson, true);

            if (is_array($parsed) && isset($parsed['is_safe'])) {
                return [
                    'is_safe' => (bool) $parsed['is_safe'],
                    'category' => $parsed['category'] ?? ($parsed['is_safe'] ? 'aman' : 'tidak_pantas'),
                    'reason' => $parsed['reason'] ?? ($parsed['is_safe'] ? null : 'Terdeteksi konten tidak pantas oleh AI Gemini.'),
                    'confidence' => (float) ($parsed['confidence'] ?? 0.9),
                ];
            }

            return $this->fallbackCheck($text);

        } catch (\Throwable $e) {
            Log::error('GeminiFilterService Exception: ' . $e->getMessage());
            return $this->fallbackCheck($text);
        }
    }

    /**
     * Basic local fallback filter when Gemini API is unreachable or fails.
     */
    protected function fallbackCheck(string $text): array
    {
        $lowercased = mb_strtolower($text);
        $blockedWords = ['anjing', 'babi', 'kontol', 'memek', 'jancok', 'bangsat', 'goblok', 'slot', 'judi', 'gacor', 'bo', 'open bo'];

        foreach ($blockedWords as $word) {
            if (str_contains($lowercased, $word)) {
                return [
                    'is_safe' => false,
                    'category' => 'bahasa_kasar',
                    'reason' => "Mengandung kata yang dilarang ({$word}).",
                    'confidence' => 0.8,
                ];
            }
        }

        return [
            'is_safe' => true,
            'category' => 'aman',
            'reason' => null,
            'confidence' => 0.5,
        ];
    }
}
