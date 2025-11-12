<?php
session_start();
include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelmqd1.php');
include_once('../MODEL/modelhoadon.php');
$hoadon = isset($_GET['id']) ? ModelHoaDon::getHoaDonById($_GET['id']) : null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hóa đơn mua hàng - BAKERY SHOP</title>
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
<div class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Hóa Đơn Mua Hàng</h1>
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-2 text-primary">Thông tin khách hàng</h2>
            <p><b>Họ tên:</b> <?php echo htmlspecialchars($hoadon['tenkhach'] ?? ''); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($hoadon['email'] ?? ''); ?></p>
            <p><b>Địa chỉ:</b> <?php echo htmlspecialchars($hoadon['diachi'] ?? ''); ?></p>
        </div>
        <div>
            <h2 class="text-xl font-semibold mb-2 text-primary">Chi tiết đơn hàng</h2>
            <table class="w-full border-collapse mb-4">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="p-2">Sản phẩm</th>
                        <th class="p-2">Số lượng</th>
                        <th class="p-2">Đơn giá</th>
                        <th class="p-2">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $tong = 0;
                if (!empty($hoadon['chitiet'])):
                    foreach ($hoadon['chitiet'] as $sp):
                        $thanhtien = $sp['dongia'] * $sp['soluong'];
                        $tong += $thanhtien;
                ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo htmlspecialchars($sp['tensanpham']); ?></td>
                        <td class="p-2 text-center"><?php echo $sp['soluong']; ?></td>
                        <td class="p-2 text-right"><?php echo number_format($sp['dongia']); ?>₫</td>
                        <td class="p-2 text-right"><?php echo number_format($thanhtien); ?>₫</td>
                    </tr>
                <?php
                    endforeach;
                else:
                ?>
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 p-4">Không có sản phẩm nào.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right font-bold p-2">Tổng cộng:</td>
                        <td class="text-right font-bold p-2"><?php echo number_format($tong); ?>₫</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center mt-8">
            <a href="mqd1.php" class="inline-block px-6 py-3 bg-primary text-white rounded hover:bg-green-700 transition">Tiếp tục mua hàng</a>
        </div>
    </div>
</div>
</body>
</html>
