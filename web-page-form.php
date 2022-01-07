<?php
// This file requires the classes as a library using require_once
require_once('edit-distance.php');

//initialize the distance with value of null for conditional rendering
$distance = null;

//if the form is submitted 
//  1. assign values to strings, strA and strB
//  2. check for Hamming or Levenshtein mode
//  3. use static methods to calculate the distance and assign it to variable distance
//the results will be rendered on the same page for the user to see
if (isset($_POST['submit'])) {
    $strA = $_POST['strA'];
    $strB = $_POST['strB'];
    $mode = $_POST['submit'];

    if ($mode == 'Hamming') {
        $distance = Hamming::initializeAndCalculate($strA, $strB);
    }

    if ($mode == 'Levenshtein') {
        $distance = Levenshtein::initializeAndCalculate($strA, $strB);
    }
}
/**
IN ORDER TO RUN THIS FILE, OPEN THE TERMINAL IN THE SAME DIRECTORY AND TYPE THE FOLLOWING IN THE COMMAND LINE: 
php -S localhost:8000 web-page-form.php

THEN OPEN YOUR WEB BROWSER AND TYPE THE FOLLOWING IN THE NAVIGATION BAR:
localhost:8000
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Edit Distance</title>
</head>

<body>
    <div class='container mt-5'>
        <div class="row mt-5">
            <div class="col-md-12 mt-5">
                <h3 class='text-center'>Hamming and Levenshtein Distance</h3>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form method='post'>
                    <div class="form-group">
                        <label for="strA">
                            <snap><u>String <b>A</b></u></snap>
                        </label>
                        <input type="text" class="form-control" name='strA' placeholder="Enter String (A)..." value = <?= $distance ? $strA : null ?>>
                    </div>
                    <div class="form-group mt-4">
                        <label for="strB">
                            <snap><u>String <b>B</b></u></snap>
                        </label>
                        <input type="text" class="form-control" name='strB' placeholder="Enter String (B)..." value = <?= $distance ? $strB : null ?>>
                    </div>
                    <div class="d-flex justify-content-around align-items-center mt-5">
                        <input type="submit" class="btn btn-primary" name="submit" value="Hamming" />
                        <input type="submit" class="btn btn-primary" name="submit" value="Levenshtein" />
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <hr />
                <?php if ($distance) : ?>
                    <h4 class='text-center font-weight-bold mb-3'><?= $mode ?> mode</h4>
                    <pre><b>String A:</b> <?= empty($strA) ? "'empty string'" : $strA ?></pre>
                    <pre><b>String B:</b> <?= empty($strB) ? "'empty string'" : $strB ?></pre>
                    <pre style='white-space: pre-wrap'><b>Distance:</b> <?= $distance ?></pre>

                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>