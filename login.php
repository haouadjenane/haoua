<?php
session_start(); // بداية الجلسة

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_client";

// إنشاء الاتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استرجاع البيانات من النموذج
    $email = $_POST['email'];
    $password = $_POST['password'];
    header("Location: comande_produit.html");
exit();

    // استعلام للتحقق من وجود المستخدم بناءً على البريد الإلكتروني
    $sql = "SELECT * FROM client WHERE Mail_Clt = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // ربط البريد الإلكتروني بالاستعلام
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // إذا كانت هناك نتائج، تحقق من كلمة السر
        $row = $result->fetch_assoc();
        
        // التحقق من كلمة السر باستخدام دالة password_verify
        if (password_verify($password, $row['Mot_Clt'])) {
            // إذا كانت كلمة السر صحيحة، تبدأ الجلسة وتخزن بيانات المستخدم
            $_SESSION['client_id'] = $row['id_Clt'];
            $_SESSION['first_name'] = $row['No_Clt'];
            $_SESSION['last_name'] = $row['Pno_Clt'];
            echo "<script>alert('Login successful! Welcome, " . $row['No_Clt'] . "');</script>";
            echo "<script>window.location.href = 'index.html';</script>"; 
        } else {
            // إذا كانت كلمة السر خاطئة
            echo "<script>alert('Incorrect password'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email not found'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>