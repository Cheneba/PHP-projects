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
                $output = runOperation($string, $op, $i);
            }
            $string =  $output;
            $arr = str_split($string, 1);
        } else continue;
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


function runOperation($string, $operator_index, $op_arr_index)
{
    global $op_arr;
    $str = $string;
    $string = str_replace(['*', '/', '+', '-', ')', '('], '@', $string,);
    $string_arr = str_split($string, 1);

    $left_side = function () use ($string_arr, $operator_index) {
        $result = '';
        for ($i = $operator_index - 1; $i >= 0; $i--) {
            if ($string_arr[$i] === '@') break;
            else $result .= $string_arr[$i];
        }
        $result = strrev($result); // Reverse the result string
        return [$result, $operator_index - $i - 1];
    };


    $right_side = function () use ($string_arr, $operator_index) {
        $result = '';
        for ($i = $operator_index + 1; $i < count($string_arr); $i++) {     //make and implement to check whether there is an operator at the start or end of the string
            if ($string_arr[$i] === '@') break;
            else $result .= $string_arr[$i];
        }
        return [$result, $i];
    };
    $num1 = $left_side();
    $num2 = $right_side();

    $answer = execute($op_arr[$op_arr_index], [$num1[0], $num2[0]]);

    $new_string = substr($str, 0, $operator_index - $num1[1]) . $answer . substr($str, $num2[1], strlen($str) - 1);
    return $new_string;
}


while (true) {
    // Gets input
    $input = $in = trim(fgets(STDIN)) ? (printf("Entered: %s\n", $in) ? $in : "Error: Try again!\n") : (printf("None entered!\nExecuting default: 6+1*5-4/2\n") ? "6+1*5-4/2" : "Error try again");
    $arr_input = str_split($input, 1);


    // Prints result
    $result = run($arr_input, $input);
    printf("Result: %.2f \n", (float)$result);
}