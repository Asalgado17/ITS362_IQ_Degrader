<?php
    // make sure the user is logged in as a valid technician
    if (!isset($_SESSION['technician'])) {
        header('Location: .' );
    }
?>