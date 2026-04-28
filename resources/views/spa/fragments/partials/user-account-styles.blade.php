<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

:root {
    --neo-bg: #ececec;
    --neo-card-light: #e5e5e5;
    --neo-card-black: #000000;
    --neo-text-dark: #121212;
    --neo-text-light: #ffffff;
    --neo-radius: 32px;
}

/* Cropper Modal */
.cropper-modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(4px); z-index: 100005; display: none; opacity: 0; transition: opacity 0.3s; }
.cropper-modal { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.9); z-index: 100006; background: #fff; border-radius: 20px; padding: 24px; width: 90%; max-width: 460px; display: none; opacity: 0; transition: all 0.3s; flex-direction: column; gap: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
.cropper-modal.active, .cropper-modal-backdrop.active { display: flex; opacity: 1; transform: translate(-50%, -50%) scale(1); }
.cropper-modal-backdrop.active { transform: none; display: block; }
.cropper-container-wrapper { width: 100%; height: 320px; background: #f0f0f0; border-radius: 12px; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); }

body { background-color: var(--neo-bg) !important; overflow-x: hidden; }

.neo-dashboard *, .neo-dashboard *::before, .neo-dashboard *::after { box-sizing: border-box; }
.neo-dashboard {
    background-color: var(--neo-bg);
    color: var(--neo-text-dark);
    font-family: 'Inter', sans-serif;
    padding: 32px 0;
    min-height: 100vh;
    width: 100%;
    overflow-x: hidden;
}
.neo-bento-container { max-width: 1400px; margin: 0 auto; width: 100%; }
.neo-bento-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px; width: 100%; }
@media (max-width: 1024px) { .neo-bento-grid { grid-template-columns: 1fr; } }

.neo-card {
    border-radius: var(--neo-radius);
    padding: 32px;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s;
    max-width: 100%;
    box-sizing: border-box;
}
.neo-card:hover { transform: translateY(-4px); }
.neo-card-light { background: var(--neo-card-light); color: var(--neo-text-dark); }
.neo-card-black { background: var(--neo-card-black); color: var(--neo-text-light); }

.neo-bento-right { display: flex; flex-direction: column; gap: 20px; min-width: 0; }
.neo-bento-top-row { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; width: 100%; }
@media (max-width: 768px) { .neo-bento-top-row { grid-template-columns: 1fr; } }

.neo-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
.neo-title { font-size: 24px; font-weight: 600; margin: 0; line-height: 1.25; letter-spacing: -0.03em; }
.neo-arrow { font-size: 32px; font-weight: 400; line-height: 1; transition: transform 0.2s; margin-top: -4px; }
.neo-card:hover .neo-arrow { transform: translate(2px, -2px); }
.neo-pill {
    background: transparent;
    color: var(--neo-text-dark);
    border: 1px solid rgba(0,0,0,0.3);
    padding: 6px 16px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 500;
    white-space: nowrap;
}
.neo-desc { font-size: 15px; color: #555; margin: 0; line-height: 1.5; }

/* Achievement items */
.acc-ach-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 16px;
    border-radius: 16px;
    transition: all 0.2s;
    cursor: help;
    min-width: 100px;
}
.acc-ach-item:hover { background: rgba(0,0,0,0.03); }
.acc-ach-item:hover img { transform: scale(1.15); }

/* Modal */
.acc-modal-backdrop {
    position: fixed; inset: 0; z-index: 998;
    background: rgba(0,0,0,0.4);
    backdrop-filter: blur(6px);
    opacity: 0; visibility: hidden;
    transition: all 0.35s;
}
.acc-modal-backdrop.active { opacity: 1; visibility: visible; }

.acc-modal {
    position: fixed; bottom: 0; left: 0; right: 0; z-index: 999;
    max-height: 90vh; overflow-y: auto;
    background: #f5f5f5;
    border-radius: 28px 28px 0 0;
    border-top: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 -20px 60px rgba(0,0,0,0.15);
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.acc-modal.active { transform: translateY(0); }
.acc-modal::-webkit-scrollbar { width: 4px; }
.acc-modal::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
.acc-modal-handle { display: flex; justify-content: center; padding: 12px 0 4px; cursor: pointer; }
.acc-modal-handle span { width: 40px; height: 4px; background: #ccc; border-radius: 4px; }

/* Form Inputs */
.acc-input-wrap {
    display: flex; align-items: center; gap: 10px; padding: 0 14px;
    border-radius: 14px; border: 1px solid rgba(0,0,0,0.08);
    background: #fff; transition: all 0.2s;
}
.acc-input-wrap:focus-within { border-color: #121212; box-shadow: 0 0 0 3px rgba(0,0,0,0.05); }
.acc-input-wrap > i { color: #888; font-size: 18px; flex-shrink: 0; }
.acc-input-wrap input {
    flex: 1; padding: 12px 0; border: none; background: transparent;
    color: #121212; font-size: 14px; outline: none; font-family: inherit;
}
.acc-input-wrap input::placeholder { color: #bbb; }

/* Toast */
.friend-toast {
    display: flex; align-items: center; gap: 10px; padding: 12px 18px;
    border-radius: 12px; font-size: 13px; font-weight: 500; font-family: 'Inter', sans-serif;
    color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    pointer-events: auto; animation: friendSlideIn 0.3s cubic-bezier(0.16,1,0.3,1); min-width: 220px;
}
.friend-toast.success { background: #10b981; }
.friend-toast.error { background: #ef4444; }
.friend-toast.fade-out { opacity: 0; transition: opacity 0.4s; }
@keyframes friendSlideIn { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* Responsive */
@media (max-width: 768px) {
    .neo-dashboard { padding: 24px 16px; }
    .neo-card { padding: 24px; }
}

/* ═══ ELITE AURA (Account Page) ═══ */
.acc-avatar-wrap.elite-aura-lg {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, #8b5cf6, #ec4899, #f59e0b, #10b981, #3b82f6);
    background-size: 200% 200%;
    animation: auraGradientMove 3s linear infinite;
    box-shadow: 0 0 20px rgba(139, 92, 246, 0.3), 0 0 40px rgba(236, 72, 153, 0.15);
}
.acc-avatar-wrap.elite-aura-lg::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: inherit;
    filter: blur(8px);
    opacity: 0.5;
    z-index: -1;
}
.acc-avatar-wrap.elite-aura-lg img,
.acc-avatar-wrap.elite-aura-lg > div {
    border: 3px solid #e5e5e5 !important;
    position: relative;
    z-index: 1;
}
@keyframes auraGradientMove {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

h4.elite-name-lg {
    background: linear-gradient(135deg, #8b5cf6, #ec4899, #f59e0b) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
    font-weight: 800 !important;
    background-size: 200% 200%;
    animation: eliteNameShift 3s ease-in-out infinite;
}
@keyframes eliteNameShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* ═══ SOVEREIGN TIER STYLES ═══ */
.acc-avatar-wrap.sovereign-aura-lg {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, #fbbf24, #d946ef, #fbbf24);
    background-size: 200% 200%;
    animation: auraGradientMove 3s linear infinite;
    box-shadow: 0 0 20px rgba(251, 191, 36, 0.4), 0 0 40px rgba(217, 70, 239, 0.2);
}
.acc-avatar-wrap.sovereign-aura-lg::before {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: inherit;
    filter: blur(10px);
    opacity: 0.6;
    z-index: -1;
}
.acc-avatar-wrap.sovereign-aura-lg img,
.acc-avatar-wrap.sovereign-aura-lg > div {
    border: 3px solid #e5e5e5 !important;
    position: relative;
    z-index: 1;
}

h4.sovereign-name-lg {
    background: linear-gradient(135deg, #fbbf24, #d946ef) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
    font-weight: 900 !important;
    background-size: 200% 200%;
    animation: eliteNameShift 3s ease-in-out infinite;
    letter-spacing: -0.2px;
}
</style>
