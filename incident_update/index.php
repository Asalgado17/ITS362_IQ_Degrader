<?php
require('../model/database.php');
require('../model/customer_db.php');
require('../model/technician_db.php');
require('../model/incident_db.php');

session_start();

$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        if (isset($_SESSION['technician'])) {    // Skip login if technician is in the session
            $action = 'display_incident_select';
        } else {
            $action = 'display_login';
        }
    }
}

//instantiate variable(s)
$email = '';

switch ($action) {
    case 'display_login':
        include('technician_login.php');
        break;
    case 'display_incident_select':
        // If technician is not in the session, set it in the session
        if (!isset($_SESSION['technician'])) {
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            if (is_valid_technician_login($email, $password)) {
                $technician = get_technician_by_email($email);
                $_SESSION['technician'] = $technician;
            }
        }
        $technician = $_SESSION['technician'];
        $incidents = get_incidents_by_technician($technician['techID']);
        if (count($incidents) == 0) {
            $message = 'There are no open incidents for this technician.';
        }
        include('incident_select.php');
        break;
    case 'select_incident':
        // Set incident in session
        $incident_id = filter_input(INPUT_POST, 'incident_id', FILTER_VALIDATE_INT);
        $_SESSION['incident_id'] = $incident_id;

        $incident = get_incident($incident_id);
        include('incident_update.php');
        break;
    case 'update_incident':
        $date_closed = filter_input(INPUT_POST, 'date_closed');
        $description = filter_input(INPUT_POST, 'description');

        $incident_id = $_SESSION['incident_id'];

        // convert date to correct format
        if (empty($date_closed)) {
            $date_closed_converted = NULL;
        } else {
            $ts = strtotime($date_closed);
            $date_closed_converted = date('Y-m-d', $ts);
        }

        $count = update_incident($incident_id, $date_closed_converted, $description);
        if ($count == 1) {
            $message = "This incident was updated.";
        } else {
            $message = "An error occurred while attempting to update the database.";
        }
        include('incident_update.php');
        break;
    case 'logout':
        unset($_SESSION['technician']);
        include('technician_login.php');
        break;
}
?>