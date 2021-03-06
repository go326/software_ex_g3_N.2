<!-- PHP -->
<?php
require("../front/f_customer.php");
// 変数宣言
$dsn = 'mysql:dbname=admin;host=localhost;charset=utf8';
$user = 'admin';
$password = 'software_ex_g3';
$rinfo = "";
$dt = new DateTime();
$date = $dt->format('Y-m-d');

try {
    $pdo = new PDO($dsn, $user, $password);

    // SELECT
    $sql = "SELECT * FROM customer WHERE is_dinner = 1";
    $stmt = $pdo->query($sql);
    $stmt->execute();

    // 表の表示
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $fdt = new DateTime($row['stay_date']);
        $fdate = $fdt->format('Y-m-d');
        for ($i = 1; $i <= $row['stay_count']; $i++) {
            if ($fdate == $date) {
                break;
            }
            $fdate = $fdt->add(DateInterval::createFromDateString("1day"))->format('Y-m-d');
        }

        if (strtotime($fdate) == strtotime($date)) {
            $rinfo .= "<tr><td>";
            $rinfo .= "<form action='../front/f_information/f_information.php' method='post'>";
            $rinfo .= "<button type='submit' name='ID' value='{$row['reseravetion_id']}'> {$row['customer_name']} </button>";
            $rinfo .= "</form>";
            $rinfo .= "</td><td>";
            $rinfo .= "{$row['adult']}</td><td>";
            $rinfo .= "{$row['child']}</td><td>";
            $rinfo .= "{$row['dinner_menu']}";
            $rinfo .= "</td></tr>";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <title>食事情報閲覧画面</title>
    <script type="text/javascript" src="restaurant.js"></script>
    <style type="text/css">
        header {
            width: 80%;
            margin: 0 auto;
        }

        footer {
            margin: 0 auto;
        }

        ul {
            text-align: right;
            list-style: none;
        }

        ul li {
            display: inline;
        }

        table {
            text-align: center;
            margin: 0 auto;
            width: 80%;
        }

        table th.name {
            width: 30%;
        }

        table th.adult {
            width: 20%;
        }

        table th.child {
            width: 20%;
        }

        table th.menu {
            width: 30%;
        }

        table tr td {
            font-size: 1.2em;
        }

        input {
            font-size: 1.2em;
        }
    </style>

</head>

<body>
    <header>
        <h1>食事情報閲覧画面</h1>
        <ul>
            <li id="view_date"></li>
        </ul>
        <script type="text/javascript">
            date();
        </script>
        <input type="button" onclick="location.href='../i_general_top.html'" value="TOP画面に戻る">
    </header>
    <!--メイン-->
    <div id="main">
        <!--食事情報閲覧画面-->
        <table border="1">
            <tr valign="top">
                <th class="name">名前</th>
                <th class="adult">大人</th>
                <th class="child">子供</th>
                <th class="menu">メニュー</th>
            </tr>
            <!-- 表の表示 -->
            <?php echo $rinfo;
            ?>
        </table>
    </div>
</body>

</html>