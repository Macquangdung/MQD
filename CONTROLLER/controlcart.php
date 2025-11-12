
















































































































































































<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ.']);
    exit;
}

include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelvouchers.php');

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

if (!$id || !in_array($action, ['increase', 'decrease', 'remove'])) {
    echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
    exit;
}

$userId = $_SESSION['ID_user'];
$cart = GioHang::loadCart();

$found = false;
foreach ($cart as $k => $item) {
    if ($item['id'] === $id) {
        if ($action === 'increase') {
            GioHang::updateItem($id, $item['qty'] + 1);
        } elseif ($action === 'decrease') {
            if ($item['qty'] > 1) {
                GioHang::updateItem($id, $item['qty'] - 1);
            } else {
                echo json_encode(['success' => false, 'message' => 'Số lượng tối thiểu là 1.']);
                exit;
            }
        } elseif ($action === 'remove') {
            GioHang::removeItem($id);
        }
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tìm thấy trong giỏ hàng.']);
    exit;
}

// Reload cart after update
$cart = GioHang::loadCart();

// Tính tổng tiền
$total = 0;
$discount = 0;
foreach ($cart as $item) {
    $item_total = $item['price'] * $item['qty'];
    if (isset($item['voucher_id']) && $item['voucher_id']) {
        $voucher_model = new data_vouchers();
        $vouchers = $voucher_model->get_user_claimed_vouchers($userId);
        foreach ($vouchers as $voucher) {
            if ($voucher['id'] == $item['voucher_id']) {
                if ($voucher['type'] == 'percent') {
                    $discount += $item_total * ($voucher['value'] / 100);
                } elseif ($voucher['type'] == 'fixed') {
                    $discount += min($voucher['value'], $item_total);
                }
                break;
            }
        }
    }
    $total += $item_total;
}
$total_after_discount = $total - $discount;

$cart_count = GioHang::getItemCount();

echo json_encode([
    'success' => true,
    'cart' => $cart,
    'total' => $total,
    'discount' => $discount,
    'total_after_discount' => $total_after_discount,
    'cart_count' => $cart_count
]);
?>
