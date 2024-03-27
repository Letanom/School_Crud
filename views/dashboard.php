<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/styles/student.css"> 
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Ad</th>
                <th>Soyad</th>
                <th>Öğrenci ID</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Öğrenci veritabanı sınıfını dahil et
            require_once('../config/student_config.php');

            // Öğrenci ekleme, güncelleme ve silme işlemlerini işle
            if(isset($_POST['add_Button'])) {
                // Yeni öğrenci ekleme işlemi
                $student_name = $_POST['student_name'];
                $student_surname = $_POST['student_surname'];
                StudentDatabase::addStudent($student_name, $student_surname);

                // Yönlendirme yaparak sayfanın yenilenmesini engelleme
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }

            if(isset($_POST['delete_Button'])) {
                // Öğrenci silme işlemi
                $student_id = $_POST['student_id'];
                StudentDatabase::deleteStudent($student_id);

                // Yönlendirme yaparak sayfanın yenilenmesini engelleme
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }

            if(isset($_POST['update_Button'])) {
                // Öğrenci güncelleme işlemi
                $student_id = $_POST['student_id'];
                $new_student_name = $_POST['new_student_name'];
                $new_student_surname = $_POST['new_student_surname'];
                StudentDatabase::updateStudent($student_id, $new_student_name, $new_student_surname);

                // Yönlendirme yaparak sayfanın yenilenmesini engelleme
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            }

            // Tüm öğrencileri getir ve tabloya ekle
            $students = StudentDatabase::getAllStudents();
            if ($students->num_rows > 0) {
                while($row = $students->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["student_name"] . "</td>";
                    echo "<td>" . $row["student_surname"] . "</td>";
                    echo "<td>" . $row["student_id"] . "</td>";
                    echo "<td> 
                            <form method='POST'>
                                <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                                <input class='delete-button' type='submit' value='Sil' name='delete_Button'>
                            </form> 
                            <form method='POST'>
                                <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                                <input type='text' name='new_student_name' placeholder='Yeni Ad' required>
                                <input type='text' name='new_student_surname' placeholder='Yeni Soyad' required>
                                <input class='update-button' type='submit' value='Güncelle' name='update_Button'>
                            </form> 
                          </td>";
                    echo "</tr>";
                }
            } else {
                // Eğer öğrenci yoksa uygun bir mesaj ver
                echo "<tr><td colspan='4'>Henüz öğrenci bulunmamaktadır.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <form action="" method="POST">
        <label for="student_name">Ad:</label>
        <input type="text" id="student_name" name="student_name" required><br><br>
        <label for="student_surname">Soyad:</label>
        <input type="text" id="student_surname" name="student_surname" required><br><br>
        <input type="submit" value="Ekle" name="add_Button">
    </form>
    <form action="grade_dashboard.php" method="GET">
        <button class="change_button" type="submit">NOT PANELİNE GEÇ</button>
    </form>
</body>
</html>
