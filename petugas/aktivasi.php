<?php error_reporting(0); ?>
<?php
include 'include/header.php';
include 'include/nav.php';
?>

<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"> Aktivasi Lelang Online</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container">
      <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Online Auction Activation Data</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                      <i class="fas fa-plus"></i> Add Auction
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <?php
              if (isset($_GET['info'])) {
                if ($_GET['info'] == "hapus") { ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-trash"></i> Success</h5>
                    Data successfully deleted
                  </div>
                <?php } else if ($_GET['info'] == "simpan") { ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success</h5>
                    Data saved successfully
                  </div>
                <?php } else if ($_GET['info'] == "update") { ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-edit"></i> Success</h5>
                    Data berhasil di update
                  </div>
              <?php }
              } ?>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nu</th>
                    <th>Item Name</th>
                    <th>Auction Date</th>
                    <th>Auction Winner</th>
                    <th>Highest Price</th>
                    <th>Status Lelang</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  include '../db/dbconnect.php';
                  $tb_lelang    = mysqli_query($conn, "SELECT * FROM tb_lelang INNER JOIN tb_barang ON tb_lelang.id_barang=tb_barang.id_barang INNER JOIN tb_petugas ON tb_lelang.id_petugas=tb_petugas.id_petugas ");
                  while ($d_tb_lelang = mysqli_fetch_array($tb_lelang)) {
                    $harga_tertinggi = mysqli_query($conn, "select max(penawaran_harga) as penawaran_harga FROM history_lelang where id_lelang='$d_tb_lelang[id_lelang]'");
                    $harga_tertinggi = mysqli_fetch_array($harga_tertinggi);
                    $d_harga_tertinggi = $harga_tertinggi['penawaran_harga'];
                    $pemenang = mysqli_query($conn, "SELECT * FROM history_lelang where id_lelang='$d_tb_lelang[id_lelang]'");
                    $d_pemenang = mysqli_fetch_array($pemenang);
                    $tb_masyarakat = mysqli_query($conn, "SELECT * FROM tb_masyarakat where id_user='$d_pemenang[id_user]'");
                    $d_tb_masyarakat = mysqli_fetch_array($tb_masyarakat);
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><?= $d_tb_lelang['nama_barang'] ?></td>
                      <td><?= $d_tb_lelang['tgl_lelang'] ?></td>
                      <td>
                        <?php if ($d_tb_lelang['status'] == 'dibuka') { ?>
                          -
                        <?php } else { ?>
                          <?= $d_tb_masyarakat['nama_lengkap'] ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if ($d_tb_lelang['status'] == 'dibuka') { ?>
                          -
                        <?php } else { ?>
                          Rp. <?= number_format($d_harga_tertinggi) ?>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if ($d_tb_lelang['status'] == '') { ?>
                          <div class="btn btn-warning btn-sm">Inactive Auction</div>
                        <?php } else if ($d_tb_lelang['status'] == 'dibuka') { ?>
                          <div class="btn btn-success btn-sm">Auction Opened</div>
                        <?php } else { ?>
                          <div class="btn btn-danger btn-sm">Auction Closed</div>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if ($d_tb_lelang['status'] == '') { ?>
                          <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-buka<?php echo $d_tb_lelang['id_lelang']; ?>">Open Auction</button>
                        <?php } else if ($d_tb_lelang['status'] == 'dibuka') { ?>
                          <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-tutup<?php echo $d_tb_lelang['id_lelang']; ?>">Close Auction</button>
                        <?php } else { ?>
                          <div class="btn btn-info btn-sm">Auction Completed</div>
                        <?php } ?>
                      </td>
                    </tr>
                    <div class="modal fade" id="modal-buka<?php echo $d_tb_lelang['id_lelang']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Open Auction Activation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="update_lelang_buka.php">
                            <div class="modal-body">
                              <p>Do you want to open an auction...?</p>
                              <div class="form-group">
                                <input type="text" class="form-control" value="dibuka" name="status" hidden="">
                                <input type="text" class="form-control" value="" name="id_user" hidden="">
                                <input type="text" class="form-control" value="" name="harga_akhir" hidden="">
                                <input type="text" class="form-control" value="<?php echo $d_tb_lelang['id_lelang']; ?>" name="id_lelang" hidden="">
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

                    <div class="modal fade" id="modal-tutup<?php echo $d_tb_lelang['id_lelang']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Close Auction Activation</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="update_lelang_tutup.php">
                            <div class="modal-body">
                              <p>Do you want to close the auction...?</p>
                              <div class="form-group">
                                <input type="text" class="form-control" value="ditutup" name="status" hidden="">
                                <input type="text" class="form-control" value="<?php echo $d_tb_masyarakat['id_user']; ?>" name="id_user" hidden="">
                                <input type="text" class="form-control" value="<?php echo $d_harga_tertinggi; ?>" name="harga_akhir" hidden="">
                                <input type="text" class="form-control" value="<?php echo $d_tb_lelang['id_lelang']; ?>" name="id_lelang" hidden="">
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

                  <?php } ?>
                </tbody>
              </table>
              <div class="modal fade" id="modal-tambah">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Add Auction Data</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form method="post" action="simpan_lelang.php">
                      <div class="modal-body">
                        <div class="form-group">
                          <label>Item Name</label>
                          <select name="id_barang" class="form-control select2" style="width: 100%;">
                            <option disabled selected>--- Select Item ---</option>
                            <?php
                            include '../db/dbconnect.php';
                            $tb_barang    = mysqli_query($conn, "SELECT * FROM tb_barang");
                            while ($d_tb_barang = mysqli_fetch_array($tb_barang)) {
                              ?>
                              <option value="<?php echo $d_tb_barang['id_barang']; ?>"><?php echo $d_tb_barang['nama_barang']; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <?php
                          include '../db/dbconnect.php';
                          $tb_petugas    = mysqli_query($conn, "SELECT * FROM tb_petugas where username='$_SESSION[username]'");
                          while ($d_tb_petugas = mysqli_fetch_array($tb_petugas)) {
                            ?>
                            <input type="text" class="form-control" value="<?php echo $d_tb_petugas['id_petugas']; ?>" name="id_petugas" hidden>
                          <?php } ?>
                        </div>
                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                      </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
            </div>
          </div>
        </div>
        <!-- TABEL REAL TIME LELANG -->
        <div id="div" class="col-lg-12"><?php include "isi.php"; ?></div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
include 'include/footer.php';
?>