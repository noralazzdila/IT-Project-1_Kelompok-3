<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f2d4e] min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8">
        
        <h2 class="text-center text-2xl font-bold mb-4 text-gray-800">Atur Ulang Kata Sandi</h2>
        <p class="text-sm text-gray-600 text-center mb-6">
            Untuk mengatur ulang kata sandi Anda, masukkan email dan tekan tombol 
            <span class="font-semibold">"Kirim Kode"</span> di bawah ini. Kami akan mengirimkan kode verifikasi ke email Anda.
        </p>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Email*</label>
                <div class="flex">
                    <input type="email" name="email" class="w-full border rounded-l-lg p-2 focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Masukkan Email" value="{{ old('email') }}">
                    <button type="submit" class="bg-blue-600 text-white px-4 rounded-r-lg hover:bg-blue-700">Kirim Kode</button>
                </div>
            </div>
        </form>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="email" value="{{ old('email') }}">
            <!-- Kode Verifikasi -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Masukkan Kode Verifikasi*</label>
                <input type="text" name="code" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Kode Verifikasi">
            </div>

            <!-- Password Baru -->
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Masukkan Kata Sandi Baru</label>
                <input type="password" name="password" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Kata Sandi Baru">
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 outline-none" placeholder="Konfirmasi Kata Sandi">
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded-full hover:bg-blue-800 transition">
                Reset Password
            </button>
        </form>

        <!-- Kembali -->
        <div class="mt-4 text-center">
            <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
        </div>
    </div>

</body>
</html>
