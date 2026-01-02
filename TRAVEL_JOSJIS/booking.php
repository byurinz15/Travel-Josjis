<?php 
include 'koneksi.php'; 
include 'header.php'; 

// Ambil ID jadwal dari URL
if(!isset($_GET['id'])) {
    echo "<script>window.location='jadwal.php';</script>";
    exit;
}

$id_jadwal = $_GET['id'];

// UPDATE: Ambil s.price as final_price, HAPUS c.price_per_seat
$query = "SELECT s.*, c.car_name, s.price as final_price, c.image_url 
          FROM schedules s 
          JOIN cars c ON s.car_id = c.car_id 
          WHERE s.schedule_id = '$id_jadwal'";

$result = mysqli_query($conn, $query);
if (!$result) die("Error Database: " . mysqli_error($conn));
$row = mysqli_fetch_assoc($result);

if(!$row) {
    echo "<script>alert('Jadwal tidak ditemukan!'); window.location='jadwal.php';</script>";
    exit;
}

// LOGIKA STOK: Langsung ambil dari seat_capacity di tabel schedules
$sisa_kursi = isset($row['seat_capacity']) ? $row['seat_capacity'] : 0;

if($sisa_kursi <= 0) {
    echo "<script>alert('Mohon maaf, kursi untuk jadwal ini sudah habis atau data kapasitas belum diisi.'); window.location='jadwal.php';</script>";
    exit;
}
?>

<div class="min-h-screen bg-gray-50 pt-28 pb-12">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col md:flex-row">
            
            <div class="w-full md:w-1/3 bg-gray-900 p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-blue-400 mb-2">Detail Perjalanan</h3>
                    <h2 class="text-3xl font-bold mb-6"><?= $row['car_name'] ?></h2>
                    <div class="space-y-6 text-sm">
                        <div>
                            <span class="block text-gray-400 uppercase text-xs font-bold tracking-wider mb-1">Rute</span>
                            <div class="font-medium text-lg"><?= $row['origin'] ?> <span class="text-gray-500 mx-1">➜</span> <?= $row['destination'] ?></div>
                        </div>
                        <div>
                            <span class="block text-gray-400 uppercase text-xs font-bold tracking-wider mb-1">Jadwal</span>
                            <div class="font-medium text-lg"><?= date('d M Y', strtotime($row['departure_time'])) ?></div>
                            <div class="font-medium text-blue-300"><?= date('H:i', strtotime($row['departure_time'])) ?> WIB</div>
                        </div>
                        <div>
                            <span class="block text-gray-400 uppercase text-xs font-bold tracking-wider mb-1">Harga per Kursi</span>
                            <!-- Harga dari final_price -->
                            <div class="font-medium text-2xl text-green-400">Rp <?= number_format($row['final_price'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/3 p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Isi Data Pemesan</h2>
                
                <form action="proses_booking.php" method="POST" class="space-y-5">
                    <input type="hidden" name="schedule_id" value="<?= $row['schedule_id'] ?>">
                    <!-- Input Harga -->
                    <input type="hidden" name="price" value="<?= $row['final_price'] ?>">

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 outline-none" placeholder="Nama Lengkap">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 outline-none" placeholder="email@contoh.com">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label>
                            <input type="number" name="phone" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-blue-500 outline-none" placeholder="0812...">
                        </div>
                    </div>

                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah Kursi</label>
                        <div class="flex items-center gap-4">
                            <input type="number" name="jumlah_kursi" 
                                   min="1" 
                                   max="<?= $sisa_kursi ?>" 
                                   required 
                                   class="w-24 px-4 py-3 rounded-xl border border-gray-300 font-bold text-center text-lg focus:border-blue-500 outline-none" 
                                   value="1">
                            <div class="text-sm text-gray-600">
                                Tersedia <span class="font-bold text-blue-600"><?= $sisa_kursi ?></span> kursi lagi.
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg mt-4">
                        Konfirmasi Pemesanan
                    </button>
                    <a href="jadwal.php" class="block text-center text-gray-500 text-sm hover:underline mt-4">Batal & Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
