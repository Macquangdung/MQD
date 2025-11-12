<?php
include ('connect.php'); 
class data_user
{

    public function insert_us($ten,$email,$diachi,$sdt)
    {
        global $conn;
        $sql="insert into user1(ten,email,diachi,sdt)
              values ('$ten','$email','$diachi','$sdt')";
        $run=mysqli_query($conn,$sql);
        return $run;
    }
    public function select_us()
{
    global $conn;
    $sql = "select * from user1";
    $run = mysqli_query($conn, $sql);
    return $run;
}

public function select_us_id($id)
{
    global $conn;
    $sql = "select * from user1 where ID_user = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
}
public function dele_us_id($id){
    global $conn;
    $sql = "delete from user1 where ID_user = $id";
    $run = mysqli_query($conn, $sql);
    return $run;

}
public function update_us($id,$ten,$email,$diachi,$sdt)
{
    global $conn;
    $sql = "update user1 set ten='$ten', email='$email', diachi='$diachi', sdt='$sdt' where ID_user=$id";
    $run = mysqli_query($conn, $sql);
    return $run;
}
public function insert_login($username,$password)
    {
        global $conn;
        $sql="select * from user1 where email='$username' and sdt='$password'";
        $run=mysqli_query($conn,$sql);
        return $run;
    }
public function dele_muahang_id($id){
    global $conn;
    $sql = "delete from sanpham where ID_sanpham = $id";
    $run = mysqli_query($conn, $sql);
    return $run;    
}
}
?>
