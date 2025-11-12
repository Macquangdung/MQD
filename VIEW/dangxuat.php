<?php
session_start();
session_unset();
session_destroy();
header("Refresh: 2; url=dangnhap.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng xuất - BAKERY SHOP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dinhdang.css">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
    </style>
</head>
<body class="bg-stone-50">
    <div class="max-w-md mx-auto px-4 py-24">
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden text-center p-10">
            <h2 class="text-2xl font-bold mb-4 text-primary">Bạn đã đăng xuất thành công!</h2>
            <p class="mb-6 text-gray-700">Cảm ơn bạn đã sử dụng hệ thống.<br>Chuyển về trang đăng nhập sau 2 giây...</p>
            <a href="dangnhap.php" class="inline-block mt-2 px-6 py-3 bg-primary text-white rounded hover:bg-green-700 transition">Đăng nhập lại</a>
        </div>
    </div>
</body>
</html>
