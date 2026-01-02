<?php
include 'koneksi.php';

// Ambil input dari user
$asal = isset($_GET['asal']) ? $_GET['asal'] : '';
$tujuan = isset($_GET['tujuan']) ? $_GET['tujuan'] : '';

// Mencegah SQL Injection sederhana
$asal_safe = mysqli_real_escape_string($conn, $asal);
$tujuan_safe = mysqli_real_escape_string($conn, $tujuan);

// Cek di database apakah ada rute yang mirip
$query = "SELECT schedule_id FROM schedules 
          WHERE origin LIKE '%$asal_safe%' AND destination LIKE '%$tujuan_safe%'";

$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
    // JIKA ADA: Redirect ke halaman jadwal dengan membawa parameter
    header("Location: jadwal.php?asal=$asal&tujuan=$tujuan");
} else {
    // JIKA TIDAK ADA: TAMPILKAN HALAMAN UI MODERN (Bukan Alert)
    include 'header.php';
    ?>
    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center border border-gray-100 relative overflow-hidden">
            
            <!-- Icon Pencarian Kosong -->
            <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    <line x1="11" y1="8" x2="11" y2="14"></line>
                    <line x1="8" y1="11" x2="14" y2="11"></line>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Rute Belum Tersedia</h2>
            
            <p class="text-gray-500 mb-8 leading-relaxed">
                Mohon maaf, kami belum menemukan jadwal perjalanan dari 
                <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded"><?= htmlspecialchars($asal) ?></span> ke 
                <span class="font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded"><?= htmlspecialchars($tujuan) ?></span>.
            </p>
            
            <div class="space-y-3">
                <a href="index.php" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                    Cari Rute Lain
                </a>
                <a href="jadwal.php" class="block w-full bg-white text-gray-600 font-bold py-4 rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                    Lihat Semua Jadwal
                </a>
            </div>

            <!-- Hiasan Background Kecil -->
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 blur-xl"></div>
            <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-24 h-24 bg-red-50 rounded-full opacity-50 blur-xl"></div>
        </div>
    </div>
    <?php
    include 'footer.php';
}
?>