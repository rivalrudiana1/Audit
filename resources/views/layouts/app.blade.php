<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - AuditSys</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus+Jakarta+Sans', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 flex flex-col h-screen overflow-hidden">

    <div class="flex flex-1 h-full overflow-hidden">

        <aside id="sidebar"
            class="w-[220px] bg-[#1A3A5C] flex flex-col shrink-0 transition-[width] duration-300 overflow-hidden">

            <div class="flex items-center gap-2.5 px-4 pt-5 pb-4 border-b border-white/10">
                <div class="w-7 h-7 bg-blue-600 rounded-md flex items-center justify-center shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="white"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                </div>
                <span class="text-white font-semibold text-[15px] whitespace-nowrap">AuditSys</span>
            </div>

            <nav class="flex-1 px-2 pt-4 flex flex-col gap-1 overflow-y-auto">

    <div
        class="text-[10px] font-semibold text-white/40 tracking-widest uppercase px-2.5 pb-1 mt-1">
        Utama
    </div>

    {{-- DASHBOARD (SEMUA ROLE) --}}
    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('dashboard') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="1.8"
            stroke-linecap="round" stroke-linejoin="round">

            <rect x="3" y="3" width="7" height="7" />
            <rect x="14" y="3" width="7" height="7" />
            <rect x="14" y="14" width="7" height="7" />
            <rect x="3" y="14" width="7" height="7" />

        </svg>

        Dashboard

    </a>

    {{-- KHUSUS ADMIN --}}
    @if(auth()->user()->role == 'admin')

        <a href="{{ route('users.index') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('users*') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24">

                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>

            </svg>

            Kelola User

        </a>

        <a href="{{ route('tpus.index') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('tpus*') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                viewBox="0 0 24 24">

                <path d="M3 21h18"/>
                <path d="M5 21V7l8-4 8 4v14"/>
                <path d="M9 9h.01"/>
                <path d="M9 13h.01"/>
                <path d="M9 17h.01"/>
                <path d="M15 9h.01"/>
                <path d="M15 13h.01"/>
                <path d="M15 17h.01"/>

            </svg>

            Kelola TPU

        </a>

    @endif

    {{-- ADMIN + KEPALA TPU --}}
    @if(in_array(auth()->user()->role, ['admin', 'kepala_tpu']))

        <a href="{{ url('/upload') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('upload') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <polyline points="16 16 12 12 8 16" />
                <line x1="12" y1="12" x2="12" y2="21" />
                <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3" />

            </svg>

            Upload File

        </a>

    @endif

    {{-- SEMUA ROLE --}}
    @if(in_array(auth()->user()->role, ['admin','kepala_tpu','kepala_uptd']))

        <a href="{{ url('/audit') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('audit*') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
                <line x1="16" y1="13" x2="8" y2="13" />
                <line x1="16" y1="17" x2="8" y2="17" />
                <polyline points="10 9 9 9 8 9" />

            </svg>

            Hasil Audit

        </a>

    @endif

    {{-- KHUSUS ADMIN --}}
    @if(auth()->user()->role == 'admin')

        <div
            class="text-[10px] font-semibold text-white/40 tracking-widest uppercase px-2.5 pb-1 mt-4">

            Laporan

        </div>

        <a href="{{ url('/notifications') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('notifications') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                <path d="M13.73 21a2 2 0 0 1-3.46 0" />

            </svg>

            Notifikasi

            <span
                class="ml-auto bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full leading-none">

                3

            </span>

        </a>

        <a href="{{ url('/settings') }}"
            class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors {{ request()->is('settings') ? 'bg-white/15 text-white font-medium' : 'text-white/65 hover:bg-white/10 hover:text-white' }}">

            <svg width="16" height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <circle cx="12" cy="12" r="3" />

                <path
                    d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />

            </svg>

            Pengaturan

        </a>

    @endif

    {{-- LOGOUT --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit"
            class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] whitespace-nowrap transition-colors text-white/65 hover:bg-red-500/20 hover:text-red-300">

            <svg width="16" height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />

            </svg>

            Logout

        </button>

    </form>

</nav>

            @if(auth()->check())
                <div class="px-4 py-3 border-b border-white/10 text-white">
                    <div class="text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </div>
                    <div class="text-xs text-slate-300">
                        {{ auth()->user()->email }}
                    </div>
                </div>
            @endif
        </aside>

        <div class="flex-1 flex flex-col min-w-0 bg-slate-100">

            <header
                class="h-[52px] bg-white border-b border-slate-200 flex items-center justify-between px-5 shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()"
                        class="p-1.5 rounded-md hover:bg-slate-100 transition-colors focus:outline-none text-slate-600">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <h1 class="font-semibold text-[15px]">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ url('/notifications') }}"
                        class="relative p-1.5 rounded-md text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition-colors block">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <span
                            class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                    </a>
                    <div
                        class="w-8 h-8 rounded-full bg-[#1A3A5C] text-white flex items-center justify-center text-xs font-semibold cursor-pointer shadow-sm">
                        AS</div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            // Toggle class width Tailwind
            sidebar.classList.toggle('w-[220px]');
            sidebar.classList.toggle('w-0');
        }
    </script>

    @stack('scripts')
</body>

</html>


</body>
</html>