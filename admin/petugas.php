
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
          <h1 class="m-0"> Officers</h1>
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
              <h3 class="card-title">Officer Data</h3>

              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">
                      <i class="fas fa-plus"></i>Add Officer
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <?php 
              if(isset($_GET['info'])){
                if($_GET['info'] == "hapus"){ ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-trash"></i> Success</h5>
                    Data successfully deleted
                  </div>
                <?php } else if($_GET['info'] == "simpan"){ ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success</h5>
                    Data saved successfully
                  </div>
                <?php }else if($_GET['info'] == "update"){ ?>
                  <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-edit"></i> Success</h5>
                    Data updated successfully
                  </div>
                <?php } } ?>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Nu</th>
                      <th>Officer Name</th>
                      <th>Username</th>
                      <th>Level</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    include "../db/dbconnect.php";
                    $tb_petugas    =mysqli_query($conn, "SELECT * FROM tb_petugas INNER JOIN tb_level ON tb_petugas.id_level=tb_level.id_level");
                    while($d_tb_petugas = mysqli_fetch_array($tb_petugas)){
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?=$d_tb_petugas['nama_petugas']?></td>
                        <td><?=$d_tb_petugas['username']?></td>
                        <td><?=$d_tb_petugas['level']?></td>
                        <td>
                          <?php if ($_SESSION['username'] == $d_tb_petugas['username']) { ?>
                            <button type="submit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ubah<?php echo $d_tb_petugas['id_petugas'];?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                          <?php } else { ?>
                            <button type="submit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-ubah<?php echo $d_tb_petugas['id_petugas'];?>">
                              <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-hapus<?php echo $d_tb_petugas['id_petugas'];?>">
                              <i class="fas fa-trash"></i> Delete
                            </button>
                          <?php } ?>                          
                        </td>
                      </tr>
                      <div class="modal fade" id="modal-hapus<?php echo $d_tb_petugas['id_petugas'];?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Delete Officer Data</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form>
                              <div class="modal-body">
                                <p>Are you sure you want to delete the data <b><?=$d_tb_petugas['nama_petugas']?></b> !!!</p>
                              </div>
                              <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <a href="hapus_petugas.php?id_petugas=<?php echo $d_tb_petugas['id_petugas']; ?>" class="btn btn-primary">Delete</a>
                              </div>
                            </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                      <div class="modal fade" id="modal-ubah<?php echo $d_tb_petugas['id_petugas'];?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Officer Data</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form method="post" action="update_petugas.php">
                              <div class="modal-body">
                                <div class="form-group">
                                  <label>Officer</label>
                                  <input type="text" name="id_petugas" value="<?php echo $d_tb_petugas['id_petugas'];?>" hidden>
                                  <input type="text" class="form-control" name="nama_petugas" value="<?php echo $d_tb_petugas['nama_petugas'];?>" placeholder="Enter the Officer's ...">
                                </div>
                                <div class="form-group">
                                  <label>Username</label>
                                  <input type="text" class="form-control" name="username" value="<?php echo $d_tb_petugas['username'];?>" placeholder="Username input ...">
                                </div>
                                <div class="form-group">
                                  <label>Password</label>
                                  <input type="password" class="form-control" name="password" value="<?php echo $d_tb_petugas['password'];?>" placeholder="Enter Password...">
                                  <i><font color="red">Ignore if password is not changed*</font></i>
                                </div>
                                <div class="form-group">
                                  <label>Level</label>
                                  <select name="id_level" class="form-control select2" style="width: 100%;">
                                    <option disabled selected>--- Select Level ---</option>
                                    <option value="2">Officer</option>

                                    <?php
                                    include "../db/dbconnect.php";
                                    $tb_level    =mysqli_query($conn, "SELECT * FROM tb_level");
                                    while($d_tb_level = mysqli_fetch_array($tb_level)){
                                      ?>
                                      <option value="<?=$d_tb_level['id_level']?>" <?php if($d_tb_level['id_level'] == $d_tb_petugas['id_level']){ echo 'selected'; } ?>><?=$d_tb_level['level']?></option>
                                    <?php } ?>
                                  </select>
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

                    <div class="modal fade" id="modal-tambah">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title">Add Officer Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post" action="simpan_petugas.php">
                            <div class="modal-body">
                              <div class="form-group">
                                <label>Officer Name</label>
                                <input type="text" class="form-control" name="nama_petugas" placeholder="Enter Officer Name ...">
                              </div>
                              <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Username input ...">
                              </div>
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Enter Password...">
                              </div>
                              <div class="form-group">
                                <label>Level</label>
                                <select class="form-control" name="id_level">
                                  <option value="">--- Select Level ---</option>
                                  <option value="1">Administrator</option>
                                  <option value="2">Officer</option>
                                </select>
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
                  </tbody>
                </table>
              </div>
            </div>
          </div>
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