<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../CONTROLLER/controlmqd1.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: mqd1.php');
    exit;
}

$id = (int)$_GET['id'];
$sanpham = null;
if (isset($ds_sanpham) && $ds_sanpham) {
    foreach ($ds_sanpham as $item) {
        if ($item['ID_sanpham'] == $id) {
            $sanpham = $item;
            break;
        }
    }
}

if (!$sanpham) {
    header('Location: mqd1.php');
    exit;
}

if (isset($_GET['toggle_menu'])) {
    $_SESSION['mobile_menu_visible'] = !isset($_SESSION['mobile_menu_visible']) || !$_SESSION['mobile_menu_visible'];
}

// Fetch available vouchers for logged-in user
$user_vouchers = [];
if (isset($_SESSION['ID_user'])) {
    include_once('../MODEL/modelvouchers.php');
    $voucher_model = new data_vouchers();
    $user_vouchers = $voucher_model->get_user_claimed_vouchers($_SESSION['ID_user']);
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user'])) {
        header("Location: dangnhap.php");
        exit;
    }

    $quantity = intval($_POST['quantity']);
    $selected_voucher = isset($_POST['voucher']) && !empty($_POST['voucher']) ? intval($_POST['voucher']) : null;

    if ($quantity > 0) {
        include_once('../MODEL/modelgiohang.php');
        $result = GioHang::addItem($sanpham['ID_sanpham'], $quantity);

        if ($result) {
            // Redirect to avoid resubmission
            header("Location: chitiet.php?id=" . $sanpham['ID_sanpham'] . "&added=1");
            exit;
        } else {
            $error_message = "Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($sanpham['tensanpham']); ?> - BAKERY SHOP</title>
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
    <script>
        function updatePrice() {
            const voucherSelect = document.getElementById('voucher');
            const originalPriceElement = document.getElementById('original-price');
            const discountedPriceElement = document.getElementById('discounted-price');
            const buyNowVoucher = document.getElementById('buy-now-voucher');

            const selectedOption = voucherSelect.options[voucherSelect.selectedIndex];
            const voucherType = selectedOption.getAttribute('data-type');
            const voucherValue = parseFloat(selectedOption.getAttribute('data-value'));
            const voucherId = selectedOption.value;

            const originalPrice = <?php echo $sanpham['dongia']; ?>;

            if (voucherType && voucherValue) {
                let discountedPrice = originalPrice;
                if (voucherType === 'percent') {
                    discountedPrice = originalPrice * (1 - voucherValue / 100);
                } else if (voucherType === 'fixed') {
                    discountedPrice = Math.max(0, originalPrice - voucherValue);
                }

                originalPriceElement.style.textDecoration = 'line-through';
                originalPriceElement.style.color = '#9CA3AF';
                discountedPriceElement.textContent = discountedPrice.toLocaleString() + '₫';
                discountedPriceElement.style.display = 'block';
                buyNowVoucher.value = voucherId;
            } else {
                originalPriceElement.style.textDecoration = 'none';
                originalPriceElement.style.color = '#e53e3e';
                discountedPriceElement.style.display = 'none';
                buyNowVoucher.value = '';
            }
        }
    </script>
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
    <a href="?toggle_menu=1" class="md:hidden p-2 hover:bg-gray-100 rounded cursor-pointer">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </a>
    <div class="flex items-center space-x-4">
      <a href="giohang.php" class="p-2 hover:bg-gray-100 rounded-full transition-colors relative inline-block">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center">
          <?php
          if (isset($_SESSION['user'])) {
              include_once('../MODEL/modelgiohang.php');
              echo GioHang::getItemCount();
          } else {
              echo 0;
          }
          ?>
        </span>
      </a>
    </div>
  </div>
  <div id="mobile-menu" class="md:hidden bg-white border-t shadow-lg <?php echo isset($_SESSION['mobile_menu_visible']) && $_SESSION['mobile_menu_visible'] ? '' : 'hidden'; ?>">
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

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="text-center">
                <img src="src/media/<?php
                    $image_file = $sanpham['hinhanh'] ?? '';
                    if (empty($image_file) || !file_exists('src/media/' . $image_file)) {
                        $name = strtolower($sanpham['tensanpham']);
                        if (strpos($name, 'bông lan') !== false && strpos($name, 'phô mai') !== false) {
                            $image_file = 'banh-bong-lan-pho-mai-nhat-ban.webp';
                        } elseif (strpos($name, 'bông lan') !== false) {
                            $image_file = 'banhbonglan.jpg';
                        } elseif (strpos($name, 'kem') !== false) {
                            $image_file = 'banhkem.jpg';
                        } elseif (strpos($name, 'trung thu') !== false) {
                            $image_file = 'banhtrungthu.jpg';
                        } elseif (strpos($name, 'bánh') !== false) {
                            $image_file = '2.jpg';
                        } elseif (strpos($name, 'cake') !== false) {
                            $image_file = '3.jpg';
                        } else {
                            $image_file = '1.jpg';
                        }
                    }
                    echo $image_file;
                ?>" alt="<?php echo htmlspecialchars($sanpham['tensanpham']); ?>" class="w-full h-96 object-cover object-center rounded-lg shadow-lg">
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4"><?php echo htmlspecialchars($sanpham['tensanpham']); ?></h1>
                <div class="mb-4">
                    <p class="text-2xl price" id="original-price"><?php echo number_format($sanpham['dongia']); ?>₫</p>
                    <p class="text-lg text-green-600 font-semibold" id="discounted-price" style="display: none;"></p>
                </div>
                <p class="text-gray-600 mb-6"><?php echo htmlspecialchars($sanpham['mota'] ?? ''); ?></p>
                <div class="space-y-4">
                    <?php if (isset($_GET['added'])): ?>
                        <div class="text-green-600 font-semibold">Đã thêm vào giỏ hàng!</div>
                    <?php endif; ?>
                    <?php if (isset($error_message)): ?>
                        <div class="text-red-600 font-semibold"><?php echo htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>
                    <form method="post" class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-gray-700 font-medium">Số lượng:</label>
                            <input type="number" id="quantity" name="quantity" min="1" value="1" class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                        </div>
                        <?php if (isset($_SESSION['user']) && !empty($user_vouchers)): ?>
                        <div class="flex items-center space-x-4">
                            <label for="voucher" class="text-gray-700 font-medium">Chọn voucher (tùy chọn):</label>
                            <select id="voucher" name="voucher" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" onchange="updatePrice()">
                                <option value="">Không dùng voucher</option>
                                <?php foreach ($user_vouchers as $voucher): ?>
                                <option value="<?php echo $voucher['id']; ?>" data-type="<?php echo $voucher['type']; ?>" data-value="<?php echo $voucher['value']; ?>"><?php echo htmlspecialchars($voucher['code'] . ' - ' . $voucher['type'] . ' ' . $voucher['value']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        <button type="submit" name="add_to_cart" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition-colors">Thêm vào giỏ hàng</button>
                    </form>
                    <div class="flex space-x-4">
                        <form method="post" action="muahang.php?mua=<?php echo $sanpham['ID_sanpham']; ?>" class="inline">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="voucher" id="buy-now-voucher" value="">
                            <button type="submit" class="px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">Mua ngay</button>
                        </form>
                        <a href="mqd1.php" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-colors">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="bg-gray-900 text-white py-12 mt-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="col-span-2 md:col-span-1">
                <img src="src/media/loo.jpg" alt="Bakery Logo" class="w-16 h-16 mb-4 rounded-full">
                <p class="text-xl font-bold mb-4">BAKERY SHOP</p>
            </div>
            <div>
                <h6 class="text-lg font-semibold mb-4 text-primary">Về chúng tôi</h6>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Giới thiệu</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Sứ mệnh nhân viên</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Giá trị sản phẩm</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">An toàn thực phẩm</a></li>
                </ul>
            </div>
            <div>
                <h6 class="text-lg font-semibold mb-4 text-primary">Vị trí cửa hàng</h6>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Miền Bắc</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Miền Trung</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Miền Nam</a></li>
                </ul>
            </div>
            <div class="col-span-2 md:col-span-1">
                <h6 class="text-lg font-semibold mb-4 text-primary">Tải ứng dụng</h6>
                <a href="#" class="inline-block"><img src="src/media/ggpl.png" alt="Google Play" class="h-12 w-auto"></a>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-400">
            <p>&copy; 2024 BAKERY SHOP. Phiên bản 1.7.7</p>
        </div>
    </div>
</footer>
</body>
</html>
