<?php
include 'MODEL/connect.php';
global $conn;

$sql = "CREATE TABLE IF NOT EXISTS user_points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points DECIMAL(10,2) NOT NULL,
    transaction_type VARCHAR(50) NOT NULL,
    description VARCHAR(255),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(ID_user) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "user_points table created successfully<br>";
} else {
    echo "Error creating user_points table: " . $conn->error . "<br>";
}

$sql_cart = "CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    selected BOOLEAN DEFAULT TRUE,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(ID_user) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(ID_sanpham) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
)";

if ($conn->query($sql_cart) === TRUE) {
    echo "cart table created successfully<br>";
} else {
    echo "Error creating cart table: " . $conn->error . "<br>";
}

$conn->close();
?>
