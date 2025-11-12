<?php
    include('../MODEL/modellg.php');
    $get_data = new data_login();
    if (!isset($_GET['sua'])) {
        echo "Thiếu tham số 'sua' trên URL.";
        exit;
    }
    $select_login_id = $get_data->select_login_id($_GET['sua']);
    foreach($select_login_id as $i_gd):
?>
   <form method="POST" action="../CONTROLLER/controllg.php?sua=<?php echo $_GET['sua']?>">
    <table align="center">
   <h2 align="center">CẬP NHẬT THÔNG TIN ĐĂNG NHẬP</h2>
   <tr>
       <td>ID:</td>
       <td>
           <input type="text" name="txtid" value="<?php echo $i_gd['ID_user']?>" readonly>
       </td>
   </tr>
   <tr>
       <td>Tên đăng nhập:</td>
       <td>
           <input type="text" name="txtusername" value="<?php echo $i_gd['username']?>">
       </td>
   </tr>
   <tr>
       <td>Mật khẩu:</td>
       <td>
           <input type="password" name="txtpassword" value="<?php echo $i_gd['password']?>">
       </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
           <input type="submit" name="txtsub_update" value="Cập nhật">
       </td>
   </tr>
   </form>
<?php endforeach; ?>
