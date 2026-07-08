<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel Admin') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-100">
        <!-- Page Wrapper -->
        <div class="flex h-screen overflow-hidden">

            <!-- Sidebar -->
            <aside class="absolute left-0 top-0 z-50 flex h-screen w-64 flex-col overflow-y-hidden bg-gray-900 duration-300 ease-linear lg:static lg:translate-x-0">
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between gap-2 px-6 py-6 border-b border-gray-800">
                    <a href="{{ route('reports.index') }}" class="text-white text-2xl font-bold flex items-center gap-2">
                        <span>Admin Panel</span>
                    </a>
                </div>

                <!-- Sidebar Menu -->
                <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
                    <nav class="mt-5 py-4 px-4 lg:mt-6 lg:px-6">
                        <div>
                            <h3 class="mb-4 ml-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu</h3>
                            <ul class="mb-6 flex flex-col gap-1.5">
                                <li>
                                    <a class="group relative flex items-center gap-2.5 rounded-md px-4 py-3 font-medium text-gray-300 duration-300 ease-in-out hover:bg-gray-800 {{ request()->routeIs('reports.index') ? 'bg-gray-800 text-white' : '' }}" href="{{ route('reports.index') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Laporan Penjualan
                                    </a>
                                </li>
                                <!-- Tambahan menu produk dll bisa ditaruh di sini ke depan -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </aside>
            <!-- ===== Sidebar End ===== -->

            <!-- Content Area -->
            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                
                <!-- Header -->
                <header class="sticky top-0 z-40 flex w-full bg-white drop-shadow-sm border-b border-gray-200">
                    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
                        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                            <!-- Mobile Menu Toggler (Placeholder) -->
                            <button class="block rounded-sm border border-stroke bg-white p-1.5 shadow-sm lg:hidden text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </div>
                        
                        <!-- Header Right (User Area) -->
                        <div class="flex items-center gap-4 ml-auto">
                            <span class="text-sm font-bold text-gray-700 bg-gray-100 px-3 py-1 rounded-full">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <!-- Dropdown Logout sederhana -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 hover:underline font-semibold flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </header>
                <!-- ===== Header End ===== -->

                <!-- Main Content -->
                <main>
                    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                        <!-- Judul Halaman -->
                        @isset($header)
                            <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                {{ $header }}
                            </div>
                        @endisset

                        {{ $slot }}
                    </div>
                </main>
                <!-- ===== Main Content End ===== -->

            </div>
        </div>
    </body>
</html>
