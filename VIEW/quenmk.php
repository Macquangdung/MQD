<?php
session_start();
include_once '../MODEL/modelquenmk.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

$userModel = new data_user_forgot();
$errors = [];
$success = '';
$step = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_code'])) {
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
                $code = random_int(100000, 999999);
                $_SESSION['reset_email'] = $email;
                $_SESSION['reset_code'] = $code;
                $_SESSION['code_time'] = time();

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@gmail.com';
                    $mail->Password = 'your_email_password';
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
            $updated = $userModel->update_password_by_email($email, $matkhaumoi);
            if ($updated) {
                unset($_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['code_time']);
                $success = "Cập nhật mật khẩu thành công! Bạn có thể <a href='dangnhap.php' class='text-primary underline'>đăng nhập</a> ngay bây giờ.";
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
  <title>Lấy lại mật khẩu - BAKERY SHOP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="dinhdang.css">
  <style>
    body { font-family: 'Geist', sans-serif; }
    .bg-primary { background-color: #8BC34A; }
    .text-primary { color: #8BC34A; }
  </style>
</head>
<body class="bg-stone-50">
<!-- Không hiện menu đầy đủ ở trang quên mật khẩu -->
<div class="max-w-md mx-auto px-4 py-12">
  <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
    <div class="px-6 py-4 border-b bg-yellow-100">
      <h4 class="text-2xl font-bold text-center text-yellow-700">Lấy lại mật khẩu</h4>
    </div>
    <div class="p-8">
      <?php if (!empty($errors)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <ul class="list-disc pl-5">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      <?php if ($success): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?= $success ?></div>
      <?php endif; ?>

      <?php if ($step === 1): ?>
      <form method="post" action="" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Nhập email của bạn</label>
          <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" />
        </div>
        <button type="submit" name="send_code" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors shadow-md">Gửi mã xác thực</button>
      </form>
      <?php elseif ($step === 2): ?>
      <form method="post" action="" class="space-y-6">
        <div>
          <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Nhập mã xác thực</label>
          <input type="text" id="code" name="code" maxlength="6" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" />
        </div>
        <div>
          <label for="matkhaumoi" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
          <input type="password" id="matkhaumoi" name="matkhaumoi" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" />
        </div>
        <div>
          <label for="nhaplaimatkhau" class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu</label>
          <input type="password" id="nhaplaimatkhau" name="nhaplaimatkhau" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" />
        </div>
        <button type="submit" name="verify_code" class="w-full bg-yellow-500 text-white py-3 rounded-lg font-semibold hover:bg-yellow-600 transition-colors shadow-md">Xác thực & Cập nhật</button>
      </form>
      <?php endif; ?>
    </div>
    <div class="px-6 py-4 border-t bg-gray-50 text-center text-sm">
      <small>Quay về <a href="dangnhap.php" class="text-primary font-medium hover:underline">Đăng nhập</a></small>
    </div>
  </div>
</div>
</body>
</html>
