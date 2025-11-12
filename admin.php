<?php
include('../CONTROLLER/controladmin.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="luoi.css">
    <link rel="stylesheet" type="text/css" href="dinhdang.css">
    <link rel="stylesheet" type="text/css" href="dinhdangmenu.css">
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../media/loo.jpg" align="center" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Bakery Shop - Admin
            </a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Thêm sản phẩm mới</h2>
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-info"><?= htmlspecialchars($_GET['message']) ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tensanpham" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="tensanpham" name="tensanpham" required>
            </div>
            <div class="mb-3">
                <label for="mota" class="form-label">Mô tả</label>
                <textarea class="form-control" id="mota" name="mota" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="hinhanh" class="form-label">Hình ảnh</label>
                <input type="file" class="form-control" id="hinhanh" name="hinhanh" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="soluong" class="form-label">Số lượng</label>
                <input type="number" class="form-control" id="soluong" name="soluong" min="1" required>
            </div>
            <div class="mb-3">
                <label for="dongia" class="form-label">Đơn giá (VND)</label>
                <input type="number" class="form-control" id="dongia" name="dongia" min="0" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Danh mục</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="banhkem">Bánh kem</option>
                    <option value="banhbonglan">Bánh bông lan</option>
                </select>
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Thêm sản phẩm</button>
        </form>

        <h2 class="mt-5">Danh sách sản phẩm</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Hình ảnh</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Danh mục</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['ID_sanpham'] ?></td>
                    <td><?= htmlspecialchars($product['tensanpham']) ?></td>
                    <td><?= htmlspecialchars($product['mota']) ?></td>
                    <td><img src="../media/<?= $product['hinhanh'] ?>" width="50" height="50" alt="Hình ảnh"></td>
<td>
    <form method="post" style="display:inline;">
        <input type="hidden" name="product_id" value="<?= $product['ID_sanpham'] ?>">
        <input type="number" name="soluong" value="<?= $product['soluong'] ?>" min="0" required style="width:70px;">
        <button type="submit" name="update_quantity" class="btn btn-sm btn-info">Cập nhật</button>
    </form>
</td>
<td>
    <form method="post" style="display:inline;">
        <input type="hidden" name="product_id" value="<?= $product['ID_sanpham'] ?>">
        <input type="number" name="dongia" value="<?= $product['dongia'] ?>" min="0" step="0.01" required style="width:80px;">
        <button type="submit" name="update_price" class="btn btn-sm btn-warning">Cập nhật</button>
    </form>
</td>
                    <td><?= htmlspecialchars($product['category']) ?></td>
                    <td><a href="?delete=<?= $product['ID_sanpham'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">Xóa</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Quản lý nhân viên -->
        <?php
        include_once("../MODEL/modeladmin.php");
        $admin = new data_admin();
        // Chỉ cho phép admin
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'):
            // Xử lý thêm/xóa/sửa/phân quyền nhân viên
            $message_nv = '';
            if (isset($_POST['add_staff'])) {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $fullname = trim($_POST['fullname']);
                $role = $_POST['role'];
                if ($admin->add_staff($username, $password, $fullname, $role)) {
                    $message_nv = "Thêm nhân viên thành công!";
                } else {
                    $message_nv = "Thêm nhân viên thất bại (trùng username?)";
                }
            }
            if (isset($_GET['delete_nv']) && is_numeric($_GET['delete_nv'])) {
                if ($admin->delete_staff(intval($_GET['delete_nv']))) {
                    $message_nv = "Xóa nhân viên thành công!";
                } else {
                    $message_nv = "Xóa nhân viên thất bại!";
                }
            }
            if (isset($_POST['update_role'])) {
                $id = intval($_POST['user_id']);
                $role = $_POST['role'];
                if ($admin->update_staff_role($id, $role)) {
                    $message_nv = "Cập nhật quyền thành công!";
                } else {
                    $message_nv = "Cập nhật quyền thất bại!";
                }
            }
            $staffs = $admin->get_all_staff();
        ?>
        <h2 class="mt-5 text-primary text-center">Quản lý nhân viên</h2>
        <?php if ($message_nv): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message_nv) ?></div>
        <?php endif; ?>
        <form method="post" class="mb-3">
            <h4>Thêm nhân viên mới</h4>
            <input type="text" name="username" placeholder="Tên đăng nhập" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="text" name="fullname" placeholder="Họ tên" required>
            <select name="role">
                <option value="nhanvien">Nhân viên</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="add_staff" class="btn btn-primary btn-sm">Thêm nhân viên</button>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th><th>Tên đăng nhập</th><th>Họ tên</th><th>Quyền</th><th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($staffs as $s): ?>
                <tr>
                    <td><?= $s['ID_user'] ?></td>
                    <td><?= htmlspecialchars($s['tendangnhap']) ?></td>
                    <td><?= htmlspecialchars($s['hoten']) ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?= $s['ID_user'] ?>">
                            <select name="role">
                                <option value="nhanvien" <?= $s['role']=='nhanvien'?'selected':'' ?>>Nhân viên</option>
                                <option value="admin" <?= $s['role']=='admin'?'selected':'' ?>>Admin</option>
                            </select>
                            <button type="submit" name="update_role" class="btn btn-sm btn-info">Cập nhật</button>
                        </form>
                    </td>
                    <td>
                        <?php if ($s['role'] != 'admin'): ?>
                        <a href="?delete_nv=<?= $s['ID_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa nhân viên này?')">Xóa</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>

        <h2 class="mt-5">Quản lý đơn hàng</h2>
        <?php if (isset($orders) && !empty($orders)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['tendangnhap']) ?></td>
                    <td><?= htmlspecialchars($order['tensanpham']) ?></td>
                    <td><?= $order['soluong'] ?></td>
                    <td><?= number_format($order['tongtien'], 0, ',', '.') ?> VND</td>
<td><?= htmlspecialchars($order['trangthai']) ?></td>
<td>
    <?php if ($order['trangthai'] !== 'đã giao hàng thành công' && $order['trangthai'] !== 'đã hủy'): ?>
        <form method="post" style="display:inline;">
            <input type="hidden" name="id_muahang" value="<?= $order['id'] ?>">
            <button type="submit" name="update_status" value="đang vận chuyển" class="btn btn-sm btn-info" onclick="return confirm('Xác nhận cập nhật trạng thái thành Đang vận chuyển?')">Đang vận chuyển</button>
        </form>
        <form method="post" style="display:inline;">
            <input type="hidden" name="id_muahang" value="<?= $order['id'] ?>">
            <button type="submit" name="update_status" value="đã giao hàng thành công" class="btn btn-sm btn-success" onclick="return confirm('Xác nhận cập nhật trạng thái thành Đã giao hàng thành công?')">Giao hàng thành công</button>
        </form>
    <?php elseif ($order['trangthai'] === 'đã giao hàng thành công'): ?>
        <span class="badge bg-success">Hoàn thành</span>
    <?php elseif ($order['trangthai'] === 'đã hủy'): ?>
        <span class="badge bg-danger">Đã hủy</span>
    <?php endif; ?>
</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>Chưa có đơn hàng nào.</p>
        <?php endif; ?>

        <h2 class="mt-5">Quản lý Voucher</h2>
        <?php if (isset($edit_voucher)): ?>
            <a href="admin.php" class="btn btn-secondary mb-3">Hủy sửa</a>
        <?php endif; ?>
        <form method="post" class="mb-4">
            <?php if (isset($edit_voucher)): ?>
                <input type="hidden" name="voucher_id" value="<?= $edit_voucher['id'] ?>">
            <?php endif; ?>
            <div class="row">
                <div class="col-md-2">
                    <label for="voucher_code" class="form-label">Mã Voucher</label>
                    <input type="text" class="form-control" id="voucher_code" name="code" value="<?= isset($edit_voucher) ? htmlspecialchars($edit_voucher['code']) : '' ?>" required>
                </div>
                <div class="col-md-2">
                    <label for="voucher_type" class="form-label">Loại</label>
                    <select class="form-control" id="voucher_type" name="type" required>
                        <option value="percent" <?= isset($edit_voucher) && $edit_voucher['type'] == 'percent' ? 'selected' : '' ?>>Phần trăm</option>
                        <option value="fixed" <?= isset($edit_voucher) && $edit_voucher['type'] == 'fixed' ? 'selected' : '' ?>>Cố định</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="voucher_value" class="form-label">Giá trị</label>
                    <input type="number" class="form-control" id="voucher_value" name="value" value="<?= isset($edit_voucher) ? $edit_voucher['value'] : '' ?>" min="0" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <label for="min_order" class="form-label">Đơn tối thiểu</label>
                    <input type="number" class="form-control" id="min_order" name="min_order" value="<?= isset($edit_voucher) ? $edit_voucher['min_order'] : '' ?>" min="0" step="0.01">
                </div>
                <div class="col-md-2">
                    <label for="max_uses" class="form-label">Sử dụng tối đa</label>
                    <input type="number" class="form-control" id="max_uses" name="max_uses" value="<?= isset($edit_voucher) && $edit_voucher['max_uses'] !== null ? $edit_voucher['max_uses'] : '' ?>" min="0">
                </div>
                <div class="col-md-2">
                    <label for="expiry_date" class="form-label">Ngày hết hạn</label>
                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?= isset($edit_voucher) && $edit_voucher['expiry_date'] ? $edit_voucher['expiry_date'] : '' ?>">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="applicable_to" class="form-label">Áp dụng cho</label>
                    <select class="form-control" id="applicable_to" name="applicable_to" required>
                        <option value="order" <?= isset($edit_voucher) && $edit_voucher['applicable_to'] == 'order' ? 'selected' : '' ?>>Đơn hàng</option>
                        <option value="product" <?= isset($edit_voucher) && $edit_voucher['applicable_to'] == 'product' ? 'selected' : '' ?>>Sản phẩm</option>
                    </select>
                </div>
                <div class="col-md-6" id="product_ids_div" style="display:none;">
                    <label for="product_ids" class="form-label">Sản phẩm áp dụng</label>
                    <select class="form-control" id="product_ids" name="product_ids[]" multiple>
                        <?php 
                        $selected_products = [];
                        if (isset($edit_voucher) && $edit_voucher['applicable_to'] == 'product' && $edit_voucher['product_ids']) {
                            $selected_products = json_decode($edit_voucher['product_ids'], true) ?: [];
                        }
                        foreach ($products as $product): 
                        ?>
                            <option value="<?= $product['ID_sanpham'] ?>" <?= in_array($product['ID_sanpham'], $selected_products) ? 'selected' : '' ?>><?= htmlspecialchars($product['tensanpham']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <?php if (isset($edit_voucher)): ?>
                        <button type="submit" name="edit_voucher" class="btn btn-warning mt-4">Cập nhật Voucher</button>
                    <?php else: ?>
                        <button type="submit" name="add_voucher" class="btn btn-primary mt-4">Thêm Voucher</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Đơn tối thiểu</th>
                    <th>Sử dụng</th>
                    <th>Hết hạn</th>
                    <th>Áp dụng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vouchers as $voucher): ?>
                <tr>
                    <td><?= $voucher['id'] ?></td>
                    <td><?= htmlspecialchars($voucher['code']) ?></td>
                    <td><?= $voucher['type'] == 'percent' ? 'Phần trăm' : 'Cố định' ?></td>
                    <td><?= $voucher['value'] ?><?= $voucher['type'] == 'percent' ? '%' : ' VND' ?></td>
                    <td><?= number_format($voucher['min_order'], 0, ',', '.') ?> VND</td>
                    <td><?= $voucher['uses_count'] ?>/<?= $voucher['max_uses'] ?: '∞' ?></td>
                    <td><?= $voucher['expiry_date'] ?: 'Không giới hạn' ?></td>
                    <td><?= $voucher['applicable_to'] == 'order' ? 'Đơn hàng' : 'Sản phẩm' ?></td>
                    <td>
                        <a href="?edit_voucher=<?= $voucher['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="?delete_voucher=<?= $voucher['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa voucher này?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Quản lý Khuyến mãi</h2>
        <form method="post" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="promotion_name" class="form-label">Tên Khuyến mãi</label>
                    <input type="text" class="form-control" id="promotion_name" name="name" required>
                </div>
                <div class="col-md-3">
                    <label for="promotion_description" class="form-label">Mô tả</label>
                    <textarea class="form-control" id="promotion_description" name="description" rows="2"></textarea>
                </div>
                <div class="col-md-2">
                    <label for="discount_type" class="form-label">Loại Giảm giá</label>
                    <select class="form-control" id="discount_type" name="discount_type" required>
                        <option value="percent">Phần trăm</option>
                        <option value="fixed">Cố định</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="discount_value" class="form-label">Giá trị</label>
                    <input type="number" class="form-control" id="discount_value" name="discount_value" min="0" step="0.01" required>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">Hoạt động</option>
                        <option value="inactive">Không hoạt động</option>
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="col-md-4">
                    <label for="applicable_products" class="form-label">Sản phẩm áp dụng</label>
                    <select class="form-control" id="applicable_products" name="applicable_products[]" multiple>
                        <option value="all">Tất cả sản phẩm</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['ID_sanpham'] ?>"><?= htmlspecialchars($product['tensanpham']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="add_promotion" class="btn btn-primary mt-4">Thêm Khuyến mãi</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Mô tả</th>
                    <th>Giảm giá</th>
                    <th>Thời gian</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td><?= $promotion['id'] ?></td>
                    <td><?= htmlspecialchars($promotion['name']) ?></td>
                    <td><?= htmlspecialchars($promotion['description']) ?></td>
                    <td><?= $promotion['discount_value'] ?><?= $promotion['discount_type'] == 'percent' ? '%' : ' VND' ?></td>
                    <td><?= $promotion['start_date'] ?> - <?= $promotion['end_date'] ?></td>
                    <td><span class="badge bg-<?= $promotion['status'] == 'active' ? 'success' : 'secondary' ?>"><?= $promotion['status'] == 'active' ? 'Hoạt động' : 'Không hoạt động' ?></span></td>
                    <td><a href="?delete_promotion=<?= $promotion['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa khuyến mãi này?')">Xóa</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Quản lý Quy tắc Tích điểm</h2>
        <form method="post" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="points_per_vnd" class="form-label">Điểm mỗi 1000 VND</label>
                    <input type="number" class="form-control" id="points_per_vnd" name="points_per_vnd" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label for="min_order_for_points" class="form-label">Đơn tối thiểu để tích điểm</label>
                    <input type="number" class="form-control" id="min_order_for_points" name="min_order_for_points" min="0" step="0.01" required>
                </div>
                <div class="col-md-4">
                    <label for="redemption_rate" class="form-label">VND mỗi điểm</label>
                    <input type="number" class="form-control" id="redemption_rate" name="redemption_rate" min="0" step="0.01" required>
                </div>
            </div>
            <button type="submit" name="add_loyalty_rule" class="btn btn-primary mt-3">Thêm Quy tắc</button>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Điểm/1000 VND</th>
                    <th>Đơn tối thiểu</th>
                    <th>VND/Điểm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loyalty_rules as $rule): ?>
                <tr>
                    <td><?= $rule['id'] ?></td>
                    <td><?= $rule['points_per_vnd'] ?></td>
                    <td><?= number_format($rule['min_order_for_points'], 0, ',', '.') ?> VND</td>
                    <td><?= number_format($rule['redemption_rate'], 0, ',', '.') ?> VND</td>
                    <td><a href="?delete_loyalty_rule=<?= $rule['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xóa quy tắc này?')">Xóa</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Quản lý Điểm Tích lũy Người dùng</h2>
        <form method="post" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="user_id" class="form-label">ID Người dùng</label>
                    <input type="number" class="form-control" id="user_id" name="user_id" required>
                </div>
                <div class="col-md-3">
                    <label for="points" class="form-label">Điểm</label>
                    <input type="number" class="form-control" id="points" name="points" required>
                </div>
                <div class="col-md-4">
                    <label for="description" class="form-label">Mô tả</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="adjust_points" class="btn btn-primary mt-4">Điều chỉnh Điểm</button>
                </div>
            </div>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Người dùng</th>
                    <th>Tên đăng nhập</th>
                    <th>Tổng Điểm</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Get users and their points
                global $conn;
                $user_sql = "SELECT u.ID_user, u.tendangnhap FROM users u";
                $user_run = mysqli_query($conn, $user_sql);
                while ($user = mysqli_fetch_assoc($user_run)): ?>
                <tr>
                    <td><?= $user['ID_user'] ?></td>
                    <td><?= htmlspecialchars($user['tendangnhap']) ?></td>
                    <td><?= $get_data->get_user_points($user['ID_user']) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h2 class="mt-5">Báo cáo thống kê</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Tổng doanh thu</h5>
                        <p class="card-text display-4 text-success"><?= number_format($total_revenue, 0, ',', '.') ?> VND</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Số lượng sản phẩm bán ra</h5>
                        <p class="card-text display-4 text-primary"><?= $total_products_sold ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Tình hình đơn hàng</h5>
                        <p class="card-text">
                            Chờ xác nhận: <?= $order_stats['chờ xác nhận'] ?><br>
                            Đang vận chuyển: <?= $order_stats['đang vận chuyển'] ?><br>
                            Đã giao thành công: <?= $order_stats['đã giao hàng thành công'] ?><br>
                            Đã hủy: <?= $order_stats['đã hủy'] ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mt-5">Quản lý đổi trả hàng</h2>
        <?php if (isset($returns) && !empty($returns)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Lý do</th>
                    <th>Trạng thái</th>
                    <th>Ngày yêu cầu</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returns as $return): ?>
                <tr>
                    <td><?= $return['id'] ?></td>
                    <td>#<?= $return['order_id'] ?> (<?= number_format($return['order_total'], 0, ',', '.') ?> VND)</td>
                    <td><?= htmlspecialchars($return['tendangnhap']) ?></td>
                    <td><?= htmlspecialchars($return['tensanpham']) ?></td>
                    <td><?= $return['quantity'] ?></td>
                    <td><?= htmlspecialchars($return['reason']) ?></td>
                    <td>
                        <?php if ($return['status'] == 'pending'): ?>
                            <span class="badge bg-warning">Chờ xử lý</span>
                        <?php elseif ($return['status'] == 'approved'): ?>
                            <span class="badge bg-success">Đã duyệt</span>
                        <?php elseif ($return['status'] == 'rejected'): ?>
                            <span class="badge bg-danger">Từ chối</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $return['request_date'] ?></td>
                    <td>
                        <?php if ($return['status'] == 'pending'): ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="return_id" value="<?= $return['id'] ?>">
                                <input type="hidden" name="status" value="approved">
                                <label for="notes_<?= $return['id'] ?>">Ghi chú:</label>
                                <input type="text" name="notes" id="notes_<?= $return['id'] ?>" placeholder="Tùy chọn">
                                <button type="submit" name="update_return_status" class="btn btn-sm btn-success" onclick="return confirm('Duyệt yêu cầu đổi trả này?')">Duyệt</button>
                            </form>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="return_id" value="<?= $return['id'] ?>">
                                <input type="hidden" name="status" value="rejected">
                                <input type="text" name="notes" placeholder="Lý do từ chối">
                                <button type="submit" name="update_return_status" class="btn btn-sm btn-danger" onclick="return confirm('Từ chối yêu cầu đổi trả này?')">Từ chối</button>
                            </form>
                        <?php else: ?>
                            <?= htmlspecialchars($return['notes']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>Chưa có yêu cầu đổi trả nào.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const applicableToSelect = document.getElementById('applicable_to');
            const productIdsDiv = document.getElementById('product_ids_div');
            
            function toggleProductDiv() {
                if (applicableToSelect.value === 'product') {
                    productIdsDiv.style.display = 'block';
                } else {
                    productIdsDiv.style.display = 'none';
                }
            }
            
            applicableToSelect.addEventListener('change', toggleProductDiv);
            toggleProductDiv(); // Initial check
        });
    </script>
</body>
</html>
