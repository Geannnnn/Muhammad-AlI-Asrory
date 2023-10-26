<!DOCTYPE html>
<html lang="en">
<?php $conn = mysqli_connect("localhost","root","","universitas"); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Mahasiswa</title>
</head>
<body>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="?home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?admin">Admin</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?ps">Program Studi</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php 
    if (isset($_POST['hapus'])) {
        $s = $_POST['tabel'];
        $a = $_POST['id_name'];
        $d = $_POST['id'];
        mysqli_query ($conn, "DELETE FROM $s where $a ='$d'");
        }
    ?> 


<!-- HOME -->
<?php if(isset($_GET['home'])) : ?>
    
    <div class="container mt-5">
        <table class="table table-bordered">
            <form action="" method="post">
                <input type="search" name="cari" placeholder="Search">
            </form>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Npm</th>
                    <th>Email</th>
                    <th>Program Studi</th>
                </tr>
            </thead>
            <tbody>
            <?php 
if (isset($_POST['cari'])) {
    $c = $_POST['cari'];
    
    $q1 = mysqli_query($conn,'SELECT * FROM mahasiswa JOIN programstudi ON mahasiswa.id_program=programstudi.id_program');
    $w = mysqli_fetch_assoc($q1);
    
    $q = mysqli_query($conn,"SELECT * FROM mahasiswa where npm LIKE '%$c%' OR nama_mahasiswa = '$c'");
    $cacing = mysqli_num_rows($q);
    
    if ($cacing > 0) {
        while ($rawr = mysqli_fetch_assoc($q)) { ?>
            <tr>
                <td><?= $rawr['nama_mahasiswa'] ?></td>
                <td><?= $rawr['npm'] ?></td>
                <td><?= $rawr['email'] ?></td>
                <td><?= $w['programstudi'] ?></td>
            </tr>
        <?php }
    } else { ?>
        <tr>
            <td colspan="4">Data tidak ada</td>
        </tr>
    <?php }
}
?>

                    
                    


            </tbody>
        </table>
    </div>

    <?php endif ?>


    <?php if(isset($_GET['admin'])) : ?>

    <?php if(isset($_POST['rawr']))
    {
    $a = $_POST['id'];
    $s = $_POST['name'];
    $d = $_POST['npm'];
    $e = $_POST['email'];
    $p = $_POST['ps'];
    
    mysqli_query ($conn, "INSERT INTO mahasiswa VALUES ('$a','$s','$d','$e','$p')");
    header("location:?admin");
    }
    
    if (isset($_POST['edi'])) {
    $id = $_POST['id'];
    $nama = $_POST['name'];
    $npm = $_POST['npm'];
    $email = $_POST['email'];
    $prog = $_POST['ps'];

    mysqli_query ($conn, "UPDATE mahasiswa SET id='$id', nama_mahasiswa='$nama', npm='$npm', email='$email', id_program='$prog' where id='$id'");
    header("location:?admin");
    } 

    ?>

    
    <div class="container mt-5">
    <table class="table table-striped">
       
        <?php if (isset($_POST["tambah"])) : ?>
        
        <form action="" method="post">
            <input type="hidden" name="id">
            <div class="form-group">
                <label class="form-label" for="w"></label>
                <input class="form-control" type="text" name="name" id="w" placeholder="Nama" autofocus="off" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-label" for="d"></label>
                <input class="form-control" type="text" name="npm" id="d" placeholder="NPM">
            </div>
            <div class="form-group">
                <label class="form-label" for="a"></label>
                <input class="form-control" type="text" name="email" id="a" placeholder="Email">
            </div>
            <select name="ps" id="" class="form-control mt-3">
                <?php foreach (mysqli_query($conn,"SELECT * FROM programstudi") as $rawr) : ?>
                <option value="<?= $rawr['id_program'] ?>"><?= $rawr['programstudi'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="">
            <input type="submit" value="Add" name="rawr" class="btn btn-primary btn-sm mt-3 ">
            <input type="submit" value="Cancel" class="btn btn-primary btn-sm mt-3 ">
            </div>
        </form>
        <?php elseif (isset($_POST['edit'])) : ?>

            <?php 
                $a = $_POST['id'];
                $q = mysqli_query($conn, "SELECT * FROM mahasiswa where id = '$a'");

                $sw = mysqli_fetch_assoc($q);

            ?>

            <form action="" method="post">
                <div class="form-group mt-3">
            <input type="hidden" name="id" value="<?= $sw['id'] ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="w"></label>
                <input class="form-control" type="text" name="name" id="w" value="<?= $sw['nama_mahasiswa'] ?>" autofocus="off" autocomplete="off">
            </div>
            <div class="form-group">
                <label class="form-label" for="d"></label>
                <input class="form-control" type="text" name="npm" id="d" value="<?= $sw['npm'] ?>">
            </div>
            <div class="form-group">
                <label class="form-label" for="a"></label>
                <input class="form-control" type="text" name="email" id="a" value="<?= $sw['email'] ?>">
            </div>
            <select name="ps" id="" class="form-control mt-3">
                <?php foreach (mysqli_query($conn,"SELECT * FROM programstudi") as $rawrs) : ?>
                <option value="<?= $rawrs['id_program'] ?>"><?= $rawrs['programstudi'] ?></option>
                <?php endforeach ?>
            </select>
            <div class="mt-3">
            <input type="submit" name="edi" class="btn btn-primary btn-sm" value="Edit">
            <button class="btn btn-primary btn-sm">Cancel</button>
            </div>
        </form>


        <?php else : ?>
            <form action="" method="post">
            <button class="btn btn-primary btn-sm" name="tambah">Add</button>
        </form>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>NPM</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $q = mysqli_query($conn,"SELECT * FROM mahasiswa JOIN programstudi ON mahasiswa.id_program = programstudi.id_program");
        while($rawr = mysqli_fetch_array($q)) :
    ?>
            <tr>
                <td><?= $rawr['nama_mahasiswa'] ?></td>
                <td><?= $rawr['npm'] ?></td>
                <td><?= $rawr['email'] ?></td>
                <td><?= $rawr['programstudi'] ?></td>
                <td>
                        <form action="" method="post">
                        <button class="btn btn-danger btn-sm" name="hapus">Delete</button>
                        <button class="btn btn-primary btn-sm" name="edit">Edit</button>
                        <input type="hidden" name="id" value="<?= $rawr['id'] ?>">
                        <input type="hidden" name="id_name" value="id">
                        <input type="hidden" name="tabel" value="mahasiswa">
                        </form>
                </td>
            </tr>
            <?php endwhile ?>
        </tbody>
    </table>
        <?php endif ?>
    </div>
    <?php endif ?>

    <?php if (isset($_GET['ps'])) : ?>

    <?php if (isset($_POST['add'])) {
        $a = $_POST['id'];
        $s = $_POST['programstudi'];
        mysqli_query ($conn, "INSERT INTO programstudi values ('$a','$s')");
    } 
    
    if(isset($_POST['ubah'])) {
        $d = $_POST['id'];
        $p = $_POST['programstudi'];
        mysqli_query ($conn,"UPDATE programstudi SET id_program='$d', programstudi='$p' where id_program='$d'");
    }
    
    ?>

    
    <div class="container mt-5">
        <table class="table table-striped">
            <?php if (isset($_POST['tam'])) : ?>
                <form action="" method="post">
                    <div class="form-floating">
                        <input type="text" id="w" name="id" placeholder="ID" class="form-control" readonly>
                        <label for="w" class="form-labels">ID</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" id="s" name="programstudi" placeholder="ID" class="form-control">
                        <label for="s" class="form-labels">Program Studi</label>
                    </div>
                    <div class="mt-3">
                        <input type="submit" value="Tambah" name="add" class="btn btn-primary btn-sm">
                        <input type="submit" value="Cancel" class="btn btn-primary btn-sm">
                    </div>
                </form>
            <?php elseif (isset($_POST['edit'])) : ?>
               <?php 
                $s = $_POST['id'];
                $q = mysqli_query ($conn,"SELECT * FROM programstudi where id_program = '$s'");
                $row = mysqli_fetch_array($q);
                ?>
                <form action="" method="post">
                    <div class="form-floating">
                        <input type="text" id="w" name="id" value="<?= $row['id_program'] ?>" class="form-control" readonly>
                        <label for="w" class="form-labels">ID</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="text" id="s" name="programstudi" value="<?= $row['programstudi'] ?>" class="form-control">
                        <label for="s" class="form-labels">Program Studi</label>
                    </div>
                    <div class="mt-3">
                        <input type="submit" value="Ubah" name="ubah" class="btn btn-primary btn-sm">
                        <input type="submit" value="Cancel" class="btn btn-primary btn-sm">
                    </div>
                </form>
            <?php else : ?>
            <form action="" method="post">
                <input type="submit" name="tam" value="Add" class="btn btn-primary btn-sm">
            </form>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                    <?php 
                    $q = mysqli_query($conn,"SELECT * FROM programstudi");
                    while($rawr = mysqli_fetch_array($q)) :
                ?>
                <tr>
                    <td><?= $rawr['id_program'] ?></td>
                    <td><?= $rawr['programstudi'] ?></td>
                    <td>
                        <form action="" method="post">
                            <button class="btn btn-danger btn-sm" name="hapus">Delete</button>
                            <button class="btn btn-primary btn-sm" name="edit">Edit</button>
                            <input type="hidden" name="id" value="<?= $rawr['id_program'] ?>">
                            <input type="hidden" name="id_name" value="id_program">
                            <input type="hidden" name="tabel" value="programstudi">
                        </form>
                    </td>
                </tr>
                <?php endwhile ?>
            </tbody>
            <?php endif ?>
        </table>
    </div>

    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

