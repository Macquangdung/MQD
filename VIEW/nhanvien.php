<?php
session_start();
include_once('../MODEL/modeladmin.php');
$adminModel = new data_admin();
$ds_nhanvien = $adminModel->get_all_staff();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên - BAKERY SHOP</title>
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
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-2xl overflow-hidden p-8">
        <h1 class="text-3xl font-bold text-center text-primary mb-8">Quản Lý Nhân Viên</h1>
        <div>
            <table class="w-full border-collapse mb-4">
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="p-2">Tên đăng nhập</th>
                        <th class="p-2">Họ tên</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Chức vụ</th>
                        <th class="p-2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($ds_nhanvien)): ?>
                    <?php foreach ($ds_nhanvien as $nv): ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo htmlspecialchars($nv['tendangnhap']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($nv['hoten']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($nv['email']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($nv['chucvu']); ?></td>
                        <td class="p-2">
                            <a href="sua_nhanvien.php?id=<?php echo $nv['id']; ?>" class="inline-block px-3 py-1 bg-primary text-white rounded hover:bg-green-700 transition">Sửa</a>
                            <a href="xoa_nhanvien.php?id=<?php echo $nv['id']; ?>" class="inline-block px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700 transition" onclick="return confirm('Xóa nhân viên này?')">Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 p-4">Chưa có nhân viên nào.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
