function spinWheel() {
    let games = ["game2.php", "game3.php", "brokenCalc.php"];
    let random = games[Math.floor(Math.random() * games.length)];

    alert("Spinning...");

    setTimeout(() => {
        goToLogin(random);
    }, 1000);
}

function goToLogin(game) {
    window.location.href = "../controllers/login.php?redirect=" + game;
}