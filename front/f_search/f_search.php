<?php
include("../../db_connect.php");

global $pdo;

ini_set('display_errors', "On");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
var_dump($_POST);
try {
    if (isset($_POST['search'])) {
        $sql = "SELECT * FROM " . $_POST['reservation'] . " where ";
        // if ($_POST['reservation']  == 'past') {
        if (!empty($_POST['tel']) && !empty($_POST['name'])) {
            $sql .= " phone_number = :phone and customer_name like :name";
            $name = "%" . $_POST['name'] . "%";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':phone', $_POST['tel'], PDO::PARAM_STR);
            $smt->bindValue(':name', $name, PDO::PARAM_STR);
        } else if (!empty($_POST['name'])) {
            $sql .= " customer_name like :name ";
            $name = "%" . $_POST['name'] . "%";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':name', $name, PDO::PARAM_STR);
        } else if (!empty($_POST['tel'])) {
            $sql .= " phone_number = :phone";
            $smt = $pdo->prepare($sql);
            $smt->bindValue(':phone', $_POST['tel'], PDO::PARAM_STR);
        }
        echo $sql;
        echo "<br>";
        $smt->execute();
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
        var_dump($data);
    } else {
        header("Location:./f_search.html");
    }
} catch (PDOException $e) {
    var_dump($e->getMessage());
}

foreach ($data as $row) {

?>
    <form method="post" name="form1" action="../f_information/f_information.php">
    <?php
    $res = "<tr>";
    $res .= "<td><a href='' value=" . $row['reseravetion_id'] . ">" . $row['reseravetion_id'] . "</a></td>";
    $res .= "<td>" . $row['stay_date'] . "</td>";
    $res .= "<td>" . $row['reservation_date'] . "</td>";
    $res .= "<td>" . $row['stay_count'] . "</td>";
    $res .= "<td>" . $row['customer_name'] . "</td>";
    $res .= "<td>" . $row['customer_address'] . "</td>";
    $res .= "<td>" . $row['phone_number'] . "</td></th></tr>";
}
echo $res;
    ?>
    </form>