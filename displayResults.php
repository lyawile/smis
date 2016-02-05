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
            <?php // print_r($data); ?>
        <?php } ?>
    </table>
    <?php
    $query4 = "set @row_num = 0;";
    mysqli_query($link, $query4);
    $query3 = " select  @row_num := @row_num + 1 as pos, `studId`, total from results;";
    $result3 = mysqli_query($link, $query3);
    $tempTable = "create table ranking (id int(4) not null primary key auto_increment,studId int(4) not null,total int(4) not null, pos int(4) not null);";
    mysqli_query($link, $tempTable);
    while ($data2 = mysqli_fetch_array($result3)) {
        $pos = $data2['pos'];
        $studId = $data2['studId'];
        $total = $data2['total'];
        $query5 = "insert into ranking (id, studId, total, pos) values (NULL,$studId,$total,$pos );";
        mysqli_query($link, $query5);
        $query6 = "select `studId`,pos,total from ranking where `studId` = $studentId;";
        $result4 = mysqli_query($link, $query6);
        $data3 = mysqli_fetch_array($result4);
        //echo $data2['pos'] . " " . $data2['studId'] . " " . $data2['total'] ." " .$data2['pos'] ."<br/>";
        
    }
    ?>
    <div style="margin-left: 10px; padding-left: 5px;">  
        <p style="margin: 0px; padding: 0px;">Results Summary</p>
        <table>
            <tr>
                <td> <?php echo "The position in class {$data3['pos']} the student {$studentId} "; ?></td>
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
    <?php
    $dropQuery = "drop table ranking";
    mysqli_query($link, $dropQuery);
    mysqli_close($link);
    ?>
</html>

