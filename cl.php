<?php

session_start();
include "config/db.php";


if (isset($_GET['offer_id']) && !empty($_GET['offer_id']) && isset($_SESSION["id"])) {
    $idUser = $_GET["userid"];

    $offer_id = $_GET['offer_id'];
    $is_valid_offer_id = false; //true if offer id is valid
    //setup required variables
    $userid = "10188"; //<< fill this in with your userid
    //url to request
    $url = "https://mobverify.com/api/v1/?affiliateid=" . urlencode($userid);

    //initialize curl
    $ch = curl_init();

    //setup curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    //make request
    $response = curl_exec($ch);

    if ($response === false) {
        //curl error occurred, handle it how you like
        echo curl_error($ch);
    }

    //close the curl object
    curl_close($ch);

    if ($response !== false) {
        //curl request was successful
        //decode the json response into a php array
        $json = json_decode($response, true);

        if ($json === false) {
            //failed to decode json response
            echo json_last_error_msg();
        } elseif ($json['success']) {

            //api call was successful
            //loop through the offers
            foreach ($json['offers'] as $offer) {

                //check if offer id is valid
                if ($offer['offerid'] == $offer_id) {
                    $image = $offer['picture'];
                    $offer_name = $offer['name_short'];
                    $description = $offer['description'];
                    $points = $offer['payout'];
                    $epc = $offer['epc'];

                    $is_valid_offer_id = true;
                    break;
                }
            }
        } else {
            //api error occurred, handle it how you like
            echo $json['error'];
        }
    }


    if ($is_valid_offer_id) {

        $sql = "SELECT * FROM user_data WHERE id_offer=$offer_id";
        $result = mysqli_query($conn, $sql);
        //check if user already completed this offer
        if (mysqli_num_rows($result) > 0) {
            header("Location: dashboard.php?msg=exist");
        } else {
            //create user offer data
            $query = "INSERT INTO user_data SET id_offer=?, offer_name=?, offer_image=?, description=?, points=?, epc=?, id_user=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('isssddi', $offer_id, $offer_name, $image, $description, $points, $epc, $idUser);
            $result = $stmt->execute();

            if ($result) {

                //update user current points
                $query = "UPDATE user SET current_points=current_points+? WHERE id=?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('di', $points, $idUser);
                $result = $stmt->execute();

                if ($result) {
                    $stmt->close();
                    header("Location: dashboard.php?msg=done");
                } else {
                    echo $conn->error;
                }
            } else {
                echo $conn->error;
            }
        }
    } else {
        echo "Offer id not valid.";
    }
} else {
    echo "Offer id not valid.";
}


