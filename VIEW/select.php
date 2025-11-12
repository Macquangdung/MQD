<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="login.php">Thêm mới</a>
<table border="1" align="center">
    <tr>
        <th>ID sản phẩm</th>
        <th>Tên sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá sản phẩm</th>
        <th colspan="2">Tùy chọn</th>
    </tr>
    <?php 
    include('../MODEL/model.php');
    $get_data=new data_sanpham();
    $select=$get_data->select_sp();
    foreach($select as $i_sp)
    {
        ?>
        <tr>
            <td><?php echo $i_sp['ID_sanpham']?></td>
            <td><?php echo $i_sp['tensanpham']?></td>
            <td><?php echo $i_sp['soluong']?></td>
            <td><?php echo $i_sp['dongia']?></td>
            <td><a href="update.php?sua=<?php echo $i_sp['ID_sanpham']?>">Sửa</a></td>
            <td><a href="../CONTROLLER/control.php?xoa=<?php echo $i_sp['ID_sanpham']?>" onclick="if(confirm('Bạn có chắc chắn muốn xóa?')) return true; else return false;">Xóa</a></td>
            <td><a href="muahang.php?mua=<?php echo $i_sp['ID_sanpham']?>">Mua hàng</a></td>
        </tr>
    <?php
    }
    ?>
</table>
</body>
</html>
