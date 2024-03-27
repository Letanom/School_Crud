<?php 
class Database {
    //Veritabanı ayarlarım.
    private static $HOST = "localhost"; 
    private static $USERNAME = "root"; 
    private static $PASSWORD = ""; 
    private static $DBNAME = "school_crud"; 

    // Veritabanı bağlantısını saklamak için bir statik değişken tanımlıyoruz
    private static $connection;

    // Veritabanına bağlanmayı sağlayan statik bir fonksiyon tanımlıyoruz
    public static function connect() {
        try {
            //PDO kullanırken, veritabanına bağlanmak için DSN
            $dsn = "mysql:host=" . self::$HOST . ";dbname=" . self::$DBNAME;
            //statik bir metot içinde değişkene self ile erişirim.
            // PDO nesnesi oluşturarak veritabanına bağlanıyoruz
            self::$connection = new PDO($dsn, self::$USERNAME, self::$PASSWORD);
            
            // Hata modunu ayarlıyoruz, hataların istisnalar olarak fırlatılmasını sağlıyoruz
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Bağlantı başarılı ise başarılı bir mesaj yazdırıyoruz
        
        } catch(PDOException $e) {
            // Bağlantı sırasında bir hata oluşursa, hatayı ekrana yazdırıyoruz
            echo "Connection failed: " . $e->getMessage();
        }
        // Oluşturulan PDO bağlantısını döndürüyoruz
        return self::$connection;
    }
}
?>
