<?php
session_start();
include('../MODEL/model1.php'); 
 $get_data = new data_user();
 if(isset($_POST['login']))
    if(empty($_POST['username']) || empty($_POST['txtpassword']))
    {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin'); window.location.href='../VIEW/loginn.php';</script>";
    }
    else
{
   $log = $get_data->insert_login($_POST['username'], $_POST['txtpassword']);
    $num=mysqli_num_rows($log);
    if($num==1){
       $_SESSION['username']=$_POST['username'];
       $_SESSION['password']=$_POST['txtpassword'];
       $_SESSION['ten']=$_POST['username'];
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
if(isset($_POST['luu']))
{
    if(empty($_POST['ten'])||empty($_POST['email'])||empty($_POST['diachi'])||empty($_POST['sdt'])){
        echo '<script>alert("ban ko du thong tin");
        window.location.href="../view/giaodien.php";
        </script>';
    }
    
    else{
    $in_us = $get_data->insert_us($_POST['ten'], $_POST['email'], $_POST['diachi'], $_POST['sdt']);
    
    if($in_us) echo "<script>alert('Thành công');
    window.location.href='../VIEW/loginn.php';
    </script>";
    else echo "<script>alert('Không thực thi được');</script>";
}}
 ?>

<?php
if(isset($_POST["txtsub_update"])){
    if(empty($_POST["ten"])||empty($_POST["email"])||empty($_POST["diachi"])||empty($_POST["sdt"])){
        echo "ban ko du thong tin";
    }                                   
    else $update_us=$get_data->update_us($_GET["sua"],$_POST['ten'], $_POST['email'], $_POST['diachi'], $_POST['sdt']); 
     
    if($update_us) echo "<script>alert('Cập nhật thanh cong')
    window.location.href='../view/selectgd.php'
        </script>";             
}
?>

<?php
if (isset($_GET['xoa'])) {
    $del=$get_data->dele_us_id($_GET['xoa']);
    if ($del) echo"<script>alert('xoa thanh cong')
    window.location.href='../view/selectgd.php'
        </script>";
    else echo"loi";
    }

?>
<?php
if (isset($_GET['xoamh'])) {
    $del=$get_data->dele_muahang_id($_GET['xoamh']);
    if ($del) echo"<script>alert('xoa thanh cong')
    window.location.href='../view/select_muahang.php'
        </script>";
    else echo"loi";
    }

?>
