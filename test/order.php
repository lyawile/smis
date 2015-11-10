<?php
require_once './config/dbconnect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // checks if button value is set
    if (!empty($_POST['surname']) && !empty($_POST['firstname']) && !empty($_POST['middlename'])) {
        $firstname = $_POST['firstname'];
        $middlename = $_POST['middlename'];
        $surname = $_POST['surname'];
        $query = "insert into customer (firstname,middlename,surname) values ('$firstname','$middlename','$surname')"; // insert customer info into customer table
        $result = mysqli_query($connection, $query);
        if ($result)
            $success = 'Customer was added';
    } else
        $error = 'Please fill all fields';
}
 $query2 = "select `roomNumber`,floor from room r, ordertb o where r.id != o.`roomId`";
        $result1 = mysqli_query($connection, $query2);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hotel System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <div>
            <p style="color: red;"><?php if (isset($error)) echo $error; ?></p>
            <p style="color: green;"><?php if (isset($success)) echo $success; ?></p>
            <form method="POST">
                <p>First Name</p>
                <input type="text" name="firstname" required/>
                <p>Middle Name</p>
                <input type="text" name="middlename" required=""/>
                <p>Surname</p>
                <input type="text" name="surname" required=""/>
                <p>Phone Number</p>
                <input type="text" name="phonenumber" required=""/>
                <p>Email</p>
                <input type="email" name="email" required=""/>
                <p>Gender</p>
                <input type="radio" name="gender" required="" value="Male"/> Male <br>
                <input type="radio" name="gender" required="" value="Female" checked=""/> Female
                <p>Rooms</p>
                <select>
                    <?php
                    while ($accomodate = mysqli_fetch_array($result1)) {
                        echo '<option>Room' . $accomodate['roomNumber'] . ' Floor:' . $accomodate['floor'] . '</option>';
                    }
                    ?>

                </select>
                <p></p>
                <input type="submit" value="Register"/>
            </form>
        </div>
    </body>
</html>