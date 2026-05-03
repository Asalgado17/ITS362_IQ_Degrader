<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include "header.php"; ?>

<h2>Your IQ Result</h2>
<p id="score">Loading...</p>

<script>
fetch("../controllers/getIQ.php")
.then(res => res.json())
.then(data => {
    document.getElementById("score").innerText =
        "Username: " + data.username + " | IQ: " + data.iq;
});
</script>

</body>
</html>