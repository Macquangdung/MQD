<?php
include ('connect.php'); 
class data_sanpham
{

    public function insert_sp($tensp,$soluong,$giasp)
    {
        global $conn;
        $sql="insert into sanpham(tensanpham,soluong,dongia)
              values ('$tensp','$soluong','$giasp')";
        $run=mysqli_query($conn,$sql);
        return $run;
    }
public function select_sp()
{
    global $conn;
    $sql = "select * from sanpham";
    $run = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($run)) {
        $data[] = $row;
    }
    return $data;
}

public function delete_sp($id){
    global $conn;
    $sql = "delete from sanpham where ID_sanpham = $id";
    $run = mysqli_query($conn, $sql);
    return $run;

}
public function update_sp($tensp,$soluong,$giasp,$id){
    global $conn;
    $sql = "update sanpham set tensanpham = '$tensp', soluong = '$soluong', dongia = '$giasp' where ID_sanpham = $id";
    echo $sql;
    $run = mysqli_query($conn, $sql);
    return $run;
}
public function select_sp_id($id){
    global $conn;
    $sql = "select * from sanpham where ID_sanpham = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
}
public function select_sp_name($name){
    global $conn;
    $sql = "select * from sanpham where tensanpham = '$name'";
    $run = mysqli_query($conn, $sql);
    return $run;
}
}
