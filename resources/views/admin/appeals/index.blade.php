{{-- 
|--------------------------------------------------------------------------
| HALAMAN ADMIN: Kotak Banding Akun Member
|--------------------------------------------------------------------------
| FUNGSI & KEGUNAAN:
| 1. Memantau seluruh pengajuan banding akun dari pengguna yang dinonaktifkan.
| 2. Menampilkan status pengajuan (Menunggu Review, Disetujui, Ditolak).
| 3. Fitur Setujui & Aktifkan Kembali Akun (otomatis membuka blokir & mengaktifkan is_active=1).
| 4. Fitur Tolak Pengajuan Banding.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak Banding Akun - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .layout {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: #fff;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .brand {
            font-size: 20px;
            font-weight: 700;
            padding: 8px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .menu a,
        .menu button {
            width: 100%;
            text-align: left;
            padding: 11px 12px;
            border-radius: 8px;
            border: none;
            background: transparent;
            color: #d1d5db;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .menu a:hover,
        .menu button:hover,
        .menu .active {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .content {
            flex: 1;
            padding: 28px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #111827;
        }

        .username {
            color: #6b7280;
            font-weight: 600;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(17, 24, 39, 0.08);
            padding: 20px;
            margin-top: 16px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .tab {
            padding: 8px 14px;
            border-radius: 8px;
            background: #f3f4f6;
            color: #4b5563;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .tab:hover,
        .tab.active {
            background: #111827;
            color: #fff;
        }

        .table-scroll {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        thead {
            background: #f9fafb;
        }

        th,
        td {
            padding: 12px 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 14px;
        }

        th {
            color: #374151;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background: #dcfce7;
            color: #166534;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .reason-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            color: #1f2937;
            margin-top: 4px;
            line-height: 1.45;
        }

        .deactivation-info {
            font-size: 12px;
            color: #991b1b;
            margin-bottom: 4px;
        }

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-status {
            border: none;
            border-radius: 6px;
            color: #fff;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-activate {
            background: #166534;
        }

        .btn-activate:hover {
            background: #14532d;
        }

        .btn-deactivate {
            background: #dc2626;
        }

        .btn-deactivate:hover {
            background: #b91c1c;
        }

        .pagination {
            margin-top: 14px;
        }

        .pagination svg {
            width: 16px;
            height: 16px;
            max-width: 16px;
            max-height: 16px;
            display: inline-block;
            vertical-align: middle;
        }

        .pagination nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination nav > div:first-child {
            font-size: 13px;
            color: #6b7280;
        }

        .pagination nav > div:last-child {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination nav a,
        .pagination nav span[aria-current="page"] > span,
        .pagination nav span[aria-disabled="true"] > span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            font-size: 13px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #374151;
            text-decoration: none;
        }

        .pagination nav a:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .pagination nav span[aria-current="page"] > span {
            background: #111827;
            color: #fff;
            border-color: #111827;
            font-weight: 600;
        }

        .pagination nav span[aria-disabled="true"] > span {
            color: #9ca3af;
            background: #f9fafb;
            cursor: not-allowed;
        }

        @media (max-width: 980px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Admin Panel</div>
            <div class="menu">
                <a href="{{ route('admin.dashboard') }}">Home</a>
                <a href="{{ route('admin.places.index') }}">Manage Tempat</a>
                <a href="{{ route('admin.comments.index') }}">Manage Komentar</a>
                <a href="{{ route('admin.users.index') }}">Manage Member</a>
                <a href="{{ route('admin.appeals.index') }}" class="active">Kotak Banding Akun</a>
                <a href="{{ route('admin.logs') }}">Admin Logs</a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah yakin ingin logout?')">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="header">
                <h1>Kotak Banding Akun Member</h1>
                <div class="username">{{ Auth::user()->name ?? Auth::user()->username }}</div>
            </div>

            @if(session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <div class="tabs">
                <a href="{{ route('admin.appeals.index') }}" class="tab {{ !request('status') ? 'active' : '' }}">
                    Semua ({{ $totalCount }})
                </a>
                <a href="{{ route('admin.appeals.index', ['status' => 'pending']) }}" class="tab {{ request('status') === 'pending' ? 'active' : '' }}">
                    Menunggu Review ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.appeals.index', ['status' => 'approved']) }}" class="tab {{ request('status') === 'approved' ? 'active' : '' }}">
                    Disetujui ({{ $approvedCount }})
                </a>
                <a href="{{ route('admin.appeals.index', ['status' => 'rejected']) }}" class="tab {{ request('status') === 'rejected' ? 'active' : '' }}">
                    Ditolak ({{ $rejectedCount }})
                </a>
            </div>

            <div class="card">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Pengguna / Email</th>
                                <th>Alasan & Pesan Banding</th>
                                <th>Status</th>
                                <th>Waktu Pengajuan</th>
                                <th>Aksi Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appeals as $appeal)
                                <tr>
                                    <td>
                                        <strong>{{ $appeal->user?->name ?? 'Pengguna' }}</strong>
                                        <div style="font-size: 12px; color: #6b7280;">{{ $appeal->email }}</div>
                                    </td>
                                    <td>
                                        @if($appeal->user && !empty($appeal->user->deactivation_reason_detail))
                                            <div class="deactivation-info">
                                                ⚠️ Alasan dinonaktifkan: {{ $appeal->user->deactivation_reason_detail }}
                                            </div>
                                        @endif
                                        <div class="reason-box">
                                            "{{ $appeal->reason }}"
                                        </div>
                                    </td>
                                    <td>
                                        @if($appeal->status === 'approved')
                                            <span class="badge badge-approved">Disetujui</span>
                                        @elseif($appeal->status === 'rejected')
                                            <span class="badge badge-rejected">Ditolak</span>
                                        @else
                                            <span class="badge badge-pending">Menunggu Review</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 13px; color: #6b7280; white-space: nowrap;">
                                        {{ $appeal->created_at?->format('d M Y H:i') }}
                                        <div style="font-size: 11px;">({{ $appeal->created_at?->diffForHumans() }})</div>
                                    </td>
                                    <td>
                                        @if($appeal->status === 'pending')
                                            <div class="actions">
                                                <form action="{{ route('admin.appeals.approve', $appeal) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-status btn-activate" onclick="return confirm('Apakah Anda yakin ingin menyetujui banding dan mengaktifkan kembali akun ini?')">
                                                        ✓ Setujui & Aktifkan
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.appeals.reject', $appeal) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-status btn-deactivate" onclick="return confirm('Apakah Anda yakin ingin menolak banding akun ini?')">
                                                        ✕ Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span style="font-size: 12px; color: #9ca3af;">Proses Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #6b7280; padding: 24px;">
                                        Belum ada data pengajuan banding akun.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    {{ $appeals->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
