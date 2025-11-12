<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: dangnhap.php");
    exit;
}

include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelvouchers.php');

// Load cart from database
$_SESSION['cart'] = GioHang::loadCart();

// Xử lý các thao tác giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'], $_POST['id'])) {
        $id = (int)$_POST['id'];
        foreach ($_SESSION['cart'] as $k => $item) {
            if ($item['id'] === $id) {
                if ($_POST['action'] === 'increase') {
                    $_SESSION['cart'][$k]['qty']++;
                } elseif ($_POST['action'] === 'decrease') {
                    if ($_SESSION['cart'][$k]['qty'] > 1) {
                        $_SESSION['cart'][$k]['qty']--;
                    }
                } elseif ($_POST['action'] === 'remove') {
                    unset($_SESSION['cart'][$k]);
                }
                break;
            }
        }
        // Reset array keys sau khi xóa
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    if (isset($_POST['action']) && $_POST['action'] === 'checkout') {
        // Process cart checkout
        $user_id = $_SESSION['ID_user'] ?? null;
        if (!$user_id) {
            $checkout_error = "Bạn cần đăng nhập để thanh toán.";
        } elseif (empty($_SESSION['cart'])) {
            $checkout_error = "Giỏ hàng của bạn đang trống.";
        } else {
            include_once('../MODEL/modelmuahang.php');
            include_once('../MODEL/modelvouchers.php');
            $muahang = new data_muahang();
            $voucher_model = new data_vouchers();
            $user_vouchers = $voucher_model->get_user_claimed_vouchers($user_id);
            $all_success = true;
            foreach ($_SESSION['cart'] as $item) {
                $product_id = $item['id'];
                $quantity = $item['qty'];
                $dongia = $item['price'];
                $tongtien = $dongia * $quantity;
                $trangthai = "chờ xác nhận";

                // Apply voucher discount if selected
                if (isset($item['voucher_id']) && $item['voucher_id']) {
                    foreach ($user_vouchers as $voucher) {
                        if ($voucher['id'] == $item['voucher_id']) {
                            if ($voucher['type'] == 'percent') {
                                $tongtien -= $tongtien * ($voucher['value'] / 100);
                            } elseif ($voucher['type'] == 'fixed') {
                                $tongtien -= min($voucher['value'], $tongtien);
                            }
                            break;
                        }
                    }
                }

                $result = $muahang->insert_muahang($user_id, $product_id, 1, $quantity, $dongia, $tongtien, $trangthai);
                if (!$result['success']) {
                    $all_success = false;
                    $checkout_error = $result['message'] ?? "Lỗi khi xử lý sản phẩm: " . htmlspecialchars($item['name']);
                    break;
                }
            }
            if ($all_success) {
                // Clear cart after successful checkout
                unset($_SESSION['cart']);
                header("Location: lichsumuahang.php?success=1");
                exit;
            }
        }
    }
    header("Location: giohang.php");
    exit;
}

// Tính tổng tiền với voucher
$total = 0;
$discount = 0;
foreach ($_SESSION['cart'] as $item) {
    $item_total = $item['price'] * $item['qty'];
    if (isset($item['voucher_id']) && $item['voucher_id']) {
        // Fetch voucher details
        include_once('../MODEL/modelvouchers.php');
        $voucher_model = new data_vouchers();
        $vouchers = $voucher_model->get_user_claimed_vouchers($_SESSION['ID_user']);
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
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - BAKERY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.03); }
        .price { color: #e53e3e; font-weight: 600; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to update cart via AJAX
            function updateCart(action, id) {
                fetch('../CONTROLLER/controlcart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        action: action,
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update quantity display
                        const qtyDisplay = document.querySelector(`.qty-display[data-id="${id}"]`);
                        if (qtyDisplay) {
                            qtyDisplay.textContent = data.cart.find(item => item.id == id)?.qty || 0;
                        }

                        // Update cart count in header
                        const cartCount = document.querySelector('.absolute');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }

                        // Update totals
                        const totalPrice = document.getElementById('total-price');
                        if (totalPrice) {
                            totalPrice.textContent = new Intl.NumberFormat('vi-VN').format(data.total_after_discount) + '₫';
                        }

                        // If remove action, remove the item from DOM
                        if (action === 'remove') {
                            const itemElement = document.querySelector(`.qty-display[data-id="${id}"]`).closest('.flex.items-center');
                            if (itemElement) {
                                itemElement.remove();
                            }
                            // Check if cart is empty
                            const cartItems = document.getElementById('cart-items');
                            if (cartItems && cartItems.children.length === 1 && cartItems.children[0].textContent.trim() === 'Giỏ hàng của bạn đang trống.') {
                                // Cart is empty, do nothing or reload page
                            }
                        }

                        // Update decrease button state
                        const decreaseBtn = document.querySelector(`.decrease-qty[data-id="${id}"]`);
                        if (decreaseBtn) {
                            const qty = data.cart.find(item => item.id == id)?.qty || 0;
                            if (qty <= 1) {
                                decreaseBtn.disabled = true;
                                decreaseBtn.style.opacity = '0.5';
                                decreaseBtn.style.cursor = 'not-allowed';
                            } else {
                                decreaseBtn.disabled = false;
                                decreaseBtn.style.opacity = '1';
                                decreaseBtn.style.cursor = 'pointer';
                            }
                        }
                    } else {
                        alert(data.message || 'Có lỗi xảy ra.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi cập nhật giỏ hàng.');
                });
            }

            // Attach event listeners
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('increase-qty')) {
                    e.preventDefault();
                    const id = e.target.getAttribute('data-id');
                    updateCart('increase', id);
                } else if (e.target.classList.contains('decrease-qty')) {
                    e.preventDefault();
                    const id = e.target.getAttribute('data-id');
                    updateCart('decrease', id);
                } else if (e.target.classList.contains('remove-item')) {
                    e.preventDefault();
                    const id = e.target.getAttribute('data-id');
                    if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                        updateCart('remove', id);
                    }
                }
            });
        });
    </script>
</head>
<body class="bg-stone-50">
<header class="sticky top-0 z-50 w-full border-b bg-white shadow-sm">
  <div class="container mx-auto flex h-16 items-center justify-between px-4">
    <a href="mqd.php" class="flex items-center space-x-2">
      <span class="text-2xl font-bold text-[#8BC34A]">BAKERY SHOP</span>
    </a>
    <nav class="hidden md:flex items-center space-x-8">
      <a href="gioithieu.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
      <a href="tintuc.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="dangnhap.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đăng nhập</a>
      <?php else: ?>
        <a href="lichsumuahang.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đơn hàng</a>
        <a href="vouchers.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Voucher</a>
        <a href="dangxuat.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đăng xuất</a>
      <?php endif; ?>
      <a href="danhgia.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
    <a href="?toggle_menu=1" class="md:hidden p-2 hover:bg-gray-100 rounded cursor-pointer">
      <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </a>
    <div class="flex items-center space-x-4">
      <a href="giohang.php" class="p-2 hover:bg-gray-100 rounded-full transition-colors relative inline-block">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-red-500 text-[10px] font-bold text-white flex items-center justify-center">
          <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
        </span>
      </a>
    </div>
  </div>
  <!-- Mobile Menu -->
  <div id="mobile-menu" class="md:hidden bg-white border-t shadow-lg <?php echo isset($_SESSION['mobile_menu_visible']) && $_SESSION['mobile_menu_visible'] ? '' : 'hidden'; ?>">
    <nav class="px-4 py-4 space-y-2">
      <a href="gioithieu.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
      <a href="tintuc.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="dangnhap.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đăng nhập</a>
      <?php else: ?>
        <a href="lichsumuahang.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đơn hàng</a>
        <a href="vouchers.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Voucher</a>
        <a href="dangxuat.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đăng xuất</a>
      <?php endif; ?>
      <a href="danhgia.php" class="block text-sm font-medium text-gray-700 hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
  </div>
</header>

    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-900">Giỏ hàng của bạn</h1>
            <div id="cart-items" class="space-y-6">
                <?php if (empty($_SESSION['cart'])): ?>
                    <div class="text-center text-gray-500">Giỏ hàng của bạn đang trống.</div>
                <?php else: ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                    <div class="flex items-center bg-gray-50 p-4 rounded-lg shadow-sm">
                        <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="w-20 h-20 object-cover rounded-lg mr-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($item['desc']); ?></p>
                            <p class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?>₫</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" class="decrease-qty px-2 py-1 bg-gray-200 rounded" data-id="<?php echo $item['id']; ?>" <?php if ($item['qty'] <= 1) echo 'disabled style="opacity:0.5;cursor:not-allowed"'; ?>>-</button>
                            <span class="qty-display px-3 py-1 bg-white border" data-id="<?php echo $item['id']; ?>"><?php echo $item['qty']; ?></span>
                            <button type="button" class="increase-qty px-2 py-1 bg-gray-200 rounded" data-id="<?php echo $item['id']; ?>">+</button>
                        </div>
                        <button type="button" class="remove-item text-red-500 hover:text-red-700 ml-4" title="Xóa sản phẩm" data-id="<?php echo $item['id']; ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div id="cart-total" class="mt-8 bg-white p-6 rounded-lg shadow-sm">
                <div class="space-y-2">
                    <div class="flex justify-between text-lg">
                        <span>Tổng tiền:</span>
                        <span><?php echo number_format($total, 0, ',', '.'); ?>₫</span>
                    </div>
                    <?php if ($discount > 0): ?>
                    <div class="flex justify-between text-lg text-green-600">
                        <span>Giảm giá:</span>
                        <span>-<?php echo number_format($discount, 0, ',', '.'); ?>₫</span>
                    </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-lg font-semibold border-t pt-2">
                        <span>Tổng cộng:</span>
                        <span id="total-price" class="price"><?php echo number_format($total_after_discount, 0, ',', '.'); ?>₫</span>
                    </div>
                </div>
                <?php if (!empty($_SESSION['cart'])): ?>
                <form method="post">
                    <input type="hidden" name="action" value="checkout">
                    <button type="submit" class="w-full mt-4 bg-primary text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors">
                        Thanh toán
                    </button>
                </form>
                <?php elseif (isset($checkout_error)): ?>
                    <div class="text-red-600 text-center mt-4 font-semibold"><?php echo htmlspecialchars($checkout_error); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="src/media/loo.jpg" alt="Logo" class="w-10 h-10">
                        <span class="text-2xl font-display font-bold">BAKERY SHOP</span>
                    </div>
                    <p class="text-gray-400 mb-4">Nơi bạn có thể tìm thấy những chiếc bánh ngọt ngào, chất lượng và sáng tạo nhất.</p>
                    <div class="flex gap-4">
                        <!-- Social icons here -->
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên Kết Nhanh</h3>
                    <ul class="space-y-2">
                        <li><a href="mqd.php" class="text-gray-400 hover:text-white transition-colors">Trang chủ</a></li>
                        <li><a href="mqd1.php" class="text-gray-400 hover:text-white transition-colors">Sản phẩm</a></li>
                        <li><a href="gioithieu.php" class="text-gray-400 hover:text-white transition-colors">Về chúng tôi</a></li>
                        <li><a href="dangnhap.php" class="text-gray-400 hover:text-white transition-colors">Liên hệ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Danh Mục</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh mì</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh kem</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh ngọt</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Bánh khô</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liên Hệ</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 123 Đường ABC, Quận XYZ</li>
                        <li>📞 1900 1234</li>
                        <li>✉️ info@bakeryshop.com</li>
                        <li>🕒 8:00 - 22:00</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 BAKERY SHOP. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
</footer>
</body>
</html>
