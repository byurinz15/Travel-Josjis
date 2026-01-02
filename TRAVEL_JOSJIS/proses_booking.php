<?php
include 'koneksi.php';

// Cek apakah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $schedule_id = $_POST['schedule_id'];
    $nama        = htmlspecialchars($_POST['nama']); 
    $email       = $_POST['email'];
    $phone       = $_POST['phone'];
    $jumlah      = $_POST['jumlah_kursi'];
    $harga       = $_POST['price'];
    
    $total_harga = $jumlah * $harga;
    $tanggal_booking = date('Y-m-d H:i:s');

    // 1. CEK STOK (Gunakan SELECT * agar aman)
    $cek_stok = mysqli_query($conn, "SELECT * FROM schedules WHERE schedule_id = '$schedule_id'");
    
    if(!$cek_stok) {
         die("Error Database (Cek Stok): " . mysqli_error($conn));
    }
    
    $data_stok = mysqli_fetch_assoc($cek_stok);

    // Fallback stok jika kolom seat_capacity belum ada
    $stok_saat_ini = isset($data_stok['seat_capacity']) ? $data_stok['seat_capacity'] : 999;

    if ($stok_saat_ini < $jumlah) {
        // Tampilan Error Stok Habis
        include 'header.php';
        echo "<div class='min-h-screen bg-gray-50 flex items-center justify-center p-4'>
                <div class='bg-white rounded-2xl shadow-xl p-8 max-w-md w-full text-center border border-red-100'>
                    <div class='w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='text-red-600'><circle cx='12' cy='12' r='10'></circle><line x1='15' y1='9' x2='9' y2='15'></line><line x1='9' y1='9' x2='15' y2='15'></line></svg>
                    </div>
                    <h2 class='text-2xl font-bold text-gray-900 mb-2'>Kursi Habis!</h2>
                    <p class='text-gray-500 mb-8'>Mohon maaf, kursi yang Anda pilih baru saja habis terjual.</p>
                    <a href='jadwal.php' class='block w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-gray-800 transition'>Cari Jadwal Lain</a>
                </div>
              </div>";
        include 'footer.php';
        exit;
    }

    // 2. PROSES USER (Cek apakah user sudah ada)
    $cek_user = mysqli_query($conn, "SELECT user_id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_user) > 0) {
        $row_user = mysqli_fetch_assoc($cek_user);
        $user_id = $row_user['user_id'];
    } else {
        // PENTING: Gunakan 'full_name' sesuai informasi database Anda
        $insert_user = mysqli_query($conn, "INSERT INTO users (full_name, email, phone_number) VALUES ('$nama', '$email', '$phone')");
        
        if(!$insert_user) {
            die("<br><h3>Gagal Membuat User Baru</h3><p>Pesan Error: " . mysqli_error($conn) . "</p>");
        }
        $user_id = mysqli_insert_id($conn);
    }

    // 3. INSERT BOOKING (FIXED: payment_status)
    $insert_booking = "INSERT INTO bookings (user_id, schedule_id, total_seats, total_price, booking_date, payment_status) 
                       VALUES ('$user_id', '$schedule_id', '$jumlah', '$total_harga', '$tanggal_booking', 'confirmed')";
    
    if (mysqli_query($conn, $insert_booking)) {
        
        // 4. UPDATE STOK KURSI
        if(isset($data_stok['seat_capacity'])) {
            $update_kursi = "UPDATE schedules SET seat_capacity = seat_capacity - $jumlah WHERE schedule_id = '$schedule_id'";
            mysqli_query($conn, $update_kursi);
        }

        // --- TAMPILAN SUKSES (UI MODERN) ---
        include 'header.php';
        ?>
        <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4 pt-20">
            <div class="bg-white rounded-3xl shadow-xl p-8 max-w-md w-full text-center border border-green-100 relative overflow-hidden">
                <!-- Confetti Effect (Optional CSS) -->
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-blue-500"></div>

                <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                </div>

                <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Pemesanan Berhasil!</h2>
                <p class="text-gray-500 mb-8 leading-relaxed">Terima kasih <b><?= $nama ?></b>, tiket Anda telah berhasil diterbitkan. Silakan simpan bukti ini.</p>
                
                <div class="bg-gray-50 rounded-xl p-4 mb-8 text-left border border-gray-100">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-500 text-sm">Total Bayar</span>
                        <span class="font-bold text-gray-900">Rp <?= number_format($total_harga, 0, ',', '.') ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 text-sm">Status</span>
                        <span class="text-green-600 font-bold text-sm bg-green-100 px-2 py-0.5 rounded">LUNAS</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="cek_pesanan.php?email=<?= $email ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                        Lihat Tiket Saya
                    </a>
                    <a href="index.php" class="block w-full bg-white text-gray-600 font-bold py-4 rounded-xl border border-gray-200 hover:bg-gray-50 transition">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        <?php
        include 'footer.php';
        
    } else {
        die("<br><h3>Gagal Menyimpan Booking</h3><p>Pesan Error: " . mysqli_error($conn) . "</p>");
    }

} else {
    header("Location: index.php");
}
?>