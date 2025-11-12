<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h2 align="center"><a href="muahang.php">Them moi</a></h2>
    <table border="1" align="center">
    <tr>
        <th>Tên sản phẩm</th>
            <th>Số lượng còn</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
        <th colspan="2">Tùy chọn</th>
    </tr>
    <?php
    include('../MODEL/modelmh.php'); 
    $get_data = new data_muahang(); 
    $select = $get_data->select_all_sanpham(); 
    foreach ($select as $i_us) { 
    ?>
     <tr>
        <td><?php echo $i_us['tensanpham']; ?></td>
        <td><?php echo $i_us['soluong']; ?></td>
        <td><?php echo $i_us['dongia']; ?></td>
        <td><?php echo $i_us['soluong'] * $i_us['dongia']; ?></td>
        <td><a href="update.php?sua=<?php echo $i_us['ID_sanpham']; ?>">Sửa</a></td>
        <td><a href="../CONTROLLER/control1.php?xoamh=<?php echo $i_us['ID_sanpham']; ?>"
        onClick="if(confirm('1 di khong tro lai')) return true; return false;">Xóa</a></td>
    </tr>
    <?php } ?>
</table>
</body>
</html>