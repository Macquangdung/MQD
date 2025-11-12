<?php
include('../MODEL/modelproduct.php'); 
$get_data = new data_product(); // 
if (isset($_POST['Add_product'])) {

    // Lấy dữ liệu từ form
    $name = $_POST['productName'];
    $quantity = $_POST['productQuantity'];
    $category = $_POST['productCategory'];
    $date = $_POST['productDate'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDescription'];
    $image_name = '';

    // Kiểm tra các trường bắt buộc
    if (empty($name) || empty($quantity) || empty($category) || empty($date) || empty($price) || empty($description)) {
        echo "<script>
            alert('Vui lòng nhập đầy đủ thông tin');
            window.location.href='../admin/product.php';
        </script>";
    } else {
        // Xử lý upload file ảnh
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
            $target_dir = "../uploads/"; // Thư mục để lưu ảnh
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            $image_name = basename($_FILES["productImage"]["name"]);
            $target_file = $target_dir . $image_name;
            
            // Di chuyển file vào thư mục uploads
            if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
                echo "<script>alert('Có lỗi khi tải lên hình ảnh.');</script>";
                $image_name = ''; // Reset tên ảnh nếu upload lỗi
            }
        }

        $insert = $get_data->insert_product($name, $quantity, $image_name, $category, $date, $price, $description);
        if ($insert) {
            echo "<script>
                alert('Thêm sản phẩm thành công');
                window.location.href='../admin/product_list.php';
            </script>";
        } else {
            echo "<script>alert('Không thể thêm sản phẩm');</script>";
        }
    }
}

if (isset($_GET['xoa'])) {
    $delete = $get_data->delete_product($_GET['xoa']);
    if ($delete) {
        echo "<script>
            alert('Xóa thành công');
            window.location.href='../admin/product_list.php';
        </script>";
    } else {
        echo "<script>alert('Không thể xóa');</script>";
    }
}


if (isset($_POST['Update_product']) && isset($_GET['sua'])) {
    $id = $_GET['sua'];
    $name = $_POST['productName'];
    $quantity = $_POST['productQuantity'];
    $category = $_POST['productCategory'];
    $date = $_POST['productDate'];
    $price = $_POST['productPrice'];
    $description = $_POST['productDescription'];
    $image_name = $_POST['currentImage']; // Giữ ảnh cũ làm mặc định

    // Kiểm tra nếu có ảnh mới được tải lên
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0 && !empty($_FILES['productImage']['name'])) {
        $target_dir = "../uploads/";
        $new_image_name = basename($_FILES["productImage"]["name"]);
        $target_file = $target_dir . $new_image_name;

        if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
            $image_name = $new_image_name; // Cập nhật tên ảnh mới
        } else {
            echo "<script>alert('Có lỗi khi tải lên hình ảnh mới.');</script>";
        }
    }

    if (empty($name) || empty($quantity) || empty($category) || empty($date) || empty($price)) {
        echo "<script>alert('Vui lòng nhập đầy đủ thông tin.'); window.history.back();</script>";
    } else {
        $update = $get_data->update_product($name, $quantity, $image_name, $category, $date, $price, $description, $id);

        if ($update) {
            echo "<script>
                alert('Cập nhật thành công');
                window.location.href='../admin/product_list.php';
            </script>";
        } else {
            echo "<script>alert('Không thể cập nhật'); window.history.back();</script>";
        }
    }
}
?>
