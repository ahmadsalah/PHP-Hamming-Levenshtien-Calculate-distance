<?php
// This file requires the classes as a library using require_once
require_once('edit-distance.php');

//two arrays to initialize the strings with some arbitrary values to perform some test
$strA = ['', 'saturday', 'ahmad', 'friday', '', 'ababa'];
$strB = ['', 'sunday', 'ahmed', 'monday', 'not empty', 'babab'];

//for loop to go through the testing cases performed using the static method of each class
for ($index = 0; $index < count($strA); $index++) {
    echo 'String A: ' . (empty($strA[$index]) ? "'empty string'" : $strA[$index]) . '<br />';
    echo 'String B: ' . (empty($strB[$index]) ? "'empty string'" : $strB[$index]) . '<br />';
    echo 'Hamming Distance => ' . Hamming::initializeAndCalculate($strA[$index], $strB[$index]) . '<br />';
    echo 'Levenshtein Distance => ' . Levenshtein::initializeAndCalculate($strA[$index], $strB[$index]) . '<br /><br /><hr /><br />';
}

/**
IN ORDER TO RUN THIS FILE, OPEN THE TERMINAL IN THE SAME DIRECTORY AND TYPE THE FOLLOWING IN THE COMMAND LINE: 
php -S localhost:8000 require-as-library.php

THEN OPEN YOUR WEB BROWSER AND TYPE THE FOLLOWING IN THE NAVIGATION BAR:
localhost:8000
 */