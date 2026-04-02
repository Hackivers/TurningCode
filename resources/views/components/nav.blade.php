<div class="container container-nav navbar @if (Auth::User()->role == "admin")
    admin
@endif" id="navBar">
    <main class="main-nav">
        <div class="wrapper-nav">
            <nav class="box-nav-profile">
                <div class="profile-img-nav btnAside">
                    <div>
                        <img src="{{ asset('assets/ico/adminUser.jpg') }}" alt="">
                        <h5>Guest</h5>
                    </div>
                </div>
                @if (Auth::User()->role == 'user')
                    <div class="profile-archive-nav">
                    <div>
                        <i class='bx bx-archive-in'></i>
                    </div>
                </div>
                @endif
            </nav>
            <nav class="box-nav-search">
                <div class="menu-nav-header btnAside">
                    <div>
                        <i class='bx bx-menu'></i>
                    </div>
                </div>
                <div>
                    <i class='bx bx-search'></i>
                    <input type="search" placeholder="Search">
                </div>
            </nav>
        </div>
    </main>
</div>
<script>
    let isScrolled = false;

    window.addEventListener("scroll", () => {
        const navbar = document.getElementById("navBar");
        if (!navbar) return;

        const emInPx = parseFloat(getComputedStyle(document.documentElement).fontSize);
        const triggerOn = 13 * emInPx; // nyala
        const triggerOff = 9 * emInPx; // mati (lebih kecil biar nggak getar)

        if (!isScrolled && window.scrollY > triggerOn) {
            navbar.classList.add("scrolled");
            isScrolled = true;
        } else if (isScrolled && window.scrollY < triggerOff) {
            navbar.classList.remove("scrolled");
            isScrolled = false;
        }
    });
</script>
















{{-- <div class="container container-nav navbar" id="navBar">
    <nav class="main-nav">
        <div class="wrapper-nav">
            <div class="box-nav">
                <div>
                    <div id="btnAside">
                        <i class="bx bx-menu"></i>
                    </div>
                    <div>
                        <h4>turning code
                            @if (auth()->user()->role == 'admin')
                                - admin
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
            <div class="box-nav">
                <div>
                    <div>
                        <i class="bx bx-message"></i>
                    </div>
                    <div>
                        <i class="bx bx-search" id="searchBar"></i>
                        <input type="search" placeholder="Pencarian">
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<div class="space-nav-header"></div>
@if ($page == 'home')
    <div class="container container-nav-header">
        <header class="main-nav-header">
            <div class="wrapper-nav-header">
                <main class="box-nav-header">
                    <div class="cover-nav-header">
                        <div>
                            <h4>halloo!!, hanzzsama</h4>
                            <h5>bingung mau jadi apa?, sini jadi programmer </h5>
                        </div>
                    </div>
                    <div class="thumb-cover-nav-header">
                        <img src="{{ asset('assets/img/img001cover.jpg') }}" alt="">
                    </div>
                    <div class="thumb-nav-header">
                        <img src="{{ asset('assets/ico/img002.png') }}" alt="">
                    </div>
                </main>
            </div>
        </header>
    </div>
@endif
<script>
    window.addEventListener("scroll", () => {
        const navbar = document.getElementById("navBar");

        if (!navbar) return;

        if (window.scrollY > 50) {
            navbar.classList.add("scrolled");
        } else {
            navbar.classList.remove("scrolled");
        }
    });
</script> --}}
