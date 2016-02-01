<?php
//sleep(3);
require_once './config/dbcon.php';
$examId = $_GET['examId'];
$examYear = $_GET['examYear'];
$streamId = $_GET['streamId'];
$FetchStudentQuery = "select distinct st.`regNumber` 'registration', st.firstname 'firstname', st.surname 'surname', st.id 'stdId', sc.`examId` 'examId' from student st, score sc where st.id = sc.`studId` and sc.`examId` = $examId and sc.`streamId` = $streamId and sc.`examYear` = $examYear;";
$result = mysqli_query($link, $FetchStudentQuery);
?>
<table class="results">
    <tr>
        <th>Reg. Number</th>
        <th>First Name</th>
        <th>Surname</th>
        <th></th>
    </tr>
    <?php while ($data = mysqli_fetch_array($result)) { ?>
        <tr>
            <td><?php echo $data['registration']; ?></td>
            <td><?php echo $data['firstname']; ?></td>
            <td><?php echo $data['surname']; ?></td>
            <td><a href="displayResults.php?stdId=<?php echo $data['stdId'] ?>&examId=<?php echo $data['examId'] ?>&examYear=<?php echo $examYear ?>">View Results</a></td>
        </tr>

    <?php } ?>
</table>



