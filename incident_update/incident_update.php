<?php
    require_once('../util/secure_conn.php');
    require_once('../util/valid_technician.php');
?>
<?php include '../view/header.php'; ?>
<main>
    <h2>Update Incident</h2>
    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
        <p><a href="">Select Another Incident</a></p>
    <?php else: 
        $ts = strtotime($incident['dateOpened']);
        $date_opened = date('n/j/Y', $ts);
    ?>
        <form action="" method="post" id="aligned">
            <label>Incident ID:</label>
            <label><?php echo $incident['incidentID']; ?></label>
            <br>

            <label>Product Code:</label>
            <label><?php echo $incident['productCode']; ?></label>
            <br>

            <label>Date Opened:</label>
            <label><?php echo $date_opened; ?></label>
            <br>

            <label>Date Closed:</label>
            <input type="text" name="date_closed">
            <br>

            <label>Title:</label>
            <label class="wide"><?php echo $incident['title']; ?></label>
            <br>

            <label>Description:</label>
            <textarea name="description" cols="40" rows="6"><?php echo $incident['description']; ?></textarea>
            <br>

            <input type="hidden" name="action" value="update_incident">
            <input type="submit" value="Update Incident">
        </form>
    <?php endif; ?>
    <p>You are logged in as <?php echo $_SESSION['technician']['email']; ?></p>
    <form action="" method="post">
        <input type="hidden" name="action" value="logout">
        <input type="submit" value="Logout">
    </form>
</main>
<?php include '../view/footer.php'; ?>