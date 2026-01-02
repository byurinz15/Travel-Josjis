<?php 
include 'koneksi.php';
include 'header.php';

$email_cari = "";
$jumlah_booking = 0;
$hasil_pencarian = null;

if (isset($_GET['email'])) {
    $email_cari = $_GET['email'];
    
    // Query menghitung jumlah booking berdasarkan email user di tabel users -> bookings
    $query = "SELECT b.*, s.departure_time, c.car_name, s.origin, s.destination 
              FROM bookings b
              JOIN users u ON b.user_id = u.user_id
              JOIN schedules s ON b.schedule_id = s.schedule_id
              JOIN cars c ON s.car_id = c.car_id
              WHERE u.email = '$email_cari'
              ORDER BY b.booking_date DESC";
              
    $hasil_pencarian = mysqli_query($conn, $query);
    $jumlah_booking = mysqli_num_rows($hasil_pencarian);
}
?>

<div class="min-h-screen bg-gray-50 pt-28 pb-12">
    <div class="max-w-2xl mx-auto px-4">
        
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-900">Cek Pesanan Saya</h2>
            <p class="text-gray-500 mt-2">Masukkan email yang Anda gunakan saat pemesanan.</p>
        </div>

        <!-- Form Pencarian -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 mb-8">
            <form action="" method="GET" class="flex gap-4">
                <input type="email" name="email" required 
                       value="<?= $email_cari ?>"
                       placeholder="Masukkan Email Anda (contoh: budi@gmail.com)" 
                       class="flex-1 p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
                <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-blue-700 transition">
                    Cek
                </button>
            </form>
        </div>

        <!-- Hasil Pencarian -->
        <?php if ($email_cari != ""): ?>
            <div class="space-y-4">
                <?php if ($jumlah_booking > 0): ?>
                    
                    <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 text-center font-bold">
                        Ditemukan <?= $jumlah_booking ?> Mobil yang telah dipesan.
                    </div>

                    <?php while($row = mysqli_fetch_assoc($hasil_pencarian)): ?>
                    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 flex justify-between items-center hover:shadow-md transition">
                        <div>
                            <h4 class="font-bold text-lg text-gray-900"><?= $row['car_name'] ?></h4>
                            <p class="text-sm text-gray-500"><?= $row['origin'] ?> -> <?= $row['destination'] ?></p>
                            <p class="text-xs text-blue-600 font-medium mt-1">
                                Berangkat: <?= date('d M Y, H:i', strtotime($row['departure_time'])) ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="block text-2xl font-bold text-gray-800"><?= $row['total_seats'] ?> Kursi</span>
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mt-1">Paid</span>
                        </div>
                    </div>
                    <?php endwhile; ?>

                <?php else: ?>
                    <div class="text-center py-10 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500 text-lg">Tidak ada pesanan ditemukan untuk email <b><?= $email_cari ?></b>.</p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include 'footer.php'; ?>
