<?php
session_start();
    include '../../koneksi/koneksi.php';

    $id_artikel=$_POST["id_artikel"];
    $gambar=$_POST["gambar"];

    $sql="delete from artikel where id_artikel=$id_artikel";
    $hapus_artikel=mysqli_query($con,$sql);

    //Menghapus gambar, gambar yang dihapus jika selain gambar default
    if ($gambar!='gambar_up.png'){
        unlink("gambar/".$gambar);
    }
 

?>