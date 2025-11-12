
</head>
<body>
 <?php
    include('../model/model1.php');
    $get_data = new data_user();
    $select_us_id = $get_data->select_us_id($_GET['sua']);
    foreach ($select_us_id as $i_us) 
    ?>
    <form method="POST" action="../CONTROLLER/control1.php?sua=<?php echo $_GET['sua']; ?>">
        <h2 align="center">Cập nhật</h2>
        <table align="center">
        <tr>
            <td>Tên : </td>
            
            <td><input type="text" name="ten" value="<?php echo $i_us['ten'];?>"></td>
        </tr>
        <tr>
            <td>Email: </td>
            
            <td><input type="text" name="email" value="<?php echo $i_us['email'];?>"></td>
        </tr>
        <tr>
            <td>Dia chi: </td>
            
            <td><input type="text" name="diachi" value="<?php echo $i_us['diachi'];?>"></td>
        </tr>
        <tr>
            <td>Sdt: </td>
            
            <td><input type="text" name="sdt" value="<?php echo $i_us['sdt'];?>"></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;"><input type="submit" name="txtsub_update" value="Cap Nhat">
        <a href="selectgd.php">Hiển thị</a></td>
        </tr>
         
        
        
        </table>
        
    </form>
