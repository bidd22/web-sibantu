<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIBANTU – Bantuan Sosial Modern</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #ffffff; }
        .hero-gradient {
            background: radial-gradient(circle at 20% 30%, rgba(79, 70, 229, 0.08) 0%, rgba(0,0,0,0) 70%);
        }
    </style>
</head>
<body class="antialiased">
    <div class="hero-gradient min-h-screen">
        <!-- Navbar transparan -->
        <div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">SIBANTU</div>
            <div class="space-x-6">
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Masuk</a>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-5 py-2 rounded-full font-medium hover:bg-indigo-700 transition shadow-md">Daftar Sekarang</a>
            </div>
        </div>

        <!-- Hero -->
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <div class="inline-flex items-center gap-2 bg-indigo-50 rounded-full px-4 py-1 text-sm text-indigo-700 mb-6">
                <span class="w-2 h-2 bg-indigo-600 rounded-full"></span> Bantuan untuk semua
            </div>
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-gray-900 mb-6">Bantuan sosial<br>yang <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">tepat sasaran</span></h1>
            <p class="text-xl text-gray-500 max-w-2xl mx-auto mb-10">SIBANTU membantu masyarakat kurang mampu mengakses program bantuan dengan transparan dan mudah.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-gray-900 text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-800 transition">Mulai Ajukan</a>
                <a href="#fitur" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-full font-semibold hover:bg-gray-50 transition">Lihat Fitur</a>
            </div>
        </div>

        <!-- Grid fitur dengan card gambar ikon -->
        <div id="fitur" class="max-w-6xl mx-auto px-6 py-16">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all p-6 border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">📋</div>
                    <h3 class="text-xl font-semibold mb-2">Ajukan Bantuan</h3>
                    <p class="text-gray-500">Isi formulir cepat, pilih program yang sesuai kebutuhan Anda.</p>
                </div>
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all p-6 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">📊</div>
                    <h3 class="text-xl font-semibold mb-2">Lacak Status</h3>
                    <p class="text-gray-500">Pantau perkembangan pengajuan secara real-time.</p>
                </div>
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all p-6 border border-gray-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">💬</div>
                    <h3 class="text-xl font-semibold mb-2">Sampaikan Pengaduan</h3>
                    <p class="text-gray-500">Kritik, saran, atau keluhan langsung ke tim kami.</p>
                </div>
            </div>
        </div>

        <!-- Call to action -->
        <div class="max-w-4xl mx-auto px-6 py-16 text-center">
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Siap mendapatkan bantuan?</h2>
                <p class="text-gray-600 mb-6">Bergabung dengan ribuan masyarakat yang sudah terbantu.</p>
                <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-indigo-700 transition">Daftar Gratis</a>
            </div>
        </div>

        <footer class="border-t border-gray-100 py-8 text-center text-gray-400 text-sm">
            © {{ date('Y') }} SIBANTU – Membangun kepedulian bersama
        </footer>
    </div>
</body>
</html>