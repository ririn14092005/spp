<?php
if (empty($_SESSION['user']['level'])) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3" style="text-align: center;">Laporan</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-body">
                <?php
                if (!empty($_SESSION['user']['level'] == 'Admin')) {
                ?>
                    <a href="cetak-pembayaran.php" target="_blank" class="btn btn-success btn-sm mb-3"><i class="fa fa-print"></i></a>
                <?php
                }
                ?>
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
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM pembayaran INNER JOIN petugas ON pembayaran.id_petugas=petugas.id_petugas INNER JOIN siswa ON pembayaran.nisn=siswa.nisn INNER JOIN spp ON pembayaran.id_spp=spp.id_spp");
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
                                        <button data-toggle="modal" data-target="#lunasi<?php echo $data['id_pembayaran']; ?>" class="btn btn-warning btn-sm">Lunasi</button>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <div class="modal fade" id="lunasi<?php echo $data['id_pembayaran'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                                                    <input type="text" class="form-control" name="old_nama_petugas" id="old_nama_petugas" value="<?php echo $data['nama_petugas'] ?>" disabled>
                                                    <input type="hidden" class="form-control" name="nama_petugas" id="nama_petugas" value="<?php echo $_SESSION['user']['id_petugas'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="text" name="nama_siswa" class="form-control" value="<?php echo $data['nama'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Tanggal Bayar</label>
                                                    <span class="text-danger">
                                                        <input type="date" class="form-control" name="old_tanggal_bayar" id="old_tanggal_bayar" value="<?php echo $data['tgl_bayar'] ?>" disabled>
                                                        <input type="hidden" class="form-control" name="tanggal_bayar" id="tanggal_bayar" value="<?php echo date('Y-m-d') ?>">
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Bulan Bayar</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="old_bulan_bayar" id="old_bulan_bayar" value="<?php echo $data['bulan_bayar'] ?>" disabled>
                                                        <input type="hidden" class="form-control" name="bulan_bayar" id="bulan_bayar" value="<?php echo date('F') ?>">
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Tahun Bayar</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" name="old_tahun_bayar" id="old_tahun_bayar" value="<?php echo $data['tahun_bayar'] ?>" disabled>
                                                        <input type="hidden" class="form-control" name="tahun_bayar" id="tahun_bayar" value="<?php echo date('Y') ?>">
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">SPP</label>
                                                    <input type="text" name="id_spp" class="form-control" value="<?php echo $data['tahun'] ?> - <?php echo $data['nominal'] ?>" disabled>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label">Kekurangan</label>
                                                    <span class="text-danger">
                                                        <input type="text" class="form-control" value="<?php echo $data['nominal'] - $data['jumlah_bayar'] ?>" disabled>
                                                        <input type="hidden" class="form-control" name="kekurangan" id="kekurangan" value="<?php echo $data['nominal'] - $data['jumlah_bayar'] ?>">
                                                    </span>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah Bayar</label>
                                                    <input type="hidden" class="form-control" name="old_jumlah_bayar" value="<?php echo $data['jumlah_bayar'] ?>">
                                                    <input type="text" name="jumlah_bayar" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="edit">Simpan</button>
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
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