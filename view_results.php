<?php
require './config/dbcon.php';
include_once './config/login.php';
$query = "select id,`streamName` from stream;";
$result1 = mysqli_query($link, $query);
$query = "select id,`name` from examterm;";
$result2 = mysqli_query($link, $query);
$query3 = "select firstname,surname,sc.marks,str.`streamName`,sb.`subjectName` "
        . "from student std join score sc on std.id = sc.`studId` join stream str on str.id = sc.`streamId` join subject sb on sb.`subjectID` = sc.`subjectID` join examterm ext on ext.id = sc.`examId` "
        . "where sc.`examYear` = 2015 and str.id = 1 and sc.`examId` = 1";
// I will continue tomorrow morning inshaallah
if (isset($_POST['subject'])) {
    $submitted = $_POST['subject'];
    $student = $_POST['selector'];
    foreach ($submitted as $key => $value) {
        $query3 = "select `subjectID` from subject where `subjectName` = '$value'";
        $result = mysqli_query($link, $query3);
        $result = mysqli_fetch_array($result);
        $subjectID = $result['subjectID'];
        $query5 = "select `studentId`,`subjectId` from student_takes_subjects where studentId = '$student' and subjectId = '$subjectID'";
        $datasource = mysqli_query($link, $query5);
        $data = mysqli_fetch_array($datasource);
        if (isset($data['subjectId'])) {
            echo 'subject exist';
        } else {
            $query4 = "INSERT INTO `student_takes_subjects` (`id`, `studentId`, `subjectId`) VALUES (NULL, '$student', '$subjectID')";
            mysqli_query($link, $query4);
        }
    }
} else {
    $error = 'select atlest one subject before submitting a form';
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
                $('#send').click(function (event) {
                    event.preventDefault();
                    var streamId = $('#streamId').val();
                    var examYear = $('#examYear').val();
                    var examId = $('#examId').val();
                    $.ajax({
                        url: "loading_students_with_results.php",
                        data: {streamId: streamId,
                            examYear: examYear,
                            examId: examId
                        },
                        success: function (data, textStatus, jqXHR) {
                            $('span:last').html(data);
                        },
                        beforeSend: function (xhr) {
                            $('span:last').html("Loading...");
                        }
                    });

                });

            });
        </script>
        <style>
            span{
                margin-left: 10px;
            }
            input[type="submit"]{
                margin-left: 10px;
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php include_once './includes/banner.php'; ?>
            <form method="POST" id="results-form">
                <span style="">Select Stream</span>
                <select style="" id="streamId" name="streamId">
                    <?php while ($data = mysqli_fetch_array($result1)) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['streamName']; ?></option>
                    <?php } ?>
                </select>
                <span style="">Year</span>
                <select style="" id="examYear" name="examYear">
                    <option value="2013">2013</option>
                    <option value="2014">2014</option>
                    <option value="2015">2015</option>
                    <option value="2016">2016</option>
                </select>
                <span style="">Exam Period</span>
                <select style="" id="examId" name="examPeriod">
                    <?php while ($data = mysqli_fetch_array($result2)) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>';
                    <?php } ?>
                </select>
                <input type="submit"  value="submit" id="send" >
            </form>
            <span></span>
<!--            <table class="results">
                <tr>
                    <th>Reg. Number</th>
                    <th>First Name</th>
                    <th>Surname</th>
                    <th></th>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
                <tr>
                    <td>001 </td>
                    <td>Ally</td>
                    <td>Saidi</td>
                    <td><a href="">View Results</a></td>
                </tr>
            </table>-->
        </div>
    </body>
</html>
