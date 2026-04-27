<?php
    // make sure the user is logged in as a valid customer
    if (!isset($_SESSION['customer'])) {
        header('Location: .' );
    }
?>