<?php
session_start();
include_once('../MODEL/modelgiohang.php');
include_once('../MODEL/modelmqd1.php'); // For product details

$cartItems = GioHang::getItems();
?>

<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Giỏ hàng</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    body { background-color: #f0f2f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
    .cart-item { display: flex; align-items: center; padding: 12px 16px; border-bottom: 1px solid #e5e5e5; background: white; }
    .cart-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; margin-right: 12px; }
    .cart-details { flex: 1; }
    .cart-details h6 { margin: 0 0 4px; font-size: 14px; color: #000; }
    .cart-details p { margin: 0 0 4px; font-size: 12px; color: #666; }
    .quantity-input { width: 80px; border: 1px solid #ddd; border-radius: 4px; text-align: center; }
    .subtotal { font-weight: bold; color: #000; font-size: 16px; }
    .bottom-bar { position: fixed; bottom: 0; left: 0; right: 0; background: white; border-top: 1px solid #e5e5e5; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; z-index: 1000; }
    .select-all { font-size: 14px; }
    .total-selected { font-weight: bold; color: #000; }
    .btn-delete { background: #ff4d4f; color: white; border: none; border-radius: 4px; padding: 8px 16px; font-size: 14px; }
    .btn-checkout { background: #00b14b; color: white; border: none; border-radius: 4px; padding: 12px 24px; font-size: 16px; font-weight: bold; }
    .empty-cart { text-align: center; padding: 40px; color: #666; }
    @media (max-width: 768px) { .bottom-bar { padding: 12px; } .cart-item { padding: 12px; } }
  </style>
</head>
<body>
  <div class="container-fluid p-3">
    <h2 class="mb-3">Giỏ hàng của bạn (<?= count($cartItems) ?> sản phẩm)</h2>
    <?php if (isset($_GET['message'])): ?>
      <div class="alert alert-info"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>
    <?php if (empty($cartItems)): ?>
      <div class="empty-cart">
        <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
        <p>Giỏ hàng của bạn đang trống.</p>
        <a href="mqd1.php" class="btn btn-primary">Tiếp tục mua hàng</a>
      </div>
    <?php else: ?>
      <div id="cartList">
        <?php foreach ($cartItems as $productId => $item): 
          $dataModel = new data_mqd1();
          $product = $dataModel->getProductById($productId);
          if (!$product) continue;
          $isSelected = isset($item['selected']) ? $item['selected'] : true;
          $itemTotal = $product['dongia'] * $item['quantity'];
        ?>
          <div class="cart-item" data-product-id="<?= $productId ?>">
            <div class="form-check me-3">
              <input class="form-check-input cart-checkbox" type="checkbox" id="select<?= $productId ?>" <?= $isSelected ? 'checked' : '' ?> onchange="toggleItem(this, <?= $productId ?>)">
              <label class="form-check-label" for="select<?= $productId ?>"></label>
            </div>
            <img src="../media/<?= htmlspecialchars($product['hinhanh'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($product['tensanpham']) ?>">
            <div class="cart-details">
              <h6><?= htmlspecialchars($product['tensanpham']) ?></h6>
              <p class="mb-2"><?= number_format($product['dongia'], 0, ',', '.') ?> VND</p>
              <div class="d-flex align-items-center">
                <label class="me-2">Số lượng:</label>
                <input type="number" class="quantity-input" value="<?= $item['quantity'] ?>" min="1" max="<?= $product['soluong'] ?>" onchange="updateQuantity(<?= $productId ?>, this.value, <?= $product['dongia'] ?>)">
                <span class="ms-3 subtotal"><?= number_format($itemTotal, 0, ',', '.') ?> VND</span>
              </div>
            </div>
            <div class="ms-auto">
              <a href="../CONTROLLER/controlgiohang.php?action=remove&id_sanpham=<?= $productId ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xóa sản phẩm này?')">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="bottom-bar">
        <div class="d-flex align-items-center">
          <div class="form-check me-3">
            <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleAll(this.checked)" <?= count($cartItems) > 0 ? 'checked' : '' ?>>
            <label class="form-check-label select-all" for="selectAll">Chọn tất cả (<?= count($cartItems) ?>)</label>
          </div>
        </div>
        <div class="d-flex align-items-center">
          <span class="total-selected me-3">Tổng thanh toán: <span id="selectedTotal">0</span> VND</span>
          <button class="btn-delete me-2" onclick="deleteSelected()" id="deleteBtn" style="display: none;">Xóa</button>
          <button class="btn-checkout" onclick="buySelected()" id="checkoutBtn">Mua hàng (0)</button>
        </div>
      </div>
      <div style="height: 80px;"></div> <!-- Spacer for fixed bottom bar -->
    <?php endif; ?>
  </div>

  <script>
    let selectedItems = <?= json_encode(array_map(function($item) { return isset($item['selected']) ? $item['selected'] : true; }, $cartItems)) ?>;
    let totalPrice = 0;
    let productPrices = <?= json_encode(array_map(function($productId, $item) { 
      $dataModel = new data_mqd1();
      $product = $dataModel->getProductById($productId);
      return $product ? $product['dongia'] : 0;
    }, array_keys($cartItems), $cartItems)) ?>;

    function updateTotal() {
      totalPrice = 0;
      let count = 0;
      document.querySelectorAll('.cart-checkbox:checked').forEach((cb, index) => {
        const productId = parseInt(cb.closest('.cart-item').dataset.productId);
        const qtyInput = cb.closest('.cart-item').querySelector('.quantity-input');
        const qty = parseInt(qtyInput.value) || 1;
        totalPrice += (productPrices[index] || 0) * qty;
        count++;
      });
      document.getElementById('selectedTotal').textContent = totalPrice.toLocaleString('vi-VN');
      document.getElementById('checkoutBtn').textContent = `Mua hàng (${count})`;
      document.getElementById('deleteBtn').style.display = count > 0 ? 'inline-block' : 'none';
      document.getElementById('checkoutBtn').disabled = count === 0;
    }

    function toggleItem(checkbox, productId) {
      // AJAX to toggle select
      const formData = new FormData();
      formData.append('productId', productId);
      formData.append('selected', checkbox.checked);
      fetch('../CONTROLLER/controlgiohang.php?action=toggle_select', {
        method: 'POST',
        body: formData
      }).then(() => {
        selectedItems[productId] = checkbox.checked;
        updateTotal();
      });
      updateTotal();
    }

    function updateQuantity(productId, quantity, price) {
      const formData = new FormData();
      formData.append('quantities[' + productId + ']', quantity);
      fetch('../CONTROLLER/controlgiohang.php?action=update', {
        method: 'POST',
        body: formData
      }).then(() => {
        // Update subtotal
        const item = document.querySelector(`[data-product-id="${productId}"]`);
        const subtotal = item.querySelector('.subtotal');
        subtotal.textContent = (price * quantity).toLocaleString('vi-VN') + ' VND';
        updateTotal();
      });
    }

    function toggleAll(checked) {
      document.querySelectorAll('.cart-checkbox').forEach(cb => {
        if (cb.checked !== checked) {
          cb.checked = checked;
          toggleItem(cb, parseInt(cb.closest('.cart-item').dataset.productId));
        }
      });
    }

    function deleteSelected() {
      if (confirm('Xóa các sản phẩm được chọn?')) {
        window.location.href = '../CONTROLLER/controlgiohang.php?action=delete_selected';
      }
    }

    function buySelected() {
      if (document.querySelectorAll('.cart-checkbox:checked').length === 0) {
        alert('Vui lòng chọn sản phẩm để mua.');
        return;
      }
      if (confirm('Xác nhận mua các sản phẩm được chọn?')) {
        window.location.href = '../CONTROLLER/controlgiohang.php?action=buy_selected';
      }
    }

    // Initial load
    document.addEventListener('DOMContentLoaded', updateTotal);
  </script>
</body>
</html>
,