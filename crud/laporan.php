<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $nama_siswa = $_POST['nama_siswa'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $query = mysqli_query($koneksi, "INSERT INTO pembayaran (nama_petugas,nama_siswa,tgl_bayar,tahun_bayar,id_spp,jumlah_bayar) VALUES('$nama_petugas','$nama_siswa','$tgl_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')");

    if ($query) {
        echo '<script>alert("Data Berhasl di Tambah");location.href="../?page=laporan"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $nama_petugas = $_POST['nama_petugas'];
    $kekurangan = $_POST['kekurangan'];
    $old_jumlah_bayar = $_POST['old_jumlah_bayar'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];

    $total = $old_jumlah_bayar + $jumlah_bayar;

    if ($jumlah_bayar > $kekurangan) {
        echo '<script>alert("Jumlah Bayar Melebihi Kekurangan.");location.href="../?page=laporan"</script>';
    } else {
        $query = mysqli_query($koneksi, "UPDATE pembayaran SET id_petugas='$nama_petugas',tgl_bayar='$tanggal_bayar',bulan_bayar='$bulan_bayar',tahun_bayar='$tahun_bayar', jumlah_bayar='$total' WHERE id_pembayaran='$id_pembayaran'");

        if ($query) {
            echo '<script>alert("Pembayaran Berhasil.");location.href="../?page=laporan"</script>';
        }
    }
}
