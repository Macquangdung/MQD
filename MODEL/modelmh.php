<?php
include('connect.php');

class data_muahang
{
    // Lấy thông tin sản phẩm theo ID
    public function select_sanpham_id($id_sanpham)
    {
        global $conn;
        // Sử dụng prepared statement để tránh SQL Injection và chỉ trả về một kết quả
        $sql = "SELECT * FROM sanpham WHERE ID_sanpham = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    
    // Lấy thông tin một sản phẩm theo ID (trả về một mảng liên kết)
    public function select_sanpham_by_id($id_sanpham)
    {
        global $conn;
        $sql = "SELECT * FROM sanpham WHERE ID_sanpham = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_sanpham);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    
    // Thêm đơn mua hàng mới
    public function insert_muahang($id_user, $id_sanpham, $solanmua, $soluong, $dongia, $tongtien, $trangthai)
    {
        global $conn;
        $sql = "INSERT INTO muahang(ID_user, ID_sanpham, solanmua, soluong, dongia, tongtien, trangthai) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiiiids", $id_user, $id_sanpham, $solanmua, $soluong, $dongia, $tongtien, $trangthai);
        return mysqli_stmt_execute($stmt);
    }
    
    public function select_all_sanpham() {
        global $conn;
        $sql = "SELECT * FROM sanpham";
        $query = mysqli_query($conn, $sql);
        $data = [];
        if ($query) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    public function update_soluong($id_sanpham, $so_luong_moi) {
        global $conn; 
        $sql = "UPDATE sanpham SET soluong = ? WHERE ID_sanpham = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $so_luong_moi, $id_sanpham);
        return mysqli_stmt_execute($stmt);
    }
    
    public function select_donhang_by_user($id_user)
    {
        global $conn;
        $id_user = mysqli_real_escape_string($conn, $id_user);
        
        $sql = "SELECT d.*, s.tensanpham 
                FROM donhang d 
                JOIN sanpham s ON d.ID_sanpham = s.ID_sanpham 
                WHERE d.ID_user = '$id_user' 
                ORDER BY d.ngaydat DESC";
        $run = mysqli_query($conn, $sql);
        $data = [];
        if ($run) {
            while ($row = mysqli_fetch_assoc($run)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    // Thêm đơn hàng mới
    public function insert_donhang($id_user, $id_sanpham, $solanmua, $soluong, $dongia, $tongtien, $trangthai)
    {
        global $conn;
        $id_user = mysqli_real_escape_string($conn, $id_user);
        $id_sanpham = mysqli_real_escape_string($conn, $id_sanpham);
        $solanmua = mysqli_real_escape_string($conn, $solanmua);
        $soluong = mysqli_real_escape_string($conn, $soluong);
        $dongia = mysqli_real_escape_string($conn, $dongia);
        $tongtien = mysqli_real_escape_string($conn, $tongtien);
        $trangthai = mysqli_real_escape_string($conn, $trangthai);
        
        $sql = "INSERT INTO donhang(ID_user, ID_sanpham, solanmua, soluong, dongia, tongtien, trangthai)
                VALUES ('$id_user', '$id_sanpham', '$solanmua', '$soluong', '$dongia', '$tongtien', '$trangthai')";
        $run = mysqli_query($conn, $sql);
        return $run;
    }

    // Hủy đơn hàng (cập nhật trạng thái)
    public function huy_donhang($id_donhang)
    {
        global $conn;
        $id_donhang = mysqli_real_escape_string($conn, $id_donhang);
        $sql = "UPDATE donhang SET trangthai = 'Đã hủy' WHERE ID_donhang = '$id_donhang'";
        return mysqli_query($conn, $sql);
    }

    // Lấy thông tin đơn hàng theo ID và ID người dùng để đảm bảo quyền sở hữu
    public function select_donhang_by_id_and_user($id_donhang, $id_user)
    {
        global $conn;
        $id_donhang = mysqli_real_escape_string($conn, $id_donhang);
        $id_user = mysqli_real_escape_string($conn, $id_user);
        
        $sql = "SELECT * FROM donhang WHERE ID_donhang = '$id_donhang' AND ID_user = '$id_user'";
        $run = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($run);
    }
}
?>
