<?php
if(isset($_GET['comment'])){
  $comment = $_GET['comment'];
  echo $comment;
}
?>
<!DOCTYPE html>
<head>
<meta charset = "utf-8">
<title>フォームからデータを受け取る</title>
</head>
<body>
<h1>フォームの送信</h1>
<form action = "kadai_1-4_720.php" method = "get">
<input type = "text" name = "comment"><br>
<input type = "submit" value = "送信">
</form>
</body>
</html>
