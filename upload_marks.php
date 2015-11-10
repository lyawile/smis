<?php
date_default_timezone_set('Africa/Dar_es_Salaam');
include './config/dbcon.php';
$query1 = "select * from examterm";
$result = mysqli_query($link, $query1);
include_once './config/login.php';
if (isset($_SESSION['loggedIn'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (file_exists('errors111.txt')) {
            unlink('errors111.txt');
        }
        if (!$link) {
            echo 'database not connected';
        }
        $examId = $_POST['examPeriod'];
        $file = $_FILES['file']['tmp_name'];
        if ($file !== '') {
            if (($handle = fopen($file, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $studentID = $data[0];
                    $examYear = $data[6];
                    $streamId = $data[7];
                    $marks = $data[9];
                    $subjectID = $data[8];
                    $query = "select studId,examId,examYear ,streamId from score where `studId` = '$studentID' and examId = '$examId' and `examYear` = '$examYear' and streamId = '$streamId';";
                    $result = mysqli_query($link, $query); 
                    if (mysqli_num_rows($result) === 1) {
                        echo 'record exist';
                    } else {
                        $query = "INSERT INTO `score` (`id`, `studId`, `examId`, `marks`, `examYear`, `streamId`,`subjectID`) VALUES (NULL, '$studentID', '$examId', '$marks', '$examYear', '$streamId','$subjectID');";
                        mysqli_query($link, $query);
                    }
                }
                // echo 'Upload done';
            }
        } else
            $error1 = 'Please select a file ';
    }
}
else {
    $error = 'please login using login screen';
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
                    <p class="label">select exam period:</p>
                    <select name="examPeriod" id="years">
    <?php while ($data = mysqli_fetch_array($result)) { ?>
                            <?php echo '<option value ="' . $data['id'] . '">' . $data['name'] . '</option>' ?>
                        <?php } ?>

                    </select>
                    <p></p>
                    <input type="file" name="file" id="fileUploaded" /><br/><br/>
                    <input type="submit" value="upload" id="grabData"/>
                </form>
            </div>
<?php } else echo $error; ?>
    </body>
</html>


