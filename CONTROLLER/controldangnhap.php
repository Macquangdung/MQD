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
            header("Location: /SANPHAMMOI/VIEW/admin.php");
            exit;
        }

        if ($tendangnhap === 'hieu' && $matkhau === '123456') {
            $_SESSION['user'] = 'hieu';
            header("Location: /SANPHAMMOI/VIEW/quanlydonhang_nv.php");
            exit;
        }
        $userModel = new data_user_login();
        $user = $userModel->get_user_by_username($tendangnhap);

        if ($user && password_verify($matkhau, $user['matkhau'])) {
            $_SESSION['user'] = $user['tendangnhap'];
            $_SESSION['ID_user'] = $user['ID_user'];
            $_SESSION['role'] = $user['role'] ?? '';
            header("Location: /SANPHAMMOI/VIEW/mqd.php");
            exit;
        } else {
            $errors[] = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đăng nhập tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Đăng nhập tài khoản</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                    ?>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="tendangnhap" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" name="tendangnhap" maxlength="35" required value="<?php echo isset($tendangnhap) ? htmlspecialchars($tendangnhap) : ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="matkhau" class="form-label">Mật khẩu</label>
                            <input type="password" class="class="form-control" name="matkhau" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Chưa có tài khoản? <a href="dangky.php">Đăng ký</a></small>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
