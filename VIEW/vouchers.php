<?php
include('../CONTROLLER/controlvouchers.php');
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voucher của tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .voucher-item { display: flex; align-items: center; padding: 12px 16px; border-bottom: 1px solid #e5e5e5; background: white; }
        .voucher-item img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; margin-right: 12px; }
        .voucher-details { flex: 1; }
        .voucher-details h6 { margin: 0 0 4px; font-size: 14px; color: #000; }
        .voucher-details p { margin: 0 0 4px; font-size: 12px; color: #666; }
        .btn-claim { background: #00b14b; color: white; border: none; border-radius: 4px; padding: 8px 16px; font-size: 14px; font-weight: bold; }
        .claimed-item { opacity: 0.7; }
        .invalid-voucher { background-color: #f8f9fa; }
        .invalid-voucher .voucher-details p { color: #dc3545; }
        .empty-vouchers { text-align: center; padding: 40px; color: #666; }
        @media (max-width: 768px) { .voucher-item { padding: 12px; } }
    </style>
</head>
<body>
    <div class="container-fluid p-3">
        <h2 class="mb-3">Voucher của bạn</h2>
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'thành công') !== false ? 'alert-success' : 'alert-danger' ?> text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <!-- Available vouchers -->
        <h4 class="mb-3">Voucher có sẵn để nhận</h4>
        <?php if (!empty($available_vouchers)): ?>
            <div id="availableVouchers">
                <?php foreach ($available_vouchers as $voucher): ?>
                    <div class="voucher-item">
                        <i class="fas fa-ticket-alt fa-3x text-success me-3"></i>
                        <div class="voucher-details">
                            <h6>Mã: <?= htmlspecialchars($voucher['code']) ?></h6>
                            <p>Giảm: <?= $voucher['type'] == 'percent' ? $voucher['value'] . '%' : number_format($voucher['value'], 0, ',', '.') . ' VND' ?></p>
                            <p>Đơn tối thiểu: <?= number_format($voucher['min_order'], 0, ',', '.') ?> VND</p>
                            <p>Hết hạn: <?= $voucher['expiry_date'] ? date('d/m/Y', strtotime($voucher['expiry_date'])) : 'Không hạn' ?></p>
                            <p>Áp dụng cho: <?= $voucher['applicable_to'] == 'order' ? 'Đơn hàng' : 'Sản phẩm cụ thể' ?></p>
                        </div>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="voucher_code" value="<?= htmlspecialchars($voucher['code']) ?>">
                            <button type="submit" name="claim_voucher" class="btn-claim">Nhận voucher</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-vouchers">
                <i class="fas fa-ticket-alt fa-3x mb-3 text-muted"></i>
                <p>Không có voucher nào có sẵn để nhận.</p>
            </div>
        <?php endif; ?>

        <!-- Claimed vouchers -->
        <h4 class="mb-3 mt-5">Voucher đã nhận</h4>
        <?php if (!empty($claimed_vouchers)): ?>
            <div id="claimedVouchers">
                <?php foreach ($claimed_vouchers as $voucher):
                    // Sửa logic: nếu expiry_date rỗng, "0000-00-00" hoặc "30/11/-0001" thì không hết hạn
                    $expiry_date = isset($voucher['expiry_date']) ? $voucher['expiry_date'] : '';
                    $is_expired = false;
                    if ($expiry_date && $expiry_date !== '0000-00-00' && $expiry_date !== '30/11/-0001') {
                        $is_expired = (strtotime($expiry_date) < strtotime(date('Y-m-d')));
                    }
                    $is_out_of_uses = (isset($voucher['max_uses']) && $voucher['max_uses'] > 0 && isset($voucher['uses_count']) && $voucher['uses_count'] >= $voucher['max_uses']);
                    $invalid = $is_expired || $is_out_of_uses;
                ?>
                    <div class="voucher-item <?= $invalid ? 'invalid-voucher' : 'claimed-item' ?>">
                        <i class="fas fa-ticket-alt fa-3x <?= $invalid ? 'text-muted' : 'text-primary' ?> me-3"></i>
                        <div class="voucher-details">
                            <h6>Mã: <?= htmlspecialchars($voucher['code']) ?></h6>
                            <p>Giảm: <?= $voucher['type'] == 'percent' ? $voucher['value'] . '%' : number_format($voucher['value'], 0, ',', '.') . ' VND' ?></p>
                            <p>Đơn tối thiểu: <?= number_format($voucher['min_order'], 0, ',', '.') ?> VND</p>
                            <p>Hết hạn: <?= $voucher['expiry_date'] ? date('d/m/Y', strtotime($voucher['expiry_date'])) : 'Không hạn' ?></p>
                            <p>Ngày nhận: <?= date('d/m/Y H:i', strtotime($voucher['claimed_at'])) ?></p>
                            <p>Áp dụng cho: <?= $voucher['applicable_to'] == 'order' ? 'Đơn hàng' : 'Sản phẩm cụ thể' ?></p>
                            <?php if ($invalid): ?>
                                <p class="text-danger fw-bold">Voucher không hợp lệ</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-vouchers">
                <i class="fas fa-ticket-alt fa-3x mb-3 text-muted"></i>
                <p>Bạn chưa nhận voucher nào.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
