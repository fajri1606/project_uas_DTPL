<?php
    $row = $db->get_row("SELECT * FROM tb_pencalon WHERE id_pencalon='$_GET[ID]'"); 
?>
<div class="page-header">
    <h1>Ubah Pencalon</h1>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php if($_POST) include'aksi.php'?>
        <form method="post" action="?m=pencalon_ubah&ID=<?=$row->id_pencalon?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode_pencalon" value="<?=$row->kode_pencalon?>"/>
            </div>
            <div class="form-group">
                <label>Nama Pencalon <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama_pencalon" value="<?=$row->nama_pencalon?>"/>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input class="form-control" type="file" name="gambar"/>
                <br />
                <p class="helper-block"><img class="thumbnail" src="gambar/<?=$row->gambar?>" height="75" /></p>
            </div>
            <div class="form-group">
                <label>Keterangan </label>
                <textarea class="form-control editor"  name="keterangan" ><?=$row->keterangan?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=pencalon"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>