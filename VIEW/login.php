<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET" action="../CONTROLLER/control.php">
        <table border="0" align="center" >
            <caption>Thêm mới sản phẩm</caption>
            <tr>
                <td>Tên sản phẩm:</td>
                <td><input type="text" name="txtsp"></td>
            </tr>
            <tr>
                <td>Số lượng:</td>
                <td><input type="text" name="txtsl"></td>
            </tr>
            <tr>
                <td>Giá sản phẩm:</td>
                <td><input type="text" name="txtgia"></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" name="txtsub" value="thêm mới">
                </td>
             <td><a href="select.php">Hiển thị</a></td>
            </tr>
        </table>
</form>
</body>
</html>