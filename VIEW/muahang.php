<?php
session_start();
include('../MODEL/modelmh.php');
$data = new data_muahang();

$id_user = isset($_SESSION['ID_user']) ? $_SESSION['ID_user'] : 1;
$message = '';
$show_message_id = null;

if (isset($_POST['datmua'])) {
    $id_sanpham = intval($_POST['id_sanpham']);
    $soluong_mua = intval($_POST['txtmua']);
    
    // Step 1: Get product information from the database
    $sanpham_hien_tai = $data->select_sanpham_id($id_sanpham);

    if ($sanpham_hien_tai) {
        $so_luong_con = $sanpham_hien_tai[0]['soluong'];
        $dongia = floatval($sanpham_hien_tai[0]['dongia']);
        $tongtien = $dongia * $soluong_mua;

        // Step 2: Check if the quantity is valid
        if ($soluong_mua > 0 && $soluong_mua <= $so_luong_con) {
            // Step 3: Update the product quantity in the database
            $so_luong_moi = $so_luong_con - $soluong_mua;
            $update_soluong = $data->update_soluong($id_sanpham, $so_luong_moi);
            
            if ($update_soluong) {
                // Step 4: Add the order to the `donhang` table
                $insert = $data->insert_donhang($id_user, $id_sanpham, 1, $soluong_mua, $dongia, $tongtien, 'Thành công');

                if ($insert) {
                    $message = 'Đặt hàng thành công!';
                } else {
                    $message = 'Lỗi khi ghi nhận đơn hàng!';
                }
            } else {
                $message = 'Lỗi khi cập nhật số lượng sản phẩm!';
            }
        } else {
            $message = 'Số lượng không hợp lệ hoặc lớn hơn số lượng còn lại!';
        }
    } else {
        $message = 'Không tìm thấy sản phẩm!';
    }
    
    $show_message_id = $id_sanpham;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mua hàng</title>
    <script>
    function tinhTongTien(input, dongia) {
        var soluong = input.value;
        var tongtien = '';
        if (soluong && dongia) {
            tongtien = Number(dongia) * Number(soluong);
        }
        input.form.tongtien.value = tongtien;
    }
    </script>
</head>
<body>
    <h2>Mua hàng</h2>
       <p style="text-align: center; margin-top: 20px;">
    <a href="donhang.php">
        Xem đơn hàng đã đặt
    </a>
</p>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng còn</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
            <th>Thao tác</th>
            <th>Trạng thái</th>
        </tr>
        <?php
        if (isset($_GET['mua']) && !empty($_GET['mua'])) {
            $id_sanpham = intval($_GET['mua']);
            $select = $data->select_sanpham_id($id_sanpham);

            if (!empty($select)) {
                foreach ($select as $se_sp) {
                    echo '<tr>';
                    echo '<td>' . $se_sp['tensanpham'] . '</td>';
                    echo '<td>' . $se_sp['soluong'] . '</td>';
                    echo '<td>' . $se_sp['dongia'] . '</td>';
                    echo '<td>';
                    echo '<form method="post" action="muahang.php?mua=' . $se_sp['ID_sanpham'] . '">';
                    echo '<input type="hidden" name="id_sanpham" value="' . $se_sp['ID_sanpham'] . '" />';
                    echo '<input type="hidden" name="dongia" value="' . $se_sp['dongia'] . '" />';
                    echo '<input type="number" name="txtmua" placeholder="Nhập số lượng" min="1" max="' . $se_sp['soluong'] . '" required oninput="tinhTongTien(this, ' . $se_sp['dongia'] . ')" />';
                    echo '<input type="text" name="tongtien" placeholder="Tổng tiền" readonly style="width:90px;" />';
                    echo '<input type="submit" name="datmua" value="Đặt mua" />';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>';
                    if ($show_message_id == $se_sp['ID_sanpham'] && $message) {
                        echo '<div style="font-weight:bold;color:' . ($message == 'Đặt hàng thành công!' ? 'green' : 'red') . '">' . $message . '</div>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='6'>Không tìm thấy sản phẩm.</td></tr>";
            }
        } else {
            global $conn;
            $sql = "SELECT * FROM sanpham";
            $run = mysqli_query($conn, $sql);
            if ($run && mysqli_num_rows($run) > 0) {
                while ($row = mysqli_fetch_assoc($run)) {
                    echo '<tr>';
                    echo '<td>' . $row['tensanpham'] . '</td>';
                    echo '<td>' . $row['soluong'] . '</td>';
                    echo '<td>' . $row['dongia'] . '</td>';
                    echo '<td></td>';
                    echo '<td><a href="muahang.php?mua=' . $row['ID_sanpham'] . '">Mua</a></td>';
                    echo '<td></td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='6'>Không có sản phẩm nào.</td></tr>";
            }
        }
        ?>
    </table>
    <?php if (isset($_GET['mua'])): ?>
        <p><a href="muahang.php">Quay lại danh sách sản phẩm</a></p>
    <?php endif; ?>
</body>
</html>