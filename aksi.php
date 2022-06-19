<?php
require_once'functions.php';

 
    /** LOGIN */ 
    if ($mod=='login_pemilih'){
        $user = esc_field($_POST[user]);
        $pass = esc_field($_POST[pass]);
        
        $row = $db->get_row("SELECT * FROM tb_pemilih WHERE ktp='$user' AND pass='$pass'");
        if($row){
            $_SESSION[login] = TRUE;
            $_SESSION[id_pemilih] = $row->id_pemilih;
            $_SESSION[level] = 'pemilih';
            redirect_js("index.php?m=tanda_terima");
        } else{
            print_msg("Salah kombinasi no KTP dan password.");
        }          
    }elseif ($mod=='login'){
        $user = esc_field($_POST[user]);
        $pass = esc_field($_POST[pass]);
        
        $row = $db->get_row("SELECT * FROM tb_admin WHERE user='$user' AND pass='$pass'");
        if($row){
            $_SESSION[login] = $row->user;
            $_SESSION[level] = 'admin';
            $_SESSION[akses] = $row->level;
            
            redirect_js("index.php");
        } else{
            print_msg("Salah kombinasi username dan password.");
        }          
    }else if ($mod=='password'){
        $pass1 = $_POST[pass1];
        $pass2 = $_POST[pass2];
        $pass3 = $_POST[pass3];
        
        if($_SESSION['level']=='pemilih')
            $row = $db->get_row("SELECT * FROM tb_pemilih WHERE id_pemilih='$_SESSION[id_pemilih]' AND pass='$pass1'");        
        
        if($pass1=='' || $pass2=='' || $pass3=='')
            print_msg('Field bertanda * harus diisi.');
        elseif(!$row)
            print_msg('Password lama salah.');
        elseif( $pass2 != $pass3 )
            print_msg('Password baru dan konfirmasi password baru tidak sama.');
        else{        
            if($_SESSION['level']=='pemilih')
                $db->query("UPDATE tb_pemilih SET pass='$pass2' WHERE id_pemilih='$_SESSION[id_pemilih]'");
                                                
            print_msg('Password berhasil diubah.', 'success');
        }
    } elseif($act=='logout'){
        session_destroy();
        header("location:index.php");
    }
    
    /** PENCALON **/
    elseif($mod=='pencalon_tambah'){
        $kode_pencalon = $_POST['kode_pencalon'];
        $nama_pencalon = $_POST['nama_pencalon'];
        $gambar = $_FILES['gambar'];
        $keterangan = $_POST['keterangan'];
        
        if(!$kode_pencalon || !$nama_pencalon || !$gambar['tmp_name'])
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_pencalon WHERE kode_pencalon='$kode_pencalon'"))
            print_msg("Kode sudah ada!");
        else{
            $filename = rand(1000, 999) . str_replace(' ', '-', $gambar['name']);
            $img = new SimpleImage($gambar['tmp_name']);               
            $img->thumbnail(640, 480);     
            $img->save('gambar/' . $filename, 100);
            
            $db->query("INSERT INTO tb_pencalon (kode_pencalon, nama_pencalon, gambar, keterangan) VALUES ('$kode_pencalon', '$nama_pencalon', '$filename', '$keterangan')");                 
            redirect_js("index.php?m=pencalon");
        }
    } elseif ($mod=='pencalon_ubah'){
        $kode_pencalon = $_POST['kode_pencalon'];
        $nama_pencalon = $_POST['nama_pencalon'];
        $gambar = $_FILES['gambar'];
        $keterangan = $_POST['keterangan'];
        
        if(!$kode_pencalon || !$nama_pencalon)        
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif($db->get_results("SELECT * FROM tb_pencalon WHERE kode_pencalon='$kode_pencalon' AND id_pencalon<>'$_GET[ID]'"))
            print_msg("Kode sudah ada!");
        else{
            if($gambar['tmp_name']){
                hapus_gambar($_GET['ID']);
                
                $filename = rand(1000, 9999) . str_replace(' ', '-', $gambar['name']);
                $img = new SimpleImage($gambar['tmp_name']);               
                $img->thumbnail(640, 480);       
                $img->save('gambar/' . $filename, 100);
                
                $sql_gambar = ", gambar='$filename'";
            }
                
            $db->query("UPDATE tb_pencalon SET kode_pencalon='$kode_pencalon', nama_pencalon='$nama_pencalon' $sql_gambar, keterangan='$keterangan' WHERE id_pencalon='$_GET[ID]'");
            redirect_js("index.php?m=pencalon");
        }
    } elseif ($act=='pencalon_hapus'){
        hapus_gambar($_GET['ID']);
        
        $db->query("DELETE FROM tb_pencalon WHERE id_pencalon='$_GET[ID]'");
        $db->query("DELETE FROM tb_pilih WHERE id_pencalon='$_GET[ID]'");
        header("location:index.php?m=pencalon");
    } 
    
    /** PEMILIH */    
    if($mod=='pemilih_tambah'){
        $ktp = $_POST['ktp'];
        $nama_pemilih = $_POST['nama_pemilih'];
        $alamat = $_POST['alamat'];
        $pass = $_POST['pass'];
        
        
        if(!$ktp || !$nama_pemilih || !$pass)
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif(strlen($pass)<4 || strlen($pass)>16)
            print_msg("Password 4-16 karakter!");
        elseif($db->get_results("SELECT * FROM tb_pemilih WHERE ktp='$ktp'"))
            print_msg("No KTP sudah terdaftar!");
        else{
            $db->query("INSERT INTO tb_pemilih (ktp, nama_pemilih, alamat, pass) VALUES ('$ktp', '$nama_pemilih', '$alamat', '$pass')");
            redirect_js("index.php?m=pemilih");
        }    
    } else if($mod=='pemilih_ubah'){
        $ktp = $_POST['ktp'];
        $nama_pemilih = $_POST['nama_pemilih'];
        $alamat = $_POST['alamat'];
        $pass = $_POST['pass'];
        
        if(!$ktp || !$nama_pemilih || !$pass)
        
            print_msg("Field bertanda * tidak boleh kosong!");
        elseif(strlen($pass)<4 || strlen($pass)>16)
            print_msg("Password 4-16 karakter!");
        elseif($db->get_results("SELECT * FROM tb_pemilih WHERE ktp='$ktp' AND id_pemilih<>'$_GET[ID]'"))
            print_msg("No KTP sudah terdaftar!");
        else{
            $db->query("UPDATE tb_pemilih SET ktp='$ktp', nama_pemilih='$nama_pemilih', alamat='$alamat', pass='$pass' WHERE id_pemilih='$_GET[ID]'");
            redirect_js("index.php?m=pemilih");
        }    
    } else if ($act=='pemilih_hapus'){
        $db->query("DELETE FROM tb_pemilih WHERE id_pemilih='$_GET[ID]'");
        $db->query("DELETE FROM tb_pilih WHERE id_pemilih='$_GET[ID]'");
        header("location:index.php?m=pemilih");
    } 
    
    /** PILIH */ 
    else if ($act=='pilih'){
        if(!$_SESSION['id_pemilih'])
            die('Anda harus login sebagai pemilih');
        
        if(sudah_memilih($_SESSION['id_pemilih']))
            die('Anda sudah pernah memilih');
        
        $db->query("INSERT INTO tb_pilih (id_pencalon, id_pemilih) VALUES ('$_GET[ID]', '$_SESSION[id_pemilih]')");
        
        $ID = $db->insert_id;
        
        var_dump($ID);
        
        for($a = 65; $a <= 90; $a++){
            $arr[] = chr($a);
        }
        shuffle($arr);
        $tanda_terima = implode('', $arr);
        $tanda_terima = substr($ID . $tanda_terima, 0, 10);
        $db->query("UPDATE tb_pilih SET tanda_terima='$tanda_terima' WHERE ID='$ID'");                                
        header("location:index.php?m=tanda_terima&act=pilih");
    }     
