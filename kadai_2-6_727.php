<script type="text/javascript">
function submitChk(){
  var flag = confirm("この投稿の変更を加えてもよろしいですか？");
  return flag;
}
function check(){
  var flag = 0;
  //チェックする項目

  if(document.form1.name.value == ""){//名前
    flag = 1;
  }else if(document.form1.comment.value == ""){//コメント
    flag = 1;
  }
  if(flag){
    alert("必須項目に未入力がありました。");//入力漏れがあれば警告ダイアログを出す
    return false;//送信中止
  }else{
    return true;//送信を実行
  }
}
</script>
<?php
 if(isset($_POST['edit'])){
  $fp = fopen("kadai2-6.txt",'a+');
  $arry_file = file('kadai2-6.txt');
  $i=0;
  while($arry_file[$i] != null){
    $arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
    if($i == ($_POST['edit']-1)){
      $cell = explode("<>",$arry_file[$i]);
      if(!empty($cell[1])){
      if(empty($cell[4])){
        $editname = $cell[1];
        $editcomment = $cell[3];
        $editcode = $_POST['edit'];
        $editpass = "変更できません。";
        }else{
          if(str_replace(array("\r", "\n"), '', $cell[4]) == $_POST['pass']){
             $editname = $cell[1];
             $editcomment = $cell[3];
             $editcode = $_POST['edit'];
             $editpass = "変更できません。";
          }else{
            $editcomment = "このコメントは編集できません。";
          }
        }
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
<form type = "kadai_2-6_727.php" method = "post" name="form1" onsubmit = "return check()">
名前(必須):<input type = "text" name = "name" value = "<?php echo $editname; ?>"><br>
<input type = "hidden" name = "editcode" value = "<?php echo $editcode; ?>">
投稿を保護する(パスワードの設定は任意):<input type = "text" name = "pass" value = "<?php echo $editpass; ?>"><br>
投稿コメント(必須):<br>
<textarea cols = "60" rows="6" name = "comment"><?php echo $editcomment; ?></textarea><br>
<input type = "submit" value = "投稿"><br><br>
</form>
<form type = "kadai_2-6_727.php" method = "post" name="form2" onsubmit = "return submitChk()">
投稿編集:<input type = "text" name = "edit">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value ="送信"><br>
</form>
<form type = "kadai_2-6_727.php" method = "post" name="form3" onsubmit = "return submitChk()">
投稿削除:<input type ="text" name = "delete">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value = "送信"><br><br>
</form>
<?php
header('Content-Type: text/html; charset=utf-8');
if(!empty($_POST['delete'])){//削除
  $fp = fopen("kadai2-6.txt",'r');
  $arry_file = file('kadai2-6.txt');
  fclose($fp);
  $fp = fopen("kadai2-6.txt",'w');
  $j = 0;
  while(count($arry_file) > $j){
    $arry_file[$j] = mb_convert_encoding($arry_file[$j],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$j]);
    if($cell[0] != $_POST['delete']){
      $arry_file[$j] = mb_convert_encoding($arry_file[$j],"euc-jp","utf-8");
      fwrite($fp,$arry_file[$j]);
      echo $cell[0].":"."名前:".$cell[1].":投稿日時".$cell[2]."<br>".$cell[3]."<br>";
    }else{
      if(!empty($cell[4])){
        if( str_replace(array("\r", "\n"), '', $cell[4]) == $_POST['pass']){
          $str = mb_convert_encoding($cell[0]."<><><>この投稿は削除されました。<>\n","euc-jp","utf-8");
          fwrite($fp,$str);
          echo $cell[0].":名前::投稿日時<br>この投稿は削除されました。<br>";
        }else{
          $arry_file[$j] = mb_convert_encoding($arry_file[$j],"euc-jp","utf-8");
          fwrite($fp,$arry_file[$j]);
          echo $cell[0].":"."名前:".$cell[1].":投稿日時".$cell[2]."<br>".$cell[3]."<br>";
        }
       }else{
        $str = mb_convert_encoding($cell[0]."<><><>この投稿は削除されました。<>\n","euc-jp","utf-8");
        fwrite($fp,$str);
        echo $cell[0].":名前::投稿日時<br>この投稿は削除されました。<br>";
       }
    }
    $j++;
  }
  fclose($fp);
}else if(!empty($_POST['editcode']) && $_POST['editcode'] >= 1){
  //編集
  $fp = fopen("kadai2-6.txt",'r');
  $arry_file = file('kadai2-6.txt');
  fclose($fp);
  $fp = fopen("kadai2-6.txt",'w');
  $j = 0;
  while(count($arry_file) > $j){
    $arry_file[$j] = mb_convert_encoding($arry_file[$j],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$j]);
    if($cell[0] != $_POST['editcode']){
      $arry_file[$j] = mb_convert_encoding($arry_file[$j],"euc-jp","utf-8");
      fwrite($fp,$arry_file[$j]);
      echo $cell[0].":名前:".$cell[1].":投稿日時".$cell[2]."<br>".$cell[3]."<br>";
    }else{
        $t = getdate();
        $str = mb_convert_encoding($cell[0]."<>".$cell[1]."<>".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."<>".$_POST['comment']."<>".$cell[4],"euc-jp","utf-8");
        fwrite($fp,$str);
        echo $cell[0].":名前:".$cell[1].":投稿日時".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."<br>".$_POST['comment']."<br>";
    }
    $j++;
  }
  fclose($fp);

  $editcode = 0;
}else if(file_exists('kadai2-6.txt') || !empty($_POST['name']) || !empty($_POST['comment'])){

  $fp = fopen("kadai2-6.txt",'a+');
  $arry_file = file('kadai2-6.txt');
  $i=0;
  while($arry_file[$i] != null){
    $arry_file[$i] = mb_convert_encoding($arry_file[$i],"utf-8","euc-jp");
    $cell = explode("<>",$arry_file[$i]);
    echo $cell[0].":"."名前:".$cell[1].":投稿日時".$cell[2]."<br>".$cell[3]."<br>";
    $i++;
  }
  if(!empty($_POST['name'])&&!empty($_POST['comment'])){
    $t = getdate();
    $i = count($arry_file)+1;
    $str = "$i"."<>".$_POST['name']."<>".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."<>".$_POST['comment']."<>".$_POST['pass'];
    $str = str_replace(array("\r", "\n"), '', $str);
    $str = $str."\n";
    $cell = explode("<>",$str);
    echo $cell[0].":"."名前:".$cell[1].":投稿日時".$cell[2]."<br>".$cell[3]."<br>";
    $str = mb_convert_encoding($str,"euc-jp","utf-8");
    fwrite($fp,$str);
  }
  fclose($fp);
}

?>
</form>
</body>
</html>

