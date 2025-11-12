<?php
session_start();
include('../CONTROLLER/controlmqd.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Web bán bánh</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="luoi.css">
    <link rel="stylesheet" type="text/css" href="dinhdang.css">
    <link rel="stylesheet" type="text/css" href="dinhdangmenu.css">
  </head>
  <body>
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="../media/loo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2">
          Bakery Shop
        </a>
        <form class="d-flex" role="search" method="GET" style="margin-left:auto;">
          <input class="form-control me-2" type="search" name="search" placeholder="Tìm kiếm" aria-label="Search" style="width: 200px;" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
          <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
        </form>
        <a href="giohang.php" class="btn btn-outline-primary position-relative ms-3">
          <i class="fa fa-shopping-cart"></i>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
            ?>
          </span>
        </a>
        <?php if (!isset($_SESSION['user'])): ?>
        <?php endif; ?>
      </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="text-center bg-light py-2">
            <h5>Xin chào <?= htmlspecialchars($_SESSION['user']) ?>! <a href="dangxuat.php" class="btn btn-outline-secondary btn-sm">Đăng xuất</a></h5>
        </div>
    <?php endif; ?>

    <div class="menu">
      <ul>
        <li><a href="mqd.php">Trang chủ</a></li>
        <li><a href="mqd1.php">Sản phẩm</a></li>
        <li>
          <a href="#">Các loại bánh</a>
          <ul>
            <li><a href="mqd3.php#banhkem">Bánh kem</a></li>
            <li><a href="mqd3.php#banhbonglan">Bánh bông lan</a></li>
            <li><a href="mqd1.php">Hiển thị tất cả</a></li>
          </ul>
        </li>
        <li><a href="https://tljus.com/">Shop bánh</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="lichsumuahang.php">Đơn hàng</a></li>
            <li><a href="vouchers.php">Voucher</a></li>
        <?php endif; ?>
        <?php if (!isset($_SESSION['user'])): ?>
            <li><a href="dangnhap.php">Đăng nhập</a></li>
        <?php endif; ?>
        <li><a href="danhgia.php">Đánh giá</a></li>
      </ul>
    </div>

      <a href="https://www.figma.com/design/8pGyYo1xfjbI5xP0qZsTKk/Untitled?node-id=0-1&m=dev&t=zA19JlVWEPBlb0ka-1">
        <img src="../media/banner (2).png" width="100%" height="400px" alt="banner"></a>

<div class="noidung">
  <div class="luoi chieurongluoi py-5">

    <div class="hang">
      <div class="cot cot-12 text-center mb-5">
        <h1 class="fw-bold">Chào mừng đến với Shop Bánh MQD!</h1>
        <p class="lead">Nơi bạn có thể tìm thấy những chiếc bánh ngọt ngào, chất lượng và sáng tạo nhất.</p>
      </div>
    </div>
    <div class="hang text-center mb-5">
      <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
        <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
          <img src="../media/3.jpg" class="card-img-top kichthuocanh1" alt="Bánh kem dâu tây">
          <div class="card-body text-center">
            <h5 class="card-title" style="color: black;">Bánh kem dâu tây</h5>
            <p class="card-text small">Bánh kem với dâu tây tươi ngon, vị ngọt thanh.</p>
          </div>
        </div>
      </div>
      <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
        <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
          <img src="../media/4.jpg" class="card-img-top kichthuocanh1" alt="Bánh kem tam giác">
          <div class="card-body text-center">
            <h5 class="card-title" style="color: black;">Bánh kem tam giác</h5>
            <p class="card-text small">Hình tam giác độc đáo, kem béo ngậy hấp dẫn.</p>
          </div>
        </div>
      </div>
      <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
        <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
          <img src="../media/5.jpg" class="card-img-top kichthuocanh1" alt="Bánh kem lớn">
          <div class="card-body text-center">
            <h5 class="card-title" style="color: black;">Bánh kem lớn</h5>
            <p class="card-text small">Kích thước lớn, phù hợp cho tiệc và sự kiện.</p>
          </div>
        </div>
      </div>
      <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
        <div class="card h-100 shadow-sm" style="background-color: #f8f9fa;">
          <img src="../media/6.jpg" class="card-img-top kichthuocanh1" alt="Bánh nướng dẻo">
          <div class="card-body text-center">
            <h5 class="card-title" style="color: black;">Bánh nướng dẻo</h5>
            <p class="card-text small">Giòn ngoài dẻo trong, vị nướng thơm lừng.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="hang">
      <div class="cot cot-12 text-center mb-4">
        <h2 class="fw-bold">Sản phẩm nổi bật</h2>
      </div>
    </div>
    <div class="hang text-center">
      <?php if (isset($featured_products) && !empty($featured_products)): ?>
        <?php foreach ($featured_products as $index => $product): ?>
          <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
            <div class="card shadow-sm tiktok-card" style="background-color: #f8f9fa; position: relative; height: 100%; border-radius: 12px; overflow: hidden;">
              <img src="../media/<?php echo $product['hinhanh'] ?? '1.jpg'; ?>" class="card-img-top kichthuocanh1" alt="<?php echo $product['tensanpham']; ?>" style="height: 200px; object-fit: cover;">
              <div class="card-body p-3 text-center" style="padding-bottom: 0;">
                <h6 class="card-title mb-2" style="color: black; font-size: 18px; height: 50px; overflow: hidden;"><?php echo htmlspecialchars($product['tensanpham']); ?></h6>
                <p class="card-text small"><?php echo htmlspecialchars($product['mota'] ?? 'Sản phẩm chất lượng cao, ngon miệng.'); ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <?php 
          $fallback_products = [
            ['id' => 1, 'img' => '1.jpg', 'title' => 'Bánh mì nướng', 'description' => 'Bánh mì nướng giòn tan, thơm ngon.'],
            ['id' => 2, 'img' => '2.jpg', 'title' => 'Bánh kem mứt', 'description' => 'Kem mứt trái cây đa vị, ngọt ngào.'],
            ['id' => 4, 'img' => '4.jpg', 'title' => 'Bánh sữa kem tươi', 'description' => 'Sữa tươi kết hợp kem mịn màng.']
          ];
        ?>
        <?php foreach ($fallback_products as $fp): ?>
          <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
            <div class="card shadow-sm tiktok-card" style="background-color: #f8f9fa; position: relative; height: 100%; border-radius: 12px; overflow: hidden;">
              <img src="../media/<?php echo $fp['img']; ?>" class="card-img-top kichthuocanh1" alt="<?php echo $fp['title']; ?>" style="height: 200px; object-fit: cover;">
              <div class="card-body p-3 text-center" style="padding-bottom: 0;">
                <h6 class="card-title mb-2" style="color: black; font-size: 18px; height: 50px; overflow: hidden;"><?php echo htmlspecialchars($fp['title']); ?></h6>
                <p class="card-text small"><?php echo $fp['description'] ?? 'Sản phẩm chất lượng cao, ngon miệng.'; ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <?php if (isset($is_search) && $is_search): ?>
      <?php $search_term = isset($_GET['search']) ? trim($_GET['search']) : ''; ?>
      <?php if (isset($search_results) && !empty($search_results)): ?>
      <div class="hang">
        <div class="cot cot-12 text-center mb-4">
          <h2 class="fw-bold">Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($search_term); ?>"</h2>
        </div>
      </div>
      <div class="hang text-center">
        <?php foreach ($search_results as $product): ?>
          <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
            <div class="card shadow-sm" style="background-color: #f8f9fa;">
              <img src="../media/<?php echo $product['hinhanh'] ?? '1.jpg'; ?>" class="card-img-top kichthuocanh1" alt="<?php echo $product['tensanpham']; ?>">
              <div class="card-body text-center">
                <h5 class="card-title" style="color: black;"><?php echo $product['tensanpham']; ?></h5>
                <p class="card-text"><?php echo $product['mota'] ?? 'Mô tả sản phẩm'; ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php else: ?>
      <div class="hang">
        <div class="cot cot-12 text-center mb-4">
          <h2 class="fw-bold">Không tìm thấy sản phẩm nào cho: "<?php echo htmlspecialchars($search_term); ?>"</h2>
        </div>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    <div class="hang my-5">
      <div class="cot cot-12">
        <h2 class="text-center mb-4">Giới thiệu Shop Bánh</h2>
        <div class="ratio ratio-16x9">
          <iframe src="https://www.youtube.com/embed/IWrYtRMg73M?si=DaHPhIkjYIGY6rbs"
            title="Giới thiệu shop bánh" allowfullscreen></iframe>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="chantrang">
  <footer class="text-center text-lg-start bg-body-tertiary text-muted">
      <section class="">
          <div class="container text-center text-md-start mt-5">
              <div class="row mt-3">
                  <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                      <img src="../media/loo.jpg" alt="Bakery Logo" width="100">
                      <div class="d-flex mt-3">
                          <a href="#" class="me-2"><img src="../media/fb.png"  alt="Facebook"  height="50" width="50"></a>
                          <a href="#" class="me-2"><img src="../media/ytb.png"  alt="YouTube"  height="50" width="50"></a>
                          <a href="#"><img src="../media/gmail.png"  alt="Gmail"  height="50" width="30"></a>
                      </div>
                  </div>
                  <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                      <h6 class="text-uppercase fw-bold mb-4">
                          Về chúng tôi
                      </h6>
                      <p>
                          <a href="#!" class="text-reset">Giới thiệu</a>
                      </p>
                      <p>
                          <a href="#!" class="text-reset">Sứ mệnh của nhân viên</a>
                      </p>
                      <p>
                          <a href="#!" class="text-reset">Giá trị sản phẩm</a>
                      </p>
                      <p>
                          <a href="#!" class="text-reset">An toàn thực phẩm</a>
                      </p>
                  </div>
                  <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                      <h6 class="text-uppercase fw-bold mb-4">
                          Vị trí cửa hàng
                      </h6>
                      <p>
                          <a href="#!" class="text-reset">Miền Bắc</a>
                      </p>
                      <p>
                          <a href="#!" class="text-reset">Miền Trung</a>
                      </p>
                      <p>
                          <a href="#!" class="text-reset">Miền Nam</a>
                      </p>
                  </div>
                  <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                      <h6 class="text-uppercase fw-bold mb-4">Tải ứng dụng</h6>
                      <a href="#"><img src="../media/ggpl.png" alt="Google Play" height="50"></a>
                  </div>
                  </div>
</div>
      </section>
      <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        Phiên bản 1.7.7
        <div class="mt-2">
            <a href="#!" class="text-reset me-3">Sự nghiệp</a>
            <a href="#!" class="text-reset me-3">Bakery Shop</a>
            <a href="#!" class="text-reset me-3">Quyền lợi của khách hàng</a>
            <span class="text-danger">Liên hệ chúng tôi 1900 1234</span>
        </div>
    </div>
      </footer>
  </div>
</body>
</html>
