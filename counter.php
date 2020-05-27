<?php

session_start();

    if ($_SESSION["calangle"] > $_SESSION["live_angle"]) {
        $_SESSION["repcounter"] = $_SESSION["repcounter"] + 1;
    }

echo "Total reps = " . $_SESSION["repcounter"];

?>