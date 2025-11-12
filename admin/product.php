<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include("head.php"); ?>
<body>
    <div id="wrapper">
        <?php include("head_top.php"); ?>
        <?php include("head_nav.php"); ?>
        <div id="page-wrapper" style="min-height: 500px; padding: 15px;">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="page-head-line">Thêm sản phẩm mới</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <form role="form" action="../CONTROLLER/controlproduct.php" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label for="productName">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Nhập tên sản phẩm" required />
                        </div>

                        <div class="form-group">
                            <label for="productQuantity">Số lượng sản phẩm</label>
                            <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Nhập số lượng" min="0" required />
                        </div>

                        <div class="form-group">
                            <label for="productImage">Hình ảnh sản phẩm</label>
                            <input type="file" id="productImage" name="productImage" />
                            <p class="help-block">Chọn tệp hình ảnh cho sản phẩm.</p>
                        </div>

                        <div class="form-group">
                            <label for="productCategory">Thể loại sản phẩm</label>
                            <select class="form-control" id="productCategory" name="productCategory" required>
                                <option value="">--Chọn loại sản phẩm--</option>
                                <option value="Electronics">Điện tử</option>
                                <option value="Clothing">Quần áo</option>
                                <option value="Books">Sách</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="productDate">Ngày nhập sản phẩm</label>
                            <input type="date" class="form-control" id="productDate" name="productDate" placeholder="dd/mm/yyyy" required />
                        </div>

                        <div class="form-group">
                            <label for="productPrice">Giá sản phẩm</label>
                            <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Nhập giá sản phẩm" min="0" step="0.01" required />
                        </div>

                        <div class="form-group">
                            <label for="productDescription">Mô tả sản phẩm</label>
                            <textarea class="form-control" id="productDescription" name="productDescription" rows="3"></textarea>
                        </div>

                        <button type="submit" name="Add_product" class="btn btn-primary">Thêm sản phẩm</button>
                    </form>
                    </div>
            </div>

        </div>
        </div>
    <?php include 'footer.php'; ?>
</body>
</html>