<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $('a').click(function (event) {
                    event.preventDefault();
                    $.ajax({
                        url: 'jsonreturn.php',
                        dataType: 'json',
                        success: function (data) {
                            alert(data.time.muda);
                        },
                        beforeSend: function (xhr) {
                        $('p').html("processing");
                    }
                       
                    });
                });

            });
        </script>
    </head>
    <body>
        <p></p>
        <div style="font-size: 30px"></div>
        <div style="font-size: 30px"></div>
        <div style="font-size: 30px"></div>
        <div style="font-size: 30px"></div>
        <a href="" >View Current time</a>
    </body>
</html>

