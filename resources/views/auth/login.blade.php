<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/img/logo.png" type="image/x-icon">
    <title>SIPAKAR</title>
    <link href="https://googleapis.com" rel="stylesheet">
    <link rel="stylesheet" href="https://cloudflare.com">
    <link href="/assets/css/login.css" rel="stylesheet">
</head>
<body>

    <div class="login-card">
        <!-- Area Atas: Header Gambar/Seni Lanskap -->
        <div class="banner-section">
            
                <img src="/assets/img/logo.png" width="30%">
            
            <h2 class="welcome-title">SELAMAT DATANG</h2>
        </div>
        @error('username')
            <div class="modal-overlay active" id="modalOverlay">
                <div class="modal-card">
                    
                    <!-- Bagian Header (Warna Pink Melengkung) -->
                    <div class="modal-header">
                        <div class="circle-decor"></div>
                        <div class="icon-circle">
                            <svg fill="none" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                    </div>

                    <div class="modal-body">
                        <h2 class="title">LOGIN GAGAL</h2>
                        <p class="description">Username atau Password Salah</p>
                        <button class="btn-retry" id="closeBtn">Coba Lagi</button>
                    </div>

                </div>
            </div>
        @enderror
        <!-- Area Bawah: Form Isian Input -->
        <div class="form-section">
            <form method="POST" action="{{ route('login') }}" >
                @csrf
                <!-- Input Username -->
                <div class="input-group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" class="@error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="username">
                   
                </div>

                <!-- Input Password -->
                <div class="input-group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" placeholder="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn-login">LOGIN</button>

        
            </form>
        </div>
    </div>
<script>
        const closeBtn = document.getElementById('closeBtn');
        const modalOverlay = document.getElementById('modalOverlay');

        // Fungsi Menutup Modal
        closeBtn.addEventListener('click', () => {
            modalOverlay.classList.remove('active');
        });

        // Menutup Modal saat area gelap di luar kotak diklik
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });
    </script>

</body>
</html>
