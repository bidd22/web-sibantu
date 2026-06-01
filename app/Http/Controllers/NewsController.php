<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
{
    public function fetch(Request $request)
    {
        $cat = $request->query('cat', 'semua');

        $allowedCats = ['semua', 'bansos', 'ekonomi', 'pendidikan'];
        if (!in_array($cat, $allowedCats)) {
            return response()->json(['error' => 'Kategori tidak valid.'], 422);
        }

        // Cache per kategori selama 30 menit agar tidak terus hit API
        $cacheKey = "sibantu_news_{$cat}";

        $articles = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($cat) {

            $prompts = [
                'semua'      => 'Buat 7 ringkasan berita terkini Indonesia seputar bantuan sosial, ekonomi, dan pendidikan. Variasikan topiknya.',
                'bansos'     => 'Buat 7 ringkasan berita terkini Indonesia seputar program bantuan sosial (bansos), PKH, BLT, BPNT, dan sejenisnya.',
                'ekonomi'    => 'Buat 7 ringkasan berita terkini Indonesia seputar ekonomi: inflasi, UMR, UMKM, lapangan kerja, kemiskinan.',
                'pendidikan' => 'Buat 7 ringkasan berita terkini Indonesia seputar pendidikan: beasiswa, kurikulum, KIP, sekolah gratis.',
            ];

            $prompt = $prompts[$cat] . '

Balas HANYA dengan JSON array, tanpa markdown, tanpa komentar, tanpa penjelasan apapun. Format:
[
  {
    "judul": "Judul berita singkat dan informatif",
    "ringkasan": "2-3 kalimat ringkasan berita yang informatif dan relevan.",
    "kategori": "bansos|ekonomi|pendidikan",
    "waktu": "X jam lalu"
  }
]';

            $response = Http::withHeaders([
                'x-api-key'         => config('services.anthropic.key'),
                'anthropic-version' => '2023-06-01',
                'Content-Type'      => 'application/json',
            ])->timeout(30)->post('https://api.anthropic.com/v1/messages', [
                'model'      => 'claude-haiku-4-5-20251001',
                'max_tokens' => 1200,
                'messages'   => [
                    ['role' => 'user', 'content' => $prompt]
                ],
            ]);

            if ($response->failed()) {
                return null;
            }

            $text = collect($response->json('content', []))
                ->where('type', 'text')
                ->pluck('text')
                ->implode('');

            // Bersihkan markdown fence jika ada
            $clean = preg_replace('/```json|```/', '', $text);
            $clean = trim($clean);

            $decoded = json_decode($clean, true);

            return is_array($decoded) ? $decoded : null;
        });

        if (is_null($articles)) {
            return response()->json(['error' => 'Gagal memuat berita dari AI.'], 502);
        }

        return response()->json($articles);
    }
}