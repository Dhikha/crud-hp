<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$id = $nama = $kategori = $no_hp = $harga = "";
$id_err = $nama_err = $kategori_err = $no_hp_err = $harga_err = "";
// $pesan_error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validasi ID
    $input_id = trim($_POST["id"]);
    if(empty($input_id)){
        $id_err = "Tolong masukan Merek HP.";
    } else{
        $id = $input_id;
    }
    // Validasi Nama
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Tolong masukan Merek HP.";
    } else{
        $nama = $input_nama;
    }

    // Validasi Kategori
    $input_kategori = trim($_POST["kategori"]);
    if(empty($input_kategori)){
        $kategori_err = "Tolong masukan Kategori.";
    }
    else{
        $kategori = $input_kategori;
    }

    //Validasi no hp
    $input_no_hp = trim($_POST["no_hp"]);
    if(empty($input_no_hp)){
        $no_hp_err = "Tolong masukan no_hp";
    }
    else{
        $no_hp = $input_no_hp;
    }

    //Validasi Harga
    $input_harga = trim($_POST["harga"]);
    if(empty($input_harga)){
        $harga_err = "Tolong masukan Harga";
    }
    else{
        $harga = $input_harga;
    }

    // echo "<pre>"; var_dump( preg_match("/^[0-9]{8}$/",$input_password) ); die(); // <-- ini untuk menguji variabel

    // Check input errors before inserting in database
    if(empty($id_err) && empty($nama_err) && empty($kategori_err) && empty($no_hp_err) && empty($harga_err)){
        // Prepare an insert statement
        $query = "INSERT INTO tb_mhs (id, nama, kategori, no_hp, harga) VALUES ( '{$id}', '{$nama}', '{$kategori}', '{$no_hp}', '{$harga}')";

        // Eksekusi untuk menjalankan query ke database
        if ($link->query($query) === TRUE) {
          // Records created successfully. Redirect to landing page
          header("location: index.php");
          exit();
        } else {
          echo "Error: " . $query . "<br>" . $link->error;
        }

        // Close connection
        $link->close();

    }
    else{

    }

    // Close connection
    mysqli_close($link);
}

// include database connection file
include_once("config.php");

// Check If form submitted, insert form data into users table.
if(isset($_POST['Submit'])) {
    $id       = htmlentities(strip_tags(trim($_POST["id"])));
    $nama     = htmlentities(strip_tags(trim($_POST["nama"])));
    $kategori = htmlentities(strip_tags(trim($_POST["kategori"])));
    $no_hp    = htmlentities(strip_tags(trim($_POST["no_hp"])));
    $harga    = htmlentities(strip_tags(trim($_POST["harga"])));
    
    // siapkan variabel untuk menampung pesan error
    $pesan_error="";

    // cek apakah "nim" sudah diisi atau tidak
    if (empty($id)) {
      $pesan_error .= "ID belum diisi <br>";
    }
    // NIM harus angka dengan 8 digit
    elseif (!preg_match("/^[0-9]{9}$/",$id) ) {
      $pesan_error .= "ID harus berupa 9 digit angka <br>";
    }

    // cek ke database, apakah sudah ada nomor NIM yang sama
    // filter data $nim
    $id = mysqli_real_escape_string($link,$id);
    $query = "SELECT * FROM tb_mhs WHERE id='$id'";
    $hasil_query = mysqli_query($link, $query);

    // cek jumlah record (baris), jika ada, $nim tidak bisa diproses
    $jumlah_data = mysqli_num_rows($hasil_query);
     if ($jumlah_data >= 1 ) {
       $pesan_error .= "ID yang sama sudah digunakan <br>";
    }

    // cek apakah "nama" sudah diisi atau tidak
    if (empty($nama)) {
      $pesan_error .= "Nama belum diisi <br>";
    }

    // cek apakah "jurusan" sudah diisi atau tidak
    if (empty($kategori)) {
        $pesan_error .= "Kategori belum diisi <br>";
    }
    
    // cek apakah "jurusan" sudah diisi atau tidak
    if (empty($no_hp)) {
        $pesan_error .= "No HP belum diisi <br>";
    }

    // cek apakah "tempat lahir" sudah diisi atau tidak
    if (empty($harga)) {
      $pesan_error .= "Harga belum diisi <br>";
    }

    // siapkan variabel untuk menggenerate pilihan fakultas
    $select_mahasiswa=""; $select_pekerja="";

    switch($kategori) {
      case "mahasiswa" : $select_mahasiswa = "selected";  break;
      case "pekerja"   : $select_pekerja   = "selected";  break;
    }

    // jika tidak ada error, input ke database
    if ($pesan_error === "") {

      // filter semua data
      $id       = mysqli_real_escape_string($link,$id);
      $nama     = mysqli_real_escape_string($link,$nama );
      $kategori = mysqli_real_escape_string($link,$kategori);
      $no_hp    = mysqli_real_escape_string($link,$no_hp);
      $harga    = mysqli_real_escape_string($link,$harga);
            
    //buat dan jalankan query INSERT
    $query = "INSERT INTO tb_mhs VALUES ";
    $query .= "('$id', '$nama', '$kategori', ";
    $query .= "'$no_hp','$harga')";

    $result = mysqli_query($link, $query);

    //periksa hasil query
    if($result) {
    // INSERT berhasil, redirect ke tampil_mahasiswa.php + pesan
      $pesan = "Mahasiswa dengan nama = \"<b>$nama</b>\" sudah berhasil di tambah";
      $pesan = urlencode($pesan);
      header("Location: index.php?pesan={$pesan}");
    }
    else {
    die ("Query gagal dijalankan: ".mysqli_errno($link).
         " - ".mysqli_error($link));
    }
    }
    }
    else {
    // form belum disubmit atau halaman ini tampil untuk pertama kali
    // berikan nilai awal untuk semua isian form
    $pesan_error      = "";
    $id               = "";
    $nama             = "";
    $select_mahasiswa = "selected";
    $select_pekerja   = "";
    $no_hp            = "";
    $harga            = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/create.css">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
        .help-block{
            color: red;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2 class="text-center">Tambah Data HP</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini untuk menambahkan data HP ke dalam database.</p>
                    <?php
                    // tampilkan error jika ada
                    if ($pesan_error !== "") {
                        echo "<div class=\"error\">$pesan_error</div>";
                    }
                    ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <table border="0" width="100%" align="center" cellspacing="1" cellpadding="5">
                        <!-- ID -->
                        <tr>
                            <td>
                                <div class="form-group <?php echo (!empty($id_err)) ? 'has-error' : ''; ?>">
                                <label>ID</label>
                                </div>
                            </td>
                            <td>: 
                                <input type="text" name="id" class="form-control" value="<?php echo $id; ?>"required>
                                <span class="focus-input100"><?php echo $id_err;?></span>
                            </td>
                        </tr>

                        <!-- Nama -->
                        <tr>
                            <td>
                                <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                                <label>Nama</label>
                                </div>
                            </td>
                            <td>: 
                                <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>"required>
                                <span class="focus-input100"><?php echo $nama_err;?></span>
                            </td>
                        </tr>

                        <!-- Kategori -->
                        <tr>
                            <td>
                                <div class="form-group <?php echo (!empty($kategori_err)) ? 'has-error' : ''; ?>">
                                <label>Kategori</label>
                                </div>
                            </td>
                            <td>: 
                                <select name="kategori" id="kategori" style="width: 82%;height:40px;font-size:15px;font-family:Poppins-Regular;margin-top:5px">
                                <option value="mahasiswa" <?php echo $select_mahasiswa ?>>
                                mahasiswa </option>
                                <option value="pekerja" <?php echo $select_pekerja ?>>
                                pekerja</option>
                                </select>
                                <span class="focus-input100"><?php echo $kategori_err;?></span>
                            </td>
                        </tr>

                        <!-- No HP -->
                        <tr>
                            <td>
                                <div class="form-group <?php echo (!empty($no_hp_err)) ? 'has-error' : ''; ?>">
                                <label>NO HP</label>
                                </div>
                            </td>
                            <td>: 
                                <input type="text" name="no_hp" class="form-control" value="<?php echo $no_hp; ?>"required>
                                <span class="focus-input100"><?php echo $no_hp_err;?></span>
                            </td>
                        </tr>

                        <!-- Harga -->
                        <tr>
                            <td>
                                <div class="form-group <?php echo (!empty($harga_err)) ? 'has-error' : ''; ?>">
                                <label>Harga</label>
                                </div>
                            </td>
                            <td>: 
                                <input type="text" name="harga" class="form-control" value="<?php echo $harga; ?>"required>
                                <span class="focus-input100"><?php echo $harga_err;?></span>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" name="Submit" class="btn-create btn-success2" value="Submit">
                    <a href="index.php" class="btn-create btn-danger2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
  // tutup koneksi dengan database mysql
  mysqli_close($link);
?>