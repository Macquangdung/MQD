<?php
include_once 'connect.php';

class data_danhgia
{
    public function addReview($username, $comment, $rating)
    {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO danhgia (user, comment, rating) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $comment, $rating);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function getReviews()
    {
        global $conn;
        $stmt = $conn->prepare("SELECT user, comment, rating, created_at FROM danhgia ORDER BY created_at DESC");
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        $stmt->close();
        return $reviews;
    }

    // Lấy đánh giá theo sản phẩm và user
    public function getReviewByProductAndUser($product_id, $username)
    {
        global $conn;
        $stmt = $conn->prepare("SELECT comment, rating, created_at FROM danhgia WHERE ID_sanpham = ? AND user = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("is", $product_id, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $review = $result->fetch_assoc();
        $stmt->close();
        return $review;
    }
}
?>
