<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../public/styles/grades.css">

    <title>Öğrenci Not Yönetim Paneli</title>
</head>
<body>
    <h1>Öğrenci Not Yönetim Paneli</h1>

    <?php
    require_once '../config/grade_config.php'; // GradeConfig sınıfını dahil ediyoruz

    // form gönder
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Yeni not ekleme
        if (isset($_POST['add_grade'])) {
            $student_number = $_POST['student_number'];
            $course_name = $_POST['course_name'];
            $semester_1_grade = $_POST['semester_1_grade'];
            $semester_2_grade = $_POST['semester_2_grade'];

            GradeConfig::insertGrade($student_number, $course_name, $semester_1_grade, $semester_2_grade);
            echo "Yeni not eklendi.";
        }
        // update
        elseif (isset($_POST['update_grade'])) {
            $id = $_POST['grade_id'];
            $student_number = $_POST['student_number'];
            $course_name = $_POST['course_name'];
            $semester_1_grade = $_POST['semester_1_grade'];
            $semester_2_grade = $_POST['semester_2_grade'];

            GradeConfig::updateGrade($id, $student_number, $course_name, $semester_1_grade, $semester_2_grade);
            echo "Not güncellendi.";
        }
        // delete
        elseif (isset($_POST['delete_grade'])) {
            $id = $_POST['grade_id'];
            GradeConfig::deleteGrade($id);
            echo "Not silindi.";
        }
    }

    // Notları ççekerim
    $grades = GradeConfig::getAllGrades();
    ?>

    <!-- Notları Görüntüleme Tablosu -->
    <h2>Notları Görüntüle</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Öğrenci Numarası</th>
            <th>Ders Adı</th>
            <th>1. Dönem Notu</th>
            <th>2. Dönem Notu</th>
            <th>İşlemler</th>
        </tr>
        <?php foreach ($grades as $grade) { ?>
            <tr>
                <td><?php echo $grade['id']; ?></td>
                <td><?php echo $grade['student_number']; ?></td>
                <td><?php echo $grade['course_name']; ?></td>
                <td><?php echo $grade['semester_1_grade']; ?></td>
                <td><?php echo $grade['semester_2_grade']; ?></td>
                <td>
                    <!-- update delete butonları -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
                        <input type="hidden" name="grade_id" value="<?php echo $grade['id']; ?>">
                        <input type="hidden" name="student_number" value="<?php echo $grade['student_number']; ?>">
                        <input type="text" name="course_name" value="<?php echo $grade['course_name']; ?>" placeholder="Yeni ders adı">
                        <input type="number" name="semester_1_grade" value="<?php echo $grade['semester_1_grade']; ?>"  step="0.01" placeholder="Yeni 1. dönem notu">
                        <input type="number" name="semester_2_grade" value="<?php echo $grade['semester_2_grade']; ?>" step="0.01" placeholder="Yeni 2. dönem notu">
                        <div class="button-group">
                            <input type="submit" name="update_grade" value="Güncelle">
                            <input type="submit" name="delete_grade" value="Sil">
                        </div>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- yeni bilgi ekleme formu -->
    <h2>Yeni Bilgiler</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Öğrenci Numarası:</label>
        <input type="text" name="student_number" required><br>
        <label>Ders Adı:</label>
        <input type="text" name="course_name" required><br>
        <label>1. Dönem Notu:</label>
        <input type="number" name="semester_1_grade" step="0.01" required><br>
        <label>2. Dönem Notu:</label>
        <input type="number" name="semester_2_grade" step="0.01" required><br>
        <input type="submit" name="add_grade" value="Ekle">
    </form>
</body>
</html>
