<?php
// Start a session
session_start();
// Check if the user is logged in
if (isset($_SESSION['username'])) {
  // Display the dashboard content
  echo "Welcome, " . $_SESSION['username'] . "<br>";
  echo "<a href='logout.php'>Logout</a>";
} else {
  // Redirect to the login page
  header("Location: index.php");
}
?>  