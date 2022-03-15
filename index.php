<?php

require_once '_connec.php';

$pdo = new \PDO(DSN, USER, PASS);


///////////// INSERT /////////////
function validator (array $postValues) {
    foreach($postValues as $value) {
        if (empty($value) || strlen($value) > 45) {
            return false;
        } else {
            return true;
        }
    }
};
$validator_result = validator($_POST);

if($validator_result == true) {
    $firstname = trim($_POST['user_firstname']);
    $lastname = trim($_POST['user_lastname']);

    $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
    $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

    $statement->execute();
    header('location:index.php');
}

///////////// SELECT /////////////
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll(PDO::FETCH_CLASS);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Challenge</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <ul>
        <?php
            foreach($friends as $friend) {
                echo '<li>' . $friend->firstname . ' ' . $friend->lastname . ' ' . '</li>';
            }
        ?>
    </ul>

    <form action="index.php" method="post" class="form">
        <label for="firstname">Your firstname</label>
        <input type="text" id="firstname" name="user_firstname"  required="required">
        <label for="lastname">Your lastname</label>
        <input type="text" id="lastname" name="user_lastname"  required="required">
        <input type="submit">
    </form>
</body>
</html>




