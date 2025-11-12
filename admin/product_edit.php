<?php
include('../MODEL/modelproduct.php');
$get_data = new data_product();
if (!isset($_GET['sua'])) {
    echo "Thiếu tham số 'sua' trên URL.";
    exit;
}
$result = $get_data->select_product_id($_GET['sua']);
$product = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include 'head.php'; ?>
<body>
    <div id="wrapper">
        <?php include("head_top.php"); ?>
        <?php include("head_nav.php"); ?>
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Chỉnh sửa sản phẩm</h1>
                        <h1 class="page-subhead-line">
                            Cập nhật thông tin chi tiết cho sản phẩm.
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                THÔNG TIN SẢN PHẨM
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post" action="../CONTROLLER/controlproduct.php?sua=<?php echo $product['id']; ?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Tên sản phẩm</label>
                                        <input class="form-control" type="text" name="productName" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Số lượng</label>
                                        <input class="form-control" type="number" name="productQuantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="0" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Danh mục</label>
                                        <select class="form-control" name="productCategory" required>
                                            <option value="Electronics" <?php if ($product['category'] == 'Electronics') echo 'selected'; ?>>Điện tử</option>
                                            <option value="Clothing" <?php if ($product['category'] == 'Clothing') echo 'selected'; ?>>Quần áo</option>
                                            <option value="Books" <?php if ($product['category'] == 'Books') echo 'selected'; ?>>Sách</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Ngày nhập</label>
                                        <input class="form-control" type="date" name="productDate" value="<?php echo htmlspecialchars($product['date']); ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input class="form-control" type="number" name="productPrice" value="<?php echo htmlspecialchars($product['price']); ?>" min="0" step="0.01" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Mô tả sản phẩm</label>
                                        <textarea class="form-control" rows="3" name="productDescription" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Hình ảnh hiện tại</label>
                                        <div>
                                            <?php if (!empty($product['image'])) : ?>
                                                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" width="150" alt="Ảnh sản phẩm">
                                            <?php else : ?>
                                                <p>Chưa có hình ảnh.</p>
                                            <?php endif; ?>
                                        </div>
                                        <input type="hidden" name="currentImage" value="<?php echo htmlspecialchars($product['image']); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Tải lên ảnh mới (để trống nếu không muốn thay đổi)</label>
                                        <input type="file" name="productImage">
                                    </div>

                                    <button type="submit" name="Update_product" class="btn btn-info">
                                        Cập nhật sản phẩm
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW  -->
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>