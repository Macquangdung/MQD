<?php
session_start();
include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelmqd1.php');
global $conn;
$user_id = $_SESSION['ID_user'] ?? null;
$orders = [];
if ($user_id) {
    $sql = "SELECT * FROM muahangg WHERE ID_user = $user_id ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }
}
$model = new data_mqd1();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng của bạn - BAKERY SHOP</title>
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
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Đơn hàng của bạn</h1>
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
                        $product = $model->getProductById($order['ID_sanpham']);
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
