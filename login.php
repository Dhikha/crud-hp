<?php

  // ambil pesan jika ada
  if (isset($_GET["pesan"])) {
      $pesan = $_GET["pesan"];
  }

  // cek apakah form telah di submit
  if (isset($_POST["submit"])) {
    // form telah disubmit, proses data

    // ambil nilai form
    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    // siapkan variabel untuk menampung pesan error
    $pesan_error="";

    // cek apakah "username" sudah diisi atau tidak
    if (empty($username)) {
      $pesan_error .= "Username belum diisi <br>";
    }

    // cek apakah "password" sudah diisi atau tidak
    if (empty($password)) {
      $pesan_error .= "Password belum diisi <br>";
    }

    // buat koneksi ke mysql dari file connection.php
    include("config.php");

    // filter dengan mysqli_real_escape_string
    $username = mysqli_real_escape_string($link,$username);
    $password = mysqli_real_escape_string($link,$password);

    // generate hashing
    $password_sha1 = sha1($password);

    // cek apakah username dan password ada di tabel admin
    $query = "SELECT * FROM tb_admin WHERE username = '$username' AND password = '$password_sha1'";
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result) == 0 )  {
      // data tidak ditemukan, buat pesan error
      $pesan_error .= "Username dan Password yang Anda masukkan salah";
    }

      // bebaskan memory
      mysqli_free_result($result);

      // tutup koneksi dengan database MySQL
      mysqli_close($link);

    // jika lolos validasi, set session
    if ($pesan_error === "") {
      session_start();
      $_SESSION["nama"] = $username;
      header("Location: index.php");
    }
  }
  else {
    // form belum disubmit atau halaman ini tampil untuk pertama kali
    // berikan nilai awal untuk semua isian form
    $pesan_error = "";
    $username = "";
    $password = "";
  }
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <title>Login</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--===================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===================================================================================-->
    <link
      rel="stylesheet"
      type="text/css"
      href="fonts/font-awesome-4.7.0/css/font-awesome.min.css"
    />
    <!--===================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css" />
    <link rel="stylesheet" type="text/css" href="css/login.css" />
    <!--===================================================================================-->
  </head>
  <body>
    <div class="limiter">
      <div class="container-login100">
        <div class="wrap-login100">
          <div
            class="login100-form-title"
            style="background-image: url(images/bg-02.jpg)"
          >
            <span class="login100-form-title-1"> Login </span>
          </div>

          <?php
            // tampilkan pesan jika ada
            if (isset($pesan)) {
                echo "<div class=\"pesan\">$pesan</div>";
            }

            // tampilkan error jika ada
            if ($pesan_error !== "") {
                echo "<div class=\"error\">$pesan_error</div>";
            }
          ?>

          <!-- form -->
          <form class="login100-form validate-form" method="POST" action="login.php">
            <!-- username -->
            <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
              <label for="username" class="label-input100">Username :</label>              
              <input
                class="input100"
                type="text"
                name="username"
                id="username"
                placeholder="Enter username"
                value="<?php echo $username ?>"
              />
              <span class="focus-input100"></span>
            </div>
            <!-- password -->
            <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
              <label for="password" class="label-input100">Password : </label>              
              <input
                class="input100"
                type="password"
                name="password"
                id="password"
                placeholder="Enter password"
                value="<?php echo $password ?>"
              />
              <span class="focus-input100"></span>
              <div id="toggle" onclick="showHide();"></div>
            </div>
            <div class="flex-sb-m w-full p-b-30"></div>
            <div class="container-login100-form-btn">
            <input type="submit" name="submit" class="login100-form-btn" value="Login">  
            </div>
          </form>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      const password = document.getElementById("password");
      const toggle = document.getElementById("toggle");

      function showHide() {
        if (password.type === "password") {
          password.setAttribute("type", "text");
          toggle.classList.add("hide");
        } else {
          password.setAttribute("type", "password");
          toggle.classList.remove("hide");
        }
      }
    </script>
  </body>
</html>
