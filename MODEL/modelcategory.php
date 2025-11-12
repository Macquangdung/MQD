<?php
include ('connect.php'); 

class data_category
{
    // 🟢 Thêm danh mục mới
    public function insert_category($name, $description)
    {
        global $conn;
        $sql = "INSERT INTO category(name, description)
                VALUES ('$name', '$description')";
        $run = mysqli_query($conn, $sql);
        return $run;
    }

    // 🟢 Lấy tất cả danh mục
    public function select_category()
    {
        global $conn;
        $sql = "SELECT * FROM category ORDER BY id DESC";
        $run = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($run)) {
            $data[] = $row;
        }
        return $data;
    }

    // 🟢 Xóa danh mục theo ID
    public function delete_category($id)
    {
        global $conn;
        $sql = "DELETE FROM category WHERE id = $id";
        $run = mysqli_query($conn, $sql);
        return $run;
    }

    // 🟢 Cập nhật danh mục
    public function update_category($name, $description, $id)
    {
        global $conn;
        $sql = "UPDATE category 
                SET name = '$name', description = '$description'
                WHERE id = $id";
        $run = mysqli_query($conn, $sql);
        return $run;
    }

    // 🟢 Lấy danh mục theo ID
    public function select_category_id($id)
    {
        global $conn;
        $sql = "SELECT * FROM category WHERE id = $id";
        $run = mysqli_query($conn, $sql);
        return $run;
    }

    // 🟢 Lấy danh mục theo tên
    public function select_category_name($name)
    {
        global $conn;
        $sql = "SELECT * FROM category WHERE name = '$name'";
        $run = mysqli_query($conn, $sql);
        return $run;
    }
}
?>


