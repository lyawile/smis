<?php
//sleep(3);
//require_once './config/dbcon.php';
//$examId = $_GET['examId']; 
//$examYear = $_GET['examYear'];
//$streamId = $_GET['streamId'];
//echo 'Exam Id: '.$examId. " Exam Year: ".$examYear. " Stream Id: ".$streamId;
//$FetchStudentQuery = "select distinct st.`regNumber` 'registration', st.firstname 'firstname', st.surname 'surname' from student st, score sc where st.id = sc.`studId` and sc.`examId` = $examId and sc.`streamId` = $streamId and sc.`examYear` = $examYear;";
//$result = mysqli_query($link, $FetchStudentQuery);
?>
<table>
<?php // while($data = mysqli_fetch_array($result)){?>
<!--    <tr>
        <td><?php echo $data['registration']; ?></td>
        <td><?php echo $data['firstname']; ?></td>
        <td><?php echo $data['surname']; ?></td>
    </tr>-->
   
<?php // }?>
</table>

   

