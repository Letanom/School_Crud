<?php
class StudentDatabase {
    private static $HOST = "localhost"; 
    private static $USERNAME = "root"; 
    private static $PASSWORD = ""; 
    private static $DBNAME = "school_crud"; 

    // Veritabanı bağlantısını oluşturur
    public static function getConnection() {
        $scon = new mysqli(self::$HOST, self::$USERNAME, self::$PASSWORD, self::$DBNAME);
        if ($scon->connect_error) {
            die("Connection failed: " . $scon->connect_error);
        }
        return $scon;
    }

    // Tüm öğrencileri getirir
    public static function getAllStudents() {
        $scon = self::getConnection();
        $sql = "SELECT * FROM student_info";
        $result = $scon->query($sql);
        $scon->close();
        return $result;
    }

    // Yeni öğrenci ekler
    public static function addStudent($student_name, $student_surname) {
        $scon = self::getConnection();
        $sql = "INSERT INTO student_info (student_name, student_surname) VALUES ('$student_name', '$student_surname')";
        if ($scon->query($sql) === TRUE) {
            echo "Yeni öğrenci başarıyla eklendi";
        } else {
            echo "Error: " . $sql . "<br>" . $scon->error;
        }
        $scon->close();
    }

    //Öğrenci Silmek
    public static function deleteStudent($student_id) {
        $scon = self::getConnection();
        $sql = "DELETE FROM student_info WHERE student_id='$student_id'";
        if ($scon->query($sql) === TRUE) {
            echo "Öğrenci Başarıyla Silindi";
        } else {
            echo "Error: " . $sql . "<br>" . $scon->error;
        }
        $scon->close();
    }

    //Öğrenci Güncelleme
    public static function updateStudent($student_id, $student_name, $student_surname) {
        $scon = self::getConnection();
        $sql = "UPDATE student_info SET student_name='$student_name', student_surname='$student_surname' WHERE student_id='$student_id'";
        if ($scon->query($sql) === TRUE) {
            echo "Bilgiler Başarıyla Güncellendi";
        } else {
            echo "Error: " . $sql . "<br>" . $scon->error;
        }
        $scon->close();
    }
}
?>
