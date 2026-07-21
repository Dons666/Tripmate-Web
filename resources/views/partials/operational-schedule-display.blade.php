@php
    $days = [
        'monday' => 'Senin',
        'tuesday' => 'Selasa',
        'wednesday' => 'Rabu',
        'thursday' => 'Kamis',
        'friday' => 'Jumat',
        'saturday' => 'Sabtu',
        'sunday' => 'Minggu',
    ];

    $schedule = $model->operational_schedule ?? [];
@endphp

<div>
    <span class="label">Jadwal Operasional</span>

    @if(!empty($schedule))
        <div class="value" style="display: grid; gap: 6px; margin-top: 8px;">
            @foreach($days as $dayKey => $dayLabel)
                @php
                    $item = $schedule[$dayKey] ?? null;
                    $status = $item['status'] ?? 'closed';
                    $openTime = $item['open_time'] ?? '';
                    $closeTime = $item['close_time'] ?? '';
                @endphp
                <div>
                    <strong>{{ $dayLabel }}:</strong>
                    @if($status === 'open')
                        {{ $openTime ?: '-' }} - {{ $closeTime ?: '-' }}
                    @else
                        Tutup
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="value">-</div>
    @endif
</div>
