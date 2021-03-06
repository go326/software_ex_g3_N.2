    <?php
    session_start();
    # var
    $dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
    $user = 'admin';
    $password = 'software_ex_g3';

    $sql = "";
    $res = "";


    try {
        $pdo = new PDO($dsn, $user, $password);
        // SELECT
        function KLogListP()
        {
            global $pdo, $sql, $res;
            $sql = "SELECT * FROM log";
            $stmt = $pdo->query($sql);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $res .= "<tr><td>";
                $res .= substr($row['log_date'], 0, 10);
                $res .= "</td><td>";
                $res .= $row['log_name'];
                $res .= "</td><td>";
                $res .= $row['log_work'];
                $res .= "</td><td>";
                $res .= $row['log_table'];
                $res .= "</td><td>";
                $res .= $row['log_line'];
                $res .= "</td><td>";
                $res .= $row['log_attribute'];
                $res .= "</td><td>";
                $res .= $row['log_befor'];
                $res .= "</td><td>";
                $res .= $row['log_after'];
                $res .= "</td></tr>";
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    ?>
    <?php require_once("k_log_record.php"); ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>システムログ参照</title>
        <style type="text/css">
        header {
            width: 80%;
            margin: 0 auto;
        }

        footer {
            margin: 0 auto;
        }

        table {
            text-align: center;
            margin: 0 auto;
            width: 80%;
            display: block;
            overflow-x: scroll;
            white-space: nowrap;
        }
    </style>
    </head>

    <body>

        <header>
            <h1>システムログ参照</h1>
            <input type="button" onclick="location.href='k_top.html'" value="TOPへ戻る">

        </header>
        <!-- Management -->
        <table border="1">
            <tr valign="top">
                <th>日付</th>
                <th>変更者</th>
                <th>変更業務</th>
                <th>変更テーブル</th>
                <th>変更行</th>
                <th>変更属性</th>
                <th>変更前</th>
                <th>変更後</th>

            </tr>
            <?php KLogListP();
            echo $res; ?>
        </table>

    </body>

    </html>