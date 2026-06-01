<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIBANTU</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }

        /* Toast notification system */
        .toast-container {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
            pointer-events: none;
        }
        .toast {
            pointer-events: auto;
            max-width: 420px;
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .toast.show {
            transform: translateX(0);
            opacity: 1;
        }
        .toast.hide {
            transform: translateX(120%);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.6, -0.28, 0.74, 0.05);
        }
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            border-radius: 0 0 0.75rem 0.75rem;
            animation: toast-countdown 5s linear forwards;
        }
        @keyframes toast-countdown {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')
        <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @yield('content')
        </main>
        <footer class="border-t border-gray-100 py-6 text-center text-gray-400 text-sm">
            <div class="max-w-7xl mx-auto px-4">
                <p>© {{ date('Y') }} SIBANTU – Sistem Informasi Bantuan untuk Masyarakat</p>
                <p class="text-xs mt-1 text-gray-300">Membantu sesama dengan transparan dan tepat sasaran</p>
            </div>
        </footer>
    </div>

    <!-- Toast Notification -->
    @if(session('success'))
    <div class="toast-container">
        <div class="toast relative bg-white border border-emerald-100 rounded-xl shadow-lg shadow-emerald-500/10 px-5 py-4 flex items-start gap-3 overflow-hidden" id="successToast">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800">Berhasil</p>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ session('success') }}</p>
            </div>
            <button onclick="dismissToast()" class="text-slate-300 hover:text-slate-500 transition flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="toast-progress bg-emerald-400"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('successToast');
            if (toast) {
                setTimeout(() => toast.classList.add('show'), 100);
                setTimeout(() => dismissToast(), 5200);
            }
        });
        function dismissToast() {
            const toast = document.getElementById('successToast');
            if (toast && !toast.classList.contains('hide')) {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.parentElement?.remove(), 400);
            }
        }
    </script>
    @endif

    @if(session('error'))
    <div class="toast-container">
        <div class="toast relative bg-white border border-rose-100 rounded-xl shadow-lg shadow-rose-500/10 px-5 py-4 flex items-start gap-3 overflow-hidden" id="errorToast">
            <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                <svg class="w-4.5 h-4.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-800">Gagal</p>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ session('error') }}</p>
            </div>
            <button onclick="dismissErrorToast()" class="text-slate-300 hover:text-slate-500 transition flex-shrink-0 mt-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="toast-progress bg-rose-400"></div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('errorToast');
            if (toast) {
                setTimeout(() => toast.classList.add('show'), 100);
                setTimeout(() => dismissErrorToast(), 5200);
            }
        });
        function dismissErrorToast() {
            const toast = document.getElementById('errorToast');
            if (toast && !toast.classList.contains('hide')) {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(() => toast.parentElement?.remove(), 400);
            }
        }
    </script>
    @endif
</body>
</html>