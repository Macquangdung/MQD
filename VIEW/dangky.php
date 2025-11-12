<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng ký tài khoản</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-success text-white text-center">
          <h4>Đăng ký tài khoản</h4>
        </div>
        <div class="card-body">
          <form name="formDangKy" method="post" action="../CONTROLLER/controldangky.php">
            <div class="mb-3">
              <label for="tendangnhap" class="form-label">Tên đăng nhập</label>
              <input type="text" class="form-control" name="tendangnhap" maxlength="35" required>
            </div>

            <div class="mb-3">
              <label for="matkhau" class="form-label">Mật khẩu</label>
              <input type="password" class="form-control" name="matkhau" required>
            </div>

            <div class="mb-3">
              <label for="nhapmatkhau" class="form-label">Nhập lại mật khẩu</label>
              <input type="password" class="form-control" name="nhapmatkhau" required>
            </div>

            <div class="mb-3">
              <label for="sdt" class="form-label">Số điện thoại</label>
              <input type="text" class="form-control" name="sdt" maxlength="10" required>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Đăng ký</button>
          </form>
        </div>
        <div class="card-footer text-center">
          <small>Đã có tài khoản? <a href="dangnhap.php">Đăng nhập</a></small>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
