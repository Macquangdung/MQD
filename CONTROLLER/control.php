<?php
include('../MODEL/model.php'); 
 $get_data = new data_sanpham();

if(isset($_GET['txtsub']))
    if(empty($_GET['txtsp']) || empty($_GET['txtsl']) || empty($_GET['txtgia']))
    {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.location.href='../VIEW/login.php';</script>";
    }
    else
{
   $in_sp = $get_data->insert_sp($_GET['txtsp'], $_GET['txtsl'], $_GET['txtgia']);

    if($in_sp) echo "<script>alert('Thành công');
    window.location.href='../VIEW/select.php';
    </script>";
    else echo "<script>alert('Không thực thi được');</script>";
}
?>
<?php
 if(isset($_GET['xoa']))
 {
     $delete = $get_data->delete_sp($_GET['xoa']);
     if($delete) echo "<script>alert('Xóa thành công');
     window.location='../VIEW/select.php';
     </script>";  
    }                                   
    else $update = $get_data->update_sp($_POST["txtsp"], $_POST["txtsl"], $_POST["txtgia"], $_GET["sua"]);
    if($update) echo "<script>alert('Cập nhật thành công'); window.location.href='../VIEW/select.php';</script>";
    else echo "<script>alert('Không thực thi được');</script>";
?>
