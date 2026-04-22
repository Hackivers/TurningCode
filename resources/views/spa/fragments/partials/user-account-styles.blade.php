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
</style>
