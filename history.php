<?php
if (isset($_POST['nisn'])) {
    $id_petugas = $_SESSION['petugas']['id_petugas'];
    $nama = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $query = mysqli_query($koneksi, "INSERT INTO pembayaran (id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar) VALUES('$id_petugas','$nama','$tl_bayar','$bulan_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')");

    if ($query) {
        echo '<script>alert("Data Berhasil di Tambah");location,href="?page=laporan"</script>';
    }
}

if (empty($_SESSION['user']['level'])) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3">History Pembayaran, <?php echo $_GET['nisn'] ?></h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['user']['level'] == 'Admin')) {
                ?>
                    <a href="cetak-history.php?nisn=<?php echo $_GET['nisn'] ?>" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-print"></i></a>
                <?php
                }
                ?>
                <table class="table table-striped table-bordered table-hover cell-border" id="history">
                    <table class="table table-bordered table-striped table-hover" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Petugas</th>
                                <th>Nama Siswa</th>
                                <th>Tanggal Bayar</th>
                                <th>Tahun Bayar</th>
                                <th>Spp</th>
                                <th>Jumlah Bayar</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                    <td>
                                        <?php
                                        if ($data['jumlah_bayar'] == $data['nominal']) {
                                        ?>
                                            <button class="btn btn-success btn-sm">Lunas</button>
                                        <?php
                                        } else {
                                        ?>
                                            <button data-bs-toggle="modal" data-bs-target="#lunasi<?php echo $data['id_pembayaran']; ?>" class="btn btn-warning btn-sm">Lunasi</button>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editpembayaran<?php echo $data['id_pembayaran'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="col-12">
                                                    <big><a href="" data-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                    <div class="text-center">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Pembayaran</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <form method="post" action="crud/laporan.php">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="id_pembayaran" value="<?php echo $data['id_pembayaran'] ?>">
                                                        <label class="form-label">Nama Petugas</label>
                                                        <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Siswa</label>
                                                        <input type="text" name="nama_siswa" class="form-control" value="<?php echo $data['nama'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">SPP</label>
                                                        <input type="text" name="tahun&nominal" class="form-control" value="<?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Jumlah Bayar</label>
                                                        <input type="text" name="jumlah_bayar" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="col-12">
                                                        <div class="text-center">
                                                            <button type="submit" class="btn btn-success" name="edit">Simpan</button>
                                                            <button type="reset" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $i++;
                            }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>