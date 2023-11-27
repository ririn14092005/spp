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

<h1 class="h3 mb-3" style="text-align: center;">Petugas</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahpetugas">+ Tambah petugas</button>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Nama Petugas</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM petugas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nama_petugas'] ?></td>
                                <td><?php echo $data['username'] ?></td>
                                <td><?php echo $data['level'] ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editpetugas<?php echo $data['id_petugas'] ?>">Edit</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapuspetugas<?php echo $data['id_petugas'] ?>">Hapus</button>

                                </td>
                            </tr>
                            <div class="modal fade" id="editpetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit petugas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/petugas.php">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="id_petugas" value="<?php echo $data['id_petugas'] ?>">
                                                    <label class="form-label">Nama Petugas</label>
                                                    <input type="text" name="nama_petugas" class="form-control" value="<?php echo $data['nama_petugas'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Username</label>
                                                    <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Level</label>
                                                    <select name="level" class="form-control">
                                                        <option value="<?php echo $data['level'] ?>" hidden><?php echo $data['level'] ?></option>
                                                        <option value="admin">Admin</option>
                                                        <option value="petugas">Petugas</option>
                                                    </select>
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
                            <div class="modal fade" id="hapuspetugas<?php echo $data['id_petugas'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus petugas</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/petugas.php">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_petugas" value=" <?php echo $data['id_petugas'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin hapus data?</span><br>
                                                    <div class="text-danger">
                                                        Nama Petugas - <?php echo $data['nama_petugas'] ?>
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
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal tambah -->
<div class="modal fade" id="tambahpetugas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah petugas</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="crud/petugas.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Akhir Modal Tambah-->