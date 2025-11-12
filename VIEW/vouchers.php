<?php
session_start();
include_once('../MODEL/modelvouchers.php');
$model = new data_vouchers();
$user_id = $_SESSION['ID_user'] ?? null;

// Get all available vouchers
$all_vouchers = $model->select_all_vouchers();

// Get user's claimed vouchers
$user_claimed_vouchers = $user_id ? $model->get_user_claimed_vouchers($user_id) : [];

// Filter claimable vouchers (not claimed by user)
$claimable_vouchers = [];
if ($user_id) {
    $claimed_ids = array_column($user_claimed_vouchers, 'id');
    foreach ($all_vouchers as $voucher) {
        if (!in_array($voucher['id'], $claimed_ids)) {
            $claimable_vouchers[] = $voucher;
        }
    }
}

// Handle voucher claim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['claim_voucher']) && $user_id) {
    $voucher_id = intval($_POST['voucher_id']);
    $result = $model->claim_voucher($user_id, $voucher_id);
    if ($result) {
        header("Location: vouchers.php?claimed=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý voucher - BAKERY SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<header class="sticky top-0 z-50 w-full border-b bg-white shadow-sm">
  <div class="container mx-auto flex h-16 items-center justify-between px-4">
    <a href="mqd.php" class="flex items-center space-x-2">
      <span class="text-2xl font-bold text-[#8BC34A]">BAKERY SHOP</span>
    </a>
    <nav class="hidden md:flex items-center space-x-8">
<a href="gioithieu.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
<a href="tintuc.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="dangnhap.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đăng nhập</a>
      <?php else: ?>
        <a href="lichsumuahang.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đơn hàng</a>
        <a href="vouchers.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Voucher</a>
        <a href="dangxuat.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đăng xuất</a>
      <?php endif; ?>
      <a href="danhgia.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
    <button class="md:hidden p-2 hover:bg-gray-100 rounded" id="mobile-menu-button">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
    <div class="flex items-center space-x-4">
      <a href="giohang.php" class="p-2 hover:bg-gray-100 rounded-full transition-colors relative inline-block">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center">
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
        </span>
      </a>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden hidden bg-white border-t shadow-lg">
    <nav class="px-4 py-4 space-y-2">
      <a href="gioithieu.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
      <a href="tintuc.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="dangnhap.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đăng nhập</a>
      <?php else: ?>
        <a href="lichsumuahang.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đơn hàng</a>
        <a href="vouchers.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Voucher</a>
        <a href="dangxuat.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đăng xuất</a>
      <?php endif; ?>
      <a href="danhgia.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
  </div>
</header>

<div class="max-w-6xl mx-auto px-4 py-12">
    <?php if (isset($_GET['claimed'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
            Voucher đã được nhận thành công!
        </div>
    <?php endif; ?>

    <!-- Claimable Vouchers Section -->
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8 mb-8">
        <h2 class="text-2xl font-bold text-center text-primary mb-6">Voucher Có Thể Nhận</h2>
        <?php if (!empty($claimable_vouchers)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($claimable_vouchers as $vc): ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($vc['code']); ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($vc['type'] == 'percent' ? 'Giảm ' . $vc['value'] . '%' : 'Giảm ' . number_format($vc['value']) . '₫'); ?></p>
                        <p class="text-sm text-gray-500 mb-4">Hết hạn: <?php echo htmlspecialchars($vc['expiry_date'] ?? 'Không giới hạn'); ?></p>
                        <form method="post" class="inline">
                            <input type="hidden" name="voucher_id" value="<?php echo $vc['id']; ?>">
                            <button type="submit" name="claim_voucher" class="w-full bg-primary text-white py-2 px-4 rounded hover:bg-green-600 transition-colors">Nhận Voucher</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500 py-8">Không có voucher nào có thể nhận.</p>
        <?php endif; ?>
    </div>

    <!-- User's Claimed Vouchers Section -->
    <?php if ($user_id): ?>
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
            <h2 class="text-2xl font-bold text-center text-primary mb-6">Voucher Đã Nhận</h2>
            <?php if (!empty($user_claimed_vouchers)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($user_claimed_vouchers as $vc): ?>
                        <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2"><?php echo htmlspecialchars($vc['code']); ?></h3>
                            <p class="text-gray-600 mb-2"><?php echo htmlspecialchars($vc['type'] == 'percent' ? 'Giảm ' . $vc['value'] . '%' : 'Giảm ' . number_format($vc['value']) . '₫'); ?></p>
                            <p class="text-sm text-gray-500 mb-4">Hết hạn: <?php echo htmlspecialchars($vc['expiry_date'] ?? 'Không giới hạn'); ?></p>
                            <span class="inline-block bg-green-500 text-white py-1 px-3 rounded-full text-sm">Đã nhận</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500 py-8">Bạn chưa nhận voucher nào.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const mobileMenuButton = document.getElementById('mobile-menu-button');
  const mobileMenu = document.getElementById('mobile-menu');

  mobileMenuButton.addEventListener('click', function() {
    mobileMenu.classList.toggle('hidden');
  });

  // Close menu when clicking outside
  document.addEventListener('click', function(event) {
    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
      mobileMenu.classList.add('hidden');
    }
  });
});
</script>
</body>
</html>
