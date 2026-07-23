<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Penyedia Travel - Admin Panel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; color: #1f2937; }
        .layout { min-height: 100vh; display: flex; }
        .sidebar { width: 250px; background: linear-gradient(180deg, #1f2937 0%, #111827 100%); color: #fff; padding: 24px 16px; display: flex; flex-direction: column; gap: 20px; }
        .brand { font-size: 20px; font-weight: 700; padding: 8px 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.2); }
        .menu { display: flex; flex-direction: column; gap: 8px; }
        .menu a, .menu button { width: 100%; text-align: left; padding: 11px 12px; border-radius: 8px; border: none; background: transparent; color: #d1d5db; text-decoration: none; font-size: 14px; cursor: pointer; transition: all 0.2s ease; }
        .menu a:hover, .menu button:hover, .menu .active { background: rgba(255, 255, 255, 0.12); color: #fff; }
        .content { flex: 1; padding: 28px; }
        .top-info { display: flex; justify-content: flex-end; margin-bottom: 12px; color: #6b7280; font-weight: 600; }
        .container { max-width: 1200px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        .admin-header h1 { color: #111827; font-size: 28px; }
        .admin-title { color: #2563eb; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .btn-create { background: #2563eb; color: #fff; text-decoration: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: background 0.2s; }
        .btn-create:hover { background: #1d4ed8; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 20px; margin-bottom: 24px; }
        .filter-bar { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 20px; flex-wrap: wrap; }
        .search-box { display: flex; gap: 8px; flex: 1; max-width: 400px; }
        .search-box input { width: 100%; padding: 9px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; }
        .search-box button { padding: 9px 16px; background: #374151; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background: #f9fafb; padding: 12px 14px; color: #4b5563; font-weight: 600; border-bottom: 2px solid #e5e7eb; }
        td { padding: 12px 14px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        tr:hover { background: #f9fafb; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 9999px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0369a1; }
        .action-btns { display: flex; gap: 6px; }
        .btn-edit { background: #f59e0b; color: white; padding: 5px 10px; border-radius: 6px; text-decoration: none; font-size: 12px; font-weight: 600; }
        .btn-delete { background: #ef4444; color: white; padding: 5px 10px; border-radius: 6px; border: none; font-size: 12px; font-weight: 600; cursor: pointer; }
        .btn-doc { color: #2563eb; text-decoration: underline; font-size: 12px; font-weight: 600; }
        .empty-state { text-align: center; padding: 40px; color: #6b7280; }
        .badge-pending { background: #fef3c7; color: #b45309; display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-approved { background: #dcfce7; color: #15803d; display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-rejected { background: #fee2e2; color: #b91c1c; display: inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .btn-approve { background: #10b981; color: white; border: none; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .btn-approve:hover { background: #059669; }
        .btn-reject { background: #6b7280; color: white; border: none; padding: 5px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Admin Panel</div>
            <div class="menu">
                <a href="{{ route('admin.dashboard') }}">Home</a>
                <a href="{{ route('admin.places.index') }}">Manage Tempat</a>
                <a href="{{ route('admin.penyedia-travel.index') }}" class="active">Kelola Travel</a>
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
                    <div class="alert-success">{{ session('success') }}</div>
                @endif

                <div class="admin-header">
                    <div>
                        <span class="admin-title">Penyedia Travel</span>
                        <h1>Kelola Penyedia Travel</h1>
                    </div>
                    <a href="{{ route('admin.penyedia-travel.create') }}" class="btn-create">
                        + Tambah Penyedia Travel
                    </a>
                </div>

                <div class="card">
                    <div class="filter-bar">
                        <form method="GET" action="{{ route('admin.penyedia-travel.index') }}" class="search-box">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama travel, email, atau kontak...">
                            <button type="submit">Cari</button>
                        </form>
                        <div style="font-size: 14px; color: #6b7280;">Total: <strong>{{ $penyediaTravels->total() }}</strong> travel</div>
                    </div>

                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Travel & Status</th>
                                    <th>Kota / Alamat</th>
                                    <th>Armada & Tarif</th>
                                    <th>Dokumen (Izin & KTP)</th>
                                    <th>Kontak Pemilik</th>
                                    <th>Aksi / ACC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penyediaTravels as $index => $item)
                                    <tr>
                                        <td>{{ $penyediaTravels->firstItem() + $index }}</td>
                                        <td>
                                            <div style="font-size: 15px; font-weight: 700; margin-bottom: 4px;">{{ $item->nama_travel }}</div>
                                            @if($item->status === 'approved')
                                                <span class="badge-approved">✓ Approved (ACC)</span>
                                            @elseif($item->status === 'rejected')
                                                <span class="badge-rejected">✕ Ditolak</span>
                                            @else
                                                <span class="badge-pending">⏳ Pending ACC</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge">{{ $item->kota_asal_travel ?? 'Belum diisi' }}</span>
                                            <div style="font-size: 12px; color: #4b5563; margin-top: 4px;">{{ Str::limit($item->alamat_travel ?? '-', 40) }}</div>
                                        </td>
                                        <td>
                                            @if(!empty($item->jenis_kendaraan))
                                                <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                                    @foreach(array_filter(array_map('trim', explode(',', $item->jenis_kendaraan))) as $armada)
                                                        <div style="background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 6px; padding: 3px 8px; font-size: 11px; font-weight: 700; color: #1e293b;">
                                                            🚐 {{ $armada }}
                                                            @if(($item->harga ?? 0) > 0 && !Str::contains($armada, ['Rp', 'rp', 'rb']))
                                                                <span style="background: #059669; color: white; padding: 1px 5px; border-radius: 4px; font-size: 10px; margin-left: 4px;">
                                                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span style="color: #94a3b8; font-size: 12px;">-</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 12px;">
                                            <div>
                                                Surat Izin: 
                                                <a href="{{ route('admin.penyedia-travel.document', [$item, 'surat_izin']) }}" target="_blank" class="btn-doc">Lihat Berkas</a>
                                            </div>
                                            <div style="margin-top: 4px;">
                                                KTP: 
                                                <a href="{{ route('admin.penyedia-travel.document', [$item, 'ktp']) }}" target="_blank" class="btn-doc">Lihat KTP</a>
                                            </div>
                                        </td>
                                        <td>
                                            <div><strong>HP:</strong> {{ $item->nomor_hp_pemilik_travel }}</div>
                                            @if($item->email)
                                                <div style="font-size: 12px; color: #2563eb; margin-top: 2px;">{{ $item->email }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-btns" style="flex-direction: column; gap: 4px;">
                                                @if($item->status !== 'approved')
                                                    <form action="{{ route('admin.penyedia-travel.approve', $item) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-approve">✓ Setujui (ACC)</button>
                                                    </form>
                                                @endif
                                                @if($item->status !== 'rejected')
                                                    <form action="{{ route('admin.penyedia-travel.reject', $item) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn-reject">✕ Tolak</button>
                                                    </form>
                                                @endif
                                                <div style="display: flex; gap: 4px; margin-top: 4px;">
                                                    <a href="{{ route('admin.penyedia-travel.edit', $item) }}" class="btn-edit">Edit</a>
                                                    <form action="{{ route('admin.penyedia-travel.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus data travel ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-state">Belum ada data penyedia travel terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 20px;">
                        {{ $penyediaTravels->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
