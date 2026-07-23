<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Escrow - Holding Dana Pembayaran Travel</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; color: #1f2937; }
        .layout { min-height: 100vh; display: flex; }
        .sidebar { width: 260px; background: linear-gradient(180deg, #1f2937 0%, #111827 100%); color: #fff; padding: 24px 16px; display: flex; flex-direction: column; gap: 20px; }
        .brand { font-size: 20px; font-weight: 700; padding: 8px 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.2); }
        .menu { display: flex; flex-direction: column; gap: 8px; }
        .menu a { padding: 11px 12px; border-radius: 8px; color: #d1d5db; text-decoration: none; font-size: 14px; transition: all 0.2s ease; }
        .menu a:hover, .menu a.active { background: rgba(255, 255, 255, 0.12); color: #fff; }
        .content { flex: 1; padding: 28px; }
        .card { background: #fff; border-radius: 16px; padding: 24px; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 24px; }
        .stats-grid { display: grid; grid-cols: 1fr; gap: 16px; margin-bottom: 24px; }
        @media(min-width: 640px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
        .stat-box { padding: 20px; border-radius: 12px; }
        .stat-box.holding { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .stat-box.released { background: #e0e7ff; border: 1px solid #c7d2fe; color: #3730a3; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 14px; }
        th, td { padding: 12px 14px; text-align: left; border-bottom: 1px solid #f3f4f6; }
        th { background: #f9fafb; font-weight: 700; color: #4b5563; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
        .btn-payout { background: #16a34a; color: #fff; border: none; padding: 8px 14px; border-radius: 8px; font-weight: 700; font-size: 12px; cursor: pointer; transition: 0.2s; }
        .btn-payout:hover { background: #15803d; }
        .alert-success { background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; font-size: 14px; }
    </style>
</head>
<body>
    <div class="layout">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="brand">TripMate Admin</div>
            <nav class="menu">
                <a href="{{ route('admin.dashboard') }}">📊 Dashboard Utama</a>
                <a href="{{ route('admin.places.index') }}">📍 Kelola Tempat</a>
                <a href="{{ route('admin.penyedia-travel.index') }}">🚌 Penyedia Travel</a>
                <a href="{{ route('admin.escrow.index') }}" class="active">💸 Escrow & Payout</a>
                <a href="{{ route('admin.users.index') }}">👥 Pengguna</a>
                <a href="{{ route('admin.comments.index') }}">💬 AI Moderasi Komentar</a>
                <a href="{{ route('admin.appeals.index') }}">📩 Banding Akun</a>
                <a href="{{ route('home') }}" style="margin-top: auto; background: #dc2626; color: white;">← Kembali ke Web Utama</a>
            </nav>
        </aside>

        <!-- CONTENT -->
        <main class="content">
            <h1 style="font-size: 24px; font-weight: 800; margin-bottom: 8px;">💸 Sistem Rekening Bersama (Escrow) Admin</h1>
            <p style="color: #6b7280; font-size: 14px; margin-bottom: 24px;">Kelola holding dana pembayaran paket travel dari pengguna sebelum diteruskan ke pihak agen travel.</p>

            @if(session('success'))
                <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            <!-- STATS HIGHLIGHT -->
            <div class="stats-grid">
                <div class="stat-box holding">
                    <p style="font-size: 12px; font-weight: 700; text-transform: uppercase;">Total Uang Di-Holding Admin (Escrow)</p>
                    <h2 style="font-size: 28px; font-weight: 900; margin-top: 4px;">Rp {{ number_format($totalHolding, 0, ',', '.') }}</h2>
                </div>
                <div class="stat-box released">
                    <p style="font-size: 12px; font-weight: 700; text-transform: uppercase;">Total Uang Telah Diteruskan ke Travel</p>
                    <h2 style="font-size: 28px; font-weight: 900; margin-top: 4px;">Rp {{ number_format($totalReleased, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- TABLE ESCROW TRANSACTION -->
            <div class="card">
                <h3 style="font-size: 16px; font-weight: 700;">📋 Daftar Transaksi Paket Travel (Holding & Payout)</h3>
                <table>
                    <thead>
                        <tr>
                            <th>User Pemesan</th>
                            <th>Mitra Agen Travel</th>
                            <th>Jadwal Keberangkatan</th>
                            <th>Nilai Transaksi</th>
                            <th>Status Perjalanan</th>
                            <th>Status Escrow</th>
                            <th>Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($escrowPlans as $plan)
                            <tr>
                                <td>
                                    <strong>{{ $plan->user->name ?? 'User' }}</strong>
                                    <div style="font-size: 12px; color: #6b7280;">{{ $plan->nama_perjalanan }}</div>
                                </td>
                                <td>
                                    <strong>🚌 {{ $plan->travel->nama_travel ?? 'Travel' }}</strong>
                                    <div style="font-size: 12px; color: #6b7280;">{{ $plan->travel->kota ?? '-' }}</div>
                                </td>
                                <td style="font-size: 12px;">
                                    📅 {{ $plan->tanggal_mulai ? $plan->tanggal_mulai->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    <strong style="color: #0284c7;">Rp {{ number_format($plan->travel->harga_paket ?? 0, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($plan->trip_status === 'in_progress')
                                        <span class="badge" style="background: #e0f2fe; color: #0369a1;">🚀 Sedang Berjalan</span>
                                    @elseif($plan->trip_status === 'completed')
                                        <span class="badge" style="background: #dcfce7; color: #15803d;">🏁 Tur Selesai</span>
                                    @elseif($plan->trip_status === 'planning')
                                        <span class="badge" style="background: #f3f4f6; color: #4b5563;">⏳ Menunggu Pelunasan</span>
                                    @else
                                        <span class="badge" style="background: #fef3c7; color: #92400e;">⏳ Siap Keberangkatan</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->payment_status === 'payout_released')
                                        <span class="badge" style="background: #e0e7ff; color: #3730a3;">💸 Dana Diteruskan</span>
                                    @elseif($plan->payment_status === 'pending_admin')
                                        <span class="badge" style="background: #fef08a; color: #854d0e;">⚠️ Menunggu Verifikasi</span>
                                    @else
                                        <span class="badge" style="background: #d1fae5; color: #065f46;">🔒 Holding Admin</span>
                                    @endif
                                </td>
                                <td>
                                    @if($plan->payment_status === 'pending_admin')
                                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                            @if($plan->payment_proof)
                                                <a href="{{ route('admin.escrow.proof', $plan) }}" target="_blank" class="btn-payout" style="background: #3b82f6; text-decoration: none;">Lihat Bukti</a>
                                            @endif
                                            <form action="{{ route('admin.escrow.verify', $plan) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-payout" style="background: #059669;">✅ Verifikasi</button>
                                            </form>
                                        </div>
                                    @elseif($plan->payment_status === 'escrow_held' && $plan->trip_status === 'completed')
                                        <form action="{{ route('admin.escrow.release', $plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-payout">
                                                💸 Transfer Uang ke Travel
                                            </button>
                                        </form>
                                    @elseif($plan->payment_status === 'payout_released')
                                        <span style="font-size: 12px; color: #16a34a; font-weight: 700;">✓ Selesai</span>
                                    @else
                                        <span style="font-size: 12px; color: #9ca3af;">Menunggu Tur Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; color: #9ca3af; padding: 24px;">Belum ada pemesanan paket travel yang di-checkout.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
