<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['client_id'])) {
    header("Location: login.html");
    exit();
}

// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_Client";

$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// جلب البيانات من الفورم
$Id_client  = $_SESSION['client_id'];
$nom        = $_POST['nom'];
$price      = $_POST['price'];
$reference  = $_POST['reference'];
$color      = isset($_POST['color']) ? $_POST['color'] : null;
$quantite   = $_POST['quantite'];
$image      = isset($_POST['image']) ? $_POST['image'] : ""; // ✅ جلب الصورة

if ($color === null) {
    echo "<script>alert('❌ You must choose a color.'); window.history.back();</script>";
    exit();
}

// تحضير الاستعلام
$sql = "INSERT INTO commande_produit (Id_client, Vendeur_prod, Prix_prod, Ref_prod, Colr_prod, Qant_prod)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("issssi", $Id_client, $nom, $price, $reference, $color, $quantite);

// تنفيذ الاستعلام
if ($stmt->execute()) {
    echo "<script>
    alert('✅ Your order has been sent successfully.');
    window.location.href = 'comande_produit.html?image=" . urlencode($image) . "&price=" . urlencode($price) . "&reference=" . urlencode($reference) . "';
</script>";
} else {
    echo "<script>alert('❌ Error sending order: " . $stmt->error . "'); window.history.back();</script>";
}

// غلق الاتصال
$stmt->close();
$conn->close();
?>