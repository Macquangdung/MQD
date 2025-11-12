<?php
    include('../MODEL/model.php');
    $get_data = new data_sanpham();
    if (!isset($_GET['sua'])) {
        echo "Thiếu tham số 'sua' trên URL.";
        exit;
    }
    $select_sanpham_id = $get_data->select_sp_id($_GET['sua']);
    foreach($select_sanpham_id as $i_sp):
?>
   <form method="POST" action="../CONTROLLER/control.php?sua=<?php echo $_GET['sua']?>">
   <table border="0" align="center" >
            <caption>Thêm mới sản phẩm</caption>
            <tr>
                <td>Tên sản phẩm:</td>
                <td><input type="text" name="txtsp" value="<?php echo $i_sp['tensanpham']?>"></td>
            </tr>
            <tr>
                <td>Số lượng:</td>
                <td><input type="text" name="txtsl" value="<?php echo $i_sp['soluong']?>"></td>
            </tr>
            <tr>
                <td>Giá sản phẩm:</td>
                <td><input type="text" name="txtgia" value="<?php echo $i_sp['dongia']?>"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="txtsub_sanpham" value="Cập nhật">
                </td>
            </tr>
        </table>
   </form>
<?php endforeach; ?>
