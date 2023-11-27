<?php
include 'koneksi.php';
if (empty($_SESSION['user'])) {
    header('location: login.php');
}

if (isset($_POST['pembayaran'])) {
    $id_petugas = $_SESSION['user']['id_petugas'];
    $nisn = $_POST['nisn'];
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];
    $tahun_bayar = $_POST['tahun_bayar'];
    $id_spp = $_POST['id_spp'];
    $jumlah_bayar = $_POST['jumlah_bayar'];

    $spp = mysqli_query($koneksi, "SELECT * FROM spp WHERE id_spp='$id_spp'");
    $cek = mysqli_fetch_array($spp);

    $pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE nisn='$nisn' AND id_spp='$id_spp'");

    $total = $cek['nominal'];

    if (mysqli_num_rows($pembayaran) > 0) {
        echo '<script>alert("Siswa Telah Membayar SPP ini.");location.href="?page=laporan"</script>';
    } elseif ($jumlah_bayar > $total) {
        echo '<script>alert("Jumlah Bayar Melebihi Nominal SPP.");location.href="?page=laporan"</script>';
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO pembayaran(id_petugas,nisn,tgl_bayar,bulan_bayar,tahun_bayar,id_spp,jumlah_bayar) VALUES ('$id_petugas','$nisn','$tgl_bayar','$bulan_bayar','$tahun_bayar','$id_spp','$jumlah_bayar')");
        if ($query) {
            echo '<script>alert("Pembayaran Berhasil.");location.href="?page=laporan"</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title> SPP -
        <?php
        $page = isset($_GET['page']) ? $_GET['page'] : 'Dashboard';
        $cek = preg_replace('/-/', ' ', $page);
        $title = ucwords($cek);
        echo $title;
        ?>
    </title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php
        if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'Admin')) {
        ?>
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <!-- <i class="fas fa-laugh-wink"></i> -->
                        <img src="img/logo.png" alt="" height="40px">
                    </div>
                    <div class="sidebar-brand-text mx-3">SPP</div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item 
<?php
            if (empty($_GET['page'])) {
                echo 'active';
            }
?>">
                    <a class="nav-link" href="index.php">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Menu
                </div>

                <!-- Nav Item - Pages Collapse Menu -->
                <li class="nav-item <?php echo ($page == 'petugas' || $page == 'siswa' || $page == 'kelas' ? 'active' : '') ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fa fa-address-book"></i>
                        <span>Halaman</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="?page=petugas">Petugas</a>
                            <a class="collapse-item" href="?page=siswa">Siswa</a>
                            <a class="collapse-item" href="?page=kelas">Kelas</a>
                        </div>
                    </div>
                </li>

                <!-- Nav Item - Utilities Collapse Menu -->
                <li class="nav-item <?php echo ($page == 'spp' || $page == 'laporan' ? 'active' : '') ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Laporan</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="#" data-toggle="modal" data-target="#tambahpembayaran">Pembayaran</a>
                            <a class="collapse-item" href="?page=spp">SPP</a>
                            <a class="collapse-item" href="?page=laporan">Laporan</a>
                        </div>
                    </div>
                </li>

                <hr class="sidebar-divider">
            </ul>
            <?php
        } else {
            if (!empty($_SESSION['user']['level']) && !empty($_SESSION['user']['level'] == 'Petugas')) {
            ?>
                <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                    <!-- Sidebar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                        <div class="sidebar-brand-icon rotate-n-15">
                            <!-- <i class="fas fa-laugh-wink"></i> -->
                            <img src="img/logo.png" alt="" height="40px">
                        </div>
                        <div class="sidebar-brand-text mx-3">SPP</div>
                    </a>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item 
<?php
                if (empty($_GET['page'])) {
                    echo 'active';
                }
?>">
                        <a class="nav-link" href="index.php">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span></a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider">

                    <!-- Heading -->
                    <div class="sidebar-heading">
                        Menu
                    </div>

                    <!-- Nav Item - Pages Collapse Menu -->
                    <li class="nav-item <?php echo ($page == 'petugas' || $page == 'siswa' || $page == 'kelas' ? 'active' : '') ?>">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <i class="fa fa-address-book"></i>
                            <span>Halaman</span>
                        </a>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="?page=siswa">Siswa</a>
                            </div>
                        </div>
                    </li>

                    <!-- Nav Item - Utilities Collapse Menu -->
                    <li class="nav-item <?php echo ($page == 'spp' || $page == 'laporan' ? 'active' : '') ?>">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                            <i class="fas fa-fw fa-wrench"></i>
                            <span>Laporan</span>
                        </a>
                        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <a class="collapse-item" href="#" data-toggle="modal" data-target="#tambahpembayaran">Pembayaran</a>
                                <a class="collapse-item" href="?page=laporan">Laporan</a>
                            </div>
                        </div>
                    </li>

                    <hr class="sidebar-divider">
                </ul>
        <?php
            }
        }
        ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                    if (!empty($_SESSION['user']['level'])) {
                                        echo $_SESSION['user']['nama_petugas'];
                                    } else {
                                        echo $_SESSION['user']['nama'];
                                    }
                                    ?>
                                </span>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                    include $page . '.php';
                    ?>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;
                            <?php
                            if (!empty($_SESSION['user']['level'])) {
                                echo $_SESSION['user']['nama_petugas'];
                            } else {
                                echo $_SESSION['user']['nama'];
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mau Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Silahkan Keluar</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <div class="modal fade" id="tambahpembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <div class="text-center">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Pembayaran</h1>
                        </div>
                    </div>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Siswa</label>
                            <select name="nisn" class="form-control">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM siswa");
                                while ($siswa = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $siswa['nisn'] ?>"><?php echo $siswa['nama'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tgl_bayar" class="form-control">
                        </div>
                        <input type="hidden" name="bulan_bayar" class="form-control" value="<?php echo date('F') ?>">
                        <input type="hidden" name="tahun_bayar" class="form-control" value="<?php echo date('Y') ?>">
                        <div class="mb-3">
                            <label class="form-label">SPP</label>
                            <select name="id_spp" class="form-control">
                                <?php
                                $query = mysqli_query($koneksi, "SELECT * FROM spp");
                                while ($spp = mysqli_fetch_array($query)) {
                                ?>
                                    <option value="<?php echo $spp['id_spp'] ?>"><?php echo $spp['tahun'] ?> - <?php echo $spp['nominal'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="text" name="jumlah_bayar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="pembayaran">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>