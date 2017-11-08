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
    return false;//送信中止
  }else{
    return true;//送信を実行
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
<body>
<h1>掲示板</h1>
<form type = "kadai_3_827.php" method = "post" name="form1" onsubmit = "return check()">
名前(必須):<input type = "text" name = "name" value = "<?php echo $editname; ?>"><br>
<input type = "hidden" name = "editcode" value = "<?php echo $editcode; ?>">
投稿を保護する(パスワードの設定は任意):<input type = "text" name = "pass" value = "<?php echo $editpass; ?>"><br>
投稿コメント(必須):<br>
<textarea cols = "60" rows="6" name = "comment"><?php echo $editcomment; ?></textarea><br>
<input type = "submit" value = "投稿"><br><br>
</form>
<form type = "kadai_3_827.php" method = "post" name="form2" onsubmit = "return submitChk()">
投稿編集:<input type = "text" name = "edit">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value ="送信"><br>
</form>
<form type = "kadai_3_827.php" method = "post" name="form3" onsubmit = "return submitChk()">
投稿削除:<input type ="text" name = "delete">
パスワード:<input type ="text" name = "pass">
<input type ="submit" value = "送信"><br><br>
</form>

<?php
    header('Content-Type: text/html; charset=utf-8');
    try {
        //mysqlデータベース接続
        $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
        //mysqlテーブルの作成,確認
        $table= 'CREATE TABLE Board (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30),
        comment VARCHAR(300),
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
            $data = "INSERT INTO Board (id,name,comment,create_datetime,password)VALUES('','".$_POST['name']."','".$_POST['comment']."','".$t['year']."/".$t['mon']."/".$t['mday']."/".$t['hours'].":".$t['minutes'].":".$t['seconds']."','".$_POST['pass']."')";
            $dbh->query($data);
        }
        
        //mysqlデータの取得
        $data = 'SELECT * FROM Board';
        $res = $dbh->query($data);
        $i = 1;
        // 連想配列を取得
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $i = $row["id"];
            echo $row["id"] .":名前:". $row["name"] .":投稿日時".$row["create_datetime"] ."<br>". $row["comment"] . "<br>";
        }
        $dbh = null;
        $res = null;
    } catch (PDOException $e) {
        print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
</body>
</html>

