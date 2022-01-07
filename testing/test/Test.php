<?php
// This file requires the classes as a library using require_once
require_once('edit-distance.php');

//the following are some tests to check the functionality of Hamming and Levenshtein classes
//each test checks if the output distance equals certain value
/**
IN ORDER TO RUN THIS FILE, OPEN THE TERMINAL IN THE SAME DIRECTORY AND TYPE THE FOLLOWING IN THE COMMAND LINE: 
cd ..
./vendor/bin/phpunit

OR GO TO 'testing' DIRECTORY, OPEN THE TERMINAL AND TYPE THE FOLLOWING IN THE COMMAND LINE:
./vendor/bin/phpunit
 */
class EditDistanceTests extends \PHPUnit\Framework\TestCase
{
    //HAMMING TESTS
    /** @test */
    public function Two_empty_strings_in_Hamming_should_result_in_0(){
        $emptyStrings = new Hamming('', '');
        $this->assertEquals($emptyStrings->calculateDistance(), "Both strings are empty. The minimum Edit Distance is 0");
    }

    /** @test */
    public function Two_strings_with_different_lengths_in_Hamming_can_not_be_performed(){
        $unequalLengths = new Hamming('aaa', 'a');
        $this->assertEquals($unequalLengths->calculateDistance(), "Not of same length! Hamming can not be performed. Refer to Levenshtein");
    }

    /** @test */
    public function Two_strings_with_same_length_and_one_different_character_in_Hamming_should_result_in_1(){
        $equalLengthsOneDifferentCharacter = new Hamming('ahmad', 'ahmed');
        $this->assertEquals($equalLengthsOneDifferentCharacter->calculateDistance(), 1);
    }

    /** @test */
    public function Two_strings_with_same_length_and_more_than_one_different_characters_in_Hamming_should_result_in_more_than_1(){
        $equalLengthsDifferentCharacters = new Hamming('ababa', 'babab');
        $this->assertEquals($equalLengthsDifferentCharacters->calculateDistance(), 5);
    }


    //LEVENSHTEIN TESTS
    /** @test */
    public function Two_empty_strings_in_Levenshtein_should_result_in_0(){
        $emptyStrings = new Levenshtein('', '');
        $this->assertEquals($emptyStrings->calculateDistance(), "Both strings are empty. The minimum Edit Distance is 0");
    }

    /** @test */
    public function One_of_the_two_strings_empty_in_Levenshtein_should_result_in_the_length_of_the_second_string(){
        $str = 'aaa';
        $zeroLength = new Levenshtein($str, '');
        $this->assertEquals($zeroLength->calculateDistance(), strlen($str));
    }

    /** @test */
    public function Two_strings_with_different_lengths_in_Levenshtein_should_result_in_1_or_more(){
        $unequalLengths = new Levenshtein('aaa', 'a');
        $this->assertEquals($unequalLengths->calculateDistance(), 2);
    }

    /** @test */
    public function Two_strings_with_same_length_and_one_different_character_in_Levenshtein_should_result_in_1(){
        $equalLengthsOneDifferentCharacter = new Levenshtein('ahmad', 'ahmed');
        $this->assertEquals($equalLengthsOneDifferentCharacter->calculateDistance(), 1);
    }

    /** @test */
    public function Two_strings_with_same_length_and_more_than_one_different_characters_in_Levenshtein_should_result_in_more_than_1(){
        $equalLengthsDifferentCharacters = new Levenshtein('ababa', 'babab');
        $this->assertEquals($equalLengthsDifferentCharacters->calculateDistance(), 2);
    }

}
