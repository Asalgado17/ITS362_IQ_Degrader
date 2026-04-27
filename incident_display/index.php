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
        $action = 'display_unassigned';
    }
}

switch ($action) {
    case 'display_unassigned':
        $incidents = get_incidents_unassigned();
        include('incidents_unassigned.php');
        break;
    case 'display_assigned':
        $incidents = get_incidents_assigned();
        include('incidents_assigned.php');
        break;
}
?>