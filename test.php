<?php
$uri = $_SERVER['REQUEST_URI'];
echo $uri.'<br/>';
function open_database_connection(){
    $link = mysqli_connect('localhost','root','','mkulima');
    return $link;
}
function close_database_connection($link){
    mysqli_close($link);
}
$testing = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
echo $testing;

class Message{
    function Show($text){
        echo $text;
    }
}
$printMessage = new Message();
$printMessage ->Show('I love the way you put your things organized');
