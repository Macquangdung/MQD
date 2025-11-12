<?php
session_start();
include_once '../MODEL/modeldangnhap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tendangnhap = trim($_POST['tendangnhap']);
    $matkhau = $_POST['matkhau'];

    $errors = [];

    if (empty($tendangnhap) || empty($matkhau)) {
        $errors[] = "Vui lòng nhập tên đăng nhập và mật khẩu.";
    }

    if (count($errors) === 0) {

        if ($tendangnhap === 'macquangdung' && $matkhau === '01062006') {
            $_SESSION['admin'] = true;
            $_SESSION['user'] = 'macquangdung';
header("Location: admin.php");
            exit;
        }

        if ($tendangnhap === 'hieu' && $matkhau === '123456') {
            $_SESSION['user'] = 'hieu';
header("Location: quanlydonhang_nv.php");
            exit;
        }
        $userModel = new data_user_login();
        $user = $userModel->get_user_by_username($tendangnhap);

        if ($user && password_verify($matkhau, $user['matkhau'])) {
            $_SESSION['user'] = $user['tendangnhap'];
            $_SESSION['ID_user'] = $user['ID_user'];
            $_SESSION['role'] = $user['role'] ?? '';
header("Location: mqd.php");
            exit;
        } else {
            $errors[] = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }
}
?>
