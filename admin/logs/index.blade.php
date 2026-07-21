<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log Admin</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(180deg, #f4f7f8 0%, #eef3f4 100%); margin: 0; color: #1f2d2d; }
        .container { max-width: 1180px; margin: 32px auto; padding: 0 20px 28px; }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 28px; }
        .header a { text-decoration: none; background: linear-gradient(135deg, #0f766e, #0d9488); color: #fff; padding: 10px 14px; border-radius: 10px; font-weight: 600; }
        .card { background: #fff; border-radius: 16px; box-shadow: 0 10px 28px rgba(15, 23, 42, 0.08); padding: 18px; }
        .log-list { display: grid; gap: 12px; }
        .log-item { border: 1px solid #e4ecec; border-radius: 14px; padding: 16px; background: #fff; }
        .log-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 8px; }
        .log-title { font-size: 16px; font-weight: 700; margin: 0 0 4px; }
        .log-sub { font-size: 13px; color: #5b6b6b; margin: 0; }
        .meta { font-size: 12px; color: #6a7777; }
        .pill { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 12px; font-weight: 700; letter-spacing: .2px; }
        .create { background: #d1fae5; color: #065f46; }
        .update { background: #dbeafe; color: #1e40af; }
        .delete { background: #fee2e2; color: #991b1b; }
        .changes { margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px; }
        .change { background: #f3f7f7; color: #244040; border: 1px solid #dce7e7; border-radius: 999px; padding: 5px 10px; font-size: 12px; }
        .location { margin-top: 10px; color: #4f5f5f; font-size: 13px; }
        .empty { padding: 18px; text-align: center; color: #5d6a6a; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Audit Log Perubahan Data</h1>
            <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
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
                    <div class="empty">Belum ada log perubahan data.</div>
                @endforelse
            </div>

            <div style="margin-top: 14px;">{{ $logs->links() }}</div>
        </div>
    </div>
</body>
</html>
