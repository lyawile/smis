<?php
require_once './config/dbcon.php';
$studentId = $_GET['stdId'];
$examId = $_GET['examId'];
$examYear = $_GET['examYear'];
$query = "select student.id 'studId', firstname,middlename,surname,subjectName, marks from score, student, subject where score.`studId` = student.id  and score.`subjectID` = subject.`subjectID` and score.`studId` = $studentId and score.`examId` = $examId and score.`examYear` = $examYear order by subjectName;";
$query1 = "select student.id 'studId', firstname,middlename,surname,subjectName, marks from score, student, subject where score.`studId` = student.id  and score.`subjectID` = subject.`subjectID` and score.`studId` = $studentId and score.`examId` = $examId and score.`examYear` = $examYear;";
$result = mysqli_query($link, $query);
$result1 = mysqli_query($link, $query1);
?>
<!DOCTYPE html>
<html>
    <title>Student Management System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" type="text/css"/>
    <div style="background-color: #f5f5f0; margin-left: 10px;padding-left: 5px; height: 40px;line-height: 40px;font-size: 20px;"><?php
        $nameOfStudent = mysqli_fetch_array($result1);
        echo $nameOfStudent['firstname'] . ' ' . $nameOfStudent['middlename'] . ' ' . $nameOfStudent['surname'];
        ?></div>
    <table class="displayList" border="1">
        <?php $sum = 0; ?>
        <tr>
            <th>Subject Name</th>
            <th>Score</th>
            <th>Grade</th>
        </tr>
        <?php while ($data = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $data['subjectName'] ?></td>
                <td><?php echo $data['marks'] ?></td>
                <td><?php
                    if ($data['marks'] > 80.49)
                        echo '<b>A</b>';
                    else
                        echo '<b>B</b>';
                    ?></td>
                <?php $sum = $sum + $data['marks'] ?>
            </tr>
        <?php } ?>
    </table>
    <div style="margin-left: 10px; padding-left: 5px;">  
        <p style="margin: 0px; padding: 0px;">Results Summary</p>
        <table>
            <tr>
                <td> <?php echo "The position in class $sum"; ?></td>
            </tr>
            <tr>
                <td> <?php echo "The overall grade $sum"; ?></td>
            </tr>
            <tr>
                <td> <?php echo "The average marks  $sum"; ?></td>
            </tr>
            <tr>
                <td> <?php echo "The total marks is $sum"; ?></td>
            </tr>
        </table>
       
    </div>
</html>

