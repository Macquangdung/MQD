<?php
include ('connect.php'); 

class data_product

{
    // 🟢 Thêm sản phẩm mới
    public function insert_product($name, $quantity, $image, $category, $date, $price, $description)
    {
        global $conn;
        $sql = "INSERT INTO products(name, quantity, image, category, date, price, description) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        // 'sisssds' - s: string, i: integer, d: double
        mysqli_stmt_bind_param($stmt, "sisssds", $name, $quantity, $image, $category, $date, $price, $description);
        return mysqli_stmt_execute($stmt);
    }

    // 🟢 Lấy tất cả sản phẩm
    public function select_product()
    {
        global $conn;
        $sql = "SELECT * FROM products ORDER BY id DESC";
        $run = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($run)) {
            $data[] = $row;
        }
        return $data;
    }

    // 🟢 Xóa sản phẩm theo ID
    public function delete_product($id)
    {
        global $conn;
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        return mysqli_stmt_execute($stmt);
    }

    // 🟢 Cập nhật sản phẩm
    public function update_product($name, $quantity, $image, $category, $date, $price, $description, $id)
    {
        global $conn;
        $sql = "UPDATE products 
                SET name = ?, quantity = ?, image = ?, category = ?, date = ?, price = ?, description = ?
                WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisssdsi", $name, $quantity, $image, $category, $date, $price, $description, $id);
        return mysqli_stmt_execute($stmt);
    }

    // 🟢 Lấy sản phẩm theo ID
    public function select_product_id($id)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }

    // 🟢 Lấy danh mục theo tên
    public function select_product_name($name)
    {
        global $conn;
        $sql = "SELECT * FROM products WHERE name = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
}
?>
