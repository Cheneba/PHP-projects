<?php
echo "Welcome to Calculator. We follow BODMAS rules (:\nEnter your calculation to be done:";
// Contant variables that define the operators
define('ADD', '+');
define('SUBTRACT', '-');
define('DIVIDE', '/');
define('MULTIPLY', '*');
define('BRACKET_OPEN', '(');
define('BRACKET_CLOSE', ')');
define('OF', 'of');
$op_arr = array(DIVIDE, MULTIPLY, ADD, SUBTRACT);

// Executes the string and returns the result in string form
function run($arr, $string)
{
    global $op_arr;

    // completely replaces the "of" with *
    $string = str_replace(OF, '*', $string);


    // Calculates and resolves anything that has to do with [+, -, /, *]
    for ($i = 0; $i < 4; $i++) {
        $operator = find_operator($arr, $op_arr[$i]);           // Gets the index of an operator if present


        if ($operator) {
            $output = '';

            foreach ($operator as $op) {
                $output = t($string, $op, $i);
            }
            [$string,  $arr] = [$output, str_split($string, 1)];
        } else continue;
        // var_dump($string);
    }
    return $string;
}

// Does the explicit execution of 2 numbers according to the operator specified
function execute($operator, $value)
{
    if ($operator === DIVIDE) {
        return (float)$value[0] / (float)$value[1];
    } elseif ($operator === MULTIPLY) {
        return (float)$value[0] * (float)$value[1];
    } elseif ($operator === ADD) {
        return (float)$value[0] + (float)$value[1];
    } elseif ($operator === SUBTRACT) {
        return (float)$value[0] - (float)$value[1];
    }
}

// Looks for the operators specified in the input string
function find_operator($string, $op)
{
    $result = [];
    for ($i = 0; $i < count($string); $i++) {
        if ($string[$i] === $op) {
            $result[] = $i;
        }
    }
    if ($result !== []) return $result;
    else return null;
}


function t($string, $operator_index, $op_arr_index)
{
    global $op_arr;
    $str = $string;
    $string = str_replace(['*', '/', '+', '-', ')', '('], '@', $string,);
    $string_arr = str_split($string, 1);

    $left_side = function ($s_arr, $op_index) {
        $result = '';
        for ($i = $op_index - 1; $i >= 0; $i--) {
            if ($s_arr[$i] === '@') break;
            $result .= $s_arr[$i];
        }
        $result = strrev($result); // Reverse the result string
        return [$result, $op_index - $i - 1];
    };


    $right_side = function ($s_arr, $op_index, $op_arr, $op_arr_index) {
        $result = '';
        for ($i = $op_index + 1; $i < count($s_arr); $i++) {     //make and implement to check whether there is an operator at the start or end of the string
            if ($s_arr[$i] === '@') break;
            $result .= $s_arr[$i];
        }
        return [$result, $i];
    };
    $num1 = $left_side($string_arr, $operator_index);
    $num2 = $right_side($string_arr, $operator_index, $op_arr, $op_arr_index);

    if ($op_arr[$op_arr_index] == '-') {                                //Come and continue here ====================================================================
        var_dump($string, $num1[0], $num2[0]);
        exit();
    }
    $answer = execute($op_arr[$op_arr_index], [$num1[0], $num2[0]]);

    $new_string = substr($str, 0, $operator_index - $num1[1]) . $answer . substr($str, $num2[1], strlen($str) - 1);
    return $new_string;
}

$calc = trim(fgets(STDIN)) ?: "6+12*453-4/2";

$split = str_split($calc, 1);


run($split, $calc);


echo "\n";