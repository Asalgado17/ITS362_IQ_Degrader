<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broken Calculator</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>

<?php
session_start();

// Redirect guests who try to access the game directly
if (!isset($_SESSION['username'])) {
    header("Location: ../controllers/login.php?redirect=brokenCalc.php");
    exit();
}

include "header.php";
?>

    <div class="calc-container">
        <div class="brand">We can help solve your problems! 113+46 </div>
        <div class="screen">
            <div id="expression"></div>
            <div id="display">0</div>
        </div>
        <div class="keypad">
            <button onclick="press('7')">7</button>
            <button onclick="press('8')">8</button>
            <button onclick="press('9')">9</button>
            <button onclick="setOp('+')">+</button>

            <button onclick="press('4')">4</button>
            <button onclick="press('5')">5</button>
            <button onclick="press('6')">6</button>
            <button onclick="setOp('-')">-</button>

            <button onclick="press('1')">1</button>
            <button onclick="press('2')">2</button>
            <button onclick="press('3')">3</button>
            <button onclick="setOp('*')">*</button>

            <button onclick="press('0')">0</button>
            <button onclick="press('.')">.</button>
            <button onclick="press('00')">00</button>
            <button onclick="setOp('/')">/</button>

            <button class="clear-btn" onclick="clearScreen()">C</button>
            <button class="equals-btn" onclick="calculate()">=</button>
        </div>
    </div>

    <button onclick="submitScore()" style="background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; margin-top: 20px;">Submit Score (Lose 10 IQ)</button>

    <script>
        let currentIq = <?php echo $_SESSION['iq']; ?>;
    </script>
    <script src="../assets/js/brokenCalc.js"></script>
</body>
</html>