<?php
require './config/dbcon.php';
include_once './config/login.php';
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
}
 else {
    $error =  'select atlest one subject before submitting a form';
}

$query = "select * from subject";
$result = mysqli_query($link, $query);
$query1 = "select * from student";
$result1 = mysqli_query($link, $query1);
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
                $('#myselect').change(function () {
                    var studentId = $('select[name=selector]').val();
                    // alert(studentId);
                    $.ajax({
                        url: "displaysubjects.php",
                        data: {studId: studentId},
                        //dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            $('p:last').html(data);
                        },
                        beforeSend: function (xhr) {
                        $('p:last').html("Loading...");
                    }
                    });

                });

            });
        </script>
        <style>

        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php include_once './includes/banner.php'; ?>
            <p>Select a student to view subjects registered</p>
            <p><?php if(isset($error))  echo $error; ?></p>
            
            <form method="POST">
                <select style="display: block" id="myselect" name="selector">
<?php while ($data = mysqli_fetch_array($result1)) { ?>
                        <option value="<?php echo $data['id']; ?>"><?php echo $data['firstname'] . ' ' . $data['surname'] ?></option>
                    <?php } ?>
                </select>
                <!--read subjects from the database based on class selected-->
<?php while ($data = mysqli_fetch_array($result)) { ?>
                    <input type="checkbox" name="subject[]" value="<?php echo $data['subjectName']; ?>" >
                    <label><?php echo $data['subjectName']; ?></label><br/>
<?php } ?>
                <input type="submit"  value="submit" >
                
            </form>
            <p></p>
        </div>
    </body>
</html>
