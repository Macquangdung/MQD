<?php
session_start();
include('../MODEL/modelmh.php');
$data = new data_muahang();

$id_user = isset($_SESSION['ID_user']) ? $_SESSION['ID_user'] : 1; 

$donhang_cua_toi = $data->select_donhang_by_user($id_user);

if (isset($_SESSION['message'])) {
    $color = ($_SESSION['message_type'] == "success") ? "green" : "red";
    echo '<p style="color: ' . $color . '; font-weight: bold; text-align: center;">' . $_SESSION['message'] . '</p>';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng đã đặt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 80%; border-collapse: collapse; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 align="center">Đơn hàng của tôi</h2>
    <table align="center">
        <tr>
            <th>ID Đơn hàng</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
        </tr>
        <?php
        if (!empty($donhang_cua_toi)) {
            foreach ($donhang_cua_toi as $donhang) {
        ?>
        <tr>
            <td><?php echo $donhang['ID_donhang']; ?></td>
            <td><?php echo $donhang['tensanpham']; ?></td>
            <td><?php echo $donhang['soluong']; ?></td>
            <td><?php echo $donhang['dongia']; ?></td>
            <td><?php echo $donhang['tongtien']; ?></td>
            <td><?php echo $donhang['trangthai']; ?></td>
            <td>
                <?php if ($donhang['trangthai'] != 'Đã hủy'): ?>
                <form method="post" action="xulyhuy.php">
                    <input type="hidden" name="id_donhang" value="<?php echo $donhang['ID_donhang']; ?>" />
                    <input type="submit" value="Hủy" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');" />
                </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='7' align='center'>Bạn chưa đặt mua sản phẩm nào.</td></tr>";
        }
        ?>
    </table>
    <p align="center"><a href="muahang.php">Tiếp tục mua sắm</a></p>
</body>
</html>