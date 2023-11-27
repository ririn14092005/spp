<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];

    $query = mysqli_query($koneksi, "INSERT INTO spp (tahun,nominal) VALUES('$tahun','$nominal')");

    if ($query) {
        echo '<script>alert("Data Berhasl di Tambah");location.href="../?page=spp"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_spp = $_POST['id_spp'];
    $tahun = $_POST['tahun'];
    $nominal = $_POST['nominal'];


    $query = mysqli_query($koneksi, "UPDATE spp SET tahun='$tahun',nominal='$nominal' WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Update");location.href="../?page=spp"</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_spp = $_POST['id_spp'];

    $query = mysqli_query($koneksi, "DELETE FROM spp WHERE id_spp='$id_spp'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="../?page=spp"</script>';
    }
}
