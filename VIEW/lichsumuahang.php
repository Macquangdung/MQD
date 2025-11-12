<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /SANPHAMMOI/VIEW/dangnhap.php");
    exit;
}
include('../MODEL/modelmh.php');
include('../MODEL/modeldangnhap.php');
include_once(__DIR__ . '/../MODEL/modeladmin.php');
$get_data = new data_muahang();
$userModel = new data_user_login();
$admin_model = new data_admin();
$user = $userModel->get_user_by_username($_SESSION['user']);
if (!$user) {
    header("Location: /SANPHAMMOI/VIEW/dangnhap.php?error=invalid_user");
    exit;
}
$id_user = $user['ID_user'];
$orders = $get_data->select_muahang_by_user($id_user);
$message = isset($_GET['message']) ? $_GET['message'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cancel_order'])) {
    $id = intval($_POST['id']);
    $cancel = $get_data->cancel_order($id);
    if ($cancel) {
        header("Location: lichsumuahang.php?message=Đã hủy đơn hàng thành công!");
        exit;
    } else {
        $message = 'Hủy đơn hàng thất bại! (Chỉ hủy được khi trạng thái là chờ xác nhận)';
    }
    // Reload orders
    $orders = $get_data->select_muahang_by_user($id_user);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_return'])) {
    $order_id = intval($_POST['order_id']);
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $reason = trim($_POST['reason']);
    if (!empty($reason)) {
        $insert = $admin_model->insert_return($order_id, $id_user, $product_id, $quantity, $reason);
        if ($insert) {
            $message = 'Yêu cầu đổi trả đã được gửi thành công! Admin sẽ xử lý sớm.';
        } else {
            $message = 'Gửi yêu cầu đổi trả thất bại. Vui lòng thử lại.';
        }
    } else {
        $message = 'Vui lòng nhập lý do đổi trả.';
    }
    // Reload orders
    $orders = $get_data->select_muahang_by_user($id_user);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lịch sử mua hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="luoi.css">
    <link rel="stylesheet" type="text/css" href="dinhdang.css">
    <link rel="stylesheet" type="text/css" href="dinhdangmenu.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="mqd.php">
                <img src="../media/loo.jpg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top me-2">
                Bakery Shop
            </a>
        <div>
            <a href="mqd.php" class="btn btn-outline-primary me-2">Trang chủ</a>
            <a href="vouchers.php" class="btn btn-outline-success me-2">Voucher</a>
            <a href="dangxuat.php" class="btn btn-outline-secondary">Đăng xuất</a>
        </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Lịch sử mua hàng</h2>
        <?php if ($message): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Điểm tích lũy</h5>
                        <p class="card-text">Bạn có <strong><?= $admin_model->get_user_points($id_user) ?> điểm</strong></p>
                        <p class="text-muted">1 điểm = 1000 VND</p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (empty($orders)): ?>
            <div class="text-center">
                <p>Bạn chưa có đơn hàng nào.</p>
                <a href="mqd1.php" class="btn btn-primary">Xem sản phẩm</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Đơn hàng</th>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td>
                                <img src="../media/<?= $order['hinhanh'] ?>" width="50" height="50" class="me-2" alt="<?= htmlspecialchars($order['tensanpham']) ?>">
                                <?= htmlspecialchars($order['tensanpham']) ?>
                            </td>
                            <td><?= $order['soluong'] ?></td>
                            <td><?= number_format($order['dongia'], 0, ',', '.') ?> VND</td>
                            <td><?= number_format($order['tongtien'], 0, ',', '.') ?> VND</td>
                            <td>
                                <span class="badge <?= $order['trangthai'] == 'chờ xác nhận' ? 'bg-warning' : ($order['trangthai'] == 'đang vận chuyển' ? 'bg-info' : ($order['trangthai'] == 'đã giao hàng thành công' ? 'bg-success' : 'bg-secondary')) ?>">
                                    <?= htmlspecialchars($order['trangthai']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($order['trangthai'] == 'chờ xác nhận'): ?>
                                    <form method="post" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn hủy đơn hàng này?');">
                                        <input type="hidden" name="id" value="<?= $order['id'] ?>">
                                        <button type="submit" name="cancel_order" class="btn btn-sm btn-danger">Hủy đơn</button>
                                    </form>
                                <?php elseif ($order['trangthai'] == 'đã giao hàng thành công'): ?>
                                    <a href="hoadon.php?order_id=<?= $order['id'] ?>" class="btn btn-sm btn-primary me-2" target="_blank">Xuất hóa đơn</a>
                                    <a href="danhgia.php?order_id=<?= $order['id'] ?>" class="btn btn-sm btn-warning me-2">Đánh giá</a>
                                    <?php
                                    $eligible_for_return = false;
                                    if (!empty($order['delivered_at'])) {
                                        $delivery_date = new DateTime($order['delivered_at']);
                                        $seven_days_later = clone $delivery_date;
                                        $seven_days_later->add(new DateInterval('P7D'));
                                        $now = new DateTime();
                                        if ($seven_days_later > $now) {
                                            $eligible_for_return = true;
                                        }
                                    }
                                    if ($eligible_for_return): ?>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#returnModal<?= $order['id'] ?>">Yêu cầu đổi trả</button>
                                    <?php else: ?>
                                        <span class="text-muted small d-block">Đã quá hạn đổi trả (7 ngày)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">Không thể thao tác</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Return Modals -->
    <?php foreach ($orders as $order): ?>
        <?php
        $eligible_for_return_modal = false;
        if ($order['trangthai'] == 'đã giao hàng thành công' && !empty($order['delivered_at'])) {
            $delivery_date = new DateTime($order['delivered_at']);
            $seven_days_later = clone $delivery_date;
            $seven_days_later->add(new DateInterval('P7D'));
            $now = new DateTime();
            if ($seven_days_later > $now) {
                $eligible_for_return_modal = true;
            }
        }
        ?>
        <?php if ($eligible_for_return_modal): ?>
        <div class="modal fade" id="returnModal<?= $order['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yêu cầu đổi trả - Đơn hàng <?= $order['id'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <input type="hidden" name="product_id" value="<?= $order['ID_sanpham'] ?>">
                            <input type="hidden" name="quantity" value="<?= $order['soluong'] ?>">
                            <div class="mb-3">
                                <label for="reason_<?= $order['id'] ?>" class="form-label">Lý do đổi trả</label>
                                <textarea class="form-control" id="reason_<?= $order['id'] ?>" name="reason" rows="4" required placeholder="Vui lòng mô tả lý do (hỏng hóc, sai sản phẩm, v.v.)..."></textarea>
                            </div>
                            <p class="text-muted small">Sản phẩm: <?= htmlspecialchars($order['tensanpham']) ?> (Số lượng: <?= $order['soluong'] ?>)</p>
                            <p class="text-muted small">Ngày giao: <?= date('d/m/Y', strtotime($order['delivered_at'])) ?></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" name="request_return" class="btn btn-primary" onclick="return confirm('Xác nhận gửi yêu cầu đổi trả?')">Gửi yêu cầu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printInvoice(orderId) {
            fetch(`../get_invoice.php?order_id=${orderId}`)
                .then(response => response.json())
                .then(order => {
                    if (order.error) {
                        alert('Không tìm thấy hóa đơn!');
                        return;
                    }
                    const invoiceWindow = window.open('', '_blank', 'width=800,height=700');
                    invoiceWindow.document.write(`
                        <html>
                        <head>
                            <title>Hóa đơn - Đơn hàng ${orderId}</title>
                            <style>
                                body { font-family: Arial, sans-serif; margin: 20px; }
                                .header { text-align: center; margin-bottom: 30px; }
                                .details { margin-bottom: 20px; }
                                table { width: 100%; border-collapse: collapse; }
                                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                                th { background-color: #f2f2f2; }
                                .total { font-weight: bold; }
                                .product-img { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; }
                                .review { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 15px; }
                            </style>
                        </head>
                        <body>
                            <div class="header">
                                <h1>Bakery Shop</h1>
                                <p>Hóa đơn mua hàng</p>
                            </div>
                            <div class="details">
                                <p><strong>ID Đơn hàng:</strong> ${orderId}</p>
                                <p><strong>Ngày đặt:</strong> ${order.ngay_dat ? order.ngay_dat : 'Chưa cập nhật'}</p>
                                <p><strong>Ngày giao thành công:</strong> ${order.ngay_giao ? order.ngay_giao : 'Chưa cập nhật'}</p>
                                <p><strong>Ngày in:</strong> ${new Date().toLocaleDateString('vi-VN')}</p>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ảnh</th>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><img src="../media/${order.hinhanh}" class="product-img" alt="${order.tensanpham}"></td>
                                        <td>${order.tensanpham}</td>
                                        <td>${order.soluong}</td>
                                        <td>${Number(order.dongia).toLocaleString('vi-VN')} VND</td>
                                        <td>${Number(order.tongtien).toLocaleString('vi-VN')} VND</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="review">
                                <h4>Đánh giá của khách hàng</h4>
                                ${
                                    order.review
                                    ? `<div>
                                        <strong>Điểm: </strong> ${order.review.rating}/5<br>
                                        <strong>Nhận xét:</strong> ${order.review.comment}<br>
                                        <small><i>Ngày đánh giá: ${order.review.created_at}</i></small>
                                    </div>`
                                    : '<span>Chưa có đánh giá cho sản phẩm này.</span>'
                                }
                            </div>
                            <p class="total" style="text-align: right; margin-top: 20px;">Cảm ơn quý khách đã mua hàng!</p>
                        </body>
                        </html>
                    `);
                    invoiceWindow.document.close();
                    invoiceWindow.print();
                })
                .catch(() => {
                    alert('Có lỗi khi lấy hóa đơn!');
                });
        }
    </script>
</body>
</html>
