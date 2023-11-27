<?php
if (empty($_SESSION['user']['level'] == 'Admin')) {
?>
    <script>
        alert('Akses di Tolak.');
        window.history.back();
    </script>
<?php
}
?>

<h1 class="h3 mb-3" style="text-align: center;">Kelas</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahkelas">+ Tambah kelas</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editkelas<?php echo $data['id_kelas'] ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuskelas<?php echo $data['id_kelas'] ?>">Hapus</button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editkelas<?php echo $data['id_kelas'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Kelas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/kelas.php">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                    <label class="form-label">Nama Kelas</label>
                                                    <input type="text" name="nama_kelas" class="form-control" value="<?php echo $data['nama_kelas'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kompeteni Keahlian</label>
                                                    <input type="text" name="kompetensi_keahlian" class="form-control" value="<?php echo $data['kompetensi_keahlian'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="edit">Simpan</button>
                                                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="hapuskelas<?php echo $data['id_kelas'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Kelas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/kelas.php">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_kelas" value="<?php echo $data['id_kelas'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin hapus data?</span><br>
                                                    <div class="text-danger">
                                                        Nama Kelas - <?php echo $data['nama_kelas'] ?><br>
                                                        Kompeteni Keahlian - <?php echo $data['kompetensi_keahlian'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="col-12">
                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-success" name="hapus">Hapus</button>
                                                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
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
<div class="modal fade" id="tambahkelas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <big><a href="" data-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Kelas</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="crud/kelas.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kompetensi Keahlian</label>
                        <input type="text" name="kompetensi_keahlian" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Akhir Modal Tambah-->