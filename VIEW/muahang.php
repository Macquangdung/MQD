<?php
session_start();
include('../MODEL/modelmh.php');
include('../MODEL/modelgiohang.php');
include('../MODEL/modelmqd1.php');
include('../MODEL/modeldangnhap.php');
include_once(__DIR__ . '/../MODEL/modeladmin.php');
$data = new data_muahang();
$data_cart = new data_mqd1();
$userModel = new data_user_login();
$admin_model = new data_admin();

$cartItems = GioHang::getItems();

$message = '';
$show_message_id = null;

    if (isset($_POST['addtocart'])) {
        $id_sanpham = intval($_POST['id_sanpham']);
        $quantity = intval($_POST['txtmua']);
        if ($quantity > 0) {
            $product = $data_cart->select_sanpham_id($id_sanpham);
            if (!empty($product)) {
                $stock = $product[0]['soluong'];
                if ($quantity <= $stock) {
                    GioHang::addItem($id_sanpham, $quantity);
                    $message = "Thêm vào giỏ hàng thành công";
                } else {
                    $message = "Số lượng yêu cầu vượt quá tồn kho (còn $stock)";
                }
            } else {
                $message = "Sản phẩm không tồn tại";
            }
        } else {
            $message = "Số lượng phải lớn hơn 0";
        }
        $show_message_id = $id_sanpham;
    }

    if (isset($_POST['datmua'])) {
        if (!isset($_SESSION['user'])) {
            $message = 'Vui lòng đăng nhập để đặt mua.';
            $show_message_id = intval($_POST['id_sanpham']);
        } else {
            $user = $userModel->get_user_by_username($_SESSION['user']);
            if (!$user) {
                $message = 'Lỗi xác thực người dùng.';
                $show_message_id = intval($_POST['id_sanpham']);
            } else {
                $id_user = $user['ID_user'];
                $id_sanpham = intval($_POST['id_sanpham']);
                $solanmua = 1;
                $soluong = intval($_POST['txtmua']);
                $dongia = floatval($_POST['dongia']);
                $tongtien = $dongia * $soluong;
                $trangthai = 'chờ xác nhận';
                $voucher_id = isset($_POST['voucher_id']) ? intval($_POST['voucher_id']) : null;

                if ($soluong <= 0) {
                    $message = 'Số lượng mua phải lớn hơn 0';
                } else {
                    $insert = $data->insert_muahang($id_user, $id_sanpham, $solanmua, $soluong, $dongia, $tongtien, $trangthai, null, $voucher_id);
                    if (is_array($insert) && $insert['success']) {
                        $discount_msg = $insert['discount'] > 0 ? " (Giảm giá: " . number_format($insert['discount'], 0, ',', '.') . " VND)" : "";
                        header('Location: lichsumuahang.php?message=Đã đặt hàng thành công và đang chờ xác nhận!' . $discount_msg);
                        exit();
                    } elseif (is_array($insert) && !$insert['success']) {
                        $message = $insert['message'];
                    } else {
                        $message = 'Thất bại hoặc số lượng mua vượt quá tồn kho';
                    }
                }
                $show_message_id = $id_sanpham;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mua hàng</title>
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
          <form class="d-flex" role="search" style="margin-left:auto;">
            <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search" style="width: 200px;">
            <button class="btn btn-outline-success" type="submit">Tìm kiếm</button>
          </form>
          <a href="giohang.php" class="btn btn-outline-primary position-relative ms-3">
            <i class="fa fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
              <?php
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

    <?php if (isset($_GET['message']) && !empty($_GET['message'])): ?>
        <div class="alert alert-info" role="alert">
            <?= htmlspecialchars($_GET['message']) ?>
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

    <div class="noidung">
        <div class="luoi chieurongluoi">
            <?php if (isset($_GET['mua']) && !empty($_GET['mua'])): ?>
                <?php
                $id_sanpham = intval($_GET['mua']);
                $select = $data->select_sanpham_id($id_sanpham);
                if (!empty($select)):
                    $se_sp = $select[0];
                ?>
                <div class="hang">
                    <div class="cot cot-12">
                        <h2 class="text-center mb-4">Chi tiết sản phẩm</h2>
                    </div>
                </div>
                <div class="hang">
                    <div class="cot cot-6 maytinhbang-cot-6 dienthoai-cot-12">
                        <img src="../media/<?= $se_sp['hinhanh'] ?? '1.jpg' ?>" class="kichthuocanh1" alt="<?= htmlspecialchars($se_sp['tensanpham']) ?>">
                    </div>
                    <div class="cot cot-6 maytinhbang-cot-6 dienthoai-cot-12">
                        <h3><?= htmlspecialchars($se_sp['tensanpham']) ?></h3>
                        <p><strong>Mô tả:</strong> <?= htmlspecialchars($se_sp['mota']) ?></p>
                        <p><strong>Số lượng còn:</strong> <?= $se_sp['soluong'] ?></p>
                        <p><strong>Đơn giá:</strong> <span id="original-price"><?= number_format($se_sp['dongia'], 0, ',', '.') ?></span> VND</p>
                        <p id="discounted-price-display" style="display: none;"><strong>Giá sau giảm:</strong> <span id="discounted-dongia">0</span> VND</p>
                        <form method="post" action="muahang.php?mua=<?= $se_sp['ID_sanpham'] ?>" class="mt-3">
                            <input type="hidden" name="id_sanpham" value="<?= $se_sp['ID_sanpham'] ?>">
                            <input type="hidden" name="dongia" value="<?= $se_sp['dongia'] ?>">
                            <div class="mb-3">
                                <label for="txtmua" class="form-label">Số lượng mua:</label>
                                <input type="number" id="txtmua" name="txtmua" class="form-control" min="1" max="<?= $se_sp['soluong'] ?>" value="1" required oninput="tinhTongTien(this, <?= $se_sp['dongia'] ?>)">
                            </div>
                            <div class="mb-3">
                                <label for="tongtien" class="form-label">Tổng tiền:</label>
                                <input type="text" id="tongtien" name="tongtien" class="form-control" value="<?= number_format($se_sp['dongia'], 0, ',', '.') ?>" placeholder="Tổng tiền" readonly>
                            </div>
                            <?php
                            // Luôn hiển thị ô chọn voucher và preview cho user đã đăng nhập
                            if (isset($_SESSION['user'])):
                                $user = $userModel->get_user_by_username($_SESSION['user']);
                                $id_user = $user['ID_user'];
                                $claimed_vouchers = $admin_model->get_user_claimed_vouchers($id_user);
                                $product_id = $se_sp['ID_sanpham'];
                            ?>
                                <div class="mb-3">
                                    <label for="voucher_select" class="form-label">Chọn Voucher (tùy chọn):</label>
                                    <select id="voucher_select" name="voucher_id" class="form-control" onchange="applyVoucherDiscount()">
                                        <option value="">Không sử dụng voucher</option>
                                        <?php foreach ($claimed_vouchers as $voucher): ?>
                                            <?php
                                            $option_text = $voucher['code'] . ' - ';
                                            if ($voucher['type'] == 'percent') {
                                                $option_text .= $voucher['value'] . '% off';
                                            } else {
                                                $option_text .= number_format($voucher['value'], 0, ',', '.') . ' VND off';
                                            }
                                            $current_date = date('Y-m-d');
                                            $expiry_date = isset($voucher['expiry_date']) ? $voucher['expiry_date'] : '';
                                            $is_expired = false;
                                            if ($expiry_date && $expiry_date !== '0000-00-00' && $expiry_date !== '30/11/-0001') {
                                                $expiry_date_fmt = date_create($expiry_date) ? date_format(date_create($expiry_date), 'Y-m-d') : $expiry_date;
                                                if ($current_date > $expiry_date_fmt) $is_expired = true;
                                            }
                                            if ($is_expired) continue;
                                            if ($voucher['max_uses'] !== null && $voucher['max_uses'] > 0 && ($voucher['uses_count'] ?? 0) >= $voucher['max_uses']) continue;

                                            $is_applicable = true;
                                            if ($voucher['applicable_to'] == 'product') {
                                                $product_ids = json_decode($voucher['product_ids'], true) ?: [];
                                                $is_applicable = in_array($product_id, $product_ids);
                                                if (!$is_applicable) continue;
                                            }
                                            ?>
                                            <option value="<?= $voucher['id'] ?>"
                                                    data-type="<?= htmlspecialchars($voucher['type']) ?>"
                                                    data-value="<?= $voucher['value'] ?>"
                                                    data-applicable-to="<?= htmlspecialchars($voucher['applicable_to']) ?>"
                                                    data-min-order="<?= $voucher['min_order'] ?>">
                                                <?= htmlspecialchars($option_text) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted">Chỉ hiển thị voucher đã claim và áp dụng được. Hệ thống sẽ kiểm tra tính hợp lệ khi đặt hàng.</small>
                                </div>
                                <div id="discount-preview" class="mb-3" style="display: none;">
                                    <p><strong>Giá sau giảm:</strong> <span id="discounted-price">0</span> VND</p>
                                    <p><strong>Tiết kiệm:</strong> <span id="savings">0</span> VND</p>
                                </div>
                            <?php endif; ?>
                        <div class="d-flex gap-2">
                            <?php if (isset($_SESSION['user'])): ?>
                                <button type="submit" name="datmua" class="btn btn-success">Đặt mua</button>
                            <?php else: ?>
                                <button type="button" class="btn btn-success" onclick="alert('Vui lòng đăng nhập để mua hàng.'); window.location.href='dangnhap.php?redirect=muahang.php?mua=<?= $se_sp['ID_sanpham'] ?>';">Đặt mua</button>
                            <?php endif; ?>
                            <button type="submit" name="addtocart" class="btn btn-primary">Thêm vào giỏ hàng</button>
                        </div>
                        <?php if ($show_message_id == $se_sp['ID_sanpham'] && $message): ?>
                            <div class="mt-3 alert alert-<?= $message == 'Thành công' ? 'success' : 'danger' ?>" role="alert">
                                <?= $message ?>
                            </div>
                        <?php endif; ?>
                        <p class="mt-3"><a href="mqd1.php" class="btn btn-primary">Quay lại danh sách sản phẩm</a></p>
                    </div>
                </div>

                <script>
                let originalDongia = <?= $se_sp['dongia'] ?>;
                let currentSoluong = 1;

                function tinhTongTien(input, dongia) {
                    currentSoluong = input.value || 1;
                    var tongtien = originalDongia * currentSoluong;
                    input.form.tongtien.value = tongtien.toLocaleString('vi-VN');
                    applyVoucherDiscount(); // Re-apply discount on quantity change
                }

                function applyVoucherDiscount() {
                    const select = document.getElementById('voucher_select');
                    const voucherId = select.value;
                    const tongtienInput = document.querySelector('input[name="tongtien"]');
                    const originalPriceSpan = document.getElementById('original-price');
                    const discountedPriceDisplay = document.getElementById('discounted-price-display');
                    const discountedDongiaSpan = document.getElementById('discounted-dongia');
                    const discountPreview = document.getElementById('discount-preview');
                    const savingsSpan = document.getElementById('savings');
                    const tongtienValue = parseFloat(tongtienInput.value.replace(/\./g, '')) || (originalDongia * currentSoluong);

                    if (!voucherId) {
                        // No voucher selected
                        tongtienInput.value = tongtienValue.toLocaleString('vi-VN');
                        discountPreview.style.display = 'none';
                        discountedPriceDisplay.style.display = 'none';
                        return;
                    }

                    const option = select.options[select.selectedIndex];
                    const type = option.dataset.type;
                    const value = parseFloat(option.dataset.value);
                    const applicableTo = option.dataset.applicableTo;
                    const minOrder = parseFloat(option.dataset.minOrder);

                    if (tongtienValue < minOrder) {
                        alert('Tổng tiền không đủ điều kiện sử dụng voucher (tối thiểu ' + minOrder.toLocaleString('vi-VN') + ' VND)');
                        select.value = '';
                        return;
                    }

                    let discountAmount = 0;
                    let discountedTotal = tongtienValue;

                    if (applicableTo === 'product') {
                        // Product discount: Apply to dongia, then multiply by quantity
                        let discountedDongia = originalDongia;
                        if (type === 'percent') {
                            discountedDongia *= (1 - value / 100);
                        } else {
                            discountedDongia -= value;
                        }
                        discountedDongia = Math.max(0, discountedDongia); // No negative price
                        discountedTotal = discountedDongia * currentSoluong;
                        discountAmount = originalDongia * currentSoluong - discountedTotal;
                        // Update display
                        discountedPriceDisplay.style.display = 'block';
                        discountedDongiaSpan.textContent = discountedDongia.toLocaleString('vi-VN');
                    } else if (applicableTo === 'order') {
                        // Order discount: Apply to total
                        if (type === 'percent') {
                            discountAmount = tongtienValue * (value / 100);
                        } else {
                            discountAmount = Math.min(value, tongtienValue); // Don't exceed total
                        }
                        discountedTotal = tongtienValue - discountAmount;
                        discountAmount = Math.max(0, discountAmount);
                    }

                    tongtienInput.value = discountedTotal.toLocaleString('vi-VN');
                    document.getElementById('discounted-price').textContent = discountedTotal.toLocaleString('vi-VN');
                    discountPreview.style.display = 'block';
                    savingsSpan.textContent = discountAmount.toLocaleString('vi-VN');
                    originalPriceSpan.style.textDecoration = applicableTo === 'product' ? 'line-through' : 'none';
                }

                // Initialize on load
                document.addEventListener('DOMContentLoaded', function() {
                    const txtmua = document.getElementById('txtmua');
                    if (txtmua) {
                        txtmua.addEventListener('input', function() {
                            tinhTongTien(this, originalDongia);
                        });
                        // Set initial total
                        tinhTongTien(txtmua, originalDongia);
                    }
                });
                </script>
                <?php else: ?>
                <div class="hang">
                    <div class="cot cot-12">
                        <p>Không tìm thấy sản phẩm.</p>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="hang">
                    <div class="cot cot-12">
                        <p>Vui lòng chọn sản phẩm để mua.</p>
                    </div>
                </div>
            <?php endif; ?>
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
                                <a href="#" class="me-2"><img src="../media/fb.png" alt="Facebook" height="50" width="50"></a>
                                <a href="#" class="me-2"><img src="../media/ytb.png" alt="YouTube" height="50" width="50"></a>
                                <a href="#"><img src="../media/gmail.png" alt="Gmail" height="50" width="30"></a>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Về chúng tôi</h6>
                            <p><a href="#!" class="text-reset">Giới thiệu</a></p>
                            <p><a href="#!" class="text-reset">Sứ mệnh của nhân viên</a></p>
                            <p><a href="#!" class="text-reset">Giá trị sản phẩm</a></p>
                            <p><a href="#!" class="text-reset">An toàn thực phẩm</a></p>
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold mb-4">Vị trí cửa hàng</h6>
                            <p><a href="#!" class="text-reset">Miền Bắc</a></p>
                            <p><a href="#!" class="text-reset">Miền Trung</a></p>
                            <p><a href="#!" class="text-reset">Miền Nam</a></p>
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
