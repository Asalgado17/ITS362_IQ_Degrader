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
        $action = 'display_incident_select';
    }
}

switch ($action) {
    case 'display_incident_select':
        $incidents = get_incidents_unassigned();
        include('incident_select.php');
        break;
    case 'select_incident':
        // Set incident in session
        $incident_id = filter_input(INPUT_POST, 'incident_id', FILTER_VALIDATE_INT);
        $_SESSION['incident_id'] = $incident_id;

        $technicians = get_technicians_with_count();
        include('technician_select.php');
        break;
    case 'select_technician':
        // Set technician ID in session
        $technician_id = filter_input(INPUT_POST, 'technician_id', FILTER_VALIDATE_INT);
        $_SESSION['technician_id'] = $technician_id;

        // Get incident ID from session
        $incident_id = $_SESSION['incident_id'];

        // Get data
        $technician = get_technician($technician_id);
        $incident = get_incident($incident_id);
        $customer = get_customer($incident['customerID']);
        include('incident_assign.php');
        break;
    case 'assign_incident':
        $count = assign_incident($_SESSION['incident_id'],
                                 $_SESSION['technician_id']);
        if ($count == 1) {
            $message = "This incident was assigned to a technician.";
        } else {
            $message = "An error occurred while attempting to update the database.";
        }
        include('incident_assign.php');
        break;
}
?>