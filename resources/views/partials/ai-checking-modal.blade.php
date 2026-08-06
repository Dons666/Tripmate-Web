<!-- MODAL POPUP SEDANG MEMERIKSA KOMENTAR (AI MODERASI GEMINI) -->
<div id="aiCheckingModal" style="position: fixed; inset: 0; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 99999; display: none; align-items: center; justify-content: center; padding: 16px;">
    <div style="background: #ffffff; border-radius: 28px; max-width: 440px; width: 100%; padding: 36px 28px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(2, 132, 199, 0.15); text-align: center; position: relative; animation: aiModalPop 0.3s cubic-bezier(0.16, 1, 0.3, 1);">
        
        <!-- Animated Icon Container -->
        <div style="position: relative; width: 80px; height: 80px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center;">
            <div style="position: absolute; inset: 0; background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); border-radius: 24px; opacity: 0.2; animation: aiPulseRing 2s infinite ease-in-out;"></div>
            <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%); border-radius: 22px; display: flex; align-items: center; justify-content: center; font-size: 36px; box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.35); position: relative; z-index: 1;">
                🤖
            </div>
            <div style="position: absolute; top: -4px; right: -4px; background: #0284c7; color: #ffffff; width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; border: 2px solid #ffffff; z-index: 2; animation: aiSpinSparkle 3s infinite linear;">
                ✨
            </div>
        </div>
        
        <h3 style="font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 8px; tracking-tight: -0.02em;">Memeriksa Komentar...</h3>
        
        <p style="font-size: 13px; color: #64748b; margin-bottom: 24px; line-height: 1.6; padding: 0 12px; font-weight: 500;">
            Sistem AI Moderasi Gemini sedang mengecek komentar Anda untuk memastikan isi ulasan bebas dari konten tidak pantas.
        </p>

        <!-- Progress Spinner / Bar -->
        <div style="width: 100%; height: 8px; background: #f1f5f9; border-radius: 999px; overflow: hidden; position: relative; border: 1px solid #e2e8f0;">
            <div style="position: absolute; top: 0; bottom: 0; width: 45%; background: linear-gradient(90deg, #0284c7, #38bdf8, #818cf8); border-radius: 999px; animation: aiShimmer 1.4s infinite ease-in-out;"></div>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 16px;">
            <div style="width: 8px; height: 8px; background: #0284c7; border-radius: 50%; animation: aiDotPulse 1.2s infinite ease-in-out 0s;"></div>
            <div style="width: 8px; height: 8px; background: #0284c7; border-radius: 50%; animation: aiDotPulse 1.2s infinite ease-in-out 0.2s;"></div>
            <div style="width: 8px; height: 8px; background: #0284c7; border-radius: 50%; animation: aiDotPulse 1.2s infinite ease-in-out 0.4s;"></div>
            <span style="font-size: 11px; font-weight: 800; color: #0284c7; text-transform: uppercase; letter-spacing: 0.5px; margin-left: 4px;">Mohon Tunggu</span>
        </div>
    </div>
</div>

<style>
@keyframes aiModalPop {
    from { opacity: 0; transform: scale(0.92) translateY(10px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes aiPulseRing {
    0%, 100% { transform: scale(1); opacity: 0.2; }
    50% { transform: scale(1.25); opacity: 0.5; }
}
@keyframes aiSpinSparkle {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
@keyframes aiShimmer {
    0% { left: -45%; }
    100% { left: 100%; }
}
@keyframes aiDotPulse {
    0%, 100% { transform: scale(0.8); opacity: 0.4; }
    50% { transform: scale(1.2); opacity: 1; }
}
</style>

<script>
    function showAiCheckingModal() {
        var modal = document.getElementById('aiCheckingModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    }
</script>
