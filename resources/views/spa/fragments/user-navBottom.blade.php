
<div class="container container-nav-bottom nav-bottombar">
    <nav class="main-nav-bottom">
        <div class="wrapper-nav-bottom">

            <div class="box-nav-bottom" data-page="dashboard">
                <div>
                    <div>
                        <div class="icon-nav-bottom active">
                            <i class='bx bxs-home'></i>
                        </div>
                    </div>
                    <div class="subtittle-nav-bottom">
                        <h5>dashboard</h5>
                    </div>
                </div>
            </div>

            <div class="box-nav-bottom" data-page="history">
                <div>
                    <div>
                        <div class="icon-nav-bottom">
                            <i class='bx bx-history'></i>
                        </div>
                    </div>
                    <div class="subtittle-nav-bottom">
                        <h5>history</h5>
                    </div>
                </div>
            </div>

            <div class="box-nav-bottom" data-page="schedule">
                <div>
                    <div>
                        <div class="icon-nav-bottom">
                            <i class='bx bx-calendar'></i>
                        </div>
                    </div>
                    <div class="subtittle-nav-bottom">
                        <h5>jadwal</h5>
                    </div>
                </div>
            </div>

            <div class="box-nav-bottom" data-page="favorites">
                <div>
                    <div>
                        <div class="icon-nav-bottom">
                            <i class='bx bx-star'></i>
                        </div>
                    </div>
                    <div class="subtittle-nav-bottom">
                        <h5>favorit</h5>
                    </div>
                </div>
            </div>

            <div class="box-nav-bottom" data-page="account">
                <div>
                    <div>
                        <div class="icon-nav-bottom">
                            <i class='bx bxs-user'></i>
                        </div>
                    </div>
                    <div class="subtittle-nav-bottom">
                        <h5>account</h5>
                    </div>
                </div>
            </div>

        </div>
    </nav>
</div>

<style>
/* ═══ ROTOOD DARK BOTTOM NAV GLOBAL ═══ */

/* Sembunyikan NavBottom di Desktop (Lebih dari 1024px) */
@media (min-width: 1025px) {
    .container-nav-bottom {
        display: none !important;
    }
}

/* Floating Pill untuk Mobile (Bawah 1024px) */
@media (max-width: 1024px) {
    .container-nav-bottom {
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
        padding: 0 20px 20px !important;
        position: fixed !important;
        bottom: 0 !important;
        width: 100% !important;
        z-index: 1000 !important;
    }
    .main-nav-bottom {
        background: rgba(17, 17, 17, 0.95) !important;
        backdrop-filter: blur(12px) !important;
        border: 1px solid #222 !important;
        border-radius: 40px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.6) !important;
        overflow: hidden !important;
        margin: 0 auto !important;
        max-width: 500px !important;
    }
    .wrapper-nav-bottom {
        padding: 8px 12px !important;
        background: transparent !important;
    }
    
    .icon-nav-bottom { background: transparent !important; margin-bottom: 2px !important; }
    .icon-nav-bottom i { color: #666 !important; font-size: 20px !important; }
    .icon-nav-bottom.active i { color: #f3ebd7 !important; }
    
    .subtittle-nav-bottom h5 { color: #666 !important; font-size: 10px !important; font-weight: 600 !important; }
    
    .box-nav-bottom[data-page].active .subtittle-nav-bottom h5,
    .box-nav-bottom:hover .subtittle-nav-bottom h5 { color: #f3ebd7 !important; }
    
    .box-nav-bottom:hover .icon-nav-bottom i { color: #f3ebd7 !important; transform: translateY(-2px); }
    .box-nav-bottom { transition: transform 0.2s ease !important; }
}
</style>
