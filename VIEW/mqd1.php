<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Giữ nguyên file controller này
include('../CONTROLLER/controlmqd1.php');

if (isset($_GET['toggle_menu'])) {
    $_SESSION['mobile_menu_visible'] = !isset($_SESSION['mobile_menu_visible']) || !$_SESSION['mobile_menu_visible'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm - BAKERY SHOP</title>
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
        /* Đảm bảo chiều cao cho banner carousel */
        .love-letter-banner {
                /* Mô phỏng banner Love Letter với màu nền và họa tiết nhạt */
                background-color: #fcf8f6;
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fcebe1' fill-opacity='0.4'%3E%3Cpath d='M36 34h-4c-1.105 0-2-.896-2-2V2c0-1.105.895-2 2-2h4a2 2 0 0 1 2 2v30c0 1.105-.895 2-2 2zM36 34h-4c-1.105 0-2-.896-2-2V2c0-1.105.895-2 2-2h4a2 2 0 0 1 2 2v30c0 1.105-.895 2-2 2zM12 34h-4c-1.105 0-2-.896-2-2V2c0-1.105.895-2 2-2h4a2 2 0 0 1 2 2v30c0 1.105-.895 2-2 2z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                padding: 6rem 0;
            }
            .banner-carousel {
                position: relative;
                width: 100%;
                height: auto; 
                overflow: hidden;
            }

            .banner-carousel a {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
                animation: banner-fade 10s infinite;
            }
            
            .banner-carousel a:nth-child(1) {
                animation-delay: 0s;
                position: relative; 
            }
            .banner-carousel a:nth-child(2) {
                animation-delay: 5s;
                position: absolute; 
            }

            .banner-carousel a img {
                width: 100%;
                height: auto; 
                object-fit: unset; 
                display: block; 
            }

            @keyframes banner-fade {
                0% { opacity: 1; }  
                40% { opacity: 1; } 
                50% { opacity: 0; } 
                100% { opacity: 0; }
            }
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
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
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

<div class="banner-carousel">
        <a href="https://www.figma.com/design/3phe4xZitJBFNLuEK2TUNR/banner?node-id=0-1&t=ZVVgYviPSUoW3TJb-1">
            <img src="src/media/banner.png" alt="banner 1" loading="lazy">
        </a>
        <a href="https://www.figma.com/design/3phe4xZitJBFNLuEK2TUNR/banner?node-id=0-1&t=ZVVgYviPSUoW3TJb-1">
            <img src="src/media/banner1.jpg" alt="banner 2" loading="lazy">
        </a>
    </div>
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-display font-bold text-gray-900 border-b-2 border-primary inline-block pb-2">Tất cả sản phẩm</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (isset($ds_sanpham) && $ds_sanpham): ?>
                <?php foreach ($ds_sanpham as $item): ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <a href="chitiet.php?id=<?php echo $item['ID_sanpham']; ?>">
                    <img src="src/media/<?php
                        // SỬA LỖI GÁN ẢNH TRÙNG & ƯU TIÊN HÌNH ẢNH TỪ DB
                        $image_file = $item['hinhanh'] ?? '';

                        // Nếu không có ảnh từ DB (hoặc ảnh không tồn tại) thì chạy logic tìm kiếm từ khóa
                        if (empty($image_file) || !file_exists('src/media/' . $image_file)) {
                            $name = strtolower($item['tensanpham']);

                            // Lọc chi tiết hơn cho các sản phẩm có từ 'kem'
                            if (strpos($name, 'bông lan') !== false && strpos($name, 'phô mai') !== false) {
                                $image_file = 'banh-bong-lan-pho-mai-nhat-ban.webp';
                            } elseif (strpos($name, 'kem') !== false && strpos($name, 'dâu') !== false) {
                                // Cần đảm bảo file banhkemdau.jpg tồn tại
                                $image_file = 'banhkemdau.jpg';
                            } elseif (strpos($name, 'kem') !== false && strpos($name, 'hoa quả') !== false) {
                                // Cần đảm bảo file banhkemhoaqua.jpg tồn tại
                                $image_file = 'banhkemhoaqua.jpg';
                            } elseif (strpos($name, 'bông lan') !== false) {
                                $image_file = 'banhbonglan.jpg';
                            } elseif (strpos($name, 'kem') !== false) {
                                $image_file = 'banhkem.jpg'; // Ảnh mặc định cho các loại bánh kem khác
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
                    ?>" alt="<?php echo htmlspecialchars($item['tensanpham']); ?>" class="w-full h-48 object-cover object-center">
                    </a>
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1"><?php echo htmlspecialchars($item['tensanpham']); ?></p>
                        <p class="price"><?php echo number_format($item['dongia']); ?>₫</p>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($item['mota'] ?? ''); ?></p>
                        <a href="chitiet.php?id=<?php echo $item['ID_sanpham']; ?>" class="inline-block mt-2 px-4 py-2 bg-primary text-white rounded hover:bg-green-700 transition">Mua</a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-4 text-center text-gray-500">Không có sản phẩm nào.</div>
            <?php endif; ?>
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