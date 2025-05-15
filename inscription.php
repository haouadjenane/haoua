<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base_client"; // اسم قاعدة البيانات الصحيح

    // الاتصال بقاعدة البيانات
    $conn = new mysqli($servername, $username, $password, $dbname);

    // التحقق من الاتصال
    if ($conn->connect_error) {
        die("Échec de la connexion: " . $conn->connect_error);
    }
    

    // استرجاع البيانات من النموذج
    $nom = $_POST['No_Clt'];
    $prenom = $_POST['Pno_Clt'];
    $age = (int) $_POST['Age_Clt'];
    $wilaya = $_POST['Wi_Clt'];
    $telephone = $_POST['Tel_Clt']; // تأكد من أن هذا نص
    $email = $_POST['Mail_Clt'];
    $adresse = $_POST['Adr_Clt'];
    $motdepasse = password_hash($_POST['Mot_Clt'], PASSWORD_DEFAULT); 
    $sexe = $_POST['Sexe_Clt'];

    // استخدام استعلام محضّر لتفادي SQL Injection
    $stmt = $conn->prepare("INSERT INTO client 
        (No_Clt, Pno_Clt, Age_Clt, Wi_Clt, Tel_Clt, Mail_Clt, Adr_Clt, Mot_Clt, Sexe_Clt)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssissssss", 
        $nom, $prenom, $age, $wilaya, $telephone, $email, $adresse, $motdepasse, $sexe);

    // تنفيذ الإدخال
    if ($stmt->execute()) {
        echo "<h3>Inscription réussie ! Bienvenue $prenom $nom.</h3>";
    } else {
        echo "Erreur: " . $stmt->error;
    }

    // غلق الاتصال
    $stmt->close();
    $conn->close();
}
?>