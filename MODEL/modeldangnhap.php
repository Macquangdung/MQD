<?php
include_once 'connect.php';

class data_user_login
{
    public function get_user_by_username($tendangnhap)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM users WHERE tendangnhap = ?");
        $stmt->bind_param("s", $tendangnhap);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>
