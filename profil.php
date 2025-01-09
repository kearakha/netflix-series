<?php
session_start(); // Memulai session
include "koneksi.php";

// Ambil username dari session
$username = $_SESSION['username'];

// Ambil data pengguna dari database berdasarkan username
$sql = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Jika data ditemukan
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>
<div class="container">
    <div class="row">
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= isset($row['id']) ? $row['id'] : ''; ?>">
            <input type="hidden" name="foto_lama" value="<?= isset($row['foto']) ? $row['foto'] : ''; ?>">

            <div class="mb-3">
                <label for="password" class="form-label">Ganti Password</label>
                <input type="password" name="password" class="form-control" placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto Profil</label>
                <input type="file" name="foto" class="form-control">
            </div>
            <div class="mb-3">
                <label for="foto_lama" class="form-label">Foto Profil Saat Ini</label>
                <br>
                <?php
                    if ($row["foto"] != '') {
                        if (file_exists('img/' . $row["foto"] . '')) {
                    ?>
                        <img src="img/<?= $row["foto"] ?>" width="200">
                    <?php
                            }
                        }
                    ?>
            </div>
            <div class="mb-3">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?php 
} else {
    echo "<p>Tidak ada data.</p>";
}
?>

<?php

include "upload_foto.php";

// Jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $password = !empty($_POST['password']) ? md5($_POST['password']) : null;
    $foto = '';
    $nama_foto = $_FILES['foto']['name'];

    // Jika ada file yang dikirim  
    if (!empty($nama_foto)) {
        $cek_upload = upload_foto($_FILES["foto"]);

        if ($cek_upload['status']) {
            $foto = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=dashboard';
            </script>";
            die;
        }
    }

    if ($id) {
        // Jika id ada, lakukan update
        if (empty($foto)) {
            $foto = $_POST['foto_lama'];
        } else {
            if (!empty($_POST['foto_lama']) && file_exists('img/' . $_POST['foto_lama'])) {
                unlink('img/' . $_POST['foto_lama']);
            }
        }

        $query = "UPDATE user SET username = ?";
        $params = [$username];

        if ($password) {
            $query .= ", password = ?";
            $params[] = $password;
        }
        $query .= ", foto = ? WHERE id = ?";
        $params[] = $foto;
        $params[] = $id;

        $stmt = $conn->prepare($query);
        $stmt->bind_param(str_repeat("s", count($params) - 1) . "i", ...$params);
        $simpan = $stmt->execute();
    } else {
        // Insert data baru jika id tidak ada
        $stmt = $conn->prepare("INSERT INTO user (username, password, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $foto);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=dashboard';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=profil';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
