    <?php
        
        try{
            //mysqlデータベース接続
            $dbh = new PDO('mysql:host=ホスト名;dbname=データベース名', 'ユーザ名', 'パスワード');
            
            //mysqlデータの取得
            //時間条件検索
            $data = 'SELECT * FROM LOGINDATA';
                if($res = $dbh->query($data)){
                    $stack = array();
                    // 連想配列を取得
                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        if(strtotime(date("Y-m-d H:i:s")) > strtotime('$row["create_datetime"]') && $row["registration"] == "false"){
                            array_push($stack,$row["id"]);
                        }
                    }
                    for($i=0;$i<count($stack);$i++){
                        $sql = 'DELETE FROM LOGINDATA WHERE id='.$stack[$i];
                        $res = $dbh->prepare($sql);
                        $res -> execute();
                    }
                }
                else{
                }
        }catch(PDOException $e){
            print "エラー!: " . $e->getMessage() . "<br/>";
            die();
        }
    ?>
