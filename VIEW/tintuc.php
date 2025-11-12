<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tin tức - BAKERY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dinhdang.css">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
        .price { color: #e53e3e; font-weight: 600; }
        .banner-carousel { position: relative; overflow: hidden; }
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
          <a href="dangnhap.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đăng nhập</a>
          <a href="danhgia.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đánh giá</a>
        </nav>
        <div class="flex items-center space-x-4">
          <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
          </button>
          <a href="giohang.php" class="p-2 hover:bg-gray-100 rounded-full transition-colors relative inline-block">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center"></span>
          </a>
        </div>
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
<section class="py-12 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Tin tức mới nhất</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Các card tin tức ở đây (giữ nguyên như tintuc.html) -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/1.jpg" alt="Vitamin Mira" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Trải nghiệm</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Nạp năng lượng tích cực tại Fresh Garden với VitaminMira</h3>
                    <p class="text-sm text-gray-600">Trong nhịp sống hiện đại, việc duy trì sức khỏe và tinh thần tràn đầy...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/banhtrungthu.jpg" alt="Bánh Trung Thu 1" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Sản phẩm mới</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Mang bánh về cho mẹ - 5 gợi ý bánh trung thu đầy ý nghĩa cho gia đình</h3>
                    <p class="text-sm text-gray-600">Mùa Tết Trung Thu về, ánh trăng trên viên mãn lại nhắc chúng ta...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/banhtrungthu.jpg" alt="Bánh Trung Thu 2" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Khuyến mãi</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ưu đãi đặc biệt -10% cho khách hàng thân thiết</h3>
                    <p class="text-sm text-gray-600">Trung thu - mùa yêu thương đoàn viên Mùa Tết Trung Thu về, ánh trăng...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/banhkem.jpg" alt="Bánh mới" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Sản phẩm mới</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ra mắt bánh kem mới với hương vị dâu tây</h3>
                    <p class="text-sm text-gray-600">Chúng tôi tự hào giới thiệu bánh kem dâu tây tươi ngon...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/2.jpg" alt="Khuyến mãi" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Khuyến mãi</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Giảm giá 20% cho đơn hàng trên 500k</h3>
                    <p class="text-sm text-gray-600">Chương trình khuyến mãi đặc biệt dành cho khách hàng...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/3.jpg" alt="Sự kiện" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Sự kiện</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ngày hội bánh ngọt gia đình</h3>
                    <p class="text-sm text-gray-600">Tham gia sự kiện vui vẻ với các hoạt động thú vị...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/4.jpg" alt="Công thức" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Công thức</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cách làm bánh mì tại nhà đơn giản</h3>
                    <p class="text-sm text-gray-600">Hướng dẫn chi tiết để bạn tự làm bánh mì ngon...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/banhkem.jpg" alt="Đánh giá" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Đánh giá</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Top 5 bánh kem được yêu thích nhất</h3>
                    <p class="text-sm text-gray-600">Khảo sát từ khách hàng về các loại bánh kem...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/5.jpg" alt="Mẹo vặt" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Mẹo vặt</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cách bảo quản bánh để giữ độ tươi ngon</h3>
                    <p class="text-sm text-gray-600">Các bí quyết để bánh luôn tươi ngon lâu dài...</p>
                </div>
            </div>
            <div class="bg-white rounded-lg overflow-hidden shadow-lg hover-scale">
                <img src="src/media/6.jpg" alt="Câu chuyện" class="w-full h-48 object-cover">
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-2">Câu chuyện</p>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Hành trình phát triển của Bakery Shop</h3>
                    <p class="text-sm text-gray-600">Từ một cửa hàng nhỏ đến thương hiệu lớn...</p>
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
                <div class="flex gap-4">
                    <!-- Social icons here -->
                </div>
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
