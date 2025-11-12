<?php
include('../MODEL/modellg.php'); 
 $get_data = new data_login();
if(isset($_GET['login']))
    if(empty($_GET['username']) || empty($_GET['txtpassword']))
    {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.location.href='../VIEW/loginn.php';</script>";
    }
    else
{
   $in_sp = $get_data->insert_login($_GET['username'], $_GET['txtpassword']);
    $num=mysqli_num_rows($log);
    if($num==1){
       $_SESSION['username']=$_GET['username'];
         echo "<script>alert('Đăng nhập thành công');
        window.location.href='../VIEW/select_login.php';
        </script>";
    }
    else{
        echo "<script>alert('Đăng nhập thất bại');
        window.location.href='../VIEW/loginn.php';
        </script>";
    }
}
?>
<?php
 if(isset($_GET['xoa']))
 {
     $delete = $get_data->delete_login($_GET['xoa']);
     if($delete) echo "<script>alert('Xóa thành công');
     window.location='../VIEW/select_login.php';
     </script>";  
    }                                   
    else $update = $get_data->update_login($_POST["username"], $_POST["txtpassword"], $_GET["sua"]);
    if($update) echo "<script>alert('Cập nhật thành công'); window.location.href='../VIEW/select_login.php';</script>";
    else echo "<script>alert('Không thực thi được');</script>";
?>
