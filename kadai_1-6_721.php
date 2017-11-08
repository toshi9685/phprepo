<?php
header('Content-Type: text/html; charset=utf-8');
if(isset($_GET['comment'])){
  $comment = $_GET['comment'];
  echo $comment;
  //ファイルのオープン
  $fp = fopen("kadai1-6.txt",'a');
  //ファイルに書き出す
  $str = $comment."\n";
  //$str = mb_convert_encoding($str,"euc-jp","utf-8");
  fwrite($fp,$str);
  //ファイルを閉じる
  fclose($fp);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>フォームからデータを受け取る</title>
</head>
<body>
<h1>フォームの送信</h1>
<form action = "kadai_1-6_721.php" method = "get">
<input type = "text" name = "comment"><br>
<input type = "submit" value = "送信">
</form>
</body>
</html>
