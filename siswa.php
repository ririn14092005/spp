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

<h1 class="h3 mb-3" style="text-align: center;">Siswa</h1>

<div class="row">
    <div class="col-12">
        <div class="card flex-fill">
            <div class="card-header">
                <?php
                if (!empty($_SESSION['user']['level'] == 'Admin')) {
                ?>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambahsiswa">+ Tambah Siswa</button>
                <?php
                }
                ?>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Kompetensi Keahlian</th>
                            <th>Alamat</th>
                            <th>No Telepon</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM siswa INNER JOIN kelas ON siswa.id_kelas=kelas.id_kelas");
                        while ($data = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $data['nisn'] ?></td>
                                <td><?php echo $data['nis'] ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['nama_kelas'] ?></td>
                                <td><?php echo $data['kompetensi_keahlian'] ?></td>
                                <td><?php echo $data['alamat'] ?></td>
                                <td><?php echo $data['no_telp'] ?></td>
                                <td width="17%">
                                    <?php
                                    if (!empty($_SESSION['user']['level'] == 'Admin')) {
                                    ?>
                                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editsiswa<?php echo $data['nisn']; ?>" class="btn btn-danger btn-sm edit-siswa">Edit</button>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapussiswa<?php echo $data['nisn']; ?>" class="btn btn-warning btn-sm hapus-siswa">Hapus</button>
                                    <?php

                                    }
                                    ?>
                                    <a href="?page=history&nisn=<?php echo $data['nisn'] ?>" class="btn btn-success btn-sm">History</i></a>


                                </td>
                            </tr>
                            <div class="modal fade" id="editsiswa<?php echo $data['nisn'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Siswa</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/siswa.php">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="hidden" name="oldnisn" value="<?php echo $data['nisn'] ?>" required>
                                                    <label class="form-label">Nisn</label>
                                                    <input type="text" name="nisn" class="form-control" value="<?php echo $data['nisn'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nis</label>
                                                    <input type="text" name="nis" class="form-control" value="<?php echo $data['nis'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="tex" name="nama_siswa" class="form-control" value="<?php echo $data['nama'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kelas dan Kompetensi Keahlian</label>
                                                    <select name="id_kelas" class="form-control">
                                                        <?php
                                                        $query1 = mysqli_query($koneksi, "SELECT * FROM kelas");
                                                        while ($kelas = mysqli_fetch_array($query1)) {
                                                        ?>
                                                            <option value="<?php echo $kelas['id_kelas'] ?>" <?php echo ($data['id_kelas'] == $kelas['id_kelas'] ? 'selected' : '') ?>>
                                                                <?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?>
                                                            </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Alamat</label>
                                                    <input type="text" name="alamat" class="form-control" value="<?php echo $data['alamat'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">No Telepon</label>
                                                    <input type="text" name="no_telepon" class="form-control" value="<?php echo $data['no_telp'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control">
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
                            <div class="modal fade" id="hapussiswa<?php echo $data['nisn'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="col-12">
                                                <big><a href="" data-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                                                <div class="text-center">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Siswa</h1>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="crud/siswa.php">
                                            <div class="modal-body">
                                                <input type="hidden" name="nisn" value="<?php echo $data['nisn'] ?>">
                                                <div class="text-center">
                                                    <span>yakin ingin hapus data?</span><br>
                                                    <div class="text-danger">
                                                        Nama Siswa - <?php echo $data['nama'] ?>
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
<div class="modal fade" id="tambahsiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-12">
                    <big><a href="" data-bs-dismiss="modal"><i class="bi bi-arrow-left" style="float: left; color: black;"></i></a></big>
                    <div class="text-center">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Siswa</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="crud/siswa.php">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas dan Kompetensi Keahlian</label>
                        <select name="id_kelas" class="form-control">
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                            while ($kelas = mysqli_fetch_array($query)) {
                            ?>
                                <option value="<?php echo $kelas['id_kelas'] ?>"><?php echo $kelas['nama_kelas'] ?> - <?php echo $kelas['kompetensi_keahlian'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
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