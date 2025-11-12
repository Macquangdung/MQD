<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($reviews)) {
    include_once '../MODEL/modeldanhgia.php';
    $reviewModel = new data_danhgia();
    $reviews = $reviewModel->getReviews();
}

if (!isset($errors)) {
    $errors = [];
}

if (!isset($success)) {
    $success = '';
}

if (!isset($comment)) {
    $comment = '';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <title>Đánh giá sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h4>Đánh giá sản phẩm</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger"><ul>';
                        foreach ($errors as $error) {
                            echo '<li>' . htmlspecialchars($error) . '</li>';
                        }
                        echo '</ul></div>';
                    }
                    if (!empty($success)) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($success) . '</div>';
                    }
                    ?>
                    <?php if (isset($_SESSION['user'])): ?>
                    <form method="post" action="../CONTROLLER/controldanhgia.php">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên người dùng</label>
                            <input type="text" class="form-control" name="username" maxlength="35" readonly value="<?php echo htmlspecialchars($_SESSION['user']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Đánh giá sao (1-5)</label>
                            <div class="d-flex justify-content-center star-rating" id="starRating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <label class="star mx-1" data-value="<?= $i ?>">
                                        <i class="fas fa-star <?= ($i <= (isset($_POST['rating']) ? intval($_POST['rating']) : 0)) ? 'text-warning' : 'text-muted' ?>"></i>
                                        <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" <?= (isset($_POST['rating']) && $_POST['rating'] == $i) ? 'checked' : '' ?> style="display: none;" required>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Nội dung đánh giá</label>
                            <textarea class="form-control" name="comment" rows="4" required><?php echo isset($comment) ? htmlspecialchars($comment) : ''; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Gửi đánh giá</button>
                    </form>
                    <?php else: ?>
                        <p class="text-center">Bạn cần <a href="dangnhap.php">đăng nhập</a> để đánh giá sản phẩm.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5>Các đánh giá trước đây</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($reviews)): ?>
                        <p class="text-muted">Chưa có đánh giá nào.</p>
                    <?php else: ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="border-bottom mb-3 pb-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong><?php echo htmlspecialchars($review['user']); ?></strong>
                                    <small class="text-muted"><?php echo htmlspecialchars($review['created_at']); ?></small>
                                </div>
                                <div class="d-flex align-items-center mt-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= ($i <= $review['rating']) ? 'text-warning' : 'text-muted' ?> me-1"></i>
                                    <?php endfor; ?>
                                    <span class="ms-2 text-muted"><?= $review['rating'] ?>/5</span>
                                </div>
                                <p class="mt-2"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star');
    const ratingInputs = document.querySelectorAll('input[name="rating"]');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            const starIcon = this.querySelector('i');

            // Update visual state
            stars.forEach((s, index) => {
                const sIcon = s.querySelector('i');
                if (index < value) {
                    sIcon.classList.remove('text-muted');
                    sIcon.classList.add('text-warning');
                } else {
                    sIcon.classList.remove('text-warning');
                    sIcon.classList.add('text-muted');
                }
            });

            // Set the radio button
            ratingInputs.forEach(input => {
                if (parseInt(input.value) === value) {
                    input.checked = true;
                }
            });
        });

        // Optional: Hover effect
        star.addEventListener('mouseover', function() {
            const value = parseInt(this.dataset.value);
            stars.forEach((s, index) => {
                const sIcon = s.querySelector('i');
                if (index < value) {
                    sIcon.classList.add('text-warning');
                    sIcon.classList.remove('text-muted');
                } else {
                    sIcon.classList.add('text-muted');
                    sIcon.classList.remove('text-warning');
                }
            });
        });

        // Reset on mouseout
        document.querySelector('.star-rating').addEventListener('mouseleave', function() {
            const selectedValue = document.querySelector('input[name="rating"]:checked');
            const currentRating = selectedValue ? parseInt(selectedValue.value) : 0;
            stars.forEach((s, index) => {
                const sIcon = s.querySelector('i');
                if (index < currentRating) {
                    sIcon.classList.remove('text-muted');
                    sIcon.classList.add('text-warning');
                } else {
                    sIcon.classList.remove('text-warning');
                    sIcon.classList.add('text-muted');
                }
            });
        });
    });
});
</script>

</body>
</html>
