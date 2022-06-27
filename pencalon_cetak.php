<h1>Pencalon</h1>
<table>
<thead>
    <tr>
        <th>Kode</th>
        <th>Gambar</th>
        <th class="nw">Nama Pencalon</th>
        <th>Keterangan</th>
    </tr>
</thead>
<?php
$q = esc_field($_GET['q']);
$rows = $db->get_results("SELECT * FROM tb_pencalon 
    WHERE kode_pencalon LIKE '%$q%' 
        OR nama_pencalon LIKE '%$q%'
    ORDER BY kode_pencalon");
foreach($rows as $row):?>
<tr>
    <td><?=$row->kode_pencalon?></td>
    <td><img src="gambar/<?=$row->gambar?>" style="height: 100px;" /></td>
    <td><?=$row->nama_pencalon?></td>
    <td><?=$row->keterangan?></td>
</tr>
<?php endforeach;
?>
</table>