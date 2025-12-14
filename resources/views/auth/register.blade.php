<!DOCTYPE html> 
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Sistem PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 590px;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.25);
            background: white;
        }
        .register-left {
            flex: 1;
            background: url("{{ asset('images/gkt.jpg') }}") no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            padding: 30px;
            color: white;
            text-align: left;
            position: relative;
        }
        .register-left h2 {
            font-weight: bold;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }
        .register-right {
            flex: 1;
            background: #fff;
            padding: 50px;
        }
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
        .btn-google img {
            width: 20px;
            margin-right: 10px;
        }
        .btn-primary {
            background-color: #2B4D8C !important;
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s ease;
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
    <div class="register-container">
        <!-- LEFT SIDE -->
        <div class="register-left">
            <div>
                <h5>Selamat Datang</h5>
                <small>Sistem Informasi Pengelolaan Praktik Kerja Lapangan<br>
                   Politeknik Negeri Tanah Laut</small>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="register-right">
            <div class="text-center mb-2">

                <h6 class="mt-2">Daftar dan Verifikasi</h6>
            </div>

            <!-- REGISTER WITH GOOGLE -->
            <a href="{{ route('google.login') }}" class="btn-google">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                Lanjutkan Dengan Google
            </a>

            <!-- FORM REGISTER -->
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-2">
                    <label>Email address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label>Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
                    </div>
                </div>
                <div class="mb-2">
                    <label>Role</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill-gear"></i></span>
                        <select name="role" class="form-control" required>
                            <option value="">Pilih Role</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="staf">Staf</option>
                            <option value="koor_prodi">Koor Prodi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-2">
                    <label>Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan kata sandi" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                </div>
                <div class="mb-2">
                    <label>Masukkan Ulang Kata Sandi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi kata sandi" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye-slash-fill"></i>
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

            <div class="text-center mt-1">
                <small class="text-muted">Sudah memiliki akun? 
                    <a href="{{ route('login') }}">Login</a>
                </small>
            </div>
        </div>
    </div> 

    <script>
        function togglePassword(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye-slash-fill");
                icon.classList.add("bi-eye-fill");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-fill");
                icon.classList.add("bi-eye-slash-fill");
            }
        }
    </script>
</body>
</html>
