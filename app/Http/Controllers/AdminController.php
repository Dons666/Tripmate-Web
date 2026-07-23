<?php

namespace App\Http\Controllers;

use App\Models\Destinasi;
use App\Models\Rating;
use App\Models\User;
use App\Models\Appeal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller Khusus Admin Panel
 * --------------------------------------------------------------------------
 * Mengelola seluruh fungsi manajemen admin, mencakup:
 * 1. Dashboard Statistik & Notifikasi Pengajuan Banding Akun
 * 2. CRUD Tempat (Wisata, Kuliner, Penginapan)
 * 3. Moderasi Komentar & Pengiriman Teguran Member
 * 4. Pengelolaan Akun Member & Penonaktifan Akun (dengan alasan)
 * 5. Persetujuan & Penolakan Pengajuan Banding Akun
 */
class AdminController extends Controller
{
    private const DEACTIVATION_REASONS = [
        'spam' => 'Spam atau promosi berlebihan',
        'abuse' => 'Bahasa kasar / pelecehan',
        'fraud' => 'Indikasi akun palsu / penipuan',
        'other' => 'Lainnya',
    ];

    /**
     * Halaman Dashboard Utama Admin
     * Menampilkan statistik total data dan kotak notifikasi pengajuan banding.
     */
    public function dashboard()
    {
        $destinationCount = Destinasi::where('tipe', 'wisata')->count();
        $culinaryCount = Destinasi::where('tipe', 'kuliner')->count();
        $stayCount = Destinasi::where('tipe', 'penginapan')->count();
        $commentCount = Rating::count();

        $topPlaces = Destinasi::withCount('ratings')
            ->withAvg('ratings', 'skor_rating')
            ->having('ratings_count', '>', 0)
            ->orderByDesc('ratings_avg_skor_rating')
            ->orderByDesc('ratings_count')
            ->limit(3)
            ->get()
            ->map(function (Destinasi $item) {
                return [
                    'type' => $this->labelForType($item->tipe),
                    'type_class' => $this->classForType($item->tipe),
                    'name' => $item->name,
                    'rating' => (float) ($item->ratings_avg_skor_rating ?? 0),
                    'comments_count' => (int) ($item->ratings_count ?? 0),
                    'detail_url' => $this->detailRouteForType($item),
                ];
            });

        // Ambil data pengajuan banding akun dari pengguna
        $appeals = Appeal::with('user')->latest()->get();

        $notifications = $appeals->map(function (Appeal $appeal) {
            return [
                'id' => $appeal->id,
                'title' => 'Pengajuan Banding Akun',
                'user_name' => $appeal->user?->name ?? $appeal->email,
                'user_email' => $appeal->email,
                'reason' => $appeal->reason,
                'status' => $appeal->status,
                'is_unread' => !$appeal->is_read,
                'time' => $appeal->created_at?->diffForHumans() ?? '-',
                'message' => 'Member (' . $appeal->email . ') mengajukan banding: "' . $appeal->reason . '"',
            ];
        });

        $unreadNotificationCount = Appeal::where('is_read', false)->count();

        return view('admin.adminDashboard', [
            'destinationCount' => $destinationCount,
            'culinaryCount' => $culinaryCount,
            'stayCount' => $stayCount,
            'commentCount' => $commentCount,
            'topPlaces' => $topPlaces,
            'notifications' => $notifications,
            'unreadNotificationCount' => $unreadNotificationCount,
        ]);
    }

    public function placesIndex()
    {
        $destinations = $this->queryByType('wisata');
        $culinary = $this->queryByType('kuliner');
        $stays = $this->queryByType('penginapan');

        return view('admin.managePlaces', [
            'destinationCount' => $destinations->count(),
            'culinaryCount' => $culinary->count(),
            'stayCount' => $stays->count(),
            'destinations' => $destinations,
            'culinary' => $culinary,
            'stays' => $stays,
        ]);
    }

    public function createDestination()
    {
        return view('admin.destinations.form', [
            'destination' => new Destinasi(),
            'isEdit' => false,
        ]);
    }

    public function storeDestination(Request $request): RedirectResponse
    {
        $data = $this->validatePlaceRequest($request, true);
        $place = new Destinasi();
        $this->fillPlace($place, $data, 'wisata', true);

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Destinasi berhasil ditambahkan.');
    }

    public function showDestination(Destinasi $destination)
    {
        $this->ensureType($destination, 'wisata');

        return view('admin.destinations.show', ['destination' => $destination]);
    }

    public function editDestination(Destinasi $destination)
    {
        $this->ensureType($destination, 'wisata');

        return view('admin.destinations.form', [
            'destination' => $destination,
            'isEdit' => true,
        ]);
    }

    public function updateDestination(Request $request, Destinasi $destination): RedirectResponse
    {
        $this->ensureType($destination, 'wisata');
        $data = $this->validatePlaceRequest($request, false);
        $this->fillPlace($destination, $data, 'wisata', false);

        return redirect()
            ->route('admin.destinations.show', $destination)
            ->with('success', 'Destinasi berhasil diperbarui.');
    }

    public function destroyDestination(Destinasi $destination): RedirectResponse
    {
        $this->ensureType($destination, 'wisata');
        $destination->delete();

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Destinasi berhasil dihapus.');
    }

    public function createCulinary()
    {
        return view('admin.culinaries.form', [
            'culinary' => new Destinasi(),
            'isEdit' => false,
        ]);
    }

    public function storeCulinary(Request $request): RedirectResponse
    {
        $data = $this->validatePlaceRequest($request, true, true);
        $place = new Destinasi();
        $this->fillPlace($place, $data, 'kuliner', true);

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Data kuliner berhasil ditambahkan.');
    }

    public function showCulinary(Destinasi $culinary)
    {
        $this->ensureType($culinary, 'kuliner');

        return view('admin.culinaries.show', ['culinary' => $culinary]);
    }

    public function editCulinary(Destinasi $culinary)
    {
        $this->ensureType($culinary, 'kuliner');

        return view('admin.culinaries.form', [
            'culinary' => $culinary,
            'isEdit' => true,
        ]);
    }

    public function updateCulinary(Request $request, Destinasi $culinary): RedirectResponse
    {
        $this->ensureType($culinary, 'kuliner');
        $data = $this->validatePlaceRequest($request, false, true);
        $this->fillPlace($culinary, $data, 'kuliner', false);

        return redirect()
            ->route('admin.culinaries.show', $culinary)
            ->with('success', 'Data kuliner berhasil diperbarui.');
    }

    public function destroyCulinary(Destinasi $culinary): RedirectResponse
    {
        $this->ensureType($culinary, 'kuliner');
        $culinary->delete();

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Data kuliner berhasil dihapus.');
    }

    public function createStay()
    {
        return view('admin.stays.form', [
            'stay' => new Destinasi(),
            'isEdit' => false,
        ]);
    }

    public function storeStay(Request $request): RedirectResponse
    {
        $data = $this->validatePlaceRequest($request, true);
        $place = new Destinasi();
        $this->fillPlace($place, $data, 'penginapan', true);

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Data penginapan berhasil ditambahkan.');
    }

    public function showStay(Destinasi $stay)
    {
        $this->ensureType($stay, 'penginapan');

        return view('admin.stays.show', ['stay' => $stay]);
    }

    public function editStay(Destinasi $stay)
    {
        $this->ensureType($stay, 'penginapan');

        return view('admin.stays.form', [
            'stay' => $stay,
            'isEdit' => true,
        ]);
    }

    public function updateStay(Request $request, Destinasi $stay): RedirectResponse
    {
        $this->ensureType($stay, 'penginapan');
        $data = $this->validatePlaceRequest($request, false);
        $this->fillPlace($stay, $data, 'penginapan', false);

        return redirect()
            ->route('admin.stays.show', $stay)
            ->with('success', 'Data penginapan berhasil diperbarui.');
    }

    public function destroyStay(Destinasi $stay): RedirectResponse
    {
        $this->ensureType($stay, 'penginapan');
        $stay->delete();

        return redirect()
            ->route('admin.places.index')
            ->with('success', 'Data penginapan berhasil dihapus.');
    }

    public function commentsIndex()
    {
        $comments = Rating::with(['user', 'destinasi'])
            ->latest()
            ->paginate(10)
            ->through(function (Rating $rating) {
                $rating->setAttribute('review', $rating->komentar);
                $rating->setAttribute('rating', $rating->skor_rating);
                $rating->setAttribute('rateable', $rating->destinasi);
                $rating->setAttribute('rateable_type', $this->labelForType($rating->destinasi?->tipe));

                return $rating;
            });

        return view('admin.comments.index', [
            'comments' => $comments,
            'maxWarningCount' => 3,
        ]);
    }

    public function destroyComment(Rating $comment): RedirectResponse
    {
        $comment->delete();

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Komentar berhasil dihapus.');
    }

    public function sendWarning(Rating $comment): RedirectResponse
    {
        $user = $comment->user;

        if (!$user) {
            return back()->withErrors(['warning' => 'Member tidak ditemukan untuk komentar ini.']);
        }

        $user->warning_count = (int) ($user->warning_count ?? 0) + 1;
        $user->save();

        return back()->with('success', 'Peringatan berhasil dikirim.');
    }

    public function usersIndex()
    {
        return view('admin.users.index', [
            'users' => User::orderByDesc('id')->paginate(10),
            'deactivationReasons' => self::DEACTIVATION_REASONS,
        ]);
    }

    public function storeUser(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:member,admin,user'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $data['role'] === 'member' ? 'user' : $data['role'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function resetUserPassword(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('success', 'Password pengguna berhasil direset.');
    }

    public function updateUserStatus(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'is_active' => ['required', 'boolean'],
            'reason_code' => ['nullable', 'in:' . implode(',', array_keys(self::DEACTIVATION_REASONS))],
            'reason_detail' => ['nullable', 'string', 'min:10', 'max:1000'],
        ]);

        $user->is_active = (bool) $data['is_active'];

        if ($user->is_active) {
            $user->deactivation_reason_code = null;
            $user->deactivation_reason_detail = null;
        } else {
            $user->deactivation_reason_code = $data['reason_code'] ?? 'other';
            $user->deactivation_reason_detail = $data['reason_detail'] ?? null;
        }

        if ($user->id === Auth::id() && !$user->is_active) {
            return back()->withErrors(['is_active' => 'Akun admin aktif tidak dapat menonaktifkan dirinya sendiri.']);
        }

        $user->save();

        return back()->with('success', 'Status pengguna berhasil diperbarui.');
    }

    public function logs()
    {
        return view('admin.logs.index', [
            'logs' => new LengthAwarePaginator([], 0, 10, 1, [
                'path' => request()->url(),
                'query' => request()->query(),
            ]),
        ]);
    }

    public function appealsIndex(Request $request)
    {
        $query = Appeal::with('user')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $appeals = $query->paginate(10)->withQueryString();

        $pendingCount = Appeal::where('status', 'pending')->count();
        $approvedCount = Appeal::where('status', 'approved')->count();
        $rejectedCount = Appeal::where('status', 'rejected')->count();
        $totalCount = Appeal::count();

        // Mark visible unread appeals as read
        Appeal::where('is_read', false)->update(['is_read' => true]);

        return view('admin.appeals.index', compact(
            'appeals',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'totalCount'
        ));
    }

    public function approveAppeal(Appeal $appeal): RedirectResponse
    {
        $user = $appeal->user;

        if ($user) {
            $user->is_active = true;
            $user->deactivation_reason_code = null;
            $user->deactivation_reason_detail = null;
            $user->save();
        }

        $appeal->status = 'approved';
        $appeal->is_read = true;
        $appeal->save();

        return back()->with('success', 'Pengajuan banding disetujui. Akun pengguna (' . ($user?->email ?? $appeal->email) . ') telah diaktifkan kembali.');
    }

    public function rejectAppeal(Appeal $appeal): RedirectResponse
    {
        $appeal->status = 'rejected';
        $appeal->is_read = true;
        $appeal->save();

        return back()->with('success', 'Pengajuan banding telah ditolak.');
    }

    public function markAllNotificationsRead(): RedirectResponse
    {
        Appeal::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi pengajuan banding ditandai sudah dibaca.');
    }

    private function queryByType(string $type)
    {
        return Destinasi::where('tipe', $type)
            ->withCount('ratings')
            ->withAvg('ratings', 'skor_rating')
            ->orderByDesc('updated_at')
            ->get();
    }

    private function validatePlaceRequest(Request $request, bool $requireDescription, bool $isCulinary = false): array
    {
        $descriptionRule = $requireDescription ? 'required|string' : 'nullable|string';

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'place_address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'price_option' => ['required', 'in:gratis,berbayar'],
            'price_custom' => ['nullable', 'numeric', 'min:0'],
            'image_files.*' => ['nullable', 'image', 'max:4096'],
            'transport_modes' => ['nullable', 'array'],
            'transport_modes.*' => ['string', 'max:50'],
            'status_lokasi' => ['required', 'in:terkenal,hidden gem'],
            'description' => $descriptionRule,
            'operational_schedule' => ['nullable', 'array'],
            'operational_schedule.*.status' => ['nullable', 'in:open,closed'],
            'operational_schedule.*.open_time' => ['nullable', 'date_format:H:i'],
            'operational_schedule.*.close_time' => ['nullable', 'date_format:H:i'],
        ];

        if ($isCulinary) {
            $rules['cuisine_type'] = ['required', 'string', 'max:255'];
            $rules['amenities'] = ['nullable', 'array'];
            $rules['amenities.*'] = ['string', 'max:120'];
        } else {
            $rules['category'] = ['required', 'string', 'max:255'];
            $rules['amenities'] = ['nullable', 'array'];
            $rules['amenities.*'] = ['string', 'max:120'];
        }

        return $request->validate($rules);
    }

    private function fillPlace(Destinasi $place, array $data, string $type, bool $isCreate): void
    {
        $price = $data['price_option'] === 'gratis' ? 0 : (float) ($data['price_custom'] ?? 0);
        $category = $type === 'kuliner' ? $data['cuisine_type'] : $data['category'];
        $transport = isset($data['transport_modes']) ? implode(', ', $data['transport_modes']) : null;
        $amenities = isset($data['amenities']) ? implode(', ', $data['amenities']) : null;

        $place->nama_destinasi = $data['name'];
        $place->tipe = $type;
        $place->kota = $data['city'];
        $place->kategori = $category;
        $place->harga = $price;
        $place->hidden_gem = $data['status_lokasi'] === 'hidden gem';
        $place->deskripsi = $data['description'] ?? null;
        $place->fasilitas = $amenities;
        $place->alamat = $this->encodeAddress($data['place_address'], $data['province'] ?? null);
        $place->latitude = $data['latitude'] ?? null;
        $place->longitude = $data['longitude'] ?? null;
        $place->transportasi = $transport;
        $place->hari_operasional = $this->serializeSchedule($data['operational_schedule'] ?? []);

        if (!empty($data['image_files'])) {
            $paths = [];

            foreach ($data['image_files'] as $image) {
                $paths[] = $image->store('destinasi-images', 'public');
            }

            $place->gambar = json_encode($paths);
        } elseif ($isCreate) {
            $place->gambar = $place->gambar ?: null;
        }

        $place->save();
    }

    private function serializeSchedule(array $schedule): ?string
    {
        if (empty($schedule)) {
            return null;
        }

        $rows = [];

        foreach ($schedule as $day => $item) {
            $status = $item['status'] ?? 'closed';

            if ($status === 'open') {
                $open = $item['open_time'] ?? '00:00';
                $close = $item['close_time'] ?? '23:59';
                $rows[] = $day . ':' . $open . '-' . $close;
            } else {
                $rows[] = $day . ':closed';
            }
        }

        return implode(';', $rows);
    }

    private function encodeAddress(string $address, ?string $province): string
    {
        if (!$province) {
            return $address;
        }

        return $address . '||' . $province;
    }

    private function ensureType(Destinasi $place, string $expectedType): void
    {
        abort_unless($place->tipe === $expectedType, 404);
    }

    private function labelForType(?string $type): string
    {
        return match ($type) {
            'kuliner' => 'Kuliner',
            'penginapan' => 'Penginapan',
            default => 'Destinasi',
        };
    }

    private function classForType(?string $type): string
    {
        return match ($type) {
            'kuliner' => 'type-culinary',
            'penginapan' => 'type-stay',
            default => 'type-destination',
        };
    }

    private function detailRouteForType(Destinasi $item): string
    {
        return match ($item->tipe) {
            'kuliner' => route('admin.culinaries.show', $item),
            'penginapan' => route('admin.stays.show', $item),
            default => route('admin.destinations.show', $item),
        };
    }
}
