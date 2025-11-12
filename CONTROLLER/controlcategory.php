<?php
include('../MODEL/modelcategory.php'); 
$get_data = new data_category(); // 
if (isset($_POST['Add_category'])) {

    
    if (empty($_POST['txtname']) || empty($_POST['txtdesc'])) {
        echo "<script>
            alert('Vui lòng nhập đầy đủ thông tin');
            window.location.href='../admin/category.php';
        </script>";
    } else {
  
        $insert = $get_data->insert_category($_POST['txtname'], $_POST['txtdesc']);

        if ($insert) {
            echo "<script>
                alert('Thêm danh mục thành công');
                window.location.href='../admin/category_list.php';
            </script>";
        } else {
            echo "<script>alert('Không thể thêm danh mục');</script>";
        }
    }
}

if (isset($_GET['xoa'])) {
    $delete = $get_data->delete_category($_GET['xoa']);
    if ($delete) {
        echo "<script>
            alert('Xóa thành công');
            window.location.href='../admin/category_list.php';
        </script>";
    } else {
        echo "<script>alert('Không thể xóa');</script>";
    }
}


if (isset($_POST['Update_category']) && isset($_GET['sua'])) {
    $update = $get_data->update_category($_POST["txtname"], $_POST["txtdesc"], $_GET["sua"]);

    if ($update) {
        echo "<script>
            alert('Cập nhật thành công');
            window.location.href='../admin/category_list.php';
        </script>";
    } else {
        echo "<script>alert('Không thể cập nhật');</script>";
    }
}
?>
