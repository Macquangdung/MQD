<?php
include ('connect.php'); 
class data_giangduong
{

    public function insert_gd($tengv,$tengd,$tenmd)
    {
        global $conn;
        $sql="insert into giangduong(giaovien,giangduong,monday)
              values ('$tengv','$tengd','$tenmd')";
        $run=mysqli_query($conn,$sql);
        return $run;
    }
    public function select_gd()
{
    global $conn;
    $sql = "select * from giangduong";
    $run = mysqli_query($conn, $sql);
    return $run;
}

public function select_gd_id($id)
{
    global $conn;
    $sql = "select * from giangduong where ID_giangduong = $id";
    $run = mysqli_query($conn, $sql);
    return $run;
}
public function delete_gd($id){
    global $conn;
    $sql = "delete from giangduong where ID_giangduong = $id";
    $run = mysqli_query($conn, $sql);
    return $run;

}
public function update_gd($gd,$gv,$md,$id){
    global $conn;
    $sql = "update giangduong set giangduong = '$gd', giaovien = '$gv', monday = '$md' where ID_giangduong = $id";
    echo $sql;
    $run = mysqli_query($conn, $sql);
    return $run;
}
}