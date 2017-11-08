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
        }else if(document.form1.confpass.value == ""){//パスワード確認用
            flag = 1;
        }else if(document.form1.mail.value == ""){//mailadress
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

    function exiterror(){
        alert("そのIDは既につかわれています。");
    }
    </script>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset = "utf-8">
        <title>新規登録</title>
    </head>
    <body>
        <h1>新規アカウント登録</h1>
        <hr>
        <div align="center">
            <table border="0">
                <form type = "kadai_3-9_904.php" method = "post" name="form1" onsubmit = "return check()">
                    <tr>
                        <th align="right">
                            ID:
                        </th>
                        <td>
                            <input type = "text" name = "name">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            パスワード:
                        </th>
                        <td>
                            <input type = "text" name = "password">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            パスワード(再確認):
                        </th>
                        <td>
                            <input type = "text" name = "confpass">
                        </td>
                    </tr>
                    <tr>
                        <th align="right">
                            メールアドレス:
                        </th>
                        <td>
                            <input type = "text" name = "mail">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        </th>
                        <td>
                            <input type = "submit" value = "決定">
                        </td>
                    </tr>
                </form>
            </table>
            <br>
            <a href="http://co-430.99sv-coco.com/kadai_3-7_825.php">登録済みの方はこちら-ログイン-</a>
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
            create_datetime DATETIME,
            uniqueid VARCHAR(255),
            registration VARCHAR(10)
            ) engine=innodb default charset=utf8';
            
            if($dbh->query($table)){
                //echo "テーブル作成成功<br>";
            }else{
                //echo "テーブル作成済み<br>";
            }
            $checkflag = false;
            if(!empty($_POST['name']) && !empty($_POST['password'])){
                //パスワードチェック
                if(checkpass()){
                    //ID重複チェック
                    if(CheckID($dbh)){
                        print "<script type=text/javascript>exiterror()</script>";
                    }else{
                        $checkflag = true;
                    }
                }else{
                    print "<script type=text/javascript>passerror()</script>";//javascript関数を呼び出す
                }
            }
            if($checkflag){
                //アカウント情報の保存
                if(Savedata($dbh)){
                    //echo "保存に成功しました<br>";
                }else{
                    //echo "保存に失敗しました<br>";
                }
            }
            
            
        }catch(PDOException $e){
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
        }
        
        //パスワードチェックの関数
        function checkpass(){
            if($_POST['password'] == $_POST['confpass']){
                return true;//一致している時
            }else{
                return false;//一致していない時
            }
        }
        //ID重複チェック
        function CheckID($dbh){
            $data = 'SELECT * FROM LOGINDATA';
            $res = $dbh->query($data);
            $flag = false;
            if($res){
                // 連想配列を取得
                while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                    if($_POST["name"] == $row["name"]){
                        $flag = true;
                        break;
                    }
                }
            }else{
            }
            return $flag;
        }
        //指定文字数のランダムな文字列を生成
        function CreateUniqueid($idlength){
            $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z"'));
            for ($i = 0; $i < $idlength; $i++) {
                $id_str .= $str[rand(0, count($str)-1)];
            }
            return $id_str;
        }
        //新規アカウント情報の保存(認証前)
        function Savedata($dbh){
            //mysqlにデータ保存
            $t = getdate();
            $uid = CreateUniqueid(15);
            $regiflag = "false";
            $data = "INSERT INTO LOGINDATA (id,name,password,create_datetime,uniqueid,registration)VALUES('','".$_POST['name']."','".$_POST['password']."','".date("Y-m-d H:i:s",strtotime("+1 hour"))."','".$uid."','".$regiflag."')";
            if($dbh->query($data)){
                Sendconfmail($uid);
                return true;
            }else{
                return false;
            }
        }
        //確認メールの送信
        function Sendconfmail($uid){
            mb_language("Japanese");
            mb_internal_encoding("UTF-8");
            $title = "掲示板登録の認証メールです";
            $to = $_POST['mail'];
            $content = "ログインする場合はこのURLからログインをお願いします。http://co-430.99sv-coco.com/kadai_3-7_825.php?uid=".$uid;
            if(mb_send_mail($to, $title, $content)){
                echo "メールを送信しました。認証するまでログインできません。";
            } else {
                //再送システムの導入
                echo "メールの送信に失敗しました";
            }
        }
        
    ?>
