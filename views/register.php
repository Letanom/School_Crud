<?php
require('../config/connection.php');

if(isset($_POST['register_Button'])){
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Boş alan kontrolü
    if(!empty($name) && !empty($surname) && !empty($email) && !empty($password)) {
       
        // SQL injection koruması için PDO kullanarak veritabanına ekle
        $p = Database::connect()->prepare('INSERT INTO registration(name, surname, email, password) VALUES(:n, :s, :e, :p)');
        $p->bindParam(':n', $name);
        $p->bindParam(':s', $surname);
        $p->bindParam(':e', $email);
        $p->bindParam(':p', $password);       
        $p->execute();
        
        // Kayıt başarılı mesajını göster ve ardından yönlendir
        echo 'KAYIT BAŞARILI ';
        header('Location: login.php');
        exit; 
    } else {
        echo "Bilgilerinizi kontrol ediniz!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/register.css">
</head>
<body>
    <div class="container">
        <form action="" method="post" id="register-form">
            <h2>Kayıt Ol</h2>
            <div class="form-group">
                <input type="text" id="firstName" placeholder="Adınız" name="name" required>
            </div>
            <div class="form-group">
                <input type="text" id="lastName" placeholder="Soyadınız" name="surname" required>
            </div>
            <div class="form-group">
                <input type="email" id="email" placeholder="E-posta Adresiniz" name="email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" placeholder="Şifreniz" name="password" required>
            </div>
            <div class="submit-container">
                <input type="submit"  value="Kayıt Ol" name="register_Button" id ="submit"> 
            </div>
        </form>
    </div>
</body>
</html>
