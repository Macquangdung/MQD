<?php
include_once('connect.php');

class ModelHoaDon
{
    // Lấy tất cả đơn hàng cho nhân viên
    public static function getAllOrdersForStaff()
    {
        global $conn;
        $sql = "SELECT * FROM hoadon ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $orders = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
        return $orders;
    }

    // Lấy hóa đơn theo id
    public static function getHoaDonById($id)
    {
        global $conn;
        $sql = "SELECT * FROM hoadon WHERE id = " . intval($id);
        $result = mysqli_query($conn, $sql);
        $hoadon = mysqli_fetch_assoc($result);
        // Lấy chi tiết hóa đơn
        $sql_ct = "SELECT c.*, p.tensanpham FROM chitiethoadon c LEFT JOIN products p ON c.id_sanpham = p.ID_sanpham WHERE c.id_hoadon = " . intval($id);
        $result_ct = mysqli_query($conn, $sql_ct);
        $chitiet = [];
        while ($row = mysqli_fetch_assoc($result_ct)) {
            $chitiet[] = $row;
        }
        $hoadon['chitiet'] = $chitiet;
        return $hoadon;
    }

    // Lấy danh sách hóa đơn theo user
    public static function getHoaDonByUser($user)
    {
        global $conn;
        $sql = "SELECT * FROM hoadon WHERE tenkhach = '" . mysqli_real_escape_string($conn, $user) . "' ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        $orders = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $orders[] = $row;
        }
        return $orders;
    }
}
?>
