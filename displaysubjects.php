<?php
$studentID = $_GET['studId'];
require_once './config/dbcon.php';
$query = "select `subjectName`, st.id as studId from student st, subject sb, student_takes_subjects stt
where st.id = stt.`studentId` and sb.`subjectID` = stt.`subjectId`";
$result = mysqli_query($link, $query);
$data = mysqli_fetch_array($result);
if(!empty($data['studId'])){
echo '<table class="test">';
echo '<tr><th>Subject</th><th>Command</th></tr>';
if ($result) {
    while ($data = mysqli_fetch_array($result)) {
        $studentIdFromDb = $data['studId'];
        if ($studentID == $studentIdFromDb) {
            echo '<tr><td>'. $data['subjectName'] . '</td><td>Delete</td></tr>';
            
        }
    }
}
echo '</table>';
}
else echo 'no data matching your query';