@php
    $user = Auth::user();
@endphp

<div class="container container-aside asidebar @if ($user->role == 'admin') admin @endif" id="asidePage">
    <aside class="main-aside">
        <div class="wrapper-aside">
            <div class="tittle-aside">
                <div>
                    <h4>Turning Code</h4>
                </div>
                <div>
                    <i class="bx bx-menu-alt-left"></i>
                </div>
            </div>
            <main class="aside-list">
                @auth
                    <figure class="box-profile">
                        <div class="wrapper-profile">
                            <div class="wrapper-user">

                                <div class="user-img">
                                    <img src="{{ asset('assets/ico/default-user.jpg') }}" alt="user" />
                                </div>
                                <div class="username">
                                    <h4>{{ $user->name }}</h4>
                                    @php
                                        $parts = explode('@', $user->email);
                                        $name = substr($parts[0], 0, 3) . '*******';
                                        $maskedEmail = $name . '@' . $parts[1];
                                    @endphp
                                    <h6>{{ $maskedEmail }}</h6>
                                </div>
                            </div>
                            <div class="user-ico">
                                <i class="bx bx-message-rounded"></i>
                            </div>
                        </div>
                    </figure>
                @endauth
                <figure>
                    <a href="{{ $user && $user->role === 'admin' ? '/admin' : '/' }}"
                        class="{{ request()->is('/') ? 'disabled' : '' }}">
                        <div class="box-aside">
                            <div>
                                <i class="bx bxs-home"></i>
                                <h4>Home</h4>
                            </div>
                        </div>
                    </a>
                    <hr />
                    @auth
                        @if ($user->role === 'admin')
                            <a href="/admin" class="{{ request()->is('admin') ? 'disabled' : '' }}">
                                <div class="box-aside">
                                    <div>
                                        <i class="bx bx-line-chart"></i>
                                        <h4>Data Analisis</h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/phpmyadmin/" target="_blank">
                                <div class="box-aside">
                                    <div>
                                        <i class="bx bxs-data"></i>
                                        <h4>Database Admin</h4>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endauth
                </figure>
                <figure>
                    @auth
                        @if ($user->role === 'admin')
                            <a href="?page=alltables" class="link-spa">
                                <div class="box-aside">
                                    <div>
                                        <i class='bx bx-upload'></i>
                                        <h4>all tables</h4>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endauth
                </figure>
                <figure>
                    @auth
                        @if ($user->role === 'admin')
                            <a href="?page=uploadmainmateri" class="link-spa">
                                <div class="box-aside">
                                    <div>
                                        <i class='bx bx-upload'></i>
                                        <h4>Upload MainMateri</h4>
                                    </div>
                                </div>
                            </a>

                            <a href="?page=uploadmateri" class="link-spa">
                                <div class="box-aside">
                                    <div>
                                        <i class='bx bx-upload'></i>
                                        <h4>Upload Materi</h4>
                                    </div>
                                </div>
                            </a>

                            <a href="?page=uploadsubmateri" class="link-spa">
                                <div class="box-aside">
                                    <div>
                                        <i class='bx bx-upload'></i>
                                        <h4>Upload SubMateri</h4>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endauth
                </figure>
                @auth
                    @if ($user->role === 'user')
                        <figure>
                            <div class="box-aside">
                                <div>
                                    <i class="bx bxs-book-content"></i>
                                    <h4>Question</h4>
                                </div>
                            </div>
                            <hr />
                            <div class="box-aside">
                                <div>
                                    <i class="bx bx-table"></i>
                                    <h4>Planned</h4>
                                </div>
                            </div>
                        </figure>
                    @endif
                @endauth
                <figure>
                    @auth
                        <form method="POST" action="/logout">
                            @csrf
                            <div class="box-aside">
                                <button type="submit" class="logout-btn">
                                    <i class='bx bx-log-out-circle'></i>
                                    <h4>Log out</h4>
                                </button>
                            </div>
                        </form>
                    @else
                        <a href="/login">
                            <div class="box-aside">
                                <div>
                                    <i class='bx bx-log-in-circle'></i>
                                    <h4>Login</h4>
                                </div>
                            </div>
                        </a>
                    @endauth
                </figure>
            </main>
        </div>
    </aside>
</div>
