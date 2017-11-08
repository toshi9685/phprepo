<?php
 if(isset($_POST['edit'])){
  $fp = fopen("kadai2.txt",'a+');
  $arry_file = file('kadai2.txt');
  $i=0;
  while($arry_file[$i] != null){
    $arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
    if($i == ($_POST['edit']-1)){
      $cell = explode("<>",$arry_file[$i]);
      if($cell[1] != ""){
        $editname = $cell[1];
        $editcomment = $cell[2];
        $editcode = $_POST['edit'];
      }else{
        $editcomment = "このコメントは編集できません。";
      }
    }
    $i++;
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>掲示板</title>
</head>
<body>
<h1>掲示板</h1>
<form type = "kadai_2-5_725.php" method = "post">
名前:<input type = "text" name = "name" value = "<?php echo $editname; ?>"><br>
<input type = "hidden" name = "editcode" value = "<?php echo $editcode; ?>">
投稿を保護する(パスワードを設定する):<input type = "text" name = "pass" ><br>
投稿コメント:<br>
<textarea cols = "60" rows="6" name = "comment"><?php echo $editcomment; ?></textarea><br>
<input type = "submit" value = "投稿"><br><br>
</form>
<form type = "kadai_2-5_725.php" method = "post">
投稿編集:<input type = "text" name = "edit">
<input type ="submit" value ="送信"><br>
</form>
<form type = "kadai_2-5_725.php" method = "post">
投稿削除:<input type ="text" name = "delete">
<input type ="submit" value = "送信"><br><br>
</form>
<?php
header('Content-Type: text/html; charset=utf-8');
if(!empty($_POST['delete']) && file_exists('kadai2.txt')){//削除
  $fp = fopen("kadai2.txt",'r');
  $arry_file = file('kadai2.txt');
  fclose($fp);
  $fp = fopen("kadai2.txt",'w');
  $j = 0;
  while(count($arry_file) > $j){
    $arry_file[$j] = mb_convert_encoding($arry_file[$j],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$j]);
    if($cell[0] != $_POST['delete']){
      $arry_file[$j] = mb_convert_encoding($arry_file[$j],"euc-jp","utf-8");
      fwrite($fp,$arry_file[$j]);
      echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    }else{
      $str = mb_convert_encoding($cell[0]."<><>この投稿は削除されました。\n","euc-jp","utf-8");
      fwrite($fp,$str);
      echo $cell[0].":この投稿は削除されました。<br>";
    }
    $j++;
  }
  fclose($fp);
}else if(!empty($_POST['editcode']) && $_POST['editcode'] >= 1){
  //編集
  $fp = fopen("kadai2.txt",'r');
  $arry_file = file('kadai2.txt');
  fclose($fp);
  $fp = fopen("kadai2.txt",'w');
  $j = 0;
  while(count($arry_file) > $j){
    $arry_file[$j] = mb_convert_encoding($arry_file[$j],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$j]);
    if($cell[0] != $_POST['editcode']){
      $arry_file[$j] = mb_convert_encoding($arry_file[$j],"euc-jp","utf-8");
      fwrite($fp,$arry_file[$j]);
      echo $cell[0].":名前:".$cell[1]."<br>".$cell[2]."<br>";
    }else{
      $str = mb_convert_encoding($cell[0]."<>".$cell[1]."<>".$_POST['comment']."\n","euc-jp","utf-8");
      fwrite($fp,$str);
      echo $cell[0].":名前:".$cell[1]."<br>".$_POST['comment']."<br>";
    }
    $j++;
  }
  fclose($fp);

  $editcode = 0;
}else if(file_exists('kadai2.txt') || !empty($_POST['name']) || !empty($_POST['comment'])){

  $fp = fopen("kadai2.txt",'a+');
  $arry_file = file('kadai2.txt');
  $i=0;
  while($arry_file[$i] != null){
    $arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$i]);
    echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    $i++;
  }
  if(!empty($_POST['name'])&&!empty($_POST['comment'])){
    $i = count($arry_file)+1;
    $str = "$i"."<>".$_POST['name']."<>".$_POST['comment'];
    $str = str_replace(array("\r", "\n"), '', $str);
    $str = $str."\n";
    $cell = explode("<>",$str);
    echo $cell[0].":"."名前:".$cell[1]."<br>".$cell[2]."<br>";
    $str = mb_convert_encoding($str,"euc-jp","utf-8");
    fwrite($fp,$str);
  }
  fclose($fp);
}else if(isset($_POST['edit'])){
}

?>
</form>
</body>
</html>

