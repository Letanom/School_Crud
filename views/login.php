<?php
session_start(); // Oturumu başlat

require('../config/connection.php');

if(isset($_POST['login_Button'])){
    $_SESSION['validate'] = false;
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Şifre kontrolü için MD5 kullanılması güvenli değil, ancak burada mevcut uygulamanın mevcut yapısını koruyacağım.
    // Gerçek bir uygulamada parola kontrolü için daha güçlü bir yöntem (örneğin, bcrypt) kullanılmalıdır.

    
    $p = Database::connect()->prepare('SELECT * FROM registration WHERE email = :e AND password = :p');
    $p->bindValue(':e', $email);
    $p->bindValue(':p', $password);
    $p->execute();
    $d=$p->fetchAll(PDO::FETCH_ASSOC);
    // Kullanıcı veritabanında bulunduysa oturum değişkenlerini ayarla
    if($p->rowCount()>0){
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['validate'] = true;
        // Giriş başarılı olduğunda yönlendirme yap
        header('Location: ../public/index.html');
        exit(); // İşlemi sonlandır
    } else {
        echo "Giriş Başarısız";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/styles/login.css">
    <title>Giriş Paneli</title>
</head>
<body>
    <div class="container">
        <h5 class="title">Kevın Özşimşek Öğrenci Giriş Paneli </h5>
        <form action="" method="POST">
            <input type="text" placeholder="Email Adresiniz" name="email" required class="input" />
            <input type="password" placeholder="Şifreniz" name="password" required class="input" />
            <input type="submit"  value="Giriş Yap" name="login_Button" id="submit"> 
        </form>
        <p>Hesabınız yok mu? <a href="register.php">Kaydolun</a></p>
    </div>
</body>
</html>
