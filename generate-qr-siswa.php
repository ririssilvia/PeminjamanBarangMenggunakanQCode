<?php 
    session_start();
    include'config.php';

    //library phpqrcode
    include "phpqrcode/qrlib.php";
    
    //direktory tempat menyimpan hasil generate qrcode jika folder belum dibuat maka secara otomatis akan membuat terlebih dahulu
    $tempdir = "temp/"; 
    if (!file_exists($tempdir))
        mkdir($tempdir);
 

    $IdSiswa=$_GET['IdSiswa'];
    $q_tampil_siswa=mysqli_query($conn,"SELECT * FROM siswa WHERE IdSiswa='$IdSiswa'");
    $r_tampil_siswa=mysqli_fetch_array($q_tampil_siswa);
?> 
<!DOCTYPE html>
<html>
<head>

<?php include 'template/header.php';?>
<?php include 'template/sidebar.php';?>
 <!-- sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-9">
            <h1 class="m-0 text-dark"><b>Detail QR Code Siswa</b></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <div class="col-12">
        <a href="download-pdf-qr-siswa.php" class="btn btn-success">Download</a>
        <a href="siswa.php" class="btn btn-primary">Kembali</a>
    </div>
    
    <br>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <th>No</th>
                    <th>ID Siswa</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>No Handphone</th>
                    <th>QRCode</th>
                </thead>
        <tbody>
        <?php
            $no = 1;
            $query = "SELECT * FROM siswa";
            $arsip1 = $conn->prepare($query);
            $arsip1->execute();
            $res1 = $arsip1->get_result();
 
                //Isi dari QRCode Saat discan
                $isi_IdSiswa1 = $IdSiswa;
                //Nama file yang akan disimpan pada folder temp 
                $namafile1 = $IdSiswa.".png";
                //Kualitas dari QRCode 
                $quality1 = 'H'; 
                //Ukuran besar QRCode
                $ukuran1 = 4; 
                $padding1 = 0; 
                QRCode::png($isi_IdSiswa1,$tempdir.$namafile1,$quality1,$ukuran1,$padding1);
        ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $r_tampil_siswa['IdSiswa']; ?></td>
                <td><?php echo $r_tampil_siswa['SwNama']; ?></td>
                <td><?php echo $r_tampil_siswa['SwKelas']; ?></td>
                <td><?php echo $r_tampil_siswa['SwNoHp']; ?></td>
                <td style="padding: 10px;"><img src="temp/<?php echo $namafile1; ?>" width="35px"></td>
            </tr>
        </tbody>
    </table>
 
</body>
</html>
<?php mysqli_close($conn); ?>