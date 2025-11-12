<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Đăng nhập tài khoản</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-primary text-white text-center">
          <h4>Đăng nhập tài khoản</h4>
        </div>
        <div class="card-body">
          <form method="post" action="../CONTROLLER/controldangnhap.php">
            <div class="mb-3">
              <label for="tendangnhap" class="form-label">Tên đăng nhập</label>
              <input type="text" class="form-control" name="tendangnhap" maxlength="35" required>
            </div>
            <div class="mb-3">
              <label for="matkhau" class="form-label">Mật khẩu</label>
              <input type="password" class="form-control" name="matkhau" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <small>Chưa có tài khoản? <a href="dangky.php">Đăng ký</a> | <a href="quenmk.php">Quên mật khẩu</a></small>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
