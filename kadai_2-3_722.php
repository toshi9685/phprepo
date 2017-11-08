<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>掲示板</title>
</head>
<body>
<h1>掲示板</h1>
<form type = "kadai_2-3_722.php" method = "post">
名前:<input type = "text" name = "name"><br>
投稿コメント:<!--<input type = "text" name = "comment">--><br>
<textarea cols = "60" rows="6" name = "comment"></textarea><br>
<input type = "submit" value = "送信"><br>

<?php
header('Content-Type: text/html; charset=utf-8');
if(file_exists('kadai2.txt') || isset($_POST['name'])){
  $fp = fopen("kadai2.txt",'a');
  $arry_file = file('kadai2.txt');
  $i = count($arry_file)+1;
  $str = "$i"."<>".$_POST['name']."<>".$_POST['comment'];
  $str = str_replace(array("\r", "\n"), '', $str);
  $str = $str."\n";
  fwrite($fp,$str);
  fclose($fp);
  $i=0;
  while($arry_file[$i] != null){
    $cell = explode("<>",$arry_file[$i]);
    echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    $i++;
  }
  $cell = explode("<>",$str);
  echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
}
?>
</form>
</body>
</html>

