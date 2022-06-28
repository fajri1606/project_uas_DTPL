<h1>Pemilih</h1>
<table>
<thead>
    <tr>
        <th>No</th>
        <th>KTP</th>
        <th>Nama Pemilih</th>
        <th>Alamat</th>
    </tr>
</thead>
<?php
$q = esc_field($_GET['q']);
$rows = $db->get_results("SELECT * FROM tb_pemilih WHERE nama_pemilih LIKE '%$q%' ORDER BY id_pemilih");
$no=0;
foreach($rows as $row):?>
<tr>
    <td><?=++$no ?></td>
    <td><?=$row->ktp?></td>
    <td><?=$row->nama_pemilih?></td>
    <td><?=$row->alamat?></td>
</tr>
<?php endforeach;
?>
</table>