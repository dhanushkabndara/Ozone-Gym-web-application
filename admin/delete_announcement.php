<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php'); ?>
<?php
// checking if a user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
}

if (isset($_GET['announcement_id'])) {
    // getting the announcement information
    $a_id = mysqli_real_escape_string($connection, $_GET['announcement_id']);

    // deleting the announcement
    $query = "DELETE FROM announcement WHERE a_id = {$a_id} LIMIT 1";

    $result = mysqli_query($connection, $query);

    if ($result) {
        // announcement deleted
        header('Location: announcement_history.php?msg=announcement_deleted');
    } else {
        header('Location: announcement_history.php?err=delete_failed');
    }
} else {
    header('Location: announcement_history.php?error');
}
?>