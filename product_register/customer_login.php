<?php
    require_once('../util/secure_conn.php');
?>
<?php include '../view/header.php'; ?>
<main>
    <h2>Customer Login</h2>
    <p>You must login before you can register a product.</p>
    <form action="" method="post" id="aligned">
        <input type="hidden" name="action" value="display_register">

        <label>Email:</label>
        <input type="input" name="email" value="">
        <br>

        <label>Password:</label>
        <input type="password" name="password" value="">
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Login">
    </form>
</main>
<?php include '../view/footer.php'; ?>