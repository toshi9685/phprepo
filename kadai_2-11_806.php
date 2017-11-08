<?php
    //phpのバージョンは4,5に対応
    header('Content-Type: text/html; charset=utf-8');
    $link = mysql_connect('ホスト名','ユーザ名','パスワード');
    if(!$link){
        echo "接続できません:".mysql_error()."\n";
    }else{
        echo "接続できました.\n";
    }
    $db_selected = mysql_select_db('データベース名',$link);
    if(!$db_selected){
        echo "can't use";
    }else{
        echo "can use";
    }
    $date = getdate();
    $data = "INSERT INTO keijiban (id,name,comment,create_datetime,password)VALUES('0','name0','comment0','" . $date . "','pass')";
    $res = mysql_query($data,$link);
    if($res){
        echo "成功!<br>".mysql_error();
    }else{
        echo "失敗<br>".mysql_error();
    }
    mysql_close($link);
?>
