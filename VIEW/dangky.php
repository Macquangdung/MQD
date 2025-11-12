<?php
require_once '../CONTROLLER/controldangky.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký tài khoản - BAKERY SHOP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="dinhdang.css">
  <style>
    body { font-family: 'Geist', sans-serif; }
    .bg-primary { background-color: #8BC34A; }
    .text-primary { color: #8BC34A; }
    .hover-scale { transition: transform 0.3s ease; }
    .hover-scale:hover { transform: scale(1.03); }
    .price { color: #e53e3e; font-weight: 600; }
  </style>
</head>
<body class="bg-stone-50">
<header class="sticky top-0 z-50 w-full border-b bg-white shadow-sm">
  <div class="container mx-auto flex h-16 items-center justify-between px-4">
    <a href="mqd.php" class="flex items-center space-x-2">
      <span class="text-2xl font-bold text-[#8BC34A]">BAKERY SHOP</span>
    </a>
    <nav class="hidden md:flex items-center space-x-8">
      <a href="gioithieu.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
      <a href="https://tljus.com/" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <a href="danhgia.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
  </div>
</header>

<div class="max-w-md mx-auto px-4 py-12">
  <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
    <div class="px-6 py-4 border-b">
      <h5 class="text-2xl font-bold text-center text-gray-800">Đăng ký tài khoản</h5>
    </div>
    <div class="p-8">
      <?php
      if (!empty($errors)) {
        echo '<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">';
        foreach ($errors as $error) {
          echo '<div>' . htmlspecialchars($error) . '</div>';
        }
        echo '</div>';
      }
      if (!empty($success)) {
        echo '<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">' . htmlspecialchars($success) . '</div>';
      }
      ?>
      <form name="formDangKy" method="post" action="">
        <div class="mb-4">
          <label for="tendangnhap" class="block text-sm font-medium text-gray-700 mb-1">Tên đăng nhập</label>
          <input type="text" id="tendangnhap" name="tendangnhap" maxlength="35" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($tendangnhap) ? htmlspecialchars($tendangnhap) : ''; ?>">
        </div>
        <div class="mb-4">
          <label for="matkhau" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
          <input type="password" id="matkhau" name="matkhau" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
        </div>
        <div class="mb-4">
          <label for="nhapmatkhau" class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu</label>
          <input type="password" id="nhapmatkhau" name="nhapmatkhau" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
        </div>
        <div class="mb-4">
          <label for="sdt" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
          <input type="text" id="sdt" name="sdt" maxlength="10" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($sdt) ? htmlspecialchars($sdt) : ''; ?>">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
        </div>
        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-md">Đăng ký</button>
      </form>
    </div>
    <div class="px-6 py-4 border-t bg-gray-50 text-center text-sm">
      <small>Đã có tài khoản? <a href="dangnhap.php" class="text-primary font-medium hover:underline">Đăng nhập</a></small>
    </div>
  </div>
</div>

<footer class="bg-gray-900 text-white py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid md:grid-cols-4 gap-8">
      <div>
        <div class="flex items-center gap-2 mb-4">
          <img src="src/media/loo.jpg" alt="Logo" class="w-10 h-10 rounded-full">
          <span class="text-2xl font-bold text-primary">BAKERY SHOP</span>
        </div>
        <p class="text-gray-400 mb-4">Nơi bạn có thể tìm thấy những chiếc bánh ngọt ngào, chất lượng và sáng tạo nhất.</p>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4 text-primary">Liên Kết Nhanh</h3>
        <ul class="space-y-2">
          <li><a href="mqd.php" class="text-gray-400 hover:text-white transition-colors">Trang chủ</a></li>
          <li><a href="mqd1.php" class="text-gray-400 hover:text-white transition-colors">Sản phẩm</a></li>
          <li><a href="gioithieu.php" class="text-gray-400 hover:text-white transition-colors">Về chúng tôi</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Liên hệ</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4 text-primary">Danh Mục</h3>
        <ul class="space-y-2">
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh Kem</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh Mousse</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Macaron</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kẹo Dẻo</a></li>
        </ul>
      </div>
      <div>
        <h3 class="text-lg font-semibold mb-4 text-primary">Liên Hệ</h3>
        <ul class="space-y-2 text-gray-400">
          <li>📍 123 Đường ABC, Quận XYZ</li>
          <li>📞 <span class="text-red-500 font-semibold">1900 1234</span></li>
          <li>✉️ info@bakeryshop.com</li>
          <li>🕒 8:00 - 22:00</li>
        </ul>
      </div>
    </div>
    <div class="border-t border-gray-800 mt-12 pt-8 text-center">
      <p class="text-gray-400">&copy; 2024 BAKERY SHOP. Tất cả quyền được bảo lưu.</p>
    </div>
  </div>
</footer>
</body>
</html>
