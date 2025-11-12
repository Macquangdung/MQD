<?php
include('../MODEL/modelgd.php'); 
 $get_data = new data_giangduong();

if(isset($_GET['txtsub']))
{
   $in_gd = $get_data->insert_gd($_GET['txtname'], $_GET['txtgd'], $_GET['txtmonday']);

    if($in_gd) echo "<script>alert('Thành công');
    window.location.href='../VIEW/gd_select.php';
    </script>";
    else echo "<script>alert('Không thực thi được');</script>";
}
?>
<?php
 if(isset($_GET['xoa']))
 {
     $delete = $get_data->delete_gd($_GET['xoa']);
     if($delete) echo "<script>alert('Xóa thành công');
     window.location='../VIEW/gd_select.php';
     </script>";  
    }                                   
    else $update = $get_data->update_gd($_POST["txtgd"], $_POST["txtname"], $_POST["txtmonday"], $_GET["sua"]);
    if($update) echo "<script>alert('Cập nhật thành công'); window.location.href='../VIEW/gd_select.php';</script>";
    else echo "<script>alert('Không thực thi được');</script>";
?>
