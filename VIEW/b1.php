<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="GET" action="../COTROLLER/control.php">
<h2 align="center">ĐĂNG KÝ GIẢNG ĐƯỜNG</h2>
Giảng đường: <select name="txtgd">
		<option>--Chọn giảng đường--</option>
		<option value="501">501</option>
		<option value="502">502</option>
		</select><br>
Giảng viên: <input type="text" name="txtname">
Môn dạy:    <select name="txtmd">
		<option>--Chọn môn--</option>
		<option value="Lập trình PHP">Lập trìnhPHP</option>
		<option value="CSDL SQL">CSDL SQL</option>
		</select><br>
<input type="submit" name="txtsub" value="Đăng ký">
</form>

</body>
</html>