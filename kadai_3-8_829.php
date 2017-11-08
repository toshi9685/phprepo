<?php
    if(isset($_COOKIE['PHPSESSID'])){
        session_start();
        $editname = $_SESSION['id'];
    }else{
        header("location: kadai_3-7_825.php");
    }
?>

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
  }
}
function passerror(){
    alert("パスワードが間違っています。");
}
function exiterror(){
    alert("その投稿は削除されています。");
}

</script>
    <?php
        if(isset($_POST['edit'])){
            try {
                //mysql接続
                $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
                //mysqlデータの取得
                $data = 'SELECT * FROM Board WHERE id='.$_POST['edit'];
                $res = $dbh->query($data);
                if($res){
                    $row = $res->fetch(PDO::FETCH_ASSOC);
                    if(empty($row['password'])){//パスワードなし
                        $editname = $row['name'];
                        $editcomment = $row['comment'];
                        $editcode = $_POST['edit'];
                        $editpass = "変更できません。";
                    }else{
                        if($_POST['pass'] == $row['password']){
                            $editname = $row['name'];
                            $editcomment = $row['comment'];
                            $editcode = $_POST['edit'];
                            $editpass = "変更できません。";
                        }else{
                            print "<script type=text/javascript>passerror()</script>";//javascript関数を呼び出す
                        }
                    }
                }else{
                    print "<script type=text/javascript>exiterror()</script>";//javascript関数を呼び出す
                }
                $dbh = null;
            } catch (PDOException $e) {
                print "エラー!: " . $e->getMessage() . "<br/>";
                die();
            }
             }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>掲示板</title>
</head>
<body bgcolor="98fb98">
<div align="center">
<h1>掲示板</h1>
<hr>
<table border="0">
<form action = "kadai_3-8_829.php" method = "post" enctype="multipart/form-data" name="form1">
<tr>
<th align="right">
名前(必須):
</th>
<td>
<input type = "text" name = "name" value = "<?php echo $editname; ?>">
<input type = "hidden" name = "editcode" value = "<?php echo $editcode; ?>">
</td>
</tr>
<tr>
<th align="right">
投稿を保護する(パスワードの設定は任意):
</th>
<td>
<input type = "text" name = "pass" value = "<?php echo $editpass; ?>">
</td>
</tr>
<tr>
<th align="right" valign="top">
投稿コメント(必須):
</th>
<td>
<textarea cols = "60" rows="6" name = "comment"><?php echo $editcomment; ?></textarea>
</td>
</tr>
<tr>
<th align="right">
ファイルを添付する(画像,動画のみ):
</th>
<td>
<input type="file" name="upfile">
</td>
</tr>
<tr>
<th>
</th>
<td>
<input type = "submit" name = "hoge" value = "投稿">
</td>
</tr>
</form>
</table>
<br>
<br>
<hr width="50%">
<table border="0">
<caption>【編集や削除したい投稿を番号で指定してください】</caption>
<form type = "kadai_3-8_829.php" method = "post" name="form2" onsubmit = "return submitChk()">
<tr>
<th>
投稿編集:
</th>
<td>
<input type = "text" name = "edit">
</td>
<th>
パスワード:
</th>
<td>
<input type ="text" name = "pass">
</td>
<td>
<input type ="submit" value ="送信">
</td>
</tr>
</form>

<form type = "kadai_3-8_829.php" method = "post" name="form3" onsubmit = "return submitChk()">
<tr>
<th>
投稿削除:
</th>
<td>
<input type ="text" name = "delete">
</td>
<th>
パスワード:
</th>
<td>
<input type ="text" name = "pass">
</td>
<td>
<input type ="submit" value = "送信">
</td>
</tr>
</table>
</form>
<br>
<br>
<hr>
<h2>投稿一覧</h2>
<?php
    //header('Content-Type: text/html; charset=utf-8');
    try {
        //mysqlデータベース接続
        $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
        //mysqlテーブルの作成,確認
        $table= 'CREATE TABLE Board (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        comment TEXT,
        ftype VARCHAR(10),
        filename VARCHAR(255),
        raw_data mediumblob,
        create_datetime DATETIME,
        password VARCHAR(30)
        ) engine=innodb default charset=utf8';
        
        if($dbh->query($table)){
        }else{
        }
        
        if(!empty($_POST['delete'])){//削除
            //mysqlデータの取得
            $data = 'SELECT * FROM Board WHERE id='.$_POST['delete'];
            $res = $dbh->query($data);
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if($_POST['pass'] == $row['password']){
                    
                $data = 'DELETE FROM Board WHERE id= '.$_POST['delete'];
                $res = $dbh->prepare($data);
                $res -> execute();
            }else{
                print "<script type=text/javascript>passerror()</script>";//javascript関数を呼び出す
            }
        }else if($_POST['editcode'] >= 1){//編集
            $t = getdate();
            //mysqlデータの取得
            $data = "UPDATE Board SET comment = '".$_POST['comment']."',create_datetime = "."'".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."'" ."WHERE id=".$_POST['editcode'];
            $res = $dbh->prepare($data);
            $res -> execute();
            $editcode = 0;
        }else if(!empty($_POST['name'])&&!empty($_POST['comment'])){//保存
            //mysqlにデータ保存
            $t = getdate();
            if(is_uploaded_file($_FILES['upfile']['tmp_name'])){
                $type = ExtensionDiscrimination();
                $img_binary = file_get_contents($_FILES['upfile']['tmp_name']);
                $data = "INSERT INTO Board (id,name,comment,ftype,filename,raw_data,create_datetime,password)VALUES('','".$_POST['name']."','".$_POST['comment']."','".$type."','".$_FILES['upfile']['name']."',".$dbh->quote($img_binary).",'".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."','".$_POST['pass']."')";
            }else{
                $data = "INSERT INTO Board (id,name,comment,create_datetime,password)VALUES('','".$_POST['name']."','".$_POST['comment']."','".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."','".$_POST['pass']."')";
            }
            if($dbh->query($data)){
                echo "保存成功";
            }else{
                echo "保存失敗";
                var_dump($dbh->errorInfo());
            }
            
        }else if(isset($_POST["hoge"])){
            print "<script type=text/javascript>check()</script>";
        }
        
        //mysqlデータの取得
        $data = 'SELECT * FROM Board';
        $res = $dbh->query($data);
        $FTypes = array(
                           'png'  => 'image',
                           'jpg'  => 'image',
                           'jpeg' => 'image',
                           'gif'  => 'image',
                           'mpg'  => 'video',
                           'mp4'  => 'video',
                           'm4v'  => 'video',
                           'mov'  => 'video',
                           'avi'  => 'video'
                           );
        // 連想配列を取得
        //投稿の表示
        
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            echo "<table border=\"0\">";
            echo "<tr><th align=\"left\">".$row["id"] .":名前:". $row["name"] .":投稿日時".$row["create_datetime"] ."</th></tr>";
            echo "<tr><td align=\"left\">".$row["comment"]."</td></tr>";
            echo "</table>";
            if($FTypes[$row['ftype']] == 'image'){
                echo "<img src=\"kadai_3-8-2_831.php?id=".$row["id"]."\"width=\"50%\" height=\"50%\">";
                echo "<br>";
            }else if($FTypes[$row['ftype']] == 'video'){
                echo "<video controls loop width=\"50%\" height=\"50%\"><source src=\"kadai_3-8-2_831.php?id=".$row["id"]."\"></video>";
                echo "<br>";
            }else{
                echo $FTypes[$row['ftype']];
                echo "<br>";
            }
            echo '<hr width="50%">';
        }
        
        $dbh = null;
        $res = null;
        

    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }

    function ExtensionDiscrimination(){
        //拡張子判別
        $ext = pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION);
        if("png" == $ext){
            //echo "pngです<br>";
            return "png";
        }else if("gif" == $ext){
            //echo "gifです<br>";
            return "gif";
        }else if("jpg" == $ext){
            //echo "jpgです<br>";
            return "gif";
        }else if("mp4" == $ext){
            //echo "mp4です<br>";
            return "mp4";
        }else if("jpeg" == $ext){
            //echo "jpegです<br>";
            return "jpeg";
        }else if("mpg" == $ext){
            //echo "mpgです<br>";
            return "mpg";
        }else if("mov" == $ext || "m4v" == $ext){
            //echo "movです<br>";
            return "mov";
        }else if("avi" == $ext){
            //echo "aviです<br>";
            return "avi";
        }else{
            //echo "対応外です".$ext."<br>";
            return null;
        }
    }

?>
</div>
</body>
</html>

