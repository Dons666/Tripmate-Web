@if(session('error') || $errors->has('review') || $errors->has('komentar'))
    <!-- MODAL POPUP PERINGATAN MODERASI AI GEMINI -->
    <div id="aiWarningModalPartial" style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px); z-index: 9999; display: flex; align-items: center; justify-content: center; padding: 16px;">
        <div style="background: #ffffff; border-radius: 24px; max-width: 440px; width: 100%; padding: 24px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); border: 1px solid #ffe4e6; text-align: center;">
            <div style="width: 56px; height: 56px; background: #ffe4e6; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px; color: #e11d48;">
                🤖⚠️
            </div>
            
            <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px;">Peringatan Moderasi AI Gemini</h3>
            
            <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 16px; padding: 14px; margin-bottom: 16px; text-align: center;">
                <p style="font-size: 11px; font-weight: 800; color: #9f1239; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Perkataan Tidak Pantas Terdeteksi</p>
                <p style="font-size: 13px; font-weight: 600; color: #881337; line-height: 1.5; margin: 0;">
                    {{ session('error') ?? $errors->first('review') ?? $errors->first('komentar') }}
                </p>
            </div>

            @if(old('review') || old('komentar'))
                <div style="margin-bottom: 20px; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px; border-radius: 12px; text-align: left;">
                    <span style="font-size: 11px; font-weight: 700; color: #64748b; display: block; margin-bottom: 4px;">Draf komentar Anda:</span>
                    <p style="font-size: 12px; font-style: italic; color: #334155; font-family: monospace; background: #ffffff; padding: 8px; border-radius: 6px; border: 1px solid #cbd5e1; margin: 0;">
                        "{{ old('review') ?? old('komentar') }}"
                    </p>
                </div>
            @endif

            <p style="font-size: 12px; color: #64748b; margin-bottom: 20px; line-height: 1.5;">
                Mohon perbaiki isi ulasan Anda dengan kata-kata yang sopan dan tidak mengandung unsur toksisitas atau kata kasar.
            </p>

            <button type="button" onclick="closeAiWarningModalPartial()" style="width: 100%; padding: 12px; background: #e11d48; color: #ffffff; font-weight: 800; border-radius: 12px; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(225, 29, 72, 0.3);">
                ✏️ Saya Mengerti & Edit Komentar
            </button>
        </div>
    </div>

    <script>
        function closeAiWarningModalPartial() {
            var modal = document.getElementById('aiWarningModalPartial');
            if (modal) {
                modal.style.display = 'none';
            }
            var textarea = document.getElementById('review') || document.getElementById('komentarInput');
            if (textarea) {
                textarea.focus();
                textarea.select();
            }
        }
    </script>
@endif

<div class="rating-box">
    <h3>Beri Rating Anda</h3>

    <form method="POST" action="{{ route('ratings.store', ['type' => $rateableType, 'id' => $rateableId]) }}">
        @csrf
        <label for="rating">Rating (1-5)</label>
        <select name="rating" id="rating" required>
            @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}" {{ (int) old('rating', optional($userRating)->rating) === $i ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <label for="review" style="display:block; margin-top:10px;">Komentar (Tekan Enter untuk kirim)</label>
        <textarea name="review" id="review" rows="4" placeholder="Tuliskan ulasan Anda di sini (tekan Enter untuk kirim)...">{{ old('review', optional($userRating)->review) }}</textarea>

        <button class="btn" type="submit" style="margin-top:12px;">Simpan Rating</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var reviewTextarea = document.getElementById('review');
        if (reviewTextarea) {
            reviewTextarea.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (this.form) {
                        this.form.requestSubmit();
                    }
                }
            });
        }
    });
</script>
