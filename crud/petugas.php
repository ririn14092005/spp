<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nama_petugas = $_POST['nama_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];

    $query = mysqli_query($koneksi, "INSERT INTO petugas (nama_petugas,username,password,level) VALUES('$nama_petugas','$username','$password','$level')");

    if ($query) {
        echo '<script>alert("Data Berhasl di Tambah");location.href="../?page=petugas"</script>';
    }
}
if (isset($_POST['edit'])) {
    $id = $_POST['id_petugas'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $nama_petugas = $_POST['nama_petugas'];
    $level = $_POST['level'];

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE petugas SET username='$username',nama_petugas='$nama_petugas',level='$level' WHERE id_petugas='$id'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="../?page=petugas"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE petugas SET username='$username',nama_petugas='$nama_petugas',level='$level',password='$password' WHERE id_petugas='$id'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="../?page=petugas"</script>';
        }
    }
}
if (isset($_POST['hapus'])) {
    $id = $_POST['id_petugas'];

    $query = mysqli_query($koneksi, "DELETE FROM petugas WHERE id_petugas='$id'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="../?page=petugas"</script>';
    }
}
