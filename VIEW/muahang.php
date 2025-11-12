<?php
session_start();
include_once('../MODEL/modelmqd1.php');
include_once('../CONTROLLER/controlmuahang.php');
$model = new data_mqd1();
$ds_sanpham = $model->select_all_sanpham();
if (!isset($errors)) $errors = [];
if (!isset($success)) $success = '';

// Handle direct purchase from chitiet.php
if (isset($_GET['mua']) && is_numeric($_GET['mua'])) {
    $product_id = (int)$_GET['mua'];
    $user_id = $_SESSION['ID_user'] ?? null;

    if (!$user_id) {
        $errors[] = "Bạn cần đăng nhập để mua hàng.";
    } else {
        $product = $model->getProductById($product_id);
        if (!$product) {
            $errors[] = "Sản phẩm không tồn tại.";
        } else {
            $quantity = 1; // Default quantity for direct purchase
            $dongia = $product['dongia'];
            $tongtien = $dongia * $quantity;
            $trangthai = "chờ xác nhận";

            // Check for voucher in POST parameter (from chitiet.php buy now)
            $voucher_id = isset($_POST['voucher']) && !empty($_POST['voucher']) ? intval($_POST['voucher']) : null;
            if ($voucher_id) {
                // Fetch voucher details and apply discount
                include_once('../MODEL/modelvouchers.php');
                $voucher_model = new data_vouchers();
                $vouchers = $voucher_model->get_user_claimed_vouchers($user_id);
                foreach ($vouchers as $voucher) {
                    if ($voucher['id'] == $voucher_id) {
                        if ($voucher['type'] == 'percent') {
                            $tongtien -= $tongtien * ($voucher['value'] / 100);
                        } elseif ($voucher['type'] == 'fixed') {
                            $tongtien -= min($voucher['value'], $tongtien);
                        }
                        break;
                    }
                }
            }

            $muahang = new data_muahang();
            $result = $muahang->insert_muahang($user_id, $product_id, 1, $quantity, $dongia, $tongtien, $trangthai);

            if ($result['success']) {
                header("Location: lichsumuahang.php?success=1");
                exit;
            } else {
                $errors[] = $result['message'] ?? "Đặt hàng thất bại.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Mua hàng - BAKERY SHOP</title>
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
<div class="max-w-md mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h1 class="text-2xl font-bold text-center text-primary">Mua Hàng</h1>
        </div>
        <div class="p-8">
            <?php
            if (!empty($errors)) {
                echo '<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">';
                foreach ($errors as $error) {
                    echo '<div>' . htmlspecialchars($error) . '</div>';
                }
                echo '</div>';
            }
            if (!empty($success)) {
                echo '<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">' . htmlspecialchars($success) . '</div>';
            }
            ?>
            <form method="post" action="" class="space-y-6">
                <div>
                    <label for="ten" class="block text-sm font-medium text-gray-700 mb-1">Họ tên:</label>
                    <input type="text" id="ten" name="ten" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($ten) ? htmlspecialchars($ten) : ''; ?>">
                </div>
                <div>
                    <label for="diachi" class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ:</label>
                    <input type="text" id="diachi" name="diachi" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($diachi) ? htmlspecialchars($diachi) : ''; ?>">
                </div>
                <div>
                    <label for="sdt" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại:</label>
                    <input type="text" id="sdt" name="sdt" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors" value="<?php echo isset($sdt) ? htmlspecialchars($sdt) : ''; ?>">
                </div>
                <div>
                    <label for="sanpham" class="block text-sm font-medium text-gray-700 mb-1">Sản phẩm:</label>
                    <select id="sanpham" name="sanpham" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                        <option value="">-- Chọn sản phẩm --</option>
                        <?php foreach ($ds_sanpham as $sp): ?>
                            <option value="<?php echo $sp['ID_sanpham']; ?>" <?php echo (isset($sanpham) && $sanpham == $sp['ID_sanpham']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($sp['tensanpham']); ?> (<?php echo number_format($sp['dongia']); ?>₫)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="soluong" class="block text-sm font-medium text-gray-700 mb-1">Số lượng:</label>
                    <input type="number" id="soluong" name="soluong" min="1" value="<?php echo isset($soluong) ? (int)$soluong : 1; ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors">
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-md">Đặt hàng</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
