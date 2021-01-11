<?php

include("../db_connect.php");
require("./f_customer.php");
global $pdo;

$sql = "SELECT room_number FROM  room";
$smt = $pdo->prepare($sql);
$data = $smt->execute();
$data = $smt->fetchAll(PDO::FETCH_NUM);

$room = array();
foreach ($data as $value) {
    array_push($room, $value[0]);
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″>
    <link rel="stylesheet" href="../seisou/clean_management.css" type="text/css">
    <link rel="stylesheet" href="f_top.css" type="text/css">
    <script src="f_top.js"></script>
    <!--今日の日付を取得-->
    <title>フロントTOP画面</title>

</head>

<body>
    <header>
        <h1> フロントTOP画面</h1>

        <!--戻るボタン(清掃で使用していたコード)-->
        <!--<div class="button-position-c">
            <div class="input#submit_button">
                <form action="../i_general_top.html">
                    <input id="submit_button" type="submit" name="submit" value="総合TOP画面へ戻る">
                </form>
            </div>
        </div>-->
        <!--総合TOP、新規入力、-->
        <ul>
            <li><input type="button" onclick="location.href='../i_general_top.html'" value="総合TOPへ戻る">
            <li><input type="button" onclick="location.href='f_reservation/f_reservation_input.html'" value="新規入力"></li>
            <li><input type="button" onclick="location.href='f_search/f_search.html'" value="予約検索"></li>
            <li id="view_date"></li>
        </ul>
        <!--今日の日付の表示-->
        <script type="text/javascript">
            date();
        </script>


        <!--日付取得-->
        <?php

        $dt = new DateTime(); //予約日
        $today = $dt->format('Y-m-d');
        ?>
        <!--
        <span class="sample0"><button class="bg_color0"></button></span>掃除していない、予約なしの状態<br>
        <span class="sample1"><button class="bg_color0"></button></span>お客様がチェックインしている状態<br>
        <span class="sample2"><button class="bg_color0"></button></span>掃除済み状態<br>-->
    </header>

    <!--清掃情報確認画面の枠組みの作成-->
    <form method="post" action="./f_information/f_information.php">
        <?php
        //３階分テーブルを作成する
        foreach ($room as $num => $value) {

            $ID = bool_stay($today, $value);

            if ($value % 100 == 1) {
                echo ("<table>");
                //ホテルの１階分だけループする。
                $room_count = 0; //1階の部屋数のカウント
                echo ("<tr>");
                //表の１行に表示する部屋数分だけループする
            }
            //1セルの表示開始
            echo ("<td>");
            //1部屋のリンク現在はボタンで作成
            //チェックインの情報をとるかな？
            $SCMroom_clean = SCleanManagemantP($value);
            //bg_color0,1,2あるがこれを文字列結合で判断している。
            echo ("<button class = room_button bg_color" . $SCMroom_clean . " type = submit value = " . $ID . " name = ID >");

            //1セルの表示名
            //1行目
            echo ($value);
            //改行
            echo ("<br>");

            echo cus_name($ID) . "<br>";
            //今日の宿泊者数
            $number_people = SCleanNumberP($ID);
            echo ("本日" . $number_people . "人");
            echo ("<br>");
            echo ("</button>");
            echo ("</td>\n");

            //１セル終了

            //セルのカウント
            $room_count++;
            //セルが8個並ぶとtrで改行を入れる
            if ($room_count % 8 == 0) {
                echo ("</tr>"); //一行分の<tr>~</tr>
                echo ("<tr>"); //次の<tr>を開始
            }

            if ($value[$num + 1] % 100 == 35) {
                echo ("</tr>");
                echo ("</table>\n");
            }
        }
        ?>
    </form>
</body>

</html>

<?php
//清掃情報確認画面の枠組みに反映
//清掃情報確認画面の枠組みの清掃状況を取り出し
//ここで参照する色を決めている
function SCleanManagemantP($ID)
{
    global $pdo;
    $room_clean = 0; //清掃状況、初期値は0で宿泊予定者がいないことを示す。
    $stmt = $pdo->prepare("SELECT customer_checkin FROM customer WHERE reseravetion_id = ?");
    $stmt->bindValue(1, $ID);
    $stmt->execute();
    //fetch
    while ($row = $stmt->fetch()) {
        $data = $row['customer_checkin'];
    }
    return $data;
}


?>