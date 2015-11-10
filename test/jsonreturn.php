<?php
sleep(5);
date_default_timezone_set('Africa/Dar_es_Salaam');
echo $script_tz = date_default_timezone_get();
$mydata = array('time' => array('muda'=> date("Y M, d H:i:s")));
echo json_encode($mydata);
