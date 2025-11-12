<?php
session_start();
include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelmqd1.php');
$user_id = $_SESSION['ID_user'] ?? null;
include_once('../MODEL/modelmuahang.php');
$model = new data_muahang();
$model_mqd1 = new data_mqd1();
$orders = $user_id ? $model->select_muahang_by_user($user_id) : [];

// Check for success message from direct purchase
$success_message = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success_message = 'Mua hàng thành công! Đơn hàng của bạn đã được thêm vào lịch sử.';
}

// Handle cancel order
$cancelled_message = '';
if (isset($_GET['huy'])) {
    $order_id = (int)$_GET['huy'];
    if ($model->cancel_order($order_id)) {
        header("Location: lichsumuahang.php?cancelled=1");
        exit();
    } else {
        $cancelled_message = 'Không thể hủy đơn hàng. Vui lòng thử lại.';
    }
}
if (isset($_GET['cancelled']) && $_GET['cancelled'] == 1) {
    $cancelled_message = 'Đơn hàng đã được hủy thành công.';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử mua hàng - BAKERY SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dinhdang.css">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
    </style>
</head>
<body class="bg-stone-50">
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Lịch Sử Mua Hàng</h1>
        <?php if (!empty($success_message)): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($cancelled_message)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <?php echo htmlspecialchars($cancelled_message); ?>
            </div>
        <?php endif; ?>
        <div>
            <table class="w-full border-collapse mb-4">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="p-2">Mã đơn</th>
                        <th class="p-2">Sản phẩm</th>
                        <th class="p-2">Số lượng</th>
                        <th class="p-2">Tổng tiền</th>
                        <th class="p-2">Trạng thái</th>
                        <th class="p-2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): 
                        $product = $model_mqd1->getProductById($order['ID_sanpham']);
                    ?>
                    <tr class="border-b">
                        <td class="p-2">#<?= $order['id'] ?></td>
                        <td class="p-2"><?= htmlspecialchars($product['tensanpham'] ?? '') ?></td>
                        <td class="p-2 text-center"><?= $order['soluong'] ?></td>
                        <td class="p-2 text-right"><?= number_format($order['tongtien']) ?>₫</td>
                        <td class="p-2 text-center"><?= htmlspecialchars($order['trangthai']) ?></td>
                        <td class="p-2 text-center">
                            <?php if ($order['trangthai'] == 'chờ xác nhận'): ?>
                                <a href="?huy=<?= $order['id'] ?>" class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700 transition" onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này?')">Hủy</a>
                            <?php elseif ($order['trangthai'] == 'đã giao hàng thành công'): ?>
                                <a href="danhgia.php?order_id=<?= $order['id'] ?>" class="inline-block px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-700 transition mr-2">Đánh giá</a>
                                <button onclick="window.print()" class="inline-block px-3 py-1 bg-green-500 text-white rounded hover:bg-green-700 transition">In hóa đơn</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 p-4">Bạn chưa có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
