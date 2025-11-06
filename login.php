<?php
include "koneksi.php";

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

$respon = [];

if ($username !== '' && $password !== '') {
    $sql = "SELECT * FROM tbl_user WHERE username = '$username'";
    $login = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($login) > 0){

        $row = mysqli_fetch_assoc($login);
        if ($row['password'] === $password) {
            $respon['success'] = true;
            $respon['message'] = "Login Berhasil! Selamat Datang ".$username;
        } else {
            $respon['success'] = false;
            $respon['message'] = "Password Salah! Coba Lagi.";
        }
    } else {
        $insert = "INSERT INTO tbl_user (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($koneksi, $insert)) {
            $respon['success'] = true;
            $respon['message'] = "Login Berhasil! Selamat Datang ".$username;
        } else {
            $respon['success'] = false;
            $respon['message'] = "Gagal menginput data.".mysqli_error($koneksi);
        }
    }
} else {
    $respon['success'] = false;
    $respon['message'] = "Username atau Password kosong!";
}

header('Content-Type: application/json');
echo json_encode($respon);


?>