<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];

    $query = mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas,kompetensi_keahlian) VALUES('$nama_kelas','$kompetensi_keahlian')");

    if ($query) {
        echo '<script>alert("Data Berhasl di Tambah");location.href="../?page=kelas"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id_kelas = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi_keahlian = $_POST['kompetensi_keahlian'];


    $query = mysqli_query($koneksi, "UPDATE kelas SET id_kelas='$id_kelas', nama_kelas='$nama_kelas', kompetensi_keahlian='$kompetensi_keahlian' WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Update");location.href="../?page=kelas"</script>';
    }
}
if (isset($_POST['hapus'])) {
    $id_kelas = $_POST['id_kelas'];

    $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="../?page=kelas"</script>';
    }
}
