<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Universe KVT') — Platform Pendidikan KVT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        .glass { background: rgba(255,255,255,0.05); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); }
        .glass-dark { background: rgba(0,0,0,0.4); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); }
        .gradient-text { background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        .fade-in { opacity: 0; transform: translateY(30px); }
        .slide-left { opacity: 0; transform: translateX(-50px); }
        .slide-right { opacity: 0; transform: translateX(50px); }
        .scale-in { opacity: 0; transform: scale(0.8); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }

        /* Elegant Popup Styles */
        .popup-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(8px); z-index: 50; display: flex; align-items: center; justify-content: center; }
        .popup-content { background: linear-gradient(145deg, #1a1a1a 0%, #0d0d0d 100%); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 2rem; max-width: 480px; width: 90%; box-shadow: 0 25px 60px rgba(0,0,0,0.5); }
        .popup-success { border-top: 3px solid #22c55e; }
        .popup-error { border-top: 3px solid #ef4444; }
        .popup-warning { border-top: 3px solid #f59e0b; }
        .popup-info { border-top: 3px solid #6b7280; }

        .btn-primary { @apply bg-white text-black font-semibold px-6 py-3 rounded-lg hover:bg-gray-200 transition-all duration-200; }
        .btn-secondary { @apply bg-transparent text-white font-semibold px-6 py-3 rounded-lg border border-gray-600 hover:border-white transition-all duration-200; }
        .btn-danger { @apply bg-red-600 text-white font-semibold px-4 py-2 rounded-lg hover:bg-red-700 transition-all duration-200; }

        input, select, textarea {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            color: white !important;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: border-color 0.2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: rgba(255,255,255,0.4) !important;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.05);
        }
        select option { background: #111; color: white; }
    </style>
    @stack('styles')
</head>
<body class="bg-black text-white min-h-screen antialiased">
    @yield('content')

    {{-- ELEGANT POPUP COMPONENT --}}
    <div x-data="popupManager()" x-init="init()" x-cloak>
        <template x-if="show">
            <div class="popup-overlay" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click.self="close()">
                <div class="popup-content" :class="'popup-' + type"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <template x-if="type === 'success'">
                                <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <template x-if="type === 'error'">
                                <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <template x-if="type === 'warning'">
                                <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.068 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            </template>
                            <template x-if="type === 'info'">
                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </template>
                            <h3 class="text-lg font-bold text-white" x-text="title"></h3>
                        </div>
                        <button @click="close()" class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed" x-text="message"></p>
                    <div class="mt-6 flex justify-end">
                        <button @click="close()" class="bg-white text-black px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">OK</button>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script>
        function popupManager() {
            return {
                show: false,
                type: 'info',
                title: '',
                message: '',
                init() {
                    @if(session('success'))
                        this.open('success', 'Berhasil', '{{ session('success') }}');
                    @endif
                    @if(session('error'))
                        this.open('error', 'Terjadi Kesalahan', '{{ session('error') }}');
                    @endif
                    @if(session('warning'))
                        this.open('warning', 'Peringatan', '{{ session('warning') }}');
                    @endif
                    @if(session('info'))
                        this.open('info', 'Informasi', '{{ session('info') }}');
                    @endif
                },
                open(type, title, message) {
                    this.type = type;
                    this.title = title;
                    this.message = message;
                    this.show = true;
                },
                close() {
                    this.show = false;
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
