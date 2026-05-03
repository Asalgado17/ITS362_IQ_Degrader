<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Degrader - Home</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php include "header.php"; ?>

<h1>IQ Degrader</h1>
<p>A game your parents don't want you to play</p>

<button onclick="spinWheel()">🎡 Spin for Random Game</button>

<h2>Or Choose a Game</h2>

<div class="game-box" onclick="goToLogin('brokenCalc.php')">
    Broken Calculator
</div>

<div class="game-box" onclick="goToLogin('game2.php')">
    Runaway Button
</div>

<div class="game-box" onclick="goToLogin('game3.php')">
    Evil Typing Test
</div>

<script src="../assets/js/wheel.js"></script>

</body>
</html>