<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
    <h2 align="center"><a href="giaodien.php">Them moi</a></h2>
    <table border="1" align="center">
    <tr>
        <th>Tên :</th>
        <th>Email:</th>
        <th>Địa chỉ:</th>
        <th>Sdt:</th>
        <th colspan="2">Tùy chọn</th>
    </tr>
    <?php
    include('../MODEL/model1.php'); 
    $get_data = new data_user(); 
    $select = $get_data->select_us(); 
    foreach ($select as $i_us) { 
    ?>
    <tr>
        <td><?php echo $i_us['ten']; ?></td>
        <td><?php echo $i_us['email']; ?></td>
        <td><?php echo $i_us['diachi']; ?></td>
        <td><?php echo $i_us['sdt']; ?></td>
        <td><a href="updatend.php?sua=<?php echo $i_us['ID_user']; ?>">Sửa</a></td>
        <td><a href="../CONTROLLER/control1.php?xoa=<?php echo $i_us['ID_user']; ?>" 
        onClick="if(confirm('1 di khong tro lai')) return true; return false;">Xóa</a></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>