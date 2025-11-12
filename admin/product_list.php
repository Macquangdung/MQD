<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include("head.php"); ?>
<body>
    <div id="wrapper">
        <?php include("head_top.php"); ?>
        <?php include("head_nav.php"); ?>

        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Danh sách sản phẩm</h1>
                        <h1 class="page-subhead-line">Xem, chỉnh sửa hoặc xóa sản phẩm hiện có trong hệ thống.</h1>
                    </div>
                </div>

                <!-- /. ROW -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                DANH SÁCH SẢN PHẨM
                                <a href="product.php" class="btn btn-success btn-sm pull-right">
                                    ➕ Thêm sản phẩm
                                </a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th style="width: 60px;">#</th>
                                                <th style="width: 200px;">Tên sản phẩm</th>
                                                <th style="width: 120px;">Hình ảnh</th>
                                                <th>Mô tả</th>
                                                <th>Số lượng</th>
                                                <th>Giá</th>
                                                <th>Danh mục</th>
                                                <th style="width: 100px;">Ngày nhập</th>
                                                <th style="width: 160px;">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include("../MODEL/modelproduct.php");
                                            $get_data = new data_product();
                                            $products = $get_data->select_product();

                                            if (!empty($products)) {
                                                $stt = 1;
                                                foreach ($products as $prod) {
                                                    echo "
                                                    <tr>
                                                        <td>{$stt}</td>
                                                        <td>" . htmlspecialchars($prod['name']) . "</td>
                                                        <td><img src='../uploads/" . htmlspecialchars($prod['image']) . "' alt='" . htmlspecialchars($prod['name']) . "' style='width: 100px; height: auto;'/></td>
                                                        <td>" . htmlspecialchars($prod['description']) . "</td>
                                                        <td>{$prod['quantity']}</td>
                                                        <td>" . number_format($prod['price']) . " VNĐ</td>
                                                        <td>{$prod['category']}</td>
                                                        <td>" . date('d/m/Y', strtotime($prod['date'])) . "</td>
                                                        <td>
                                                            <a href='product_edit.php?sua={$prod['id']}' class='btn btn-warning btn-sm'>✏️ Sửa</a>
                                                            <a href='../CONTROLLER/controlproduct.php?xoa={$prod['id']}' 
                                                               onclick=\"return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');\" 
                                                               class='btn btn-danger btn-sm'>🗑️ Xóa</a>
                                                        </td>
                                                    </tr>
                                                    ";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='9' class='text-center text-danger'>Chưa có sản phẩm nào!</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /. ROW -->
            </div>
            <!-- /. PAGE INNER -->
        </div>
        <!-- /. PAGE WRAPPER -->
    </div>

    <?php include("footer.php"); ?>
</body>
</html>
