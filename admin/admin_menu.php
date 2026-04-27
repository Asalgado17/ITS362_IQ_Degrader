<?php
    require_once('../util/secure_conn.php');
    require_once('../util/valid_admin.php');
?>
<?php include '../view/header.php'; ?>
<main>
    <h2>Admin Menu</h2>
    <nav>
    <ul>
        <li><a href="../product_manager">Manage Products</a></li>
        <li><a href="../technician_manager">Manage Technicians</a></li>
        <li><a href="../customer_manager">Manage Customers</a></li>
        <li><a href="../incident_create">Create Incident</a></li>
        <li><a href="../incident_assign">Assign Incident</a></li>
        <li><a href="../incident_display">Display Incidents</a></li>
    </ul>
    </nav>

    <h2>Login Status</h2>
    <p>You are logged in as <?php echo $_SESSION['admin']; ?>.</p>
    <form action="" method="post">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>

</main>
<?php include '../view/footer.php'; ?>