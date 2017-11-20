<?php
    //mysqlデータベース接続
    try {

        $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
        if(!$dbh){
            //echo "接続できません:".mysql_error()."\n";
        }else{
            //echo "接続できました.\n";
        }
        $data = "SELECT ftype, raw_data FROM Board WHERE id ='".$_GET['id']."'";
        $res = $dbh->query($data);
        if($res){
            // 拡張子によってMIMEタイプを切り替えるための配列
            $MIMETypes = array(
                               'png'  => 'image/png',
                               'jpg'  => 'image/jpeg',
                               'jpeg' => 'image/jpeg',
                               'gif'  => 'image/gif',
                               'mpg'  => 'video/mpeg',
                               'mp4'  => 'video/mp4',
                               'mov'  => 'video/quicktime',
                               'm4v'  => 'video/quicktime',
                               'avi'  => 'video/x-msvideo'
                               );
            $row = $res->fetch(PDO::FETCH_ASSOC);
            if(!empty($row["raw_data"])){
                header("Content-Type:".$MIMETypes[$row['ftype']]);
                echo $row["raw_data"];
            }else{
                echo "empty";
            }
        }else{
            //echo "失敗<br>".mysql_error();
        }
    } catch (PDOException $e) {
        //print "エラー!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
