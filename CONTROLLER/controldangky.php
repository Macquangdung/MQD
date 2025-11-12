<?php
include_once '../MODEL/modeldangky.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tendangnhap = trim($_POST['tendangnhap']);
    $matkhau = $_POST['matkhau'];
    $nhapmatkhau = $_POST['nhapmatkhau'];
    $sdt = trim($_POST['sdt']);
    $email = trim($_POST['email']);

    $errors = [];

    // Basic validation
    if (empty($tendangnhap) || empty($matkhau) || empty($nhapmatkhau) || empty($sdt) || empty($email)) {
        $errors[] = "Vui lòng điền đầy đủ thông tin.";
    }

    if ($matkhau !== $nhapmatkhau) {
        $errors[] = "Mật khẩu nhập lại không khớp.";
    }

    // Validate phone number length and digits
    if (!preg_match('/^\d{10}$/', $sdt)) {
        $errors[] = "Số điện thoại phải gồm 10 chữ số.";
    }

    $userModel = new data_user();

    // Check if username already exists
    if ($userModel->check_username_exists($tendangnhap)) {
        $errors[] = "Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.";
    }

    if (count($errors) === 0) {
        // Insert user
        $inserted = $userModel->insert_user($tendangnhap, $matkhau, $sdt, $email, 'khách hàng');
        if ($inserted) {
            $success = "Đăng ký thành công! Bạn có thể <a href='../VIEW/dangnhap.php'>đăng nhập</a> ngay bây giờ.";
        } else {
            $errors[] = "Đăng ký thất bại, vui lòng thử lại.";
        }
    }
}
?>
