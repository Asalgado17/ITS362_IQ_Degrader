<?php include '../view/header.php'; ?>
<main>
    <h1>Database Error</h1>
    <p>An error occurred while attempting to work with the database.</p>
    <p>Message: <?php echo htmlspecialchars($error_message); ?></p>
</main>
<?php include '../view/footer.php'; ?>