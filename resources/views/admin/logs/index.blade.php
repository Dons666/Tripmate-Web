{{-- 
|--------------------------------------------------------------------------
| HALAMAN ADMIN: Catatan Aktivitas Admin (Logs)
|--------------------------------------------------------------------------
| FUNGSI & KEGUNAAN:
| 1. Mencatat dan menampilkan riwayat perubahan data yang dilakukan oleh Admin.
| 2. Menampilkan riwayat seperti pembuatan, pembaruan, atau penghapusan data tempat & akun member.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Aktivitas Admin - Admin Panel</title>
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
        }

        .log-list {
            display: grid;
            gap: 12px;
        }

        .log-item {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            background: #fff;
        }

        .log-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 8px;
        }

        .log-title {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 4px;
            color: #111827;
        }

        .log-sub {
            font-size: 13px;
            color: #6b7280;
            margin: 0;
        }

        .meta {
            font-size: 12px;
            color: #6b7280;
        }

        .pill {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .create { background: #dcfce7; color: #166534; }
        .update { background: #dbeafe; color: #1e40af; }
        .delete { background: #fee2e2; color: #991b1b; }

        .changes {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .change {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
        }

        .location {
            margin-top: 10px;
            color: #4b5563;
            font-size: 13px;
        }

        .empty {
            padding: 24px;
            text-align: center;
            color: #6b7280;
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
                <a href="{{ route('admin.appeals.index') }}">Kotak Banding Akun</a>
                <a href="{{ route('admin.logs') }}" class="active">Admin Logs</a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah yakin ingin logout?')">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </aside>

        <main class="content">
            <div class="header">
                <h1>Catatan Aktivitas Admin</h1>
                <div class="username">{{ Auth::user()->name ?? Auth::user()->username }}</div>
            </div>

            <div class="card">
                <div class="log-list">
                    @forelse($logs as $log)
                        <div class="log-item">
                            <div class="log-top">
                                <div>
                                    <p class="log-title">{{ $log->changeSummary() }}</p>
                                    <p class="log-sub">
                                        {{ $log->entityLabel() }} #{{ $log->entity_id }} · {{ $log->admin_name ?? ($log->user?->username ?? '-') }}
                                    </p>
                                </div>
                                <div class="pill {{ $log->action }}">{{ $log->actionLabel() }}</div>
                            </div>

                            <div class="meta">
                                {{ $log->changed_at?->format('d-m-Y H:i:s') }}
                                <span> · </span>
                                {{ $log->created_at?->diffForHumans() }}
                            </div>

                            <div class="changes">
                                @forelse($log->changedFieldLabels() as $fieldLabel)
                                    <span class="change">{{ $fieldLabel }}</span>
                                @empty
                                    <span class="change">Tidak ada detail perubahan</span>
                                @endforelse
                            </div>

                            @if($log->subjectLocation())
                                <div class="location">Lokasi: {{ $log->subjectLocation() }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="empty">Belum ada catatan aktivitas.</div>
                    @endforelse
                </div>

                @if($logs->hasPages())
                    <div class="pagination">{{ $logs->links() }}</div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
