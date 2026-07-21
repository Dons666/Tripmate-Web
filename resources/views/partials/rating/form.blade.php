@if($errors->has('review'))
    <div class="warning-popup" id="moderation-warning-popup">
        <strong>Peringatan komentar</strong>
        <div>{{ $errors->first('review') }}</div>
        <button type="button" class="warning-popup-close" onclick="document.getElementById('moderation-warning-popup').remove();">Tutup</button>
    </div>
    <script>
        setTimeout(function () {
            var popup = document.getElementById('moderation-warning-popup');
            if (popup) {
                popup.remove();
            }
        }, 5000);
    </script>
@endif

<div class="rating-box">
    <h3>Beri Rating Anda</h3>
    @if($errors->any())
        <div style="margin-bottom:14px; padding:12px 14px; border-radius:12px; background:rgba(239,68,68,0.12); color:#b91c1c; border:1px solid rgba(239,68,68,0.25);">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('ratings.store', ['type' => $rateableType, 'id' => $rateableId]) }}">
        @csrf
        <label for="rating">Rating (1-5)</label>
        <select name="rating" id="rating" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ (int) old('rating', optional($userRating)->rating) === $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <label for="review" style="display:block; margin-top:10px;">Komentar</label>
        <textarea name="review" id="review" rows="4">{{ old('review', optional($userRating)->review) }}</textarea>

        <button class="btn" type="submit">Simpan Rating</button>
    </form>
</div>
