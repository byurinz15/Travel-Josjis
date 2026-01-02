<?php include 'header.php'; ?>

<!-- HERO SECTION -->
<div class="relative h-[650px] flex items-center justify-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=2000" alt="Travel Bus" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/90 to-blue-800/60 mix-blend-multiply"></div>
    </div>

    <div class="relative z-10 w-full max-w-5xl px-4 pt-10 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-blue-500/30 text-blue-100 backdrop-blur-sm border border-blue-400/30 text-sm font-medium mb-4">
            🚀 #1 Travel Pilihan Keluarga
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight">
            Jelajahi Kota <br />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-yellow-500">Tanpa Batas</span>
        </h1>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto font-light">
            Nikmati perjalanan antar kota dengan armada premium kami. Pesan tiket mudah, cepat, dan aman.
        </p>

        <!-- SEARCH WIDGET FORM -->
        <div class="bg-white p-4 rounded-2xl shadow-2xl backdrop-blur-xl bg-white/95 max-w-4xl mx-auto transform translate-y-8 border border-gray-100 text-left">
            <form action="cek_ketersediaan.php" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Dari Mana?</label>
                            <div class="flex items-center bg-gray-50 p-3 rounded-xl border hover:border-blue-400 transition">
                                <!-- Input diberi nama 'asal' -->
                                <input type="text" name="asal" required placeholder="Kota Asal (ex: Jakarta)" class="bg-transparent w-full outline-none font-semibold text-gray-700 placeholder-gray-400" />
                            </div>
                        </div>
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Ke Mana?</label>
                            <div class="flex items-center bg-gray-50 p-3 rounded-xl border hover:border-blue-400 transition">
                                <!-- Input diberi nama 'tujuan' -->
                                <input type="text" name="tujuan" required placeholder="Kota Tujuan (ex: Bandung)" class="bg-transparent w-full outline-none font-semibold text-gray-700 placeholder-gray-400" />
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1 flex justify-center items-center">
                        Cari Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- FEATURES SECTION (Tetap sama) -->
<div class="pt-32 pb-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Kenapa Memilih <span class="text-blue-600">Travel Josjis?</span></h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Kami berkomitmen memberikan pengalaman perjalanan terbaik dengan standar keamanan tinggi.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Aman & Terpercaya</h3>
                <p class="text-gray-500 leading-relaxed">Asuransi perjalanan termasuk dalam setiap tiket yang Anda pesan demi ketenangan hati.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Tepat Waktu</h3>
                <p class="text-gray-500 leading-relaxed">Jaminan keberangkatan tepat waktu. Waktu Anda sangat berharga bagi kami.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition duration-300 group">
                <div class="w-14 h-14 rounded-2xl bg-yellow-50 flex items-center justify-center mb-6 group-hover:scale-110 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Layanan Premium</h3>
                <p class="text-gray-500 leading-relaxed">Armada terbaru dengan fasilitas reclining seat, charger, dan AC dingin.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
