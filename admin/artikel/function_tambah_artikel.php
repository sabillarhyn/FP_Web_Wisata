<?php
session_start();
include '../../koneksi/koneksi.php';


        //Include file koneksi, untuk koneksikan ke database
if (isset($_POST['publish']) || isset($_POST['simpan_konsep'])) {
	
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
	function input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
        //Cek apakah ada kiriman form dari method post
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (isset($_POST['publish'])) {
			$status=1;
		}else {
			$status=0;
		}
            //Include database
		include '../../koneksi/koneksi.php';

		$kode_artikel=input($_POST["kode_artikel"]);
		$judul_artikel=input($_POST["judul_artikel"]);
		$kategori=input($_POST["kategori"]);
		$isi_artikel=input($_POST["isi_artikel"]);
		$tanggal=date("Y-m-d H:i:s");
		$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
		$gambar = $_FILES['gambar']['name'];
		$x = explode('.', $gambar);
		$ekstensi = strtolower(end($x));
            //$ukuran	= $_FILES['gambar']['size'];
		$file_tmp = $_FILES['gambar']['tmp_name'];	

		if (!empty($gambar)){
			if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    //Mengupload gambar
				move_uploaded_file($file_tmp, 'gambar/'.$gambar);

                    //Menambah artikel dengan gambar
				$sql="insert into artikel (kode_artikel,judul_artikel,isi_artikel,gambar,tanggal,status,id_kategori) values
				('$kode_artikel','$judul_artikel','$isi_artikel','$gambar','$tanggal','$status','$kategori')";
			}    
			
		}else {
                 
			$sql="insert into artikel (kode_artikel,judul_artikel,isi_artikel,tanggal,status,id_kategori) values
			('$kode_artikel','$judul_artikel','$isi_artikel','$tanggal','$status','$kategori')";
			
		}

            //Mengeksekusi/menjalankan query 
		$simpan_artikel=mysqli_query($con,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
		if ($simpan_artikel) {
			header("Location:../index.php?halaman=artikel&kategori=$kategori&add=berhasil");
		}
		else {
			header("Location:../index.php?halaman=artikel&kategori=$kategori&add=gagal");
			
		} 

	}
}
