<?php
session_start();
include('../MODEL/modelmh.php');
$data = new data_muahang();

// Kiểm tra xem ID người dùng đã được lưu trong session chưa
if (!isset($_SESSION['ID_user'])) {
    // Nếu không có, thông báo lỗi và không thực hiện thao tác hủy
    $_SESSION['message'] = "Bạn phải đăng nhập để thực hiện thao tác này.";
    $_SESSION['message_type'] = "error";
    header("Location: loginn.php"); // Hoặc trang đăng nhập tùy ý
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_donhang'])) {
    
    $id_donhang = intval($_POST['id_donhang']);
    $id_user = $_SESSION['ID_user']; // Lấy ID_user từ session

    $donhang = $data->select_donhang_by_id_and_user($id_donhang, $id_user);

    if ($donhang) {
        if ($donhang['trangthai'] != 'Đã hủy') {
            $huy_don = $data->huy_donhang($id_donhang);

            if ($huy_don) {
                // ... code hoàn trả số lượng sản phẩm ...
                $so_luong_hoan = $donhang['soluong'];
                $id_sanpham_hoan = $donhang['ID_sanpham'];
                
                $sanpham_hien_tai = $data->select_sanpham_by_id($id_sanpham_hoan);
                
                if ($sanpham_hien_tai) {
                    $so_luong_moi = $sanpham_hien_tai['soluong'] + $so_luong_hoan;
                    $data->update_soluong($id_sanpham_hoan, $so_luong_moi);
                }
                
                $_SESSION['message'] = "Đơn hàng đã được hủy thành công và sản phẩm đã được hoàn vào kho.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Đơn hàng này đã bị hủy trước đó.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Đơn hàng không tồn tại hoặc không thuộc quyền sở hữu của bạn.";
        $_SESSION['message_type'] = "error";
    }
} else {
    $_SESSION['message'] = "Yêu cầu không hợp lệ.";
    $_SESSION['message_type'] = "error";
}

header("Location: donhang.php");
exit();
?>