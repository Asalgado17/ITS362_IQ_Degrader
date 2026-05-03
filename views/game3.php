<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php
session_start();

// Redirect guests who try to access the game directly
if (!isset($_SESSION['username'])) {
    header("Location: ../controllers/login.php?redirect=game3.php");
    exit();
}

include "header.php";
?>

<h2>Your IQ Result</h2>

<p id="score">Loading...</p>

<script>
fetch("../controllers/getIQ.php")
.then(res => res.json())
.then(data => {
    document.getElementById("score").innerText =
        "Username: " + data.username + 
        " | IQ: " + data.iq;
});
</script>

</body>
</html>