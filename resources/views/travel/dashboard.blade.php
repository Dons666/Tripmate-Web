<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Partner Travel - TripMate</title>
    <!-- Google Fonts Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; margin: 0; padding: 0; }
        .hero-banner { background: linear-gradient(135deg, #0f172a 0%, #0369a1 60%, #1e1b4b 100%); }
    </style>
</head>
<body style="background-color: #f8fafc; color: #0f172a; min-height: 100vh;">
    
    <!-- Top Dark Navigation -->
    <header style="background-color: #0f172a; border-bottom: 1px solid #1e293b; color: #ffffff; position: sticky; top: 0; z-index: 50; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 20px; height: 64px; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="{{ route('home') }}" style="font-size: 22px; font-weight: 900; color: #38bdf8; text-decoration: none; tracking-tight: -0.025em; display: flex; align-items: center; gap: 8px;">
                    <span>TripMate</span>
                    <span style="font-size: 10px; font-weight: 900; padding: 3px 10px; background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border-radius: 9999px; border: 1px solid rgba(56, 189, 248, 0.3); text-transform: uppercase;">Partner Center</span>
                </a>
            </div>

            <div style="display: flex; align-items: center; gap: 16px;">
                <a href="{{ route('penyedia-travel.index') }}" target="_blank" style="font-size: 12px; font-weight: 700; color: #cbd5e1; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <svg style="width: 16px; height: 16px; color: #38bdf8;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Katalog Publik</span>
                </a>
                <span style="color: #334155;">|</span>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; border-radius: 9999px; background: #0284c7; color: #ffffff; font-weight: 900; font-size: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid #38bdf8;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span style="font-size: 13px; color: #f1f5f9; font-weight: 800;">{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin logout?')" style="margin: 0;">
                    @csrf
                    <button type="submit" style="padding: 6px 14px; background: #1e293b; color: #e2e8f0; border-radius: 10px; font-size: 11px; font-weight: 800; border: 1px solid #334155; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main style="max-width: 1280px; margin: 0 auto; padding: 32px 20px;">
        
        <!-- Flash Alert Message -->
        @if(session('success'))
            <div style="background: #ecfdf5; border: 1px solid #6ee7b7; color: #065f46; padding: 14px 20px; border-radius: 18px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 32px; height: 32px; border-radius: 10px; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 14px;">✓</div>
                    <span style="font-size: 13px; font-weight: 800;">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" style="background: none; border: none; color: #047857; font-weight: 900; cursor: pointer; font-size: 16px;">✕</button>
            </div>
        @endif

        @php
            $status = $penyediaTravel->status ?? 'pending';
        @endphp

        <!-- Hero Banner Card with Explicit Dark Contrast -->
        <div class="hero-banner" style="background: linear-gradient(135deg, #0f172a 0%, #0369a1 60%, #1e1b4b 100%); color: #ffffff; padding: 32px; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2); border: 1px solid #1e293b; margin-bottom: 28px; display: flex; flex-wrap: wrap; items-center; justify-content: space-between; gap: 24px;">
            <div style="display: flex; items-center; gap: 20px; flex: 1; min-width: 280px;">
                <div style="width: 80px; height: 80px; border-radius: 22px; background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 900; border: 2px solid rgba(56, 189, 248, 0.4); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3); shrink: 0;">
                    🚌
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">
                        <h1 style="font-size: 26px; font-weight: 900; color: #ffffff; margin: 0; letter-spacing: -0.02em;">
                            {{ $penyediaTravel->nama_travel ?? Auth::user()->name }}
                        </h1>
                        
                        @if($status === 'approved')
                            <span style="background: rgba(16, 185, 129, 0.2); color: #6ee7b7; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 900; border: 1px solid rgba(16, 185, 129, 0.4); display: inline-flex; align-items: center; gap: 6px;">
                                <span style="width: 8px; height: 8px; background: #34d399; border-radius: 9999px;"></span>
                                Verified ACC
                            </span>
                        @elseif($status === 'rejected')
                            <span style="background: rgba(244, 63, 94, 0.2); color: #fca5a5; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 900; border: 1px solid rgba(244, 63, 94, 0.4);">
                                ✕ Ditolak
                            </span>
                        @else
                            <span style="background: rgba(245, 158, 11, 0.2); color: #fde047; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 900; border: 1px solid rgba(245, 158, 11, 0.4);">
                                ⏳ Menunggu ACC Admin
                            </span>
                        @endif
                    </div>
                    
                    <p style="font-size: 13px; color: #e2e8f0; font-weight: 600; margin: 0; display: flex; flex-wrap: wrap; gap: 16px;">
                        <span>📍 {{ $penyediaTravel->kota_asal_travel ?? 'Kota Belum Diisi' }}</span>
                        <span>✉️ {{ $penyediaTravel->email ?? Auth::user()->email }}</span>
                        <span style="color: #6ee7b7; font-weight: 800;">📞 WA: {{ $penyediaTravel->nomor_hp_pemilik_travel ?? '-' }}</span>
                    </p>
                </div>
            </div>

            <div style="display: flex; align-items: center;">
                <a href="{{ route('travel.dashboard.edit') }}" style="background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); color: #ffffff; font-weight: 900; font-size: 13px; padding: 14px 24px; border-radius: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 10px 15px -3px rgba(56, 189, 248, 0.3);">
                    <span>✏️ Edit Profil & Armada</span>
                    <span style="font-size: 16px;">&rarr;</span>
                </a>
            </div>
        </div>

        <!-- 4 Key Metrics Cards Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 18px; margin-bottom: 32px;">
            <!-- Metric 1: Status -->
            <div style="background: #ffffff; padding: 20px; border-radius: 20px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; items-center; justify-content: space-between;">
                <div>
                    <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Status Kemitraan</span>
                    @if($status === 'approved')
                        <span style="font-size: 15px; font-weight: 900; color: #059669; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 10px; height: 10px; background: #10b981; border-radius: 9999px;"></span> ACC Verified
                        </span>
                    @elseif($status === 'rejected')
                        <span style="font-size: 15px; font-weight: 900; color: #e11d48; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 10px; height: 10px; background: #f43f5e; border-radius: 9999px;"></span> Ditolak
                        </span>
                    @else
                        <span style="font-size: 15px; font-weight: 900; color: #d97706; display: flex; align-items: center; gap: 6px;">
                            <span style="width: 10px; height: 10px; background: #f59e0b; border-radius: 9999px;"></span> Pending ACC
                        </span>
                    @endif
                </div>
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #a7f3d0;">
                    🛡️
                </div>
            </div>

            <!-- Metric 2: Armada Count -->
            @php
                $armadaCount = !empty($penyediaTravel->jenis_kendaraan) ? count(array_filter(array_map('trim', explode(',', $penyediaTravel->jenis_kendaraan)))) : 0;
            @endphp
            <div style="background: #ffffff; padding: 20px; border-radius: 20px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; items-center; justify-content: space-between;">
                <div>
                    <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Total Kendaraan</span>
                    <span style="font-size: 16px; font-weight: 900; color: #0f172a;">{{ $armadaCount }} Jenis Armada</span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #c7d2fe;">
                    🚐
                </div>
            </div>

            <!-- Metric 3: Operating Days -->
            <div style="background: #ffffff; padding: 20px; border-radius: 20px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; items-center; justify-content: space-between;">
                <div style="min-width: 0; padding-right: 8px;">
                    <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Hari Operasional</span>
                    <span style="font-size: 12px; font-weight: 900; color: #0f172a; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ Str::limit($penyediaTravel->jadwal_ketersediaan ?? 'Setiap Hari (Senin - Minggu)', 22) }}
                    </span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #bae6fd;">
                    📅
                </div>
            </div>

            <!-- Metric 4: Bank Account -->
            <div style="background: #ffffff; padding: 20px; border-radius: 20px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; items-center; justify-content: space-between;">
                <div style="min-width: 0; padding-right: 8px;">
                    <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px;">Rekening Bank</span>
                    <span style="font-size: 12px; font-weight: 900; color: #0f172a; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ Str::limit($penyediaTravel->rekening ?? 'Belum diisi', 20) }}
                    </span>
                </div>
                <div style="width: 44px; height: 44px; border-radius: 14px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 20px; border: 1px solid #fde68a;">
                    💳
                </div>
            </div>
        </div>

        <!-- Main Showcase Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 28px;">
            
            <!-- Left Main Column: Vehicles & Schedule Matrix -->
            <div style="grid-column: span 2; display: flex; flex-direction: column; gap: 28px;">
                
                <!-- Armada Vehicles Card Showcase -->
                <div style="background: #ffffff; border-radius: 24px; padding: 28px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
                        <div>
                            <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0;">Showcase Armada & Tarif Kendaraan</h2>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Daftar jenis kendaraan, foto asli, dan tarif sewa per harinya.</p>
                        </div>
                        <a href="{{ route('travel.dashboard.edit') }}" style="background: #4338ca; color: #ffffff; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 12px; text-decoration: none;">
                            ✏️ Edit Armada
                        </a>
                    </div>

                    @if(!empty($penyediaTravel->jenis_kendaraan))
                        @php
                            $armadaList = array_values(array_filter(array_map('trim', explode(',', $penyediaTravel->jenis_kendaraan))));
                            $fotosArray = $penyediaTravel->fotos_array;
                        @endphp
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                            @foreach($armadaList as $index => $armada)
                                @php
                                    $armadaPhoto = $fotosArray[$index] ?? null;
                                    $rawItem = $armada;

                                    // Extract Price (Rp ...)
                                    $extractedPrice = null;
                                    if (preg_match('/^(.*?)\s*\((?:Rp\s*)?([\d\.]+)\)$/i', $rawItem, $priceMatches)) {
                                        $rawItem = trim($priceMatches[1]);
                                        $cleanNum = str_replace('.', '', $priceMatches[2]);
                                        if (is_numeric($cleanNum) && (float)$cleanNum > 0) {
                                            $extractedPrice = 'Rp ' . number_format((float)$cleanNum, 0, ',', '.');
                                        }
                                    }
                                    if (!$extractedPrice && ($penyediaTravel->harga ?? 0) > 0) {
                                        $extractedPrice = 'Rp ' . number_format($penyediaTravel->harga, 0, ',', '.');
                                    }

                                    // Extract Seats (14 Kursi / 14 Orang)
                                    $extractedSeats = null;
                                    if (preg_match('/^(.*?)\s*\((?:(\d+)\s*(?:Kursi|Orang|Pax|Seat))\)$/i', $rawItem, $seatMatches)) {
                                        $rawItem = trim($seatMatches[1]);
                                        $extractedSeats = $seatMatches[2] . ' Kursi';
                                    }

                                    // Extract Qty (2 Unit)
                                    $extractedQty = null;
                                    if (preg_match('/^(\d+\s*Unit)\s+(.*)$/i', $rawItem, $qtyMatches)) {
                                        $extractedQty = $qtyMatches[1];
                                        $rawItem = trim($qtyMatches[2]);
                                    }
                                @endphp
                                <div style="background: #0f172a; color: #ffffff; border-radius: 20px; padding: 18px; border: 1px solid #1e293b; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: space-between;">
                                    <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
                                        @if($armadaPhoto)
                                            <img src="{{ asset('storage/' . $armadaPhoto) }}" alt="{{ $rawItem }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 14px; border: 2px solid #334155; shrink: 0;">
                                        @else
                                            <div style="width: 70px; height: 70px; border-radius: 14px; background: #1e293b; display: flex; align-items: center; justify-content: center; font-size: 30px; shrink: 0; border: 1px solid #334155;">
                                                🚐
                                            </div>
                                        @endif

                                        <div style="min-width: 0; flex: 1;">
                                            <h3 style="font-size: 14px; font-weight: 800; color: #ffffff; margin: 0 0 4px 0; line-height: 1.3;">
                                                @if($extractedQty)
                                                    <span style="color: #38bdf8; font-weight: 900;">{{ $extractedQty }}</span>
                                                @endif
                                                {{ $rawItem }}
                                            </h3>

                                            <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center; margin-top: 6px;">
                                                @if($extractedSeats)
                                                    <span style="background: rgba(56, 189, 248, 0.15); color: #7dd3fc; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; border: 1px solid rgba(56, 189, 248, 0.3);">
                                                        👥 {{ $extractedSeats }}
                                                    </span>
                                                @endif

                                                @if($extractedPrice)
                                                    <span style="background: #10b981; color: #ffffff; font-size: 10px; font-weight: 900; padding: 3px 8px; border-radius: 6px;">
                                                        {{ $extractedPrice }} / hari
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div style="padding-top: 10px; border-top: 1px solid #1e293b; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #94a3b8;">
                                        <span>Status Armada: <strong style="color: #34d399;">Aktif</strong></span>
                                        @if($armadaPhoto)
                                            <a href="{{ asset('storage/' . $armadaPhoto) }}" target="_blank" style="color: #38bdf8; font-weight: 800; text-decoration: none;">
                                                Lihat Foto &rarr;
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 36px 20px; background: #f8fafc; border-radius: 20px; border: 1px solid #e2e8f0;">
                            <span style="font-size: 40px; display: block; margin-bottom: 8px;">🚐</span>
                            <h4 style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">Belum Ada Armada Terdaftar</h4>
                            <p style="font-size: 12px; color: #64748b; margin: 4px 0 16px 0;">Tambahkan jenis kendaraan, tarif sewa, dan foto armada travel Anda.</p>
                            <a href="{{ route('travel.dashboard.edit') }}" style="background: #4338ca; color: #ffffff; font-weight: 800; font-size: 12px; padding: 10px 20px; border-radius: 12px; text-decoration: none;">
                                + Tambah Kendaraan Pertama
                            </a>
                        </div>
                    @endif
                </div>

                <!-- 7-Day Operating Schedule Grid -->
                <div style="background: #ffffff; border-radius: 24px; padding: 28px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 20px;">
                        <div>
                            <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0;">Jadwal Operasional (Senin - Minggu)</h2>
                            <p style="font-size: 12px; color: #64748b; margin: 2px 0 0 0;">Status buka atau libur per hari dalam seminggu.</p>
                        </div>
                        <a href="{{ route('travel.dashboard.edit') }}" style="font-size: 12px; font-weight: 800; color: #0284c7; text-decoration: none;">
                            Ubah Status Hari &rarr;
                        </a>
                    </div>

                    @php
                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        $rawSchedule = strtolower($penyediaTravel->jadwal_ketersediaan ?? '');
                    @endphp
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @foreach($days as $day)
                            @php
                                $isLibur = Str::contains($rawSchedule, strtolower($day) . ': libur') || Str::contains($rawSchedule, 'libur: ' . strtolower($day));
                                if (Str::contains($rawSchedule, 'tutup')) $isLibur = true;
                            @endphp
                            <div style="flex: 1 1 90px; max-width: 120px; padding: 12px 8px; border-radius: 16px; text-align: center; border: 1.5px solid {{ !$isLibur ? '#a7f3d0' : '#fca5a5' }}; background: {{ !$isLibur ? '#ecfdf5' : '#fef2f2' }}; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;">
                                <span style="font-size: 12px; font-weight: 900; color: #0f172a;">{{ $day }}</span>
                                <span style="font-size: 10px; font-weight: 900; text-transform: uppercase; padding: 3px 8px; border-radius: 6px; background: {{ !$isLibur ? '#d1fae5' : '#fee2e2' }}; color: {{ !$isLibur ? '#047857' : '#b91c1c' }};">
                                    {{ !$isLibur ? '🟢 Buka' : '🔴 Libur' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Right Column: Office Address, Bank Account, Legal Docs -->
            <div style="display: flex; flex-direction: column; gap: 24px;">
                
                <!-- Office Address & Bank Account Card -->
                <div style="background: #ffffff; border-radius: 24px; padding: 24px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; flex-direction: column; gap: 16px;">
                    <h3 style="font-size: 15px; font-weight: 900; color: #0f172a; margin: 0; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px;">
                        <span>🏢 Kantor & Garasi Travel</span>
                    </h3>

                    <div>
                        <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 6px;">Alamat Lengkap Garasi</span>
                        <p style="font-size: 12px; font-weight: 600; color: #0f172a; background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #e2e8f0; margin: 0; line-height: 1.5;">
                            {{ $penyediaTravel->alamat_travel ?? 'Alamat kantor / garasi belum diisi.' }}
                        </p>
                    </div>

                    <div>
                        <span style="font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 6px;">Rekening Bank Pembayaran</span>
                        <p style="font-size: 12px; font-weight: 800; color: #0f172a; background: #f8fafc; padding: 14px; border-radius: 14px; border: 1px solid #e2e8f0; margin: 0; display: flex; align-items: center; gap: 8px;">
                            <span>💳</span>
                            <span>{{ $penyediaTravel->rekening ?? 'Nomor rekening belum diisi.' }}</span>
                        </p>
                    </div>
                </div>

                <!-- Legal Documents Status Card -->
                <div style="background: #ffffff; border-radius: 24px; padding: 24px; border: 1px solid #cbd5e1; box-shadow: 0 2px 4px rgba(0,0,0,0.04); display: flex; flex-direction: column; gap: 14px;">
                    <h3 style="font-size: 15px; font-weight: 900; color: #0f172a; margin: 0; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px;">
                        <span>📄 Berkas Legalitas Usaha</span>
                    </h3>

                    <div style="display: flex; flex-direction: column; gap: 10px; font-size: 12px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span style="font-weight: 700; color: #334155;">Surat Izin Usaha:</span>
                            @if(isset($penyediaTravel->surat_izin_usaha_travel) && $penyediaTravel->surat_izin_usaha_travel)
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 8px; font-weight: 900; font-size: 11px;">
                                    ✓ Terunggah
                                </span>
                            @else
                                <span style="background: #ffe4e6; color: #be123c; padding: 4px 10px; border-radius: 8px; font-weight: 700; font-size: 11px;">
                                    ✕ Belum Ada
                                </span>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 14px; background: #f8fafc; border: 1px solid #e2e8f0;">
                            <span style="font-weight: 700; color: #334155;">KTP Pemilik Travel:</span>
                            @if(isset($penyediaTravel->ktp_pemilik) && $penyediaTravel->ktp_pemilik)
                                <span style="background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 8px; font-weight: 900; font-size: 11px;">
                                    ✓ Terunggah
                                </span>
                            @else
                                <span style="background: #ffe4e6; color: #be123c; padding: 4px 10px; border-radius: 8px; font-weight: 700; font-size: 11px;">
                                    ✕ Belum Ada
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action CTA Card -->
                <div style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #ffffff; border-radius: 24px; padding: 24px; text-align: center; border: 1px solid #1e293b; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2);">
                    <span style="font-size: 36px; display: block; margin-bottom: 8px;">⚙️</span>
                    <h4 style="font-size: 15px; font-weight: 900; color: #ffffff; margin: 0 0 6px 0;">Perbarui Data Travel Anda</h4>
                    <p style="font-size: 12px; color: #94a3b8; margin: 0 0 18px 0; line-height: 1.4;">Ubah nama travel, armada, tarif, foto kendaraan, atau jadwal operasional.</p>
                    <a href="{{ route('travel.dashboard.edit') }}" style="display: block; width: 100%; padding: 14px 0; background: linear-gradient(135deg, #38bdf8 0%, #2563eb 100%); color: #ffffff; font-weight: 900; font-size: 13px; border-radius: 14px; text-decoration: none; box-shadow: 0 4px 6px -1px rgba(56, 189, 248, 0.3); box-sizing: border-box;">
                        ✏️ Edit Profil & Armada Travel
                    </a>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer style="margin-top: 48px; background: #0f172a; color: #64748b; padding: 24px 0; border-top: 1px solid #1e293b; text-center: center; font-size: 12px; font-weight: 600;">
        <div style="max-width: 1280px; margin: 0 auto; text-align: center;">
            <p style="margin: 0;">&copy; {{ date('Y') }} TripMate Partner Portal. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
