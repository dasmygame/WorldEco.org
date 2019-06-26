<?php

session_start();
$idUser = $_SESSION["id"];
include "config/db.php";


if (isset($_GET['r']) && !empty($_GET['r']) && is_numeric($_GET['r'])) {

    $redeem_value = htmlspecialchars($_GET['r']);
    $redeem_value = $redeem_value / 100;

    //get current points
    $result_00 = $conn->query("SELECT current_points FROM user WHERE id = $idUser;");

    if ($result_00) {
        $row_00 = $result_00->fetch_assoc();
        $current_points = $row_00["current_points"];

        if ($current_points < $redeem_value) {
            header("Location: dashboard.php?msg=not-sufficient");
        } else {

            //update user current points
            $query = "UPDATE user SET current_points=current_points-? WHERE id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('di', $redeem_value, $idUser);
            $result = $stmt->execute();

            if ($result) {
                $stmt->close();
                header("Location: dashboard.php?msg=done-r");
            } else {
                echo $conn->error;
            }
        }
    } else {
        echo $conn->error;
    }
} else {
    header("Location: dashboard.php?msg=error");
}