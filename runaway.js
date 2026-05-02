let frustration = 0;

let btn = document.getElementById("runaway");

btn.addEventListener("mouseover", () => {
    let x = Math.random() * (window.innerWidth - 100);
    let y = Math.random() * (window.innerHeight - 50);

    btn.style.position = "absolute";
    btn.style.left = x + "px";
    btn.style.top = y + "px";

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