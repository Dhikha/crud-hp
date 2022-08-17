<?php
  // periksa apakah user sudah login, cek kehadiran session name 
  // jika tidak ada, redirect ke login.php
  session_start();
  if (!isset($_SESSION["nama"])) {
     header("Location: login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Halaman Admin Mhs</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left text-center">Halaman Admin Mahasiswa</h2>
                        <a href="create.php" class="btn btn-success pull-right">Tambah Data</a>
                        <a href="logout.php" class="btn btn-success btn-logout">Logout</a>
                    </div>
                    <?php
                    // Include config file
                    require_once "config.php";

                    // Attempt select query execution
                    $sql = "SELECT * FROM tb_mhs";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>ID</th>";
                                        echo "<th>NAMA</th>";
                                        echo "<th>KATEGORI</th>";
                                        echo "<th>NO HP</th>";
                                        echo "<th>HARGA</th>";
                                        echo "<th>AKSI</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['nama'] . "</td>";
                                        echo "<td>" . $row['kategori'] . "</td>";
                                        echo "<td>" . $row['no_hp'] . "</td>";
                                        echo "<td>" . $row['harga'] . "</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-sm ml-1 mb-1 btn-success btn-edit' href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'>Edit</a>";
                                            echo "<a class='btn btn-sm ml-1 mb-1 btn-danger btn-delete' href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'>Hapus</a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }

                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>