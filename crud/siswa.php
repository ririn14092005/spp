<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $password = md5($_POST['password']);

    $cek = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");
    $cek_nisn = mysqli_num_rows($cek);
    $cek1 = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis='$nis'");
    $cek_nis = mysqli_num_rows($cek1);

    if ($cek_nisn > 0) {
        echo '<script>alert("NISN sudah digunakan.");location.href="../?page=siswa"</script>';
    } elseif ($cek_nis > 0) {
        echo '<script>alert("NIS sudah digunakan.");location.href="../?page=siswa"</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO siswa (nisn,nis,nama,id_kelas,alamat,no_telp,password) VALUES('$nisn','$nis','$nama_siswa','$id_kelas','$alamat','$no_telp','$password')");

        if ($query) {
            echo '<script>alert("Data Berhasl di Tambah");location.href="../?page=siswa"</script>';
        }
    }
}
if (isset($_POST['edit'])) {
    $oldnisn = $_POST['oldnisn'];
    $nisn = $_POST['nisn'];
    $nis = $_POST['nis'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telepon'];
    $password = md5($_POST['password']);

    if (empty($_POST['password'])) {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama_siswa', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp' WHERE nisn='$oldnisn'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="../?page=siswa"</script>';
        }
    } else {
        $query = mysqli_query($koneksi, "UPDATE siswa SET nisn='$nisn', nis='$nis', nama='$nama_siswa', id_kelas='$id_kelas', alamat='$alamat', no_telp='$no_telp',password='$password' WHERE nisn='$oldnisn'");

        if ($query) {
            echo '<script>alert("Data Berhasil di Update");location.href="../?page=siswa"</script>';
        }
    }
}
if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];

    $query = mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn='$nisn'");

    if ($query) {
        echo '<script>alert("Data Berhasil di Hapus");location.href="../?page=siswa"</script>';
    }
}
