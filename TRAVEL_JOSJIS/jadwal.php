<?php 
include 'koneksi.php'; 
include 'header.php'; 

$whereClause = "";
if (isset($_GET['asal']) && isset($_GET['tujuan'])) {
    $asal = $_GET['asal'];
    $tujuan = $_GET['tujuan'];
    $whereClause = "WHERE s.origin LIKE '%$asal%' AND s.destination LIKE '%$tujuan%'";
    $pesan_judul = "Hasil Pencarian: $asal ke $tujuan";
} else {
    $pesan_judul = "Jadwal & Armada Tersedia";
}

// UPDATE QUERY: Ambil s.price (Harga Rute) dan HAPUS c.price_per_seat
$query = "SELECT s.schedule_id, s.origin, s.destination, s.departure_time, s.seat_capacity, s.price, 
                 c.car_name, c.car_type, c.image_url
          FROM schedules s
          JOIN cars c ON s.car_id = c.car_id
          $whereClause
          ORDER BY s.departure_time ASC";

$result = mysqli_query($conn, $query);
?>

<div class="min-h-screen bg-gray-50 pt-28 pb-12">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-900"><?= $pesan_judul ?></h2>
                <p class="text-gray-500 mt-2">Temukan jadwal terbaik untuk perjalananmu.</p>
            </div>
            <?php if(!empty($whereClause)): ?>
                <a href="jadwal.php" class="text-blue-600 hover:underline font-medium">Tampilkan Semua Jadwal</a>
            <?php endif; ?>
        </div>

        <div class="space-y-6">
            <?php 
            if(mysqli_num_rows($result) == 0): 
                echo "<div class='text-center py-10 text-gray-500'>Tidak ada jadwal ditemukan.</div>";
            endif;

            while($row = mysqli_fetch_assoc($result)) : 
                // Stok kursi langsung dari tabel schedules
                $stok = isset($row['seat_capacity']) ? $row['seat_capacity'] : 0;
            ?>
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition duration-300 flex flex-col md:flex-row gap-6 items-center">
                
                <div class="w-full md:w-64 h-48 md:h-40 shrink-0 rounded-xl overflow-hidden relative group bg-gray-200">
                    <?php 
                        $gambar = !empty($row['image_url']) ? $row['image_url'] : '[https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=400](https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=400)';
                    ?>
                    <img src="<?= $gambar ?>" 
                         alt="<?= $row['car_name'] ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500" 
                         onerror="this.src='[https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=400](https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?auto=format&fit=crop&q=80&w=400)'" />
                </div>

                <div class="flex-grow w-full">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900"><?= $row['car_name'] ?></h3>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                <?= $row['car_type'] ?>
                            </span>
                        </div>
                        <div class="text-right hidden md:block">
                            <!-- HARGA DARI S.PRICE -->
                            <p class="text-2xl font-bold text-blue-600">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                            <p class="text-xs text-gray-400">/ orang</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 my-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase font-bold">Waktu</span>
                            <!-- Menampilkan Tanggal dan Jam -->
                            <div class="mt-1 text-gray-700 font-medium">
                                <div class="text-xs text-gray-500 mb-0.5"><?= date('d M Y', strtotime($row['departure_time'])) ?></div>
                                <div class="text-base"><?= date('H:i', strtotime($row['departure_time'])) ?> WIB</div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase font-bold">Rute</span>
                            <div class="flex items-center mt-1 text-gray-700 font-medium">
                                <?= $row['origin'] ?> - <?= $row['destination'] ?>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400 uppercase font-bold">Sisa Kursi</span>
                            <div class="flex items-center mt-1 font-medium">
                                <?php if($stok == 0): ?>
                                    <span class="text-red-600 font-bold bg-red-100 px-2 py-0.5 rounded">HABIS</span>
                                <?php elseif($stok <= 3): ?>
                                    <span class="text-orange-600 font-bold"><?= $stok ?> Tersisa!</span>
                                <?php else: ?>
                                    <span class="text-gray-700"><?= $stok ?> Kursi</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="md:hidden flex justify-between items-center border-t pt-4 mt-4">
                        <div>
                            <!-- HARGA DARI S.PRICE (Mobile) -->
                            <p class="text-lg font-bold text-blue-600">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                            <p class="text-xs text-gray-400">/ orang</p>
                        </div>
                        <?php if($stok > 0): ?>
                            <a href="booking.php?id=<?= $row['schedule_id'] ?>" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold text-sm shadow-lg shadow-blue-500/30">Pilih</a>
                        <?php else: ?>
                            <button disabled class="bg-gray-300 text-gray-500 px-6 py-2 rounded-lg font-bold text-sm cursor-not-allowed">Penuh</button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="hidden md:flex flex-col justify-center border-l pl-6 border-dashed border-gray-200 h-32">
                    <?php if($stok > 0): ?>
                        <a href="booking.php?id=<?= $row['schedule_id'] ?>" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-blue-500/30 transition transform hover:-translate-y-1">
                            Pilih
                        </a>
                    <?php else: ?>
                        <button disabled class="bg-gray-300 text-gray-500 px-8 py-3 rounded-xl font-bold cursor-not-allowed">Penuh</button>
                    <?php endif; ?>
                </div>

            </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
