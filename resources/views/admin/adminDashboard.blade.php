{{-- 
|--------------------------------------------------------------------------
| HALAMAN ADMIN: Dashboard Utama (Home Admin)
|--------------------------------------------------------------------------
| FUNGSI & KEGUNAAN:
| 1. Menampilkan ringkasan statistik total data destinasi, kuliner, dan penginapan.
| 2. Menampilkan Kotak Notifikasi & Pengajuan Banding Akun dari member yang dinonaktifkan.
| 3. Menyediakan navigasi sidebar untuk mengelola seluruh fitur Admin Panel.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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

        .top-info {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 12px;
            color: #6b7280;
            font-weight: 600;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 26px;
        }

        .admin-header h1 {
            color: #111827;
            font-size: 28px;
        }

        .admin-title {
            color: #e74c3c;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .summary-note {
            color: #6b7280;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .notification-panel {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .notification-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 16px;
        }

        .notification-panel-header h2 {
            color: #111827;
            font-size: 18px;
            margin-bottom: 4px;
        }

        .notification-panel-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .notification-panel-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .notification-badge {
            background: #111827;
            color: #fff;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 700;
        }

        .notification-mark-read {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #111827;
            padding: 8px 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .notification-list {
            display: grid;
            gap: 12px;
        }

        .notification-item {
            border-radius: 12px;
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .notification-item.is-unread {
            background: #eff6ff;
            border-color: #bfdbfe;
        }

        .notification-item-top {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .notification-item p {
            color: #374151;
            font-size: 14px;
            line-height: 1.55;
            margin-bottom: 8px;
        }

        .notification-link {
            color: #b91c1c;
            font-weight: 700;
            text-decoration: none;
        }

        .notification-empty {
            color: #6b7280;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
            padding: 14px 16px;
            border-radius: 12px;
        }

        .notification-warning {
            border-left: 4px solid #f59e0b;
        }

        .notification-danger {
            border-left: 4px solid #dc2626;
        }

        .notification-info {
            border-left: 4px solid #2563eb;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .section-block {
            margin-top: 28px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 16px;
        }

        .section-heading h2 {
            font-size: 20px;
            color: #111827;
        }

        .section-heading p {
            color: #6b7280;
            font-size: 14px;
        }

        .best-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            border-left: 5px solid #e74c3c;
        }

        .stat-card h3 {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .number {
            font-size: 34px;
            font-weight: 700;
            color: #e74c3c;
            line-height: 1;
        }

        .best-card {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e7eb;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .best-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .best-card h3 {
            font-size: 18px;
            color: #111827;
            line-height: 1.35;
        }

        .place-type {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .type-destination {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .type-culinary {
            background: #dcfce7;
            color: #15803d;
        }

        .type-stay {
            background: #fef3c7;
            color: #b45309;
        }

        .best-rating {
            font-size: 28px;
            font-weight: 800;
            color: #e74c3c;
        }

        .best-meta {
            color: #6b7280;
            font-size: 14px;
        }

        .best-link {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 10px;
            background: #111827;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .best-link:hover {
            background: #000;
        }

        .empty-state {
            background: #fff;
            border: 1px dashed #d1d5db;
            border-radius: 14px;
            padding: 20px;
            color: #6b7280;
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
                <a href="{{ route('admin.dashboard') }}" class="active">Home</a>
                <a href="{{ route('admin.places.index') }}">Manage Tempat</a>
                <a href="{{ route('admin.penyedia-travel.index') }}">Kelola Travel</a>
                <a href="{{ route('admin.comments.index') }}">Manage Komentar</a>
                <a href="{{ route('admin.users.index') }}">Manage Member</a>
                <a href="{{ route('admin.appeals.index') }}">Kotak Banding Akun</a>
                <a href="{{ route('admin.logs') }}">Admin Logs</a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah yakin ingin logout?')">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="top-info">{{ Auth::user()->username }}</div>
            <div class="container">
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="admin-header">
                    <div>
                        <span class="admin-title">Administrator</span>
                        <h1>Dashboard</h1>
                    </div>
                </div>

                <p class="summary-note">Ringkasan total data pada sistem.</p>



                @include('partials.notification-box', [
                    'title' => 'Kotak Notifikasi & Pengajuan Banding Akun',
                    'description' => 'Pantau dan kelola pengajuan banding dari pengguna yang akunnya dinonaktifkan.',
                    'notifications' => $notifications,
                    'unreadNotificationCount' => $unreadNotificationCount,
                    'emptyText' => 'Belum ada pengajuan banding akun dari pengguna.',
                    'markAllReadRoute' => route('notifications.mark-all-read'),
                ])

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Destinasi</h3>
                        <div class="number">{{ $destinationCount }}</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Kuliner</h3>
                        <div class="number">{{ $culinaryCount }}</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Penginapan</h3>
                        <div class="number">{{ $stayCount }}</div>
                    </div>
                    <div class="stat-card">
                        <h3>Total Komentar</h3>
                        <div class="number">{{ $commentCount }}</div>
                    </div>
                </div>

                <div class="section-block">
                    <div class="section-heading">
                        <div>
                            <h2>3 Tempat Terbaik</h2>
                            <p>Gabungan destinasi, kuliner, dan penginapan dengan rating tertinggi.</p>
                        </div>
                    </div>

                    @if($topPlaces->count() > 0)
                        <div class="best-grid">
                            @foreach($topPlaces as $place)
                                <div class="best-card">
                                    <div class="best-card-header">
                                        <div>
                                            <span class="place-type {{ $place['type_class'] }}">{{ $place['type'] }}</span>
                                            <h3 style="margin-top: 10px;">{{ $place['name'] }}</h3>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="best-rating">* {{ number_format($place['rating'], 2) }}</div>
                                        <div class="best-meta">{{ $place['comments_count'] }} komentar</div>
                                    </div>

                                    <a href="{{ $place['detail_url'] }}" class="best-link">Lihat Detail</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">Belum ada data rating untuk menampilkan tempat terbaik.</div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>
                                                                                                                                                                