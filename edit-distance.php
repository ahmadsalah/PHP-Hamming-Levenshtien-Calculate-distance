<?php
// EditDistance abstract class is presented as a blueprint for Hamming and Levenshtein classes
// It holds the mutual properties and methods for Hamming and Levenshtein classes to inherit
abstract class EditDistance
{
    //defining needed properties as protected in order to 
    //  1. be inherited 
    //  2. not to be manipulated directly unless through setters and getters
    protected $strA;
    protected $strB;
    protected $lengthA;
    protected $lengthB;
    protected $distance;

    //a constructor to initialize the properties with the required values
    public function __construct($strA, $strB){
        $this->strA = $strA;
        $this->strB = $strB;
        $this->lengthA = strlen($strA);
        $this->lengthB = strlen($strB);
        $this->distance = 0;
    }

    //setters for string A and B, to set strings to new values and calculate their new lengths
    protected function setStrA($str)
    {
        $this->strA = $str;
        $this->lengthA = strlen($str);
    }

    protected function setStrB($str)
    {
        $this->strB = $str;
        $this->lengthB = strlen($str);
    }

    //getters for string A and B, to return strings values
    protected function getStrA()
    {
        return $this->strA;
    }

    protected function getStrB()
    {
        return $this->strB;
    }

    //isBothEmpty is a method used to check if both strings are empty. returns true or false
    protected function isBothEmpty()
    {
        return empty($this->strA) && empty($this->strB);
    }

    //incrementPosition, calculateDistance, and calculate are three methods used to calculate the edit distance
    //those methods are implemented in Hamming and Levenshtein classes differently
    abstract function incrementPosition();

    abstract function calculateDistance();

    abstract function calculate();
}

// Hamming class inherits properties and methods from EditDistance class
// It holds properties and methods to calculate the minimum edit distance using substitution operations only
class Hamming extends EditDistance
{
    //defining the position property as private as it is used internally for calculations
    private $position;
    
    //a constructor to inherit properties from EditDistance class constructor and to initialize the position property with 0
    public function __construct($strA, $strB)
    {
        parent::__construct($strA, $strB);
        $this->position = 0;
    }

    //isSameLength is a method used to check if both strings are of same length. returns true or false
    private function isSameLength()
    {
        return $this->lengthA == $this->lengthB;
    }

    //incrementDistance is a method used to check if there is a difference between strings at a specific position/index 
    //increments the distance by one
    private function incrementDistance()
    {
        if($this->strA{$this->position} != $this->strB{$this->position})  ++$this->distance;
    }

    //incrementPosition is a method used to increment the position by one when called
    public function incrementPosition()
    {
        ++$this->position;
    }

    //calculateDistance is the controller which decides what to do...
    //if both strings are empty, return a message and calculate nothing
    //if strings are not of same length, return a message and calculate nothing as well
    //if strings are not empty and of same length, then go through the process of calculating the distance
    public function calculateDistance()
    {
        if ($this->isBothEmpty()) return "Both strings are empty. The minimum Edit Distance is 0";
        if (!$this->isSameLength()) return "Not of same length! Hamming can not be performed. Refer to Levenshtein";
        return $this->calculate();
    }

    //calculate is a method called from the controller (calculateDistance) when needed
    //it checks for the position is still in the range
    //calls incrementDistance method which will decide to increment the distance or not
    //increments the position by one for the next iteration through incrementPosition method
    //it works recursively until it satisfies the exit condition to return the distance
    public function calculate()
    {
        if ($this->position < $this->lengthA) {
            $this->incrementDistance();
            $this->incrementPosition();
            return $this->calculate();
        } 
        return $this->distance;
    }


    //initializeAndCalculate is a static helper to create an instance, initialize the state, and calculates distance
    static public function initializeAndCalculate($strA, $strB)
    {
        $hammingInstance = new Hamming($strA, $strB);
        return $hammingInstance->calculateDistance();
    }
}

// Levenshtein class inherits properties and methods from EditDistance class
// It holds properties and methods to calculate the minimum edit distance using substitution, deletion, and insertion operations
class Levenshtein extends EditDistance
{
    //defining the properties as private as they are used internally for calculations
    private $positionA;
    private $positionB;
    private $matrix;

    //a constructor to inherit properties from EditDistance class constructor and to initialize the properties with the required values
    //inside the constructor, there is a check, if one string or more are empty, there is no need to offset the strings
    public function __construct($strA, $strB)
    {
        parent::__construct($strA, $strB);
        if($this->lengthA > 0 && $this->lengthA > 0) $this->offset();
        $this->positionA = 0;
        $this->positionB = 0;
        $this->matrix = [];
    }

    //offset method is used to offset the strings when needed
    private function offset()
    {
        $this->strA = ' ' . $this->strA;
        $this->strB = ' ' . $this->strB;
    }

    //isLengthZero is a method used to check if one of the strings is zero. returns the other string's length or null as an indicator
    private function isLengthZero()
    {
        if ($this->lengthA == 0) return $this->lengthB;
        if ($this->lengthB == 0) return $this->lengthA;
        return null;
    }

    //incrementPosition is a method used to increment the position/index of string A by one when called
    public function incrementPosition()
    {
        ++$this->positionA;
    }

    //substitution method is used to return a vale from the matrix as it represents the substitution operation
    private function substitution()
    {
        $equality = $this->strA{$this->positionA} == $this->strB{$this->positionB} ? 0 : 1;
        return $this->matrix[$this->positionA - 1][$this->positionB - 1] + $equality;
    }

    //deletion method is used to return a vale from the matrix as it represents the deletion operation
    private function deletion()
    {
        return $this->matrix[$this->positionA - 1][$this->positionB] + 1;
    }

    //insertion method is used to return a vale from the matrix as it represents the insertion operation
    private function insertion()
    {
        return $this->matrix[$this->positionA][$this->positionB - 1] + 1;
    }

    //calculateDistance is the controller which decides what to do...
    //if both strings are empty, return a message and calculate nothing
    //if isLengthZero method returns an integer (which represents the length of a strings), return that length and calculate nothing as well
    //otherwise,go through the process of calculating the distance
    public function calculateDistance()
    {
        if ($this->isBothEmpty()) return "Both strings are empty. The minimum Edit Distance is 0";
        return (is_null($this->isLengthZero())) ?
            $this->calculate() :
            $this->isLengthZero();
    }

    //calculate is a method called from the controller (calculateDistance) when needed
    //it fills up the matrix while the position/index A is still in range
    //it uses substitution, deletion, and insertion methods in order to choose the minimum value of them and fill it up in the matrix at a specific position 
    //increments the position by one for the next iteration through incrementPosition method
    //it works recursively until it satisfies the exit condition to return the distance
    //for more information, refer to: https://medium.com/@ethannam/understanding-the-levenshtein-distance-equation-for-beginners-c4285a5604f0
    public function calculate()
    {
        if ($this->positionA > $this->lengthA) {
            $this->distance = $this->matrix[$this->positionA - 1][$this->positionB - 1];
            return $this->distance;
        }

        $this->matrix[$this->positionA] = [];
        for ($this->positionB = 0; $this->positionB <= $this->lengthB; $this->positionB++) {
            if (min($this->positionA, $this->positionB) == 0) {
                $this->matrix[$this->positionA][$this->positionB] = max($this->positionA, $this->positionB);
                continue;
            }
            $this->matrix[$this->positionA][$this->positionB] = min($this->insertion(), $this->deletion(), $this->substitution());
        }

        $this->incrementPosition();
        return $this->calculate();
    }

    //initializeAndCalculate is a static helper to create an instance, initialize the state, and calculates distance
    static public function initializeAndCalculate($strA, $strB)
    {
        $levenshteinInstance = new Levenshtein($strA, $strB);
        return $levenshteinInstance->calculateDistance();
    }
}