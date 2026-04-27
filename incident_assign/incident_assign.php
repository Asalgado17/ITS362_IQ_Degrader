<?php include '../view/header.php'; ?>
<main>
    <h2>Assign Incident</h2>
    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
        <p><a href="">Select Another Incident</a></p>
    <?php else: ?>

        <form action="." method="post" id="aligned">
            <label>Customer:</label>
            <label><?php echo $customer['firstName'] . ' ' . $customer['lastName']; ?></label>
            <br>

            <label>Product:</label>
            <label><?php echo $incident['productCode']; ?></label>
            <br>

            <label>Technician:</label>
            <label><?php echo $technician['firstName'] . ' ' . $technician['lastName']; ?></label>
            <br>

            <input type="hidden" name="action" value="assign_incident">
            <input type="submit" value="Assign Incident">
        </form>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>