<?php
date_default_timezone_set('Africa/Dar_es_Salaam');
include './config/dbcon.php';
$query1 = "select id, streamName from stream";
$result = mysqli_query($link, $query1);
include_once './config/login.php';
if (file_exists('errors111.txt')) {
    unlink('errors111.txt');
}
if (isset($_SESSION['loggedIn'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $file = $_FILES['file']['tmp_name'];
        if (!$link) {
            echo 'database not connected';
        }
        $streamId = $_POST['stream'];
        //$row = 1;
        if ($file !== '') {
            if (($handle = fopen($file, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $yearRegistered = $_POST['regYear'];
                    $registrationNumber = $data[0];
                    // $date = date("Y-m-d H:i:s");
                    $firstname = $data[1];
                    $middlename = $data[2];
                    $surname = $data[3];
                    $query = "select `regNumber`,firstname,surname from student std , student_in_stream str where std.id = str.`studentId` and str.`streamId` = '$streamId' and str.`yearRegistered` = '$yearRegistered' and std.`regNumber` = '$registrationNumber'";
                    $result = mysqli_query($link, $query);
                    if (mysqli_num_rows($result) > 0) {// checks if a student exists, if yes, store the existing student in errors111.txt file
                        while ($data = mysqli_fetch_array($result)) {
                            $firstname = $data['firstname'];
                            $surname = $data['surname'];
                            $registrationNumber = $data['regNumber'];
                            $errors = strtoupper($surname) . ", " . $firstname . " with registration number " . $registrationNumber . " exists \n";
                            $file = fopen('errors111.txt', 'a');
                            fwrite($file, $errors);
                            fclose($file);
                        }
                    } else {
                        $query = "INSERT INTO `student` (`id`, `regNumber`, `firstname`, `middlename`, `surname`) VALUES ('','$registrationNumber', '$firstname', '$middlename', '$surname')";
                        mysqli_query($link, $query);
                        $query = "select id from student where student.`regNumber` = $registrationNumber";
                        $result = mysqli_query($link, $query);
                        $datastream = mysqli_fetch_array($result);
                        $registrationNumber = $datastream['id'];
                        if (!$datastream) {
                            printf("Error: %s\n", mysqli_error($link));
                            exit();
                        }
                        $query = "INSERT INTO `student_in_stream` (`id`, `studentId`, `streamId`, `yearRegistered`, `timeRegistered`) VALUES (NULL, '$registrationNumber', '$streamId', '$yearRegistered', CURRENT_DATE())";
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
                    <p></p>
                    <input type="file" name="file" id="fileUploaded" /><br/><br/>
                    <input type="submit" value="upload" id="grabData"/>
                </form>
                <p><?php
                    if (file_exists('errors111.txt')) {
                        echo '<a href="errors111.txt" target="_blank">view errors</a>';
                    }
                    ?>
                </p>
            </div>
        <?php } else echo $error; ?>
    </body>
</html>


