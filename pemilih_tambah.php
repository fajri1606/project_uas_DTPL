<div class="page-header">
    <h1>Tambah Pemilih</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=pemilih_tambah">
            <div class="form-group">
                <label>No KTP <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="ktp" value="<?=$_POST['ktp']?>"/>
            </div>
            <div class="form-group">
                <label>Nama Pemilih <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_pemilih" value="<?=$_POST['nama_pemilih']?>"/>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="alamat"><?=$_POST['alamat']?></textarea>
            </div>
            <div class="form-group">
                <label>Password <span class="text-danger">*</span></label>
                <input class="form-control" type="password" name="pass" value="<?=$_POST['pass']?>"/>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=pemilih"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>