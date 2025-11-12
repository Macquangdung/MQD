<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($reviews)) {
    include_once '../MODEL/modeldanhgia.php';
    $reviewModel = new data_danhgia();
    $reviews = $reviewModel->getReviews();
}
if (!isset($errors)) $errors = [];
if (!isset($success)) $success = '';
if (!isset($comment)) $comment = '';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đánh giá sản phẩm - BAKERY SHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="dinhdang.css">
    <style>
        body { font-family: 'Geist', sans-serif; }
        .bg-primary { background-color: #8BC34A; }
        .text-primary { color: #8BC34A; }
        .star-yellow { color: #FFD600; }
        .star-gray { color: #d1d5db; }
    </style>
</head>
<body class="bg-stone-50">
<header class="sticky top-0 z-50 w-full border-b bg-white shadow-sm">
  <div class="container mx-auto flex h-16 items-center justify-between px-4">
    <a href="mqd.php" class="flex items-center space-x-2">
      <span class="text-2xl font-bold text-[#8BC34A]">BAKERY SHOP</span>
    </a>
    <nav class="hidden md:flex items-center space-x-8">
      <a href="gioithieu.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Giới thiệu</a>
      <a href="mqd1.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Sản phẩm</a>
      <a href="https://tljus.com/" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Tin tức</a>
      <a href="danhgia.php" class="text-sm font-medium hover:text-[#8BC34A] transition-colors">Đánh giá</a>
    </nav>
  </div>
</header>

<div class="max-w-2xl mx-auto px-4 py-12">
  <div class="bg-white rounded-xl shadow-2xl overflow-hidden mb-8">
    <div class="px-6 py-4 border-b">
      <h5 class="text-2xl font-bold text-center text-gray-800">Đánh giá sản phẩm</h5>
    </div>
    <div class="p-8">
      <?php
      if (!empty($errors)) {
        echo '<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">';
        foreach ($errors as $error) {
          echo '<div>' . htmlspecialchars($error) . '</div>';
        }
        echo '</div>';
      }
      if (!empty($success)) {
        echo '<div class="mb-4 p-3 bg-green-100 text-green-700 rounded">' . htmlspecialchars($success) . '</div>';
      }
      ?>
      <?php if (isset($_SESSION['user'])): ?>
      <form method="post" action="../CONTROLLER/controldanhgia.php" class="space-y-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Tên người dùng</label>
          <input type="text" name="username" maxlength="35" readonly value="<?php echo htmlspecialchars($_SESSION['user']); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Đánh giá sao (1-5)</label>
          <div class="flex items-center space-x-2">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <label>
                <input type="radio" name="rating" value="<?= $i ?>" class="hidden" <?= (isset($_POST['rating']) && $_POST['rating'] == $i) ? 'checked' : '' ?> required>
                <svg class="w-7 h-7 cursor-pointer <?= (isset($_POST['rating']) && $_POST['rating'] >= $i) ? 'star-yellow' : 'star-gray' ?>" fill="currentColor" viewBox="0 0 20 20">
                  <polygon points="10,1 12.59,7.36 19.51,7.64 14.18,12.14 15.82,19.02 10,15.27 4.18,19.02 5.82,12.14 0.49,7.64 7.41,7.36"/>
                </svg>
              </label>
            <?php endfor; ?>
          </div>
        </div>
        <div>
          <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Nội dung đánh giá</label>
          <textarea name="comment" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors"><?php echo isset($comment) ? htmlspecialchars($comment) : ''; ?></textarea>
        </div>
        <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition-colors shadow-md">Gửi đánh giá</button>
      </form>
      <?php else: ?>
        <p class="text-center">Bạn cần <a href="dangnhap.php" class="text-primary font-medium hover:underline">đăng nhập</a> để đánh giá sản phẩm.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
    <div class="px-6 py-4 border-b bg-primary text-white">
      <h5 class="text-xl font-bold">Các đánh giá trước đây</h5>
    </div>
    <div class="p-8">
      <?php if (empty($reviews)): ?>
        <p class="text-gray-500">Chưa có đánh giá nào.</p>
      <?php else: ?>
        <?php foreach ($reviews as $review): ?>
          <div class="border-b pb-4 mb-4">
            <div class="flex justify-between items-center">
              <strong><?php echo htmlspecialchars($review['user']); ?></strong>
              <span class="text-gray-400 text-sm"><?php echo htmlspecialchars($review['created_at']); ?></span>
            </div>
            <div class="flex items-center mt-1">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <svg class="w-5 h-5 <?= ($i <= $review['rating']) ? 'star-yellow' : 'star-gray' ?>" fill="currentColor" viewBox="0 0 20 20">
                  <polygon points="10,1 12.59,7.36 19.51,7.64 14.18,12.14 15.82,19.02 10,15.27 4.18,19.02 5.82,12.14 0.49,7.64 7.41,7.36"/>
                </svg>
              <?php endfor; ?>
              <span class="ml-2 text-gray-500"><?= $review['rating'] ?>/5</span>
            </div>
            <p class="mt-2"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
