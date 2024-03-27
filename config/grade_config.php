<?php
class GradeConfig {
    private static $HOST = "localhost";
    private static $USERNAME = "root";
    private static $PASSWORD = "";
    private static $DBNAME = "school_crud";
    private static $db;

    // Bağlantıyı başlat
    private static function init() {
        self::$db = new mysqli(self::$HOST, self::$USERNAME, self::$PASSWORD, self::$DBNAME);
        if (self::$db->connect_error) {
            die("Connection failed: " . self::$db->connect_error);
        }
    }

    // CREATE  işlemi
    public static function insertGrade($student_number, $course_name, $semester_1_grade, $semester_2_grade) {
        self::init();
        // Ortalama hesaplanıyor
        $average = ($semester_1_grade + $semester_2_grade) / 2;
        $sql = "INSERT INTO student_grades (student_number, course_name, semester_1_grade, semester_2_grade, average) VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param("ssddd", $student_number, $course_name, $semester_1_grade, $semester_2_grade, $average);
        $stmt->execute();
        $stmt->close();
        self::$db->close();
    }

    // READ  işlemi: Tüm notları al
    public static function getAllGrades() {
        self::init();
        $sql = "SELECT * FROM student_grades";
        $result = self::$db->query($sql);
        $grades = [];
        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }
        self::$db->close();
        return $grades;
    }

    // UPDATE  işlemi
    public static function updateGrade($id, $student_number, $course_name, $semester_1_grade, $semester_2_grade) {
        self::init();
        // Ortalama hesaplanıyor
        $average = ($semester_1_grade + $semester_2_grade) / 2;
        $sql = "UPDATE student_grades SET student_number=?, course_name=?, semester_1_grade=?, semester_2_grade=?, average=? WHERE id=?";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param("ssddii", $student_number, $course_name, $semester_1_grade, $semester_2_grade, $average, $id);
        $stmt->execute();
        $stmt->close();
        self::$db->close();
    }

    // DELETE  işlemi
    public static function deleteGrade($id) {
        self::init();
        $sql = "DELETE FROM student_grades WHERE id=?";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        self::$db->close();
    }
    
    // Öğrencinin not ortalamasını hesapla
    public static function calculateAverage($student_number) {
        self::init();
        $sql = "SELECT AVG(average) AS average FROM student_grades WHERE student_number=?";
        $stmt = self::$db->prepare($sql);
        $stmt->bind_param("s", $student_number);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $average = $row['average'];
        $stmt->close();
        self::$db->close();
        return $average;
    }
}
?>
