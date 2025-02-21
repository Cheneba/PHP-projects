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

// Executes the string and returns the result in string form
function run($arr, $string)
{
    // completely replaces the "of" with *
    $string = str_replace(OF, '*', $string);


    // Calculates and resolves anything that has to do with [+, -, /, *]
    $op_arr = array(DIVIDE, MULTIPLY, ADD, SUBTRACT);
    for ($i = 0; $i < 5; $i++) {
        $operator = find_operator($arr, $op_arr[$i]);           // Gets the index of an operator if present

        if ($operator) {
            $output = '';
            foreach ($operator as $op) {
                $result = number_format(execute($op_arr[$i], [$string[$op - 1], $string[$op + 1]]));            // executes the operator and creates output string
                $output = substr($string, 0, $op - 1) . $result . substr($string, $op + 2, strlen($string) - 1 === $op + 2 ? 0 : strlen($string) - 1);
            }
            $string = $output;
            $arr = str_split($string, 1);
        } else continue;
    }
    return $string;
}

// Does the explicit execution of 2 numbers according to the operator specified
function execute($operator, $value)
{
    if ($operator === DIVIDE) {
        return $value[0] / $value[1];
    } elseif ($operator === MULTIPLY) {
        return $value[0] * $value[1];
    }
    if ($operator === ADD) {
        return $value[0] + $value[1];
    }
    if ($operator === SUBTRACT) {
        return $value[0] - $value[1];
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

$calc = trim(fgets(STDIN)) ?: "6+2*3-4/2";

$split = str_split($calc, 1);


var_dump(run($split, $calc));



echo "\n";