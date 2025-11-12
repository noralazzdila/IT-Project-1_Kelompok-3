<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4ff;
        }
        .login-container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            height: 650px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            background: white;
        }
        .login-left {
            flex: 1;
            background: url("{{ asset('images/gkt.jpg') }}") no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding: 30px;
            color: white;
            text-align: left;
        }
        .login-left h2 {
            font-weight: bold;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }
        .login-right {
            flex: 1;
            background: #fff;
            padding: 50px;
        }

        /* TOMBOL GOOGLE */
        .btn-google {
            border: 1px solid #ccc;
            background: white;
            width: 100%;
            padding: 12px;
            font-weight: 500;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-google:hover {
            background: #f7f7f7;
        }
        .btn-google img {
            width: 20px;
            margin-right: 10px;
        }

        /* TOMBOL MASUK */
        .btn-primary {
            background-color: #2B4D8C !important;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #223b6a !important;
        }

        .input-group-text {
            background: #f8f9fa;
        }
        .password-toggle {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- LEFT SIDE -->
        <div class="login-left">
            <div>
                <h5>Selamat Datang</h5>
                <p>Sistem Informasi Pengelolaan Praktik Kerja Lapangan<br>
                   Politeknik Negeri Tanah Laut</p>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="login-right">
            <div class="text-center mb-4">
                <img src="{{ asset('images/Logo_Politala.png') }}" alt="Logo" width="80">
                <h5 class="mt-2">Masuk dan Verifikasi</h5>
                <small>Nikmati kemudahan sistem autentikasi tunggal untuk mengakses semua layanan dengan satu akun.</small>
            </div>
        
            <!-- LOGIN WITH GOOGLE -->
            <a href="{{ route('google.login') }}" class="btn-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                Lanjutkan dengan Google
            </a>

            <div class="text-center my-2 text-muted">Atau</div>

            <!-- FORM LOGIN -->
            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Email / NIM</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Kata sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword('password', this)">
                            <i class="fa fa-eye-slash"></i>
                        </span>
                    </div>
                </div>
                <p class="d-flex justify-content-between mb-3"> <a href="{{ route('password.email') }}" class="text-muted">Lupa kata sandi?</a> </p>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>

                <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>
