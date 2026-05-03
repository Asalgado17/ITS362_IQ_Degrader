let frustration = 0;

let box = document.getElementById("box");

box.addEventListener("input", () => {
    let val = box.value;

    box.value = val
        .split("")
        .map(c => Math.random() > 0.7 ? "#" : c)
        .join("");

    frustration++;
});

function submitIQ() {
    let iq = 100 - frustration;

    fetch("../controllers/updateIQ.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ iq: iq })
    })
    .then(() => {
        window.location.href = "results.php";
    });
}