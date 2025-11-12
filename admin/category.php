<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include 'head.php'; ?>
<body>
    <div id="wrapper">
        <?php include("head_top.php"); ?>
        <!-- /. NAV TOP  -->
        <?php include("head_nav.php"); ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Category Form</h1>
                        <h1 class="page-subhead-line">
                            Vui lòng nhập thông tin danh mục mới bên dưới.
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                CATEGORY
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post" action="../CONTROLLER/controlcategory.php">
                                    <div class="form-group">
                                        <label>Tên danh mục</label>
                                        <input class="form-control" type="text" name="txtname" required>
                                        <p class="help-block">Nhập tên danh mục</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Mô tả</label>
                                        <textarea class="form-control" rows="3" name="txtdesc" required></textarea>
                                        <p class="help-block">Thêm mô tả chi tiết cho danh mục nếu cần.</p>
                                    </div>

                                    <button type="submit" name="Add_category" class="btn btn-info">
                                        Thêm danh mục
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
