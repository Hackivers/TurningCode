<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite(['resources/css/global.css', 'resources/css/auth.css'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Konfirmasi email — {{ config('app.name') }}</title>
</head>

<body>
    <div class="auth-container">
        <main class="thumbnail">
        <div class="wrapper-thumb">
            <div class="title-thumb">
                <h2>cek email kamu!!</h2>
                <h5>tinggal satu langkah lagi sebelum masuk...</h5>
            </div>
            <div class="thumb-img">
                <img src="{{ asset('assets/ico/img001thumb02Trans.png') }}" alt="">
            </div>
        </div>
    </main>
    <main class="form-input">
        <div class="wrapper-input">
            <div class="title-input">
                <h2>verifikasi email</h2>
            </div>
            <div class="profile">
                <div class="wrapper-profile verify">
                    <div class="profile-admin">
                        <i class='bx bxs-envelope' style="position:relative;font-size:22px;color:#464646;margin:0;"></i>
                    </div>
                    <div class="profile-title">
                        <h5>email terdaftar</h5>
                        <h4>{{ auth()->user()->email }}</h4>
                    </div>
                </div>
            </div>

            <div class="main-input admin-otp" style="gap:14px;">
                <h5 class="text-sm" style="margin-top:14px;">
                    Tautan verifikasi sudah dikirim ke email kamu. Klik link di email untuk mengaktifkan akun.
                    Cek juga folder <strong>spam</strong>.
                </h5>

                @if (session('info'))
                    <h5 class="text-sm info">{{ session('info') }}</h5>
                @endif
                @if (session('success'))
                    <h5 class="text-sm info">{{ session('success') }}</h5>
                @endif
                @if (session('error'))
                    <h5 class="text-sm error">{{ session('error') }}</h5>
                @endif

                <form method="post" action="{{ route('verification.send') }}">
                    @csrf
                    <div class="btn-verify">
                        <button type="submit">kirim ulang email</button>
                    </div>
                </form>

                <form method="post" action="{{ route('logout') }}" style="margin-top:5px;">
                    @csrf
                    <button type="submit" class="btn-resend">keluar dari akun</button>
                </form>
            </div>
        </div>
    </main>
    </div>
</body>

</html>