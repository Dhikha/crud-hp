<?php
  // buat koneksi dengan database mysql
  $DB_SERVER = "localhost";
  $DB_USERNAME = "root";
  $DB_PASSWORD = "";
  $link = mysqli_connect($DB_SERVER,$DB_USERNAME,$DB_PASSWORD);

  //periksa koneksi, tampilkan pesan kesalahan jika gagal
  if(!$link){
    die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
         " - ".mysqli_connect_error());
  }

  //buat database tugaspbo jika belum ada
  $query = "CREATE DATABASE IF NOT EXISTS tugaspbo";
  $result = mysqli_query($link, $query);

  if(!$result){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Database <b>'tugaspbo'</b> berhasil dibuat... <br>";
  }

  //pilih database tugaspbo
  $result = mysqli_select_db($link, "tugaspbo");

  if(!$result){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Database <b>'tugaspbo'</b> berhasil dipilih... <br>";
  }

  // cek apakah tabel mhs sudah ada. jika ada, hapus tabel
$query = "DROP TABLE IF EXISTS tb_hp";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'mhs'</b> berhasil dihapus... <br>";
}

// buat query untuk CREATE tabel mhs
$query  = "CREATE TABLE tb_mhs (id INT(11) NOT NULL, ";
$query .= "nama VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, ";
$query .= "kategori VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, ";
$query .= "no_hp VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, ";
$query .= "harga VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL, PRIMARY KEY (id))";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'mhs'</b> berhasil dibuat... <br>";
}

// buat query untuk INSERT data ke tabel hp
$query  = "INSERT INTO tb_mhs VALUES ";
$query .= "('200103091', 'dikaadi', '1', '082233777084', '12500')";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'mhs'</b> berhasil diisi... <br>";
}

// cek apakah tabel admin sudah ada. jika ada, hapus tabel
$query = "DROP TABLE IF EXISTS tb_admin";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
  die ("Query Error: ".mysqli_errno($link).
       " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'admin'</b> berhasil dihapus... <br>";
}

// buat query untuk CREATE tabel admin
$query  = "CREATE TABLE tb_admin (username VARCHAR(50), ";
$query .= "password VARCHAR(50), PRIMARY KEY (username))";
$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'admin'</b> berhasil dibuat... <br>";
}

// buat username dan password untuk admin
$username = "dikaadi12";
$password = sha1("dikaadi1212");

// buat query untuk INSERT data ke tabel admin
$query  = "INSERT INTO tb_admin VALUES ('$username','$password')";

$hasil_query = mysqli_query($link, $query);

if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
}
else {
  echo "Tabel <b>'admin'</b> berhasil diisi... <br>";
}

// tutup koneksi dengan database mysql
mysqli_close($link);

?>
