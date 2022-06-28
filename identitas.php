<?php
$row = $db->get_row("SELECT * FROM tb_pemilih WHERE id_pemilih='$_SESSION[id_pemilih]'");
?>
<div class="page-header">
    <h1>Data Identitas Pemilih hmj sistem informasi uin ib padang</h1>
</div>
<table class="table table-bordered aw">
    <tr>
        <td>Nama Pemilih</td>
        <td><?=$row->nama_pemilih?></td>
    </tr>
    <tr>
        <td>No KTP</td>
        <td><?=$row->ktp?></td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td><?=$row->alamat?></td>
    </tr>
</table>
<?php 
$batas = 'mktime'(12, 9, 22);
$batas = 'mktime'(12, 9, 22);

if($batas > $batas):?>
<p>Maaf pemilihan berakhir pukul <?=date('H-i-s', $batas)?> WIB</p>
<?php else:?>
<a class="btn btn-primary" href="?m=tanda_terima&act=pilih">Lanjutkan <span class="glyphicon glyphicon-chevron-right"></span></a>
<?php endif;?>