<?php
session_start();
include_once '../MODEL/modelquenmk.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../VIEW/PHPMailer/src/Exception.php';
require '../VIEW/PHPMailer/src/PHPMailer.php';
require '../VIEW/PHPMailer/src/SMTP.php';

$userModel = new data_user_forgot();
$errors = [];
$success = '';
$step = 1; // Step 1: enter email, Step 2: enter code and new password

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_code'])) {
        // Step 1: Send verification code to email
        $email = trim($_POST['email']);
        if (empty($email)) {
            $errors[] = "Vui lòng nhập email.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email không hợp lệ.";
        } else {
            $user = $userModel->get_user_by_email($email);
            if (!$user) {
                $errors[] = "Email không tồn tại trong hệ thống.";
            } else {
                // Generate 6-digit code
                $code = random_int(100000, 999999);
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_code'] = $code;
                $_SESSION['code_time'] = time();

                // Send email
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@gmail.com'; // TODO: replace with your email
                    $mail->Password = 'your_email_password'; // TODO: replace with your email password or app password
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('your_email@gmail.com', 'Bakery Shop');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Mã xác thực lấy lại mật khẩu';
                    $mail->Body = "Mã xác thực của bạn là: <b>$code</b>. Mã có hiệu lực trong 10 phút.";

                    $mail->send();
                    $success = "Mã xác thực đã được gửi đến email của bạn.";
                    $step = 2;
                } catch (Exception $e) {
                    $errors[] = "Gửi email thất bại: {$mail->ErrorInfo}";
                }
            }
        }
    } elseif (isset($_POST['verify_code'])) {
        // Step 2: Verify code and reset password
        $email = $_SESSION['reset_email'] ?? '';
        $code = trim($_POST['code']);
        $matkhaumoi = $_POST['matkhaumoi'];
        $nhaplaimatkhau = $_POST['nhaplaimatkhau'];

        if (empty($code) || empty($matkhaumoi) || empty($nhaplaimatkhau)) {
            $errors[] = "Vui lòng điền đầy đủ thông tin.";
        } elseif ($matkhaumoi !== $nhaplaimatkhau) {
            $errors[] = "Mật khẩu mới và nhập lại mật khẩu không khớp.";
        } elseif ($code != ($_SESSION['reset_code'] ?? '') || (time() - ($_SESSION['code_time'] ?? 0)) > 600) {
            $errors[] = "Mã xác thực không đúng hoặc đã hết hạn.";
        } else {
            // Update password
            $updated = $userModel->update_password_by_email($email, $matkhaumoi);
            if ($updated) {
                unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['code_time']);
                $success = "Cập nhật mật khẩu thành công! Bạn có thể <a href='dangnhap.php'>đăng nhập</a> ngay bây giờ.";
                $step = 1;
            } else {
                $errors[] = "Cập nhật mật khẩu thất bại, vui lòng thử lại.";
                $step = 2;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lấy lại mật khẩu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-warning text-dark text-center">
          <h4>Lấy lại mật khẩu</h4>
        </div>
        <div class="card-body">
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul>
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php endif; ?>

          <?php if ($step === 1): ?>
          <form method="post" action="">
            <div class="mb-3">
              <label for="email" class="form-label">Nhập email của bạn</label>
              <input type="email" class="form-control" name="email" required value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
            </div>
            <button type="submit" name="send_code" class="btn btn-warning w-100">Gửi mã xác thực</button>
          </form>
          <?php elseif ($step === 2): ?>
          <form method="post" action="">
            <div class="mb-3">
              <label for="code" class="form-label">Nhập mã xác thực</label>
              <input type="text" class="form-control" name="code" maxlength="6" required />
            </div>
            <div class="mb-3">
              <label for="matkhaumoi" class="form-label">Mật khẩu mới</label>
              <input type="password" class="form-control" name="matkhaumoi" required />
            </div>
            <div class="mb-3">
              <label for="nhaplaimatkhau" class="form-label">Nhập lại mật khẩu</label>
              <input type="password" class="form-control" name="nhaplaimatkhau" required />
            </div>
            <button type="submit" name="verify_code" class="btn btn-warning w-100">Xác thực & Cập nhật</button>
          </form>
          <?php endif; ?>
        </div>
        <div class="card-footer text-center">
          <small>Quay về <a href="dangnhap.php">Đăng nhập</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
