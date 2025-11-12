<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once('../MODEL/modelmuahang.php');
include_once('../MODEL/modelmqd1.php');

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten = trim($_POST['ten']);
    $diachi = trim($_POST['diachi']);
    $sdt = trim($_POST['sdt']);
    $sanpham = intval($_POST['sanpham']);
    $soluong = intval($_POST['soluong']);
    $user_id = $_SESSION['ID_user'] ?? null;

    if (!$user_id) {
        $errors[] = "Bạn cần đăng nhập để đặt hàng.";
    }
    if (empty($ten) || empty($diachi) || empty($sdt) || empty($sanpham) || empty($soluong)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin.";
    }

    $model = new data_mqd1();
    $sp = $model->getProductById($sanpham);
    if (!$sp) {
        $errors[] = "Sản phẩm không tồn tại.";
    }

    if (count($errors) === 0) {
        $dongia = $sp['dongia'];
        $tongtien = $dongia * $soluong;
        $trangthai = "chờ xác nhận";
        $muahang = new data_muahang();
        $result = $muahang->insert_muahang($user_id, $sanpham, 1, $soluong, $dongia, $tongtien, $trangthai);
        if ($result['success']) {
            // Xóa giỏ hàng session nếu cần
            unset($_SESSION['cart']);
            header("Location: mqd.php?order=success");
            exit;
        } else {
            $errors[] = $result['message'] ?? "Đặt hàng thất bại.";
        }
    }
}
?>
