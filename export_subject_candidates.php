<?php
include_once './config/login.php';
date_default_timezone_set('Africa/Dar_es_Salaam');
include './config/dbcon.php';
$query1 = "select id, streamName from stream";
$result = mysqli_query($link, $query1);
$query2 = "select `subjectID`, `subjectName` from subject";
$result1 = mysqli_query($link, $query2);
@$yearRegistered = $_POST['regYear'];
@$streamId = $_POST['stream'];
@$subjectID = $_POST['subject'];
    if (file_exists('output.csv')) {
        unlink('output.csv');
    }
if (isset($yearRegistered) && isset($streamId) && isset($subjectID)) {
    // echo ' all have been set ';    echo 'year' . $yearRegistered. '<br/>Subject Id'. $subjectID . '<br/> streamId'. $streamId ;
    $query3 = "select distinct std.id as studId,`regNumber`, firstname, middlename, surname,sub.`subjectName` as subjectName, studStr.`yearRegistered` as yearRegistered, str.streamName as stream, sub.`subjectID` as subID"
            . " from student std, student_takes_subjects stdSub, student_in_stream studStr, stream str, subject sub "
            . "where (std.id = stdSub.`studentId` and stdSub.`subjectId` = '$subjectID') and "
            . "(std.id = studStr.`studentId` and str.id = studStr.`streamId` and studStr.`streamId` = '$streamId' and studStr.`yearRegistered` = '$yearRegistered' ) and (sub.`subjectID` = stdSub.`subjectId`)";
    $result = mysqli_query($link, $query3);
    while ($data = mysqli_fetch_array($result)) {
        $studentID = $data['studId'];
        $registrationNumber = $data['regNumber'];
        $firstname = $data['firstname'];
        $middlename = $data['middlename'];
        $surname = $data['surname'];
        $subjectName = $data['subjectName'];
        $yearRegistered = $data['yearRegistered'];
        $subjectID = $data['subID'];
        $handle = fopen('output.csv', 'a');
        $data = $studentID . ',' . $registrationNumber . ',' . $firstname . ',' . $middlename . ',' . $surname . ',' . $subjectName . ',' . $yearRegistered . ','.$streamId.','.$subjectID."\n";
        fwrite($handle, $data);
    }
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student Management System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery-1.9.1.min.js"></script>
        <script>
            $(document).ready(function () {
//             $('#grabData').click(function(e){
//               e.preventDefault();
//                var file = $('#fileUploaded').val();
//                $.ajax({
//                    url: "test.php",
//                    type: 'POST',
//                    data: {
//                        file: file
//                    }
//                });
//                
//             });
            });
        </script>
    </head>
    <body>
        <?php if (!isset($error)) { ?>
            <div class="wrapper">
                <?php include './includes/banner.php'; ?>
                <p class="error" style="color: red;"><?php if (isset($error1)) echo $error1; ?></p>
                <form action="" method="POST"  enctype="multipart/form-data" id="x">
                    <p class="label">select year:</p>
                    <select name="regYear" id="years">
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                    </select>
                    <p class="label">select stream:</p>
                    <select name="stream" id="stream">
                        <?php while ($data = mysqli_fetch_array($result)) { ?>
                            <?php echo '<option value ="' . $data['id'] . '">' . $data['streamName'] . '</option>' ?>
                        <?php } ?>
                    </select>
                    <p class="label">select subject:</p>
                    <select name="subject" id="stream">
                        <?php while ($data = mysqli_fetch_array($result1)) { ?>
                            <?php echo '<option value ="' . $data['subjectID'] . '">' . $data['subjectName'] . '</option>' ?>
                        <?php } ?>
                    </select>
                    <p></p>
                    <input type="submit" value="Export" id="grabData"/>
                </form>
                <?php if(file_exists('output.csv')) echo '<p><a href="output.csv">Download students</a></p>';?>
            </div>
        <?php } else echo $error; ?>
    </body>
</html>