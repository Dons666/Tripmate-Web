<div class="section-block" style="margin-top: 16px;">
    <div class="section-heading">
        <div>
            <h2>{{ $title ?? 'Kotak Notifikasi & Banding Admin' }}</h2>
            <p>{{ $description ?? 'Pantau pengajuan banding akun dari pengguna yang dinonaktifkan.' }}</p>
        </div>
        @if(!empty($markAllReadRoute))
            <form action="{{ $markAllReadRoute }}" method="POST">
                @csrf
                <button type="submit" class="best-link">Tandai Semua Dibaca</button>
            </form>
        @endif
    </div>

    @if(($unreadNotificationCount ?? 0) > 0)
        <p style="margin-bottom: 12px; color: #b45309; font-weight: 700; font-size: 13px;">
            🔔 {{ $unreadNotificationCount }} pengajuan banding belum dibaca
        </p>
    @endif

    @if(!empty($notifications) && count($notifications) > 0)
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Detail Pengajuan Banding</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr style="{{ !empty($notification['is_unread']) ? 'background: #fffbeb;' : '' }}">
                            <td>
                                <div style="font-weight: 700; color: #111827; margin-bottom: 4px;">
                                    📧 {{ $notification['user_email'] ?? $notification['user_name'] ?? '-' }}
                                </div>
                                <div style="font-size: 13px; color: #374151; background: #f3f4f6; padding: 8px 12px; border-radius: 8px; border: 1px solid #e5e7eb;">
                                    "{{ $notification['reason'] ?? $notification['message'] ?? '-' }}"
                                </div>
                            </td>
                            <td>
                                @if(($notification['status'] ?? '') === 'approved')
                                    <span class="badge" style="background: #dcfce7; color: #166534;">Disetujui</span>
                                @elseif(($notification['status'] ?? '') === 'rejected')
                                    <span class="badge" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                                @else
                                    <span class="badge" style="background: #fef3c7; color: #92400e;">Menunggu Review</span>
                                @endif
                            </td>
                            <td style="font-size: 12px; color: #6b7280; white-space: nowrap;">
                                {{ $notification['time'] ?? '-' }}
                            </td>
                            <td>
                                @if(($notification['status'] ?? '') === 'pending' && !empty($notification['id']))
                                    <div style="display: flex; gap: 6px;">
                                        <form action="{{ route('admin.appeals.approve', $notification['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-status btn-activate" style="border: none; padding: 6px 10px; font-size: 12px; font-weight: 700; border-radius: 6px; cursor: pointer; background: #166534; color: #fff;">
                                                ✓ Setujui & Aktifkan
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.appeals.reject', $notification['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-status btn-deactivate" style="border: none; padding: 6px 10px; font-size: 12px; font-weight: 700; border-radius: 6px; cursor: pointer; background: #dc2626; color: #fff;">
                                                ✕ Tolak
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span style="font-size: 12px; color: #9ca3af;">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">{{ $emptyText ?? 'Belum ada pengajuan banding akun.' }}</div>
    @endif
</div>
