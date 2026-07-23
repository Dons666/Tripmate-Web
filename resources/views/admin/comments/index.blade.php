{{-- 
|--------------------------------------------------------------------------
| HALAMAN ADMIN: Manage Komentar & Ulasan Member (Dengan Gemini AI Filter)
|--------------------------------------------------------------------------
| FUNGSI & KEGUNAAN:
| 1. Memantau & memfilter seluruh komentar dan ulasan member berdasarkan Rating, Tipe Tempat, dan Status Moderasi AI Gemini.
| 2. Fitur Scan AI Komentar untuk mendeteksi toksisitas, spam, dan bahasa kasar secara otomatis.
| 3. Fitur Hapus Komentar & Kirim Teguran bagi pembuat komentar yang melanggar.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Komentar - TripMate Admin</title>
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

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        .alert-error {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 14px;
        }

        /* Stats Bar */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .stat-card .label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-top: 4px;
        }

        .stat-card.danger {
            border-left: 4px solid #ef4444;
        }

        .stat-card.warning {
            border-left: 4px solid #f59e0b;
        }

        .stat-card.info {
            border-left: 4px solid #0284c7;
        }

        /* Filter Controls */
        .filter-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            min-width: 160px;
        }

        .input-group label {
            font-size: 11px;
            font-weight: 700;
            color: #4b5563;
            text-transform: uppercase;
        }

        .form-control {
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            background: #fff;
            color: #1f2937;
            outline: none;
        }

        .form-control:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            align-items: flex-end;
            margin-top: auto;
        }

        .btn-filter {
            background: #0284c7;
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-filter:hover {
            background: #0369a1;
        }

        .btn-reset {
            background: #e5e7eb;
            color: #374151;
            border: none;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-reset:hover {
            background: #d1d5db;
        }

        .btn-ai-scan {
            background: linear-gradient(135deg, #7c3aed 0%, #4f46e5 100%);
            color: #fff;
            border: none;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
        }

        .btn-ai-scan:hover {
            opacity: 0.95;
        }

        .table-scroll {
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
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
        }

        th {
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        td {
            font-size: 13.5px;
            color: #111827;
        }

        .comment-text {
            max-width: 360px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .rating-badge {
            font-weight: 700;
            color: #b45309;
            background: #fef3c7;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 12px;
            display: inline-block;
        }

        /* AI Badges */
        .badge-safe {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-flagged {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-unchecked {
            background: #f3f4f6;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .flag-reason {
            font-size: 11px;
            color: #dc2626;
            margin-top: 4px;
            font-style: italic;
        }

        .muted {
            color: #6b7280;
        }

        .empty-message {
            text-align: center;
            padding: 30px 12px;
            color: #6b7280;
        }

        .actions {
            min-width: 170px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .btn {
            width: 100%;
            border: none;
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 11.5px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-warning {
            background: #f59e0b;
            color: #111827;
        }

        .btn-warning:hover {
            background: #d97706;
            color: #fff;
        }

        .btn-ai-recheck {
            background: #6366f1;
            color: #fff;
        }

        .btn-ai-recheck:hover {
            background: #4f46e5;
        }

        .btn:disabled {
            background: #d1d5db;
            color: #6b7280;
            cursor: not-allowed;
        }

        .warning-count {
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }

        .pagination {
            margin-top: 16px;
        }

        .pagination svg {
            width: 16px;
            height: 16px;
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
                <a href="{{ route('admin.comments.index') }}" class="active">Manage Komentar</a>
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
            <div class="header">
                <h1>Manage Komentar & Moderasi AI</h1>
                <div class="username">{{ Auth::user()->username }}</div>
            </div>

            <!-- Stats Bar -->
            <div class="stats-grid">
                <div class="stat-card info">
                    <div class="label">Total Komentar</div>
                    <div class="value">{{ $totalComments ?? 0 }}</div>
                </div>
                <div class="stat-card danger">
                    <div class="label">Terindikasi Bermasalah (AI)</div>
                    <div class="value">{{ $flaggedCount ?? 0 }}</div>
                </div>
                <div class="stat-card warning">
                    <div class="label">Belum Di-scan AI</div>
                    <div class="value">{{ $uncheckedCount ?? 0 }}</div>
                </div>
            </div>

            <div class="card">
                @if(session('success'))
                    <div class="alert-success">✅ {{ session('success') }}</div>
                @endif

                @if($errors->has('warning'))
                    <div class="alert-error">⚠️ {{ $errors->first('warning') }}</div>
                @endif

                <!-- Filter & Scan AI Section -->
                <div class="filter-section">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
                        <!-- Filter Form -->
                        <form method="GET" action="{{ route('admin.comments.index') }}" class="filter-form" style="flex: 1;">
                            <div class="input-group">
                                <label>Cari Teks / Member / Tempat</label>
                                <input type="text" name="search" class="form-control" placeholder="Kata kunci..." value="{{ request('search') }}">
                            </div>

                            <div class="input-group">
                                <label>Tipe Tempat</label>
                                <select name="type" class="form-control">
                                    <option value="">Semua Tipe</option>
                                    <option value="wisata" {{ request('type') == 'wisata' ? 'selected' : '' }}>Wisata</option>
                                    <option value="kuliner" {{ request('type') == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                                    <option value="penginapan" {{ request('type') == 'penginapan' ? 'selected' : '' }}>Penginapan</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Rating Stars</label>
                                <select name="rating" class="form-control">
                                    <option value="">Semua Rating</option>
                                    <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐ 5 Star</option>
                                    <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐ 4 Star</option>
                                    <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐ 3 Star</option>
                                    <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐ 2 Star</option>
                                    <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ 1 Star</option>
                                </select>
                            </div>

                            <div class="input-group">
                                <label>Status Moderasi AI</label>
                                <select name="ai_status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="flagged" {{ request('ai_status') == 'flagged' ? 'selected' : '' }}>⚠️ Terindikasi Bermasalah</option>
                                    <option value="clean" {{ request('ai_status') == 'clean' ? 'selected' : '' }}>🤖 Aman (Clean)</option>
                                    <option value="unchecked" {{ request('ai_status') == 'unchecked' ? 'selected' : '' }}>⚪ Belum Di-scan</option>
                                </select>
                            </div>

                            <div class="filter-actions">
                                <button type="submit" class="btn-filter">🔍 Filter</button>
                                <a href="{{ route('admin.comments.index') }}" class="btn-reset">Reset</a>
                            </div>
                        </form>

                        <!-- Batch Scan AI Button -->
                        <form method="POST" action="{{ route('admin.comments.scan-ai') }}" onsubmit="return confirm('Jalankan pemindaian Gemini AI untuk semua komentar tersimpan?')">
                            @csrf
                            <button type="submit" class="btn-ai-scan">
                                🤖 Scan AI Komentar (Gemini)
                            </button>
                        </form>
                    </div>
                </div>

                @if($comments->count() > 0)
                    <div class="table-scroll">
                        <table id="comments-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Tipe Tempat</th>
                                    <th>Nama Tempat</th>
                                    <th>Rating</th>
                                    <th>Komentar</th>
                                    <th>Status Moderasi AI</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comments as $comment)
                                    @php
                                        $rateable = $comment->rateable;
                                        $placeName = $rateable?->name ?? '-';
                                        $type = class_basename($comment->rateable_type);
                                        $warningCount = (int) ($comment->user->warning_count ?? 0);
                                        $maxReached = $warningCount >= $maxWarningCount;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $comment->user->name ?? $comment->user->username ?? 'Member' }}</strong><br><span class="muted" style="font-size: 11px;">{{ $comment->user->email ?? '' }}</span></td>
                                        <td>{{ $type }}</td>
                                        <td>{{ $placeName }}</td>
                                        <td>
                                            @if(!is_null($comment->rating))
                                                <span class="rating-badge">⭐ {{ $comment->rating }}</span>
                                            @else
                                                <span class="muted">-</span>
                                            @endif
                                        </td>
                                        <td class="comment-text">{{ $comment->review }}</td>
                                        <td>
                                            @if(isset($comment->is_flagged) && $comment->is_flagged)
                                                <span class="badge-flagged">⚠️ Bermasalah</span>
                                                @if($comment->flag_reason)
                                                    <div class="flag-reason">{{ $comment->flag_reason }}</div>
                                                @endif
                                            @elseif(isset($comment->ai_checked_at) && $comment->ai_checked_at)
                                                <span class="badge-safe">🤖 Aman</span>
                                            @else
                                                <span class="badge-unchecked">⚪ Belum Scan</span>
                                            @endif
                                        </td>
                                        <td>{{ $comment->created_at?->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="actions">
                                                <!-- Recheck AI Single -->
                                                <form action="{{ route('admin.comments.recheck-ai', $comment) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-ai-recheck">🤖 Re-scan AI</button>
                                                </form>

                                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus Komentar</button>
                                                </form>

                                                @if($comment->user)
                                                    <form action="{{ route('admin.comments.warning', $comment) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-warning" {{ $maxReached ? 'disabled' : '' }}>
                                                            Kirim Peringatan
                                                        </button>
                                                    </form>
                                                    <div class="warning-count">Peringatan: {{ $warningCount }}/{{ $maxWarningCount }}</div>
                                                @else
                                                    <div class="warning-count">Peringatan: -</div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        {{ $comments->links() }}
                    </div>
                @else
                    <div class="empty-message">Belum ada komentar dari member atau tidak ada data sesuai filter.</div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
