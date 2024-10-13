function calculateCost() {
    const operator = document.getElementById("operator").value;
    const city = document.getElementById("city").value;
    const time = document.getElementById("time").value;

    if (operator && city && time) {
        const xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState === 4 && xhttp.status === 200) {
                document.getElementById("cost").innerText = xhttp.responseText;
                if (/^\d+[.]?\d*$/.test(xhttp.responseText)) {
                    document.getElementById("cost").innerText += " руб."
                }
            }
        };
        xhttp.open("GET",'calculate.php?operator=' + operator + '&city=' + city + '&time=' + time, true);
        xhttp.send();
    }
}