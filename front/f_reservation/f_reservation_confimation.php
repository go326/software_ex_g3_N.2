<!DOCTYPE html>
<html>

<head>
    <!--文字コードUTF-8-->
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="f_input.css" type="text/css" ?>
    <script src="f_reservation.js" ?></script>
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1>予約登録確認画面</h1>
    </header>
    <?php
    require(dirname(__FILE__) . "/../../db_connect.php");
    require(dirname(__FILE__) . "/../f_customer.php");
    global $pdo;
    if (isset($_POST['reservation'])) {
        $dt = new DateTime($_POST["stay_year"] . '/' . $_POST["stay_manth"]  . '/' . $_POST["stay_day"]); //宿泊日
        $date = $dt->format('Y-m-d');
	$count = $_POST["stay_count"];
	$is_submit = 0;
        for ($i = 1; $i <= $count; $i++) {
            for ($j = 1; $j < 4; $j++) {
                if (empty($_POST['room_number' . $j])) {
                    continue;
                }
                if (bool_stay($date, $_POST['room_number' . $j]) != 0) {
                    echo "予約が重複しています";
		    $is_submit = 1;
                    break 2;
                }
            }
            $date = $dt->add(DateInterval::createFromDateString("1day"))->format('Y-m-d');
        }
    }
    foreach ($_POST as $name => $value) {
        if (empty($value)) {
            $_POST[$name] = 'なし';
        }
    }
    ini_set('display_errors', "On");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    if (isset($_POST['cus_info'])) {
        try {
            var_dump($_POST['cus_info']);
            $sql = 'INSERT INTO customer VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,0,?)';
            $stmt = $pdo->prepare($sql);
            $dt = new DateTime(); //予約日
            $today = $dt->format('Y-m-d');
            $dt = new DateTime($_POST['cus_info'][0] . '/' . $_POST['cus_info'][1] . '/' . $_POST['cus_info'][2]); //宿泊日
            $stay_day = $dt->format('Y-m-d');
            $ID = $dt->format('Ymd');
            $ID .= $_POST['cus_info'][14];
            $is_dinner = get_num($_POST['cus_info'][10]);
            $is_breakfast = get_num($_POST['cus_info'][12]);

            $stmt->bindValue(1, $ID, PDO::PARAM_INT); //宿泊日
            $stmt->bindValue(2, $stay_day, PDO::PARAM_STR); //宿泊日
            $stmt->bindValue(3, $today, PDO::PARAM_STR);    //予約日
            $stmt->bindValue(4, $_POST['cus_info'][3], PDO::PARAM_STR);  //泊数
            $stmt->bindValue(5, $_POST['cus_info'][4], PDO::PARAM_STR);  //氏名
            $stmt->bindValue(6, $_POST['cus_info'][5], PDO::PARAM_STR);  //住所
            $stmt->bindValue(7, $_POST['cus_info'][6], PDO::PARAM_STR);  //電話番号
            $stmt->bindValue(8, $_POST['cus_info'][7], PDO::PARAM_INT);  //大人
            set_null(9, $_POST['cus_info'][8], 1); //子供
            $stmt->bindValue(10, $_POST['cus_info'][9], PDO::PARAM_STR); //プラン
            $stmt->bindValue(11, (int)$is_dinner, PDO::PARAM_INT); //is夕食
            set_null(12, $_POST['cus_info'][11], 2);  //メニュー
            $stmt->bindValue(13, (int)$is_breakfast, PDO::PARAM_INT); //is朝食
            set_null(14, $_POST['cus_info'][13], 2); //メニュー
            $stmt->bindValue(15, $_POST['cus_info'][14], PDO::PARAM_INT); //部屋１
            set_null(16, $_POST['cus_info'][15], 1); //部屋２
            set_null(17, $_POST['cus_info'][16], 1); //部屋３
            set_null(18, $_POST['cus_info'][17], 2); //備考
            $stmt->execute();
        } catch (PDOException $e) {
            var_dump($e->getMessage());
        }
        header("Location:/software_ex_g3/front/f_reservation/f_reservation_done.html");
    }

    function get_num($name)
    {
        if (strcmp($name, "有") == 0) {
            $num = 1;
        } else if (strcmp($name, "無") == 0) {
            $num = 0;
        }
        return $num;
    }
    function set_null($num, $name, $flag)
    {
        global $stmt;
        if (strcmp($name, "なし") == 0) {
            $stmt->bindValue($num, null, PDO::PARAM_NULL);
        } else if ($flag == 1) {
            $stmt->bindValue($num, (int)$name, PDO::PARAM_INT);
        } else if ($flag == 2) {
            $stmt->bindValue($num, $name, PDO::PARAM_STR);
        }
    }
    ?>

    <!--メイン-->
    <div id="main" ?>
        <dl>
            <dt>宿泊日</dt>
            <dd>
                <?php echo $_POST["stay_year"] . "年" .  $_POST["stay_manth"] . "月" . $_POST["stay_day"] . "日" ?>
            </dd>
            <dt>氏名</dt>
            <dd>
                <?php echo $_POST["name"] ?>
            </dd>
            <dt>住所</dt>
            <dd>
                <?php echo $_POST["address"] ?>
            </dd>
            <dt>電話番号</dt>
            <dd>
                <?php echo $_POST["phone"] ?>
            </dd>
            <dt>人数</dt>
            <dd>

                大人 <?php echo $_POST["adult"] ?> 人
                子供 <?php echo $_POST["child"] ?> 人
            </dd>
            <dt>プラン</dt>
            <dd>
                <?php echo $_POST["plan"] ?>
            </dd>
            <dt>夕食の有無</dt>
            <dd>
                <?php echo $_POST["is_dinner"] ?>
            </dd>
            <dt>食事のメニュー</dt>
            <dd>
                <?php echo $_POST["dinner_nemu"] ?>
            </dd>
            <dt>朝食の有無</dt>
            <dd>
                <?php echo $_POST["is_breakfast"] ?>

            </dd>
            <dt>部屋番号</dt>
            <dd>
                <?php echo $_POST['room_number1'] ?>
                <?php echo $_POST['room_number2'] ?>
                <?php echo $_POST['room_number3'] ?>
            </dd>
            <dt>備考</dt>
            <dd>
                <?php echo $_POST['remark'] ?>
            </dd>
        </dl>

    </div>
    <form action="" method="post">
        <input type="button" onclick="location.href='./f_reservation_input.html'" value="キャンセル">
        <?php
        foreach ($_POST as $info) {
        ?>
            <input type="hidden" name="cus_info[]" class="" value=<?php echo $info ?>>
        <?php
        }
        if ($is_submit == 0) {
        ?>
            <input type="submit" name="input" value="登録" class="">
        <?php
        }
        ?>
    </form>
    <!--フッター-->
</body>

</html>
