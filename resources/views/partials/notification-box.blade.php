@use('Illuminate\Support\Str')

<div class="section-card" style="margin-bottom: 28px;">
    <div class="section-title">
        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
            <span>📩 {{ $title ?? 'Ringkasan Notifikasi & Banding Akun' }}</span>
            @if(($unreadNotificationCount ?? 0) > 0)
                <span style="background: #ef4444; color: #ffffff; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 99px;">
                    {{ $unreadNotificationCount }} Baru
                </span>
            @endif
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            @if(!empty($markAllReadRoute) && ($unreadNotificationCount ?? 0) > 0)
                <form action="{{ $markAllReadRoute }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-link" style="background: none; border: none; cursor: pointer; color: #64748b; font-size: 12px; font-weight: 700;">
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
            <a href="{{ route('admin.appeals.index') }}" class="btn-link">Lihat Semua Banding &rarr;</a>
        </div>
    </div>

    <p style="font-size: 13px; color: #64748b; margin-bottom: 16px;">
        {{ $description ?? 'Ringkasan pengajuan banding akun dari pengguna yang dinonaktifkan.' }}
    </p>

    @if(!empty($notifications) && count($notifications) > 0)
        <div style="display: flex; flex-direction: column; gap: 10px;">
            @foreach(collect($notifications)->take(4) as $notification)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: {{ !empty($notification['is_unread']) ? '#fffbeb' : '#f8fafc' }}; border: 1px solid {{ !empty($notification['is_unread']) ? '#fef3c7' : '#e2e8f0' }}; border-radius: 12px; font-size: 13px; gap: 12px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 10px; min-width: 200px; flex: 1;">
                        <span style="font-size: 16px;">📧</span>
                        <div style="min-width: 0;">
                            <div style="font-weight: 700; color: #0f172a;">
                                {{ $notification['user_name'] ?? $notification['user_email'] ?? '-' }}
                                <span style="font-weight: 400; color: #64748b; font-size: 12px; margin-left: 4px;">({{ $notification['user_email'] ?? '-' }})</span>
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                                "{{ Str::limit($notification['reason'] ?? $notification['message'] ?? '-', 75) }}"
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                        <span style="font-size: 12px; color: #94a3b8;">{{ $notification['time'] ?? '-' }}</span>
                        @if(($notification['status'] ?? '') === 'approved')
                            <span class="badge-status status-paid" style="background: #dcfce7; color: #166534;">Disetujui</span>
                        @elseif(($notification['status'] ?? '') === 'rejected')
                            <span class="badge-status" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                        @else
                            <span class="badge-status status-pending">Menunggu</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="text-align: center; color: #64748b; font-size: 13px; padding: 20px 0;">
            {{ $emptyText ?? 'Belum ada pengajuan banding akun dari pengguna.' }}
        </div>
    @endif
</div>
