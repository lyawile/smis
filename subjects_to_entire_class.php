<?php
require './config/dbcon.php';
include_once './config/login.php';
$query = "SELECT id,streamName from stream";
$result1 = mysqli_query($link, $query);
$subject = @$_POST['BulkSubjectAdd'];
$streamId = @$_POST['streamId'];
$query1 = "select std.id as studentId from student std, stream str, student_in_stream studstr 
where std.id = studstr.`studentId` AND  str.id = studstr.`streamId` and str.id = $streamId";
$result2 = mysqli_query($link, $query1);
if (!empty($streamId) && !empty($subject)) {
    while ($student = mysqli_fetch_array($result2)) {
        $studentId = $student['studentId'];
        foreach ($subject as $key => $subjectId) {
            $findSubjectId = "select `subjectId` from student_takes_subjects where `subjectId` = $subjectId";
            $resultSubjectId = mysqli_query($link, $findSubjectId);
            $studentsTakingSubjects = "select `studentId` from student_in_stream where `streamId` = $streamId;";
            $countResults = mysqli_query($link, $studentsTakingSubjects);
            $countResults = mysqli_num_rows($countResults);
            if (mysqli_num_rows($resultSubjectId) < $countResults) {
                $query3 = "INSERT INTO `mtiss_db`.`student_takes_subjects` (`id`, `studentId`, `subjectId`, `isForAll`) "
                        . "VALUES (NULL, '$studentId', '$subjectId', '1')";
                mysqli_query($link, $query3);
            }
        }
    }
} else {
    $message = '<span class="message">Select atleast one subject</span>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Student Management System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(function () {
                //$('#send').click(function () {
                // var data = $('#results-form').serialize();
                // alert(data);
//                    $.ajax({
//                        url: "displaysubjects.php",
//                        data: $('#results-form').serialize(),
//                        //dataType: 'json',
//                        success: function (data, textStatus, jqXHR) {
//                            $('p:last').html(data);
//                        },
//                        beforeSend: function (xhr) {
//                            $('p:last').html("Loading...");
//                        }
//                    });

            });
            });
        </script>
        <style>
            span{
                margin-left: 10px;
            }
            input[type="submit"]{
                margin: 5px;
                margin-left: 10px;
            }
            input[type="checkbox"]{
                margin-left: 10px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php include_once './includes/banner.php'; ?>

            <form method="POST" id="results-form">
                <span style="">Select Stream</span>
                <select  id="myselect" name="streamId">
                    <?php while ($data = mysqli_fetch_array($result1)) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['streamName']; ?></option>
                    <?php } ?>
                </select>
                <div></div>
                <input type="checkbox" name="BulkSubjectAdd[]" value="6" /><label>Islamic Knowledge</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="13" /><label>Arabic Language</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="7"/><label>Quran</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="2"/><label>Physics</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="1"/><label>Chemistry</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="12"/><label>Biology</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="11"/><label>History</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="8"/><label>Kiswahili</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="4"/><label>Civics</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="3"/><label>Mathematics</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="9"/><label>English Language</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="10"/><label>Information and Computer Studies</label><br/>
                <input type="checkbox" name="BulkSubjectAdd[]" value="5"/><label>Geography</label><br/>
                <input type="submit"  value="submit" id="send" >
            </form>
            <p></p>
        </div>
    </body>
</html>
