<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../CONTROLLER/controlmqd1.php');
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
    <link rel="stylesheet" type="text/css" href="fontawesome-free-6.7.2-web/css/all.css">
  </head> 
  <body>
    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid d-flex align-items-center justify-content-between">
        <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="../media/loo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2">
          Bakery Shop
        </a>
        <form class="d-flex" role="search" style="margin-left:auto;">
          <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" style="width: 200px;">
          <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
        </form>
        <a href="../VIEW/giohang.php" class="btn btn-outline-primary position-relative ms-3">
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
        <li><a href="dangnhap.php">Đăng nhập</a></li>
        <li><a href="danhgia.php">Đánh giá</a></li>
      </ul>
    </div>
    
     <a href="https://www.figma.com/design/8pGyYo1xfjbI5xP0qZsTKk/Untitled?node-id=0-1&m=dev&t=zA19JlVWEPBlb0ka-1">
        <img src="../media/banner.png" width="100%" height="400px" alt="banner"></a>
    

    <div class="noidung">
      <div class="luoi chieurongluoi">
          <div class="hang">
            <div class="cot cot-12">
              <h4>Sản phẩm</h4>
            </div>
          </div>
              <div class="hang">
                <?php if ($ds_sanpham): ?>
                  <?php foreach ($ds_sanpham as $index => $item): ?>
                    <?php 
                      $id = $item['ID_sanpham'] ?? ($index + 1);
                      $dongia = $item['dongia'] ?? 150000;
                    ?>
                    <div class="cot cot-3 maytinhbang-cot-6 dienthoai-cot-12">
                      <div class="card shadow-sm tiktok-card" style="background-color: #f8f9fa; position: relative; height: 100%; border-radius: 12px; overflow: hidden;">
                        <img src="../media/<?= $item['hinhanh'] ?? '1.jpg' ?>" class="card-img-top kichthuocanh1" alt="<?= htmlspecialchars($item['tensanpham']) ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body p-3 text-center" style="padding-bottom: 0;">
                          <h6 class="card-title mb-2" style="color: black; font-size: 18px; height: 50px; overflow: hidden;"><?= htmlspecialchars($item['tensanpham']) ?></h6>
                          <p class="card-text"><?= htmlspecialchars($item['mota']) ?></p>
                          <a href="muahang.php?mua=<?= $id ?>" class="btn btn-primary">Mua</a>
                          <form method="post" action="../CONTROLLER/controlgiohang.php?action=add" class="w-100">
                            <input type="hidden" name="id_sanpham" value="<?= $id ?>">
                            <input type="hidden" name="dongia" value="<?= $dongia ?>">
                            <input type="hidden" name="soluong" value="1">
                          </form>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="cot cot-12">
                    <p>Không có sản phẩm nào.</p>
                  </div>
                <?php endif; ?>
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
