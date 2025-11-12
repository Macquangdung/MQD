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
                        <h1 class="page-head-line">Danh sách danh mục</h1>
                        <h1 class="page-subhead-line">Xem, chỉnh sửa hoặc xóa danh mục hiện có trong hệ thống.</h1>
                    </div>
                </div>

                <!-- /. ROW -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                CATEGORY LIST
                                <a href="category.php" class="btn btn-success btn-sm pull-right">
                                    ➕ Thêm danh mục
                                </a>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr class="info">
                                                <th style="width: 60px;">#</th>
                                                <th>Tên danh mục</th>
                                                <th>Mô tả</th>
                                                <th>Ngày tạo</th>
                                                <th style="width: 150px;">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include("../MODEL/modelcategory.php");
                                            $get_data = new data_category();
                                            $categories = $get_data->select_category();

                                            if (!empty($categories)) {
                                                $stt = 1;
                                                foreach ($categories as $cat) {
                                                    echo "
                                                    <tr>
                                                        <td>{$stt}</td>
                                                        <td>{$cat['name']}</td>
                                                        <td>{$cat['description']}</td>
                                                        <td>{$cat['created_at']}</td>
                                                        <td>
                                                            <a href='category_edit.php?sua={$cat['id']}' class='btn btn-warning btn-sm'>✏️ Sửa</a>
                                                            <a href='../CONTROLLER/controlcategory.php?xoa={$cat['id']}' 
                                                               onclick=\"return confirm('Bạn có chắc chắn muốn xóa danh mục này?');\" 
                                                               class='btn btn-danger btn-sm'>🗑️ Xóa</a>
                                                        </td>
                                                    </tr>
                                                    ";
                                                    $stt++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center text-danger'>Chưa có danh mục nào!</td></tr>";
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
