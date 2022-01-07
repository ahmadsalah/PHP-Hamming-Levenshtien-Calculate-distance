<?php
// This file requires the classes as a library using require_once
require_once('edit-distance.php');

//here are some messages to show on when running it on the terminal
echo "Welcome to Edit Distance Command Line Tool\n";
echo "It takes two strings as inputs to calculate the edit distance between them\n";
echo "There are two methods:\n   1. Hamming\n   2. Levenshtein\n";
echo "By transforming string (A) into string (B)\n\n";

//the code will keep running until the exit condition is satisfied
//readline method will read the user inputs and assign to a variable
//the static methods will be used to initialize the state and calculate distances 
//after entering the strings, the distance in both Hamming and Levenshtein will be calculated and shown
//at the end, there will be an option to enter another two strings or exit the tool
while (true) {
    echo "Enter string (A) >>> ";
    $strA = readline();

    echo "Enter string (B) >>> ";
    $strB = readline();

    echo "\n\n";
    echo 'Hamming Distance => ' . Hamming::initializeAndCalculate($strA, $strB) . "\n";
    echo 'Levenshtein Distance => ' . Levenshtein::initializeAndCalculate($strA, $strB) . "\n\n";

    $repeat;
    while(true){
        echo "Want to go again? 'yes' or 'no' to exit >>> ";
        $repeat = readline();
        if($repeat == 'yes') {
            echo "\n";
            break;
        }
        if($repeat == 'no') exit;
    }
}
/**
IN ORDER TO RUN THIS FILE, OPEN THE TERMINAL IN THE SAME DIRECTORY AND TYPE THE FOLLOWING IN THE COMMAND LINE: 
php command-line.php

go along with it in order to see the results...
 */