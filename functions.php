<?php
error_reporting(~E_NOTICE & ~E_DEPRECATED);
session_start();
date_default_timezone_set('Etc/GMT-7');
//date_default_timezone_set('Etc/GMT-8'); WITA

include'config.php';
include'includes/ez_sql_core.php';
include'includes/ez_sql_mysqli.php';
include'includes/SimpleImage.php';
$db = new ezSQL_mysqli($config['username'], $config['password'], $config['database_name'], $config['server']);
    
$mod = $_GET['m'];
$act = $_GET['act'];  

/** ============ GENERAL =========== */
function esc_field($str){
    if (!get_magic_quotes_gpc())
        return addslashes($str);
    else
        return $str;
}

function redirect_js($url){
    echo '<script type="text/javascript">window.location.replace("'.$url.'");</script>';
}

function print_msg($msg, $type = 'danger'){
    echo('<div class="alert alert-'.$type.' alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$msg.'</div>');
}

function sudah_memilih($id_pemilih)
{
    global $db;
    return $db->get_row("SELECT id_pemilih FROM tb_pilih WHERE id_pemilih='$id_pemilih'");
}

function hapus_gambar($ID)
{
    global $db;
    $gambar = $db->get_var("SELECT gambar FROM tb_pencalon WHERE id_pencalon='$ID'");
    $file_name = 'gambar/' . $gambar;
    if(is_file($file_name))
        return unlink($file_name);
}