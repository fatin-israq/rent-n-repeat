<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

echo "<h2>Welcome, " . $_SESSION['name'] . "!</h2>";

if ($_SESSION['role'] == 'lessee') {
    echo "<p>You are logged in as a lessee.</p>";
} else if ($_SESSION['role'] == 'lessor') {
    echo "<p>You are logged in as a lessor.</p>";
}
?>
<a href="logout.php">Logout</a>