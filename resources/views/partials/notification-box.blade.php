<div class="section-block" style="margin-top: 16px;">
    <div class="section-heading">
        <div>
            <h2>{{ $title ?? 'Notifikasi' }}</h2>
            <p>{{ $description ?? 'Pembaruan terbaru dari sistem.' }}</p>
        </div>
        @if(!empty($markAllReadRoute))
            <form action="{{ $markAllReadRoute }}" method="POST">
                @csrf
                <button type="submit" class="best-link">Tandai Semua Dibaca</button>
            </form>
        @endif
    </div>

    @if(($unreadNotificationCount ?? 0) > 0)
        <p style="margin-bottom: 10px; color: #b45309; font-weight: 600;">
            {{ $unreadNotificationCount }} notifikasi belum dibaca
        </p>
    @endif

    @if(!empty($notifications) && count($notifications) > 0)
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Notifikasi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification['message'] ?? '-' }}</td>
                            <td>{{ $notification['time'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">{{ $emptyText ?? 'Tidak ada notifikasi.' }}</div>
    @endif
</div>
