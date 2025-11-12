<?php
session_start();
include_once('../MODEL/modelhoadon.php');
$orders = ModelHoaDon::getAllOrdersForStaff();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng - BAKERY SHOP</title>
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
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Quản Lý Đơn Hàng</h1>
        <div>
            <table class="w-full border-collapse mb-4">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="p-2">Mã đơn</th>
                        <th class="p-2">Khách hàng</th>
                        <th class="p-2">Ngày đặt</th>
                        <th class="p-2">Tổng tiền</th>
                        <th class="p-2">Trạng thái</th>
                        <th class="p-2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $order): ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo htmlspecialchars($order['mahoadon']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($order['tenkhach']); ?></td>
                        <td class="p-2 text-center"><?php echo htmlspecialchars($order['ngaymua']); ?></td>
                        <td class="p-2 text-right"><?php echo number_format($order['tongtien']); ?>₫</td>
                        <td class="p-2 text-center"><?php echo htmlspecialchars($order['trangthai']); ?></td>
                        <td class="p-2 text-center">
                            <a href="hoadon.php?id=<?php echo $order['id']; ?>" class="inline-block px-3 py-1 bg-primary text-white rounded hover:bg-green-700 transition">Xem</a>
                            <a href="duyetdon.php?id=<?php echo $order['id']; ?>" class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-800 transition">Duyệt</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 p-4">Không có đơn hàng nào.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
