<?php
session_start();
if (isset($_SESSION['client_id'])) {
    echo "1"; // Logged in
} else {
    echo "0"; // Not logged in
}
?>