<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php  
if (isset($_SESSION['ten'])) {  
    echo "<h2>Hello bạn: {$_SESSION['ten']}</h2>  
          <a href='dangxuat.php' style='color:red; margin-left:20px;'>Đăng xuất</a>";
}  
?>
    <a href='select.php' style='color:red; margin-left:20px;'>Giỏ hàng</a>
    <a href="loginn.php">Thêm mới</a>
<table border="1" align="center">
    <tr>
        <th>ID</th>
        <th>username</th>
        <th>Pass</th>
        <th colspan="2">Tùy chọn</th>
    </tr>
    <?php 
    include('../MODEL/model1.php');
    $get_data=new data_user();
    $select=$get_data->select_us();
    foreach($select as $i_gd)
    {
        ?>
        <tr>
            <td><?php echo $i_gd['ID_user']?></td>
            <td><?php echo $i_gd['email']?></td>
            <td><?php echo $i_gd['sdt']?></td>
            <td><a href="updatend.php?sua=<?php echo $i_gd['ID_user']?>">Sửa</a></td>
            <td><a href="../CONTROLLER/control1.php?xoa=<?php echo $i_gd['ID_user']?>" onclick="if(confirm('Bạn có chắc chắn muốn xóa?')) return true; else return false;">Xóa</a></td>
            
        </tr>
    <?php
    }
    ?>
</table>
</body>
</html>
