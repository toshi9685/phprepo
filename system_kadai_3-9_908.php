    <?php
        if(empty($_GET['action'])){
            echo '<pre>';
            $last_line = system('crontab -l', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "ls"){
            echo '<pre>';
            $last_line = system('ls -l', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "pwd"){
            echo '<pre>';
            $last_line = system('pwd', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "php"){
            echo '<pre>';
            $last_line = system('which php', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "error"){
            echo '<pre>';
            $last_line = system('cat /var/log/cron', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "status"){
            echo '<pre>';
            $last_line = system('/etc/rc.d/init.d/crond status', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else if($_GET['action'] == "config"){
            echo '<pre>';
            $last_line = system('chkconfig --list crond', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }else{
            echo '<pre>';
            $last_line = system('crontab /home/co-430.it.3919.com/public_html/cron.conf', $retval);
            // 追加情報を表示します。
            echo '
            </pre>
            <hr />Last line of the output: ' . $last_line . '
            <hr />Return value: ' . $retval;
        }
    ?>
