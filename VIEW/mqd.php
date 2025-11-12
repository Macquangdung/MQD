<?php
session_start();
include('../CONTROLLER/controlmqd.php');

if (isset($_GET['toggle_menu'])) {
    $_SESSION['mobile_menu_visible'] = !isset($_SESSION['mobile_menu_visible']) || !$_SESSION['mobile_menu_visible'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAKERY SHOP</title>
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
        .banner-carousel { position: relative; overflow: hidden; }
        /* Tăng h-96 cho cha để hiển thị banner con */
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
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0; ?>
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
      <? else: ?>
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
            <div class="flex justify-center space-x-4 md:space-x-8 overflow-x-auto pb-4">
                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5l6 6v7.5a2 2 0 01-2 2h-8a2 2 0 01-2-2v-7.5l6-6zM15 11.25V5.25a1.5 1.5 0 00-3 0v6M10.5 17.25h3M12 21h0"></path></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Bánh mì</h3>
                </div>

                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22a2 2 0 002-2v-4a2 2 0 00-2-2H8a2 2 0 00-2 2v4a2 2 0 002 2h4zM12 14v-2.5a.5.5 0 00-.5-.5h-3a.5.5 0 00-.5.5V14M16 16.5c1.5 0 3-1.5 3-3V5.5c0-1.5-1.5-3-3-3s-3 1.5-3 3V12M12 19.5c1.5 0 3-1.5 3-3V5.5c0-1.5-1.5-3-3-3s-3 1.5-3 3V12"></path></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Bánh kem</h3>
                </div>

                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22a2 2 0 002-2v-4a2 2 0 00-2-2H8a2 2 0 00-2 2v4a2 2 0 002 2h4zM12 14v-2.5a.5.5 0 00-.5-.5h-3a.5.5 0 00-.5.5V14M16 16.5c1.5 0 3-1.5 3-3V5.5c0-1.5-1.5-3-3-3s-3 1.5-3 3V12M12 19.5c1.5 0 3-1.5 3-3V5.5c0-1.5-1.5-3-3-3s-3 1.5-3 3V12"></path></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Bánh ngọt</h3>
                </div>

                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 10h-2V7c0-1.65-1.35-3-3-3s-3 1.35-3 3v3H8c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2z"/></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Bánh khô</h3>
                </div>

                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.75l-9-4.5V6.75l9-4.5 9 4.5v10.5l-9 4.5zM12 2.25v19.5"/></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Bánh đông lạnh</h3>
                </div>
                
                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2m-4 0V3m0 2h3m-3 0h-3M9 14h6M9 18h6"/></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Đồ uống</h3>
                </div>
                
                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 00-5.774 18.513c.004.015.008.03.012.045M12 22a10 10 0 100-20 10 10 0 000 20zM12 18a6 6 0 100-12 6 6 0 000 12zM12 12a2 2 0 100-4 2 2 0 000 4z"/></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Dịch vụ</h3>
                </div>

                <div class="text-center group cursor-pointer flex-shrink-0">
                    <div class="w-20 h-20 md:w-28 md:h-28 mx-auto mb-2 border border-gray-300 rounded-full flex items-center justify-center group-hover:border-primary transition-colors">
                        <svg class="w-10 h-10 md:w-12 md:h-12 text-gray-600 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 17a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2h16a2 2 0 012 2v10zM12 11v6m-3-3h6"/></svg>
                    </div>
                    <h3 class="text-sm md:text-base font-medium text-gray-900">Phụ Kiện</h3>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-display font-bold text-gray-900 border-b-2 border-primary inline-block pb-2">Bánh kem</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/1.jpg" alt="Bánh kem Choco Tiger" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh kem Choco Tiger</p>
                        <p class="price">320.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/2.jpg" alt="Bánh kem Rainbow Magic" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh kem Rainbow Magic</p>
                        <p class="price">180.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/3.jpg" alt="Bánh kem Regal Planet" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh kem Regal Planet</p>
                        <p class="price">450.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/4.jpg" alt="Bánh kem Amber Spirit" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh kem Amber Spirit</p>
                        <p class="price">320.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/5.jpg" alt="Bánh Mousse Rossett" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Mousse Rossett</p>
                        <p class="price">345.000₫</p>
                    </div>
                </div>
                 <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/6.jpg" alt="Bánh Mousse Peach" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Mousse Peach</p>
                        <p class="price">345.000₫</p>
                    </div>
                </div>
                 <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/8.jpg" alt="Bánh Mousse Caramel" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Mousse Caramel</p>
                        <p class="price">345.000₫</p>
                    </div>
                </div>
                 <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/9.jpg" alt="Bánh Mousse Passion" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Mousse Passion</p>
                        <p class="price">345.000₫</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-display font-bold text-gray-900 border-b-2 border-primary inline-block pb-2">Bánh ngọt</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/10.jpg" alt="Tiramisu Cup" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Tiramisu</p>
                        <p class="price">22.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/11.jpg" alt="Bánh Tiramisu" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh Tiramisu</p>
                        <p class="price">36.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/12.jpg" alt="Bánh Opera" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh opera</p>
                        <p class="price">36.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/13.jpg" alt="Bánh madeleine" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh madeleine</p>
                        <p class="price">35.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/14.jpg" alt="Bánh Bông Lan Tròn" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh bông lan</p>
                        <p class="price">35.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/15.jpg" alt="Bánh madeleine Socola" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Madeleine Socola</p>
                        <p class="price">35.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/16.jpg" alt="Bánh madeleine Trứng" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Madeleine Trứng</p>
                        <p class="price">35.000₫</p>
                    </div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/19.jpg" alt="Bánh Cuộn" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh cuộn</p>
                        <p class="price">35.000₫</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-display font-bold text-gray-900 border-b-2 border-primary inline-block pb-2">Sản phẩm nổi bật</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (isset($featured_products) && !empty($featured_products)): ?>
                <?php foreach ($featured_products as $product): ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/<?php
                        // SỬA LỖI: Ưu tiên dùng hinhanh từ DB, sau đó là logic từ khóa chi tiết hơn
                        $image_file = $product['hinhanh'] ?? ''; 
                        
                        if (empty($image_file)) {
                            $name = strtolower($product['tensanpham']);
                            
                            if (strpos($name, 'bông lan') !== false && strpos($name, 'phô mai') !== false) {
                                $image_file = 'banh-bong-lan-pho-mai-nhat-ban.webp';
                            } elseif (strpos($name, 'kem') !== false && strpos($name, 'dâu') !== false) {
                                $image_file = 'banhkemdau.jpg'; // Cần tạo file này
                            } elseif (strpos($name, 'kem') !== false && strpos($name, 'hoa quả') !== false) {
                                $image_file = 'banhkemhoaqua.jpg'; // Cần tạo file này
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
                    ?>" alt="<?php echo htmlspecialchars($product['tensanpham']); ?>" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1"><?php echo htmlspecialchars($product['tensanpham']); ?></p>
                        <p class="price"><?php echo number_format($product['dongia']); ?>₫</p>
                        <p class="text-sm text-gray-600"><?php echo htmlspecialchars($product['mota'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale text-center">
                    <img src="src/media/banhbonglan.jpg" alt="Bánh mẫu" class="w-full h-48 object-cover object-center">
                    <div class="p-4">
                        <p class="text-gray-900 font-medium mb-1">Bánh mẫu</p>
                        <p class="price">100.000₫</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="mt-16 text-center">
                <h2 class="text-4xl font-bold text-gray-900 mb-6 border-b-2 border-pink-500 inline-block pb-2">
                    Video Giới Thiệu
                </h2>
                <div class="max-w-3xl mx-auto rounded-xl overflow-hidden shadow-2xl">
                    <div class="relative pt-[56.25%] bg-black">
                        <iframe 
                            class="absolute top-0 left-0 w-full h-full"
                            src="https://www.youtube.com/embed/IWrYtRMg73M?si=DaHPhIkjYIGY6rbs"
                            title="Giới thiệu shop bánh" 
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                        <div class="absolute bottom-3 left-3 text-white text-sm font-semibold bg-black/50 px-2 py-1 rounded">
                            Xem trên YouTube
                        </div>
                    </div>
                    <p class="mt-4 text-lg text-gray-700 text-center p-2 bg-gray-50 border-t">
                        Ngọt ngào trao yêu thương bắt đầu từ những chiếc bánh
                    </p>
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