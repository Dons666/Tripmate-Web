<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * List bookmark milik user yang login.
     */
    public function index(Request $request)
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->with('destinasi')
            ->latest()
            ->get()
            ->map(function ($bookmark) {
                return [
                    'id'        => $bookmark->id,
                    'destinasi' => $bookmark->destinasi ? [
                        'id'             => $bookmark->destinasi->id,
                        'nama_destinasi' => $bookmark->destinasi->nama_destinasi,
                        'kota'           => $bookmark->destinasi->kota,
                        'kategori'       => $bookmark->destinasi->kategori,
                        'harga'          => $bookmark->destinasi->harga,
                        'gambar'         => $bookmark->destinasi->image_url,
                        'rating'         => $bookmark->destinasi->rating_destinasi,
                        'latitude'       => $bookmark->destinasi->latitude,
                        'longitude'      => $bookmark->destinasi->longitude,
                    ] : null,
                    'created_at' => $bookmark->created_at,
                ];
            });

        return response()->json($bookmarks);
    }

    /**
     * Toggle bookmark (tambah jika belum ada, hapus jika sudah ada).
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'destinasi_id' => 'required|exists:destinasi,id',
        ]);

        $existing = Bookmark::where('user_id', $request->user()->id)
            ->where('destinasi_id', $request->destinasi_id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'status'     => 'success',
                'bookmarked' => false,
                'message'    => 'Bookmark dihapus.',
            ]);
        }

        $bookmark = Bookmark::create([
            'user_id'      => $request->user()->id,
            'destinasi_id' => $request->destinasi_id,
        ]);

        return response()->json([
            'status'     => 'success',
            'bookmarked' => true,
            'message'    => 'Destinasi dibookmark!',
            'bookmark'   => $bookmark,
        ], 201);
    }

    /**
     * Hapus bookmark berdasarkan ID.
     */
    public function destroy(Request $request, string $id)
    {
        $bookmark = Bookmark::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $bookmark->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Bookmark berhasil dihapus.',
        ]);
    }
}
