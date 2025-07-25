<?php error_reporting(0); ?>
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data Realtime Lelang Online</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <div class="input-group-append">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Barang</th>
                        <th>Peserta Lelang Tertinggi</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    include '../db/dbconnect.php';
                    $tb_lelang    = mysqli_query($conn, "SELECT * FROM tb_lelang INNER JOIN tb_barang ON tb_lelang.id_barang=tb_barang.id_barang INNER JOIN tb_petugas ON tb_lelang.id_petugas=tb_petugas.id_petugas");
                    while ($d_tb_lelang = mysqli_fetch_array($tb_lelang)) {
                        $harga_tertinggi = mysqli_query($conn, "select max(penawaran_harga) as penawaran_harga FROM history_lelang where id_lelang='$d_tb_lelang[id_lelang]'");
                        $harga_tertinggi = mysqli_fetch_array($harga_tertinggi);
                        $d_harga_tertinggi = $harga_tertinggi['penawaran_harga'];
                        $pemenang = mysqli_query($conn, "SELECT * FROM history_lelang where penawaran_harga='$harga_tertinggi[penawaran_harga]'");
                        $d_pemenang = mysqli_fetch_array($pemenang);
                        $tb_masyarakat = mysqli_query($conn, "SELECT * FROM tb_masyarakat where id_user='$d_pemenang[id_user]'");
                        $d_tb_masyarakat = mysqli_fetch_array($tb_masyarakat);
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?= $d_tb_lelang['nama_barang'] ?></td>
                            <td><?= $d_tb_masyarakat['nama_lengkap'] ?></td>
                            <td>Rp. <?= number_format($d_harga_tertinggi) ?></td>
                        </tr>
                        <div class="modal fade" id="modal-buka<?php echo $d_tb_lelang['id_lelang']; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Aktivasi Buka Lelang</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="update_lelang_buka.php">
                                        <div class="modal-body">
                                            <p>Apakah anda ingin membuka lelang...?</p>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="dibuka" name="status" hidden="">
                                                <input type="text" class="form-control" value="<?php echo $d_tb_lelang['id_lelang']; ?>" name="id_lelang" hidden="">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                                        <h4 class="modal-title">Aktivasi Tutup Lelang</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="update_lelang_tutup.php">
                                        <div class="modal-body">
                                            <p>Apakah anda ingin menutup lelang...?</p>
                                            <div class="form-group">
                                                <input type="text" class="form-control" value="ditutup" name="status" hidden="">
                                                <input type="text" class="form-control" value="<?php echo $d_tb_lelang['id_lelang']; ?>" name="id_lelang" hidden="">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
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
                            <h4 class="modal-title">Tambah Data Lelang</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="simpan_lelang.php">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <select name="id_barang" class="form-control select2" style="width: 100%;">
                                        <option disabled selected>--- Pilih Barang ---</option>
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
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