function pickFunction() {
    document.getElementById("picked_id").style.display = "block";
    document.getElementById("ing_id").style.display = "none";
    document.getElementById("finish_id").style.display = "none";
}

function spreadFunction() {
    document.getElementById("ing_id").style.display = "none";
    document.getElementById("finish_id").style.display = "none";
    document.getElementById("spread_id").style.display = "block";
}

function ingFunction() {
    if (document.getElementById("picked_id") != null) {
        document.getElementById("picked_id").style.display = "none";
    } else {
        document.getElementById("spread_id").style.display = "none";
    }
    document.getElementById("ing_id").style.display = "block";
    document.getElementById("finish_id").style.display = "none";
}

function finFunction() {
    if (document.getElementById("picked_id") != null) {
        document.getElementById("picked_id").style.display = "none";
    } else {
        document.getElementById("spread_id").style.display = "none";
    }
    document.getElementById("ing_id").style.display = "none";
    document.getElementById("finish_id").style.display = "block";
}