let currentInput = "0";
let previousInput = "";
let operation = null;
let resetScreen = false;
let expression = "";

// Create the audio elements from the Google Assistant Sound Library
const screamSound = new Audio('https://actions.google.com/sounds/v1/human_voices/death_impact_yell_single.ogg');
screamSound.loop = true; 

const cryingSound = new Audio('https://actions.google.com/sounds/v1/human_voices/male_dramatic_crying.ogg');
cryingSound.loop = true; 

const updateDisplay = () => {
    document.getElementById("display").innerText = currentInput;
    document.getElementById("expression").innerText = expression;

    const calcContainer = document.querySelector(".calc-container");

    let has21 = currentInput.includes("21");
    let has67 = currentInput.includes("67");

    //  If either number is present, make the screen shake
    if (has21 || has67) {
        calcContainer.classList.add("shake-intense");
    } else {
        calcContainer.classList.remove("shake-intense");
    }

    // Play or pause the crying sound for 21
    if (has21) {
        cryingSound.play().catch(error => console.log("Audio waiting for user click:", error));
    } else {
        cryingSound.pause();
        cryingSound.currentTime = 0;
    }

    //  Play or pause the scream sound for 67
    if (has67) {
        screamSound.play().catch(error => console.log("Audio waiting for user click:", error));
    } else {
        screamSound.pause();
        screamSound.currentTime = 0;
    }
};

function press(digit) {
    if (resetScreen) {
        currentInput = "";
        resetScreen = false;
    }
    if (currentInput === "0" && digit !== "0" && digit !== ".") {
        currentInput = digit;
    } else if (currentInput !== "0" || digit === ".") {
        // Prevent multiple decimals
        if (digit === "." && currentInput.includes(".")) return;
        currentInput += digit;
    }
    updateDisplay();
}

function setOp(op) {
    if (operation !== null) calculate();
    previousInput = currentInput;
    operation = op;
    expression = previousInput + " " + op + " ";
    resetScreen = true;
    updateDisplay(); //  clears the shake if setting an op changes the input
}

function clearScreen() {
    currentInput = "0";
    previousInput = "";
    operation = null;
    resetScreen = false;
    expression = "";
    updateDisplay();
}

function calculate() {
    if (operation === null || resetScreen) return;

    let num1 = parseFloat(previousInput);
    let num2 = parseFloat(currentInput);
    let result = 0;

    // Broken operations
    switch (operation) {
        case '+': result = num1 - num2; break; 
        case '-': result = num1 * num2; break; 
        case '*': 
            if (num2 === 0) {
                currentInput = "Error";
                updateDisplay();
                return;
            }
            result = num1 / num2; break; 
        case '/': result = num1 + num2; break; 
    }

    expression = previousInput + " " + operation + " " + currentInput + " =";
    currentInput = result.toString();
    operation = null;
    resetScreen = true;
    updateDisplay();
}

// Initial display render
updateDisplay();

function submitScore() {
    let newIq = currentIq - 10;

    fetch("../controllers/updateIQ.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ iq: newIq })
    })
    .then(() => {
        window.location.href = "results.php";
    });
}