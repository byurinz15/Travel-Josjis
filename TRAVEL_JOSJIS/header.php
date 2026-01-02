<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Josjis - Travel Pilihan Keluarga</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icon Library -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900 flex flex-col min-h-screen">

<!-- NAVBAR (Fixed & Modern) -->
<nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center cursor-pointer group" onclick="window.location.href='index.php'">
                <div class="p-2 rounded-lg bg-blue-600 text-white">
                    <!-- Icon Mobil -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                </div>
                <span class="ml-3 font-bold text-xl tracking-wider text-blue-900">
                    TRAVEL<span class="text-yellow-500">JOSJIS</span>
                </span>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-8">
                    <a href="index.php" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="jadwal.php" class="text-gray-600 hover:text-blue-600 font-medium transition">Jadwal & Armada</a>
                    <!-- Tombol Cek Pesanan Diarahkan ke cek_pesanan.php -->
                    <a href="cek_pesanan.php" class="px-5 py-2.5 rounded-full font-bold bg-blue-600 text-white hover:bg-blue-700 transition shadow-lg shadow-blue-500/30">
                        Cek Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow">
