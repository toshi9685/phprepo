
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
    }else if(document.form1.password.value == ""){//パスワード
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
    alert("パスワードが正しく入力されていません。");
}
function iderror(){
    alert("IDが正しく入力されていません。");
}
</script>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset = "utf-8">
<title>ログイン</title>
</head>
<body>
<h1>ログイン</h1>
<hr>
<div align="center">
<table border="0">
<form type = "kadai_3-7_825.php" method = "post" name="form1" onsubmit = "return check()">
<tr>
<th align="right">
ID:
</th>
<td>
<input type = "text" name = "name" >
</td>
</tr>
<tr>
<th align="right">
パスワード:
</th>
<td>
<input type = "text" name = "password" >
</td>
</tr>
<tr>
<th align="right">
</th>
<td>
<input type = "submit" value = "ログイン">
</td>
</tr>

</form>
</table>
<br>
<a href="http://co-430.99sv-coco.com/kadai_3-9_904.php">未登録の方はこちら-新規アカウント登録-</a>
</div>

</body>
</html>
    <?php
        header('Content-Type: text/html; charset=utf-8');
        try {
            //mysqlデータベース接続
            $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
            //mysqlテーブルの作成,確認
            $table= 'CREATE TABLE LOGINDATA (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30),
            password VARCHAR(30),
            create_datetime DATETIME
            ) engine=innodb default charset=utf8';
            
            if($dbh->query($table)){
                //echo "テーブル作成成功<br>";
            }else{
                //echo "テーブル作成済み<br>";
            }
            if(!empty($_POST['name']) && !empty($_POST['password'])){
                //パスワードチェック
                $f = CheckID($dbh);
                
                if($f == 0){
                    print "<script type=text/javascript>iderror()</script>";//javascript関数を呼び出す
                }else if($f == 1){
                    print "<script type=text/javascript>passerror()</script>";//javascript関数を呼び出す
                }else{
                    session_start();
                    $_SESSION['id'] = $_POST['name'];
                    $_SESSION['pass'] = $_POST['password'];
                    header("location: kadai_3-8_829.php");
                }
            }
            
            
        }catch(PDOException $e){
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
        }
        
        
        //IDチェック
        function CheckID($dbh){
            $data = 'SELECT * FROM LOGINDATA';
            $res = $dbh->query($data);
            $flag = 0;
            if($res){
                // 連想配列を取得
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    if($_POST['name'] == $row['name']){
                        if($row['registration'] == "true"){
                            $flag = Checkpass($row['id'],$dbh);
                        }else{
                            if($_GET['uid'] == $row['uniqueid']){
                                $flag = Checkpass($row['id'],$dbh);
                                $sql = "UPDATE LOGINDATA SET registration ='true' WHERE id=".$row['id'];
                                $dbh->query($sql);
                                
                            }
                        }
                        break;
                    }
                }
            }else{
            }
            return $flag;
        }
        //パスワードチェック
        function Checkpass($id,$dbh){
            $data = 'SELECT * FROM LOGINDATA WHERE id='.$id;
            $res = $dbh->query($data);
            $flag = 1;
            if($res){
                // 連想配列を取得
                $row = $res->fetch(PDO::FETCH_ASSOC);
                if($_POST['password'] == $row['password']){
                    $flag = 2;
                }
            }else{
            }
            return $flag;
        }
        
    ?>
