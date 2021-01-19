<?php
$auth = $_POST['auth'];

function IAuthCheckP($auth,$auth_check){

    if(strpos($manual_file_name, $auth_check) !== false){    
        return true;
    }else{
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <!--文字コードUTF-8-->
    <meta charset="UTF-8">
    <link rel="stylesheet" href="i_general_top.css">
    <title>総合TOP</title>
</head>

<body>
    <!--ヘッダー-->
    <header>
        <h1>ホテルマネジメントシステム総合TOP</h1>
        <fieldset class="back">
            <center>
                <h2>機能選択</h2>
            </center>
            <div class="inner">
                <button type="button" class="flont" onclick="location.href='front/room.php'">フロント業務機能</button>
                <button type="button" class="seisou"
                    onclick="location.href='seisou/s_clean_management.php'">清掃業務機能</button>
            </div>

            <div class="inner">
                <button type="button" class="restaurant"
                    onclick="location.href='restaurant/r_information.php'">レストラン業務機能</button>
                <button type="button" class="manual" onclick="location.href='manual/i_mq_top.html'">マニュアル・質問閲覧</button>
            </div>

            <div class="inner">
                <button type="button" class="kanri" onclick="location.href='kanri/k_top.html'">管理者専用機能</button>
                <button type="button" class="logout" onclick="location.href='i_login.html'">ログアウト</button>
            </div>
        </fieldset>


</body>

</html>