<?php
function grade($totalMark){
    $averageMark = $totalMark/2;
    switch ($averageMark){
        case $averageMark <= 100 && $averageMark >= 81:
            echo 'A';
            break;
        case $averageMark <= 80 && $averageMark >=61:
            echo 'B';
            break;
        case $averageMark <= 60 && $averageMark >= 41:
            echo 'C';
            break;
        case $averageMark <= 40 && $averageMark >= 21:
            echo 'D';
            break;
        default : 
            echo 'F';
                
    }
    
}