<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Penyedia Travel - Admin Panel</title>
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
        .container { max-width: 900px; margin: 0 auto; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .admin-header h1 { color: #111827; font-size: 28px; }
        .admin-title { color: #2563eb; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
        .card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 28px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 6px; color: #374151; }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="tel"],
        .form-group textarea { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group textarea:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .btn-submit { background: #2563eb; color: white; padding: 11px 22px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 14px; }
        .btn-submit:hover { background: #1d4ed8; }
        .btn-cancel { background: #e5e7eb; color: #374151; padding: 11px 22px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
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
                <div class="admin-header">
                    <div>
                        <span class="admin-title">Penyedia Travel</span>
                        <h1>Tambah Penyedia Travel (Admin)</h1>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="alert-error">
                        <strong>Terjadi Kesalahan:</strong>
                        <ul style="margin-top: 6px; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <form action="{{ route('admin.penyedia-travel.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Nama Travel *</label>
                                <input type="text" name="nama_travel" value="{{ old('nama_travel') }}" required placeholder="Nama Travel">
                            </div>

                            <div class="form-group">
                                <label>Email Pemilik / Travel *</label>
                                <input type="email" name="email" value="{{ old('email') }}" required placeholder="Email Travel">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Password Akun Travel *</label>
                            <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter">
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Kota Asal Travel *</label>
                                <input type="text" name="kota_asal_travel" value="{{ old('kota_asal_travel') }}" required placeholder="Kota Asal">
                            </div>

                            <div class="form-group">
                                <label>Nomor HP Pemilik *</label>
                                <input type="tel" name="nomor_hp_pemilik_travel" value="{{ old('nomor_hp_pemilik_travel') }}" required placeholder="Nomor HP Pemilik">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat Travel *</label>
                            <textarea name="alamat_travel" rows="3" required placeholder="Alamat Lengkap">{{ old('alamat_travel') }}</textarea>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Jenis Kendaraan *</label>
                                <input type="text" name="jenis_kendaraan" value="{{ old('jenis_kendaraan') }}" required placeholder="Jenis Mobil / Armada">
                            </div>

                            <div class="form-group">
                                <label>Harga / Tarif (Rp) *</label>
                                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" step="1000" placeholder="Harga Sewa">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Jadwal Ketersediaan Mobil *</label>
                            <textarea name="jadwal_ketersediaan" rows="2" required placeholder="Jadwal Keberangkatan / Ketersediaan">{{ old('jadwal_ketersediaan') }}</textarea>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Rekening Bank *</label>
                                <input type="text" name="rekening" value="{{ old('rekening') }}" required placeholder="Bank & No Rekening">
                            </div>

                            <div class="form-group">
                                <label>Nomor HP Pemilik Travel *</label>
                                <input type="tel" name="nomor_hp_pemilik_travel" value="{{ old('nomor_hp_pemilik_travel') }}" required placeholder="Nomor HP Pemilik">
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label>Surat Izin Usaha Travel *</label>
                                <input type="file" name="surat_izin_usaha_travel">
                                <span style="font-size: 11px; color: #6b7280; display: block; margin-top: 4px;">Pilih file PDF/Gambar atau tuliskan nomor surat di bawah</span>
                                <input type="text" name="surat_izin_usaha_travel" placeholder="Atau ketik nomor surat izin" style="margin-top: 6px;">
                            </div>

                            <div class="form-group">
                                <label>KTP Pemilik *</label>
                                <input type="file" name="ktp_pemilik">
                                <span style="font-size: 11px; color: #6b7280; display: block; margin-top: 4px;">Pilih foto KTP atau ketik NIK pemilik di bawah</span>
                                <input type="text" name="ktp_pemilik" placeholder="Atau ketik NIK KTP pemilik" style="margin-top: 6px;">
                            </div>
                        </div>

                        <div style="margin-top: 24px; display: flex; gap: 12px; justify-content: flex-end;">
                            <a href="{{ route('admin.penyedia-travel.index') }}" class="btn-cancel">Batal</a>
                            <button type="submit" class="btn-submit">Simpan Travel</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
