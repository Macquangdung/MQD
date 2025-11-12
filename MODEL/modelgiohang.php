<?php
include('connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class GioHang {
    private static function getUserId() {
        return isset($_SESSION['ID_user']) ? $_SESSION['ID_user'] : null;
    }

    public static function loadCart() {
        $userId = self::getUserId();
        if (!$userId) return [];

        global $conn;
        $stmt = $conn->prepare("SELECT c.*, p.tensanpham, p.dongia, p.mota, p.hinhanh FROM cart c JOIN products p ON c.product_id = p.ID_sanpham WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];
        while ($row = $result->fetch_assoc()) {
            $cart[] = [
                'id' => $row['product_id'],
                'name' => $row['tensanpham'],
                'desc' => $row['mota'],
                'img' => 'src/media/' . ($row['hinhanh'] ?: '1.jpg'),
                'price' => $row['dongia'],
                'qty' => $row['quantity'],
                'selected' => $row['selected']
            ];
        }
        return $cart;
    }

    public static function addItem($productId, $quantity) {
        $userId = self::getUserId();
        if (!$userId) return false;

        global $conn;
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, selected) VALUES (?, ?, ?, 1) ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);
        return $stmt->execute();
    }

    public static function removeItem($productId) {
        $userId = self::getUserId();
        if (!$userId) return false;

        global $conn;
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $userId, $productId);
        return $stmt->execute();
    }

    public static function updateItem($productId, $quantity) {
        $userId = self::getUserId();
        if (!$userId) return false;

        if ($quantity <= 0) {
            return self::removeItem($productId);
        }

        global $conn;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $quantity, $userId, $productId);
        return $stmt->execute();
    }

    public static function toggleSelect($productId, $selected = true) {
        $userId = self::getUserId();
        if (!$userId) return false;

        global $conn;
        $stmt = $conn->prepare("UPDATE cart SET selected = ? WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("iii", $selected, $userId, $productId);
        return $stmt->execute();
    }

    public static function getSelectedItems() {
        $userId = self::getUserId();
        if (!$userId) return [];

        global $conn;
        $stmt = $conn->prepare("SELECT c.*, p.tensanpham, p.dongia, p.mota, p.hinhanh FROM cart c JOIN products p ON c.product_id = p.ID_sanpham WHERE c.user_id = ? AND c.selected = 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];
        while ($row = $result->fetch_assoc()) {
            $cart[$row['product_id']] = [
                'quantity' => $row['quantity'],
                'selected' => $row['selected']
            ];
        }
        return $cart;
    }

    public static function deleteSelected() {
        $userId = self::getUserId();
        if (!$userId) return false;

        global $conn;
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND selected = 1");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public static function getItems() {
        $userId = self::getUserId();
        if (!$userId) return [];

        global $conn;
        $stmt = $conn->prepare("SELECT c.*, p.tensanpham, p.dongia, p.mota, p.hinhanh FROM cart c JOIN products p ON c.product_id = p.ID_sanpham WHERE c.user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart = [];
        while ($row = $result->fetch_assoc()) {
            $cart[$row['product_id']] = [
                'quantity' => $row['quantity'],
                'selected' => $row['selected']
            ];
        }
        return $cart;
    }

    public static function getItemCount() {
        $userId = self::getUserId();
        if (!$userId) return 0;

        global $conn;
        $stmt = $conn->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'] ?: 0;
    }

    public static function clearCart() {
        $userId = self::getUserId();
        if (!$userId) return false;

        global $conn;
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }
}
?>
