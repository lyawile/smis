<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
        <style type="text/css">
            div{
                margin: 10px;
                margin-left: 30px;
                height: 30px;
                width: 600px;
                background-color: #f5f5f0;
                padding: 3px;
                border-radius: 2px;
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function () {
                $.ajax({
                    url: "articles.json",
                    type: 'GET',
                    dataType: 'json',
                    cache: false,
                    success: function (data, textStatus, jqXHR) {
                        $('div:first').remove();
                        $(data.articles).each(function (i, v) {
                            $('body').append('<div>' + v.name  +' </div>');
                        });
                    }
                });
            });
        </script>
    </head>
    <body>
        <div>TODO write content</div>
    </body>
</html>

