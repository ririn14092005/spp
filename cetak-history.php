<?php
include 'koneksi.php';
if (empty($_SESSION['user']['level'] == 'Admin')) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<script>
    window.print();
</script>

<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th colspan="8">History Pembayaran</th>
    </tr>
    <tr>
        <th>No</th>
        <th>Nama Petugas</th>
        <th>Nama Siswa</th>
        <th>Tanggal Bayar</th>
        <th>Tahun Bayar</th>
        <th>Spp</th>
        <th>Jumlah Bayar</th>
        <th>Status</th>
    </tr>
    <?php
    if (isset($_GET['nisn'])) {
        $i = 1;
        $nisn = $_GET['nisn'];
        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp WHERE pembayaran.nisn='$nisn'");
    }
    while ($data = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $data['nama_petugas'] ?></td>
            <td><?php echo $data['nama'] ?></td>
            <td><?php echo $data['tgl_bayar'] ?></td>
            <td><?php echo $data['tahun_bayar'] ?></td>
            <td><?php echo $data['tahun'] ?> -Rp <?php echo number_format($data['nominal'], 2, ',') ?></td>
            <td>Rp <?php echo number_format($data['jumlah_bayar'], 2, ',') ?></td>
            <td>
                <?php
                if ($data['jumlah_bayar'] < $data['nominal']) {
                    echo 'Kurang';
                } else {
                    echo 'Lunas';
                }
                ?>
            </td>
        </tr>
    <?php
        $i++;
    }
    ?>
</table>