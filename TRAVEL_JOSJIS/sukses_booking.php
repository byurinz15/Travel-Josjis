<?php
include 'koneksi.php';
include 'header.php';

$booking_id = $_GET['id'];

// Ambil data lengkap hasil join 4 tabel (bookings, users, schedules, cars)
$query = "SELECT b.*, u.full_name, u.email, s.origin, s.destination, s.departure_time, c.car_name, c.car_type 
          FROM bookings b
          JOIN users u ON b.user_id = u.user_id
          JOIN schedules s ON b.schedule_id = s.schedule_id
          JOIN cars c ON s.car_id = c.car_id
          WHERE b.booking_id = '$booking_id'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<div class='min-h-screen flex items-center justify-center'>Data tidak ditemukan</div>";
    exit;
}
?>

<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4 pt-24 pb-12">
    <div class="bg-white p-10 rounded-3xl shadow-2xl max-w-lg w-full text-center relative overflow-hidden border border-gray-100">
        
        <!-- Hiasan Atas -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-blue-600"></div>
        
        <!-- Icon Sukses Animasi -->
        <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Pembayaran Berhasil!</h2>
        <p class="text-gray-500 mb-8 leading-relaxed">
            Terima kasih <b><?= $data['full_name'] ?></b>. E-Tiket perjalanan Anda telah terbit.
        </p>
        
        <!-- Kartu Tiket -->
        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 mb-8 text-left relative">
            <!-- Hiasan Bolong Tiket -->
            <div class="absolute -left-3 top-1/2 w-6 h-6 bg-white rounded-full border-r border-gray-200 transform -translate-y-1/2"></div>
            <div class="absolute -right-3 top-1/2 w-6 h-6 bg-white rounded-full border-l border-gray-200 transform -translate-y-1/2"></div>

            <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-4 border-dashed">
                <span class="text-gray-500 text-sm font-medium">Kode Booking</span>
                <span class="font-mono text-xl font-bold text-blue-600 tracking-wider">TRV-<?= $data['booking_id'] ?></span>
            </div>
            
            <div class="space-y-3 text-sm text-gray-600">
                <div class="flex justify-between">
                    <span>Armada</span> 
                    <span class="font-bold text-gray-900"><?= $data['car_name'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Rute</span> 
                    <span class="font-bold text-gray-900"><?= $data['origin'] ?> -> <?= $data['destination'] ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Jadwal</span> 
                    <span class="font-bold text-gray-900"><?= date('d M Y, H:i', strtotime($data['departure_time'])) ?></span>
                </div>
                <div class="flex justify-between">
                    <span>Kursi</span> 
                    <span class="font-bold text-gray-900"><?= $data['total_seats'] ?> Orang</span>
                </div>
                 <div class="flex justify-between pt-2 border-t border-gray-200 mt-2">
                    <span>Total Bayar</span> 
                    <span class="font-bold text-green-600 text-lg">Rp <?= number_format($data['total_price'], 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <a href="index.php" class="block w-full bg-gray-900 text-white font-bold py-4 rounded-xl hover:bg-black transition shadow-lg transform hover:-translate-y-1">
            Kembali ke Beranda
        </a>
    </div>
</div>

<?php include 'footer.php'; ?>
