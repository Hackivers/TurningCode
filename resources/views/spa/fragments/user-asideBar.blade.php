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
                    <a href="#" data-spa-page="dashboard">
                        <div class="box-aside">
                            <div>
                                <i class="bx bxs-home"></i>
                                <h4>Home</h4>
                            </div>
                        </div>
                    </a>
                    <hr />
                </figure>
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
