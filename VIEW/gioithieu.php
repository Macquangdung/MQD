<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAKERY SHOP - Giới thiệu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
        .about-hero { background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%); }
        .section-title { position: relative; display: inline-block; }
        .section-title::after { content: ''; position: absolute; bottom: -8px; left: 50%; transform: translateX(-50%); width: 80px; height: 4px; background-color: #8BC34A; border-radius: 2px; }
        .value-card { transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -2px rgba(0,0,0,0.1);}
        .value-card:hover { box-shadow: 0 10px 15px -3px rgba(139,195,74,0.3), 0 4px 6px -4px rgba(139,195,74,0.2); transform: translateY(-5px);}
    </style>
</head>
<body class="bg-stone-50 font-sans text-gray-800">

    <!-- Header -->
    <header class="sticky top-0 z-50 w-full border-b bg-white shadow-sm">
      <div class="container mx-auto flex h-16 items-center justify-between px-4">
        <a href="mqd.php" class="flex items-center space-x-2">
          <span class="text-2xl font-bold text-[#8BC34A]">BAKERY SHOP</span>
        </a>
        <nav class="hidden md:flex items-center space-x-8">
          <a href="gioithieu.php" class="text-sm font-medium text-[#8BC34A] transition-colors">Giới thiệu</a>
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
        </div>
      </div>
    </header>

    <main>
        <!-- Hero Section -->
        <section class="about-hero pt-20 pb-16 md:py-24 text-center">
            <div class="container mx-auto px-4">
                <h1 class="text-6xl font-extrabold text-[#8BC34A] mb-4">Câu Chuyện Chúng Tôi</h1>
                <p class="text-xl text-gray-700 max-w-3xl mx-auto">
                    Bakery Shop – Nơi tình yêu và sự tỉ mỉ được gửi gắm trong từng chiếc bánh.
                </p>
                <div class="mt-8">
                    <a href="#cau-chuyen" class="inline-block px-6 py-2 bg-primary text-white font-semibold rounded-lg shadow-lg hover:bg-green-600 transition duration-300">
                        Tìm hiểu thêm
                    </a>
                </div>
            </div>
        </section>

        <!-- Story Section -->
        <section id="cau-chuyen" class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="lg:grid lg:grid-cols-3 lg:gap-12">
                    <div class="lg:col-span-1 mb-10 lg:mb-0">
                        <div class="rounded-xl overflow-hidden shadow-2xl sticky top-24">
                            <img src="https://placehold.co/600x800/f8bbd0/4a4a4a?text=Fresh+Baked+Goods" alt="Hình ảnh các loại bánh tươi" class="w-full h-auto object-cover">
                        </div>
                    </div>
                    <div class="lg:col-span-2 space-y-12">
                        <div class="p-6 md:p-10 bg-gray-50 rounded-xl shadow-lg">
                            <h2 class="text-3xl font-bold text-gray-900 section-title mb-6">
                                1. Khởi nguồn: "Bánh tươi mỗi ngày"
                            </h2>
                            <p class="text-gray-700 leading-relaxed text-lg">
                                Thành lập vào tháng <b>12/2010</b> từ tình yêu với những chiếc bánh, Bakery Shop khởi nguồn cùng slogan <b>"Bánh tươi mỗi ngày"</b> và sứ mệnh xuyên suốt về mang tới những sản phẩm thơm ngon nhất, đảm bảo chất lượng và vệ sinh an toàn thực phẩm.
                            </p>
                            <p class="text-gray-700 leading-relaxed text-lg mt-4">
                                Hàng năm, sản phẩm chủ lực của Fresh Garden là <b>bánh kem</b> và <b>bánh mì tươi</b>. Trong mỗi dịp lễ hay sinh nhật, bánh kem của Fresh Garden luôn là một trong những lựa chọn hàng đầu, bởi độ ngọt vừa phải, mẫu bánh đẹp, và giá thành hợp lý. Đồng hành mỗi ngày cùng khách hàng là các sản phẩm bánh mì tươi dinh dưỡng, được nướng mới liên tục trong ngày.
                            </p>
                        </div>
                        <div class="p-6 md:p-10 bg-white rounded-xl shadow-lg">
                            <h2 class="text-3xl font-bold text-gray-900 section-title mb-6">
                                2. Dấu ấn hành trình & Mạng lưới
                            </h2>
                            <p class="text-gray-700 leading-relaxed text-lg">
                                Trải qua một thập kỷ phát triển, Bakery Shop tự hào trở thành thương hiệu bánh tươi uy tín bậc nhất tại Việt Nam.
                            </p>
                            <ul class="mt-4 space-y-3 text-gray-700 list-disc list-inside">
                                <li><b>Quy mô:</b> Hơn <b>100 cửa hàng và đại lý</b> phân phối phủ khắp các tỉnh phía Bắc.</li>
                                <li><b>Nhân sự:</b> Gần <b>1000 nhân sự</b> làm việc chăm chỉ, không ngừng sáng tạo.</li>
                                <li><b>Sản xuất:</b> Dây chuyền sản xuất tiên tiến, hiện đại, đảm bảo chất lượng đồng nhất.</li>
                            </ul>
                            <p class="text-gray-700 leading-relaxed text-lg mt-4 font-medium">
                                Bakery Shop chính là một "thế giới thu nhỏ" của bánh trái, chiều lòng bất kì vị khách nào ghé ngang với sự đa dạng danh bạ Âu - Á, từ bánh ngọt, bánh mặn đến các loại bánh kem phức tạp.
                            </p>
                        </div>
                        <div class="p-6 md:p-10 bg-gray-50 rounded-xl shadow-lg">
                            <h2 class="text-3xl font-bold text-gray-900 section-title mb-6 text-center w-full">
                                Video Giới Thiệu
                            </h2>
                            <div class="max-w-xl mx-auto rounded-xl overflow-hidden shadow-2xl">
                                <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000;">
                                    <iframe 
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                        src="https://www.youtube.com/embed/IWrYtRMg73M?si=DaHPhIkjYIGY6rbs"
                                        title="Giới thiệu shop bánh" 
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <p class="mt-0 text-md text-gray-700 text-center p-3 bg-white border-t">
                                    Ngọt ngào trao yêu thương bắt đầu từ những chiếc bánh
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="gia-tri" class="bg-pink-50 py-16 md:py-24">
            <div class="container mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold text-gray-900 section-title mb-16">
                    Giá Trị Cốt Lõi Và Cam Kết
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="value-card bg-white p-6 rounded-xl shadow-lg">
                        <svg class="w-12 h-12 text-[#8BC34A] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944c-3.15.542-5.9 2.518-7.59 5.25C2.69 11.41 2 14.156 2 17c0 3.313 1.343 6 3 6h14c1.657 0 3-2.687 3-6 0-2.844-.69-5.59-2.41-7.794z"/></svg>
                        <h3 class="text-xl font-semibold mb-3 text-[#8BC34A]">Nguyên liệu cao cấp</h3>
                        <p class="text-gray-700 text-sm">
                            Từng sản phẩm Bakery Shop được đầu tư rất kỹ ngay từ khâu chọn nguyên liệu. Chúng tôi sử dụng những thành phần tươi mới nhất từ các nhãn hiệu uy tín quốc tế như <b>Anchor, Vivo, Meiji, Komplet</b>.
                        </p>
                    </div>
                    <div class="value-card bg-white p-6 rounded-xl shadow-lg">
                        <svg class="w-12 h-12 text-[#8BC34A] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3 1.343 3 3v3a3 3 0 01-6 0v-3c0-1.657 1.343-3 3-3zM7 16h10m1-3l2 2m-2-4l2-2m-10 4l-2 2m2-4l-2-2"/></svg>
                        <h3 class="text-xl font-semibold mb-3 text-[#8BC34A]">Đa dạng hương vị</h3>
                        <p class="text-gray-700 text-sm">
                            Đến với Bakery Shop là đến với hàng trăm hương vị bánh đa chủng loại <b>Âu - Á</b>: bánh ngọt, bánh mì tươi, các dòng bánh kem sinh nhật, bánh sự kiện và bánh khô theo mùa.
                        </p>
                    </div>
                    <div class="value-card bg-white p-6 rounded-xl shadow-lg">
                        <svg class="w-12 h-12 text-[#8BC34A] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318z"/></svg>
                        <h3 class="text-xl font-semibold mb-3 text-[#8BC34A]">Sứ mệnh Yêu thương</h3>
                        <p class="text-gray-700 text-sm">
                            Sứ mệnh của chúng tôi: Mang đến những sản phẩm đạt chất lượng cao nhất như một <b>lời tri ân</b> đối với sự yêu mến và tin dùng của quý khách hàng, xây dựng thói quen thưởng thức bánh ngon mỗi ngày.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="src/media/loo.jpg" alt="Logo" class="w-10 h-10">
                        <span class="text-2xl font-display font-bold">Bakery Shop</span>
                    </div>
                    <p class="text-gray-400 mb-4">Nơi bạn có thể tìm thấy những chiếc bánh ngọt ngào, chất lượng và sáng tạo nhất.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên Kết Nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="mqd.php" class="text-gray-400 hover:text-white transition-colors">Trang chủ</a></li>
                        <li><a href="mqd1.php" class="text-gray-400 hover:text-white transition-colors">Sản phẩm</a></li>
                        <li><a href="gioithieu.php" class="text-gray-400 hover:text-white transition-colors">Về chúng tôi</a></li>
                        <li><a href="dangnhap.php" class="text-gray-400 hover:text-white transition-colors">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Danh Mục</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh mì</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh kem</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh ngọt</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh khô</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên Hệ</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 123 Đường ABC, Quận XYZ</li>
                        <li>📞 1900 1234</li>
                        <li>✉️ info@freshgarden.com</li>
                        <li>🕒 8:00 - 22:00</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-6 text-center text-gray-400">
                <p>&copy; 2024 FRESH GARDEN. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer>
</body>
</html>
