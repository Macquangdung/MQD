<?php
    include('../MODEL/modelgd.php');
    $get_data = new data_giangduong();
    if (!isset($_GET['sua'])) {
        echo "Thiếu tham số 'sua' trên URL.";
        exit;
    }
    $select_giangduong_id = $get_data->select_gd_id($_GET['sua']);
    foreach($select_giangduong_id as $i_gd):
?>
   <form method="POST" action="../CONTROLLER/control.php?sua=<?php echo $_GET['sua']?>">
    <table align="center">
   <h2 align="center">ĐĂNG KÝ GIẢNG ĐƯỜNG</h2>
   <tr>
       <td>Giảng đường:</td>
       <td>
           <select name="txtgd">
               <option value="<?php echo $i_gd['giangduong']?>"><?php echo $i_gd['giangduong']?></option>
               <option>--Chọn giảng đường--</option>
               <option value="501">501</option>
               <option value="502">502</option>
               <option value="503">503</option>
               <option value="504">504</option>
           </select>
       </td>
   </tr>
   <tr>
       <td>Giảng viên:</td>
       <td><input type="text" name="txtname" 
       value="<?php echo $i_gd['giaovien']?>"></td>
   </tr>
   <tr>
       <td>Môn dạy:</td>
       <td>
           <select name="txtmonday">
               <option value="<?php echo $i_gd['monday']?>"><?php echo $i_gd['monday']?></option>
               <option>--Chọn môn--</option>
               <option value="Lập trình PHP">Lập trình PHP</option>
               <option value="CSDL SQL">CSDL SQL</option>
           </select>
       </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
           <input type="submit" name="txtsub_update" value="Đăng ký">
       </td>
   </tr>
   </form>
<?php endforeach; ?>
