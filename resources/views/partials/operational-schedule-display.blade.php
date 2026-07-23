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

    $hariOperasional = $model->hari_operasional ?? 'Setiap Hari';
    $jamBuka = $model->jam_buka ?? '--:--';
    $jamTutup = $model->jam_tutup ?? '--:--';
    $schedule = $model->operational_schedule ?? [];
@endphp

<div>
    <span class="label">Hari & Jam Operasional</span>
    <div class="value" style="margin-top: 6px;">
        <div style="font-weight: 700; color: #1f2937;">📅 {{ $hariOperasional }}</div>
        <div style="color: #4b5563; font-size: 14px; margin-top: 2px;">⏰ {{ $jamBuka }} — {{ $jamTutup }}</div>
    </div>
</div>
