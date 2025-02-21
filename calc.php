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

// Variable responsible for moving from one case to another
$setter = 1;

// Executes the string and returns the result in string form
function run($arr, $string)
{
    global $setter;
    $setter++;

    // completely replaces the of with *
    $string = str_replace(OF, '*', $string);


    switch ($setter) {
        case 1:
            // Checking if either of the operators are present
            $op_brac = find_operator($arr, BRACKET_OPEN) ? function ($arr) {
                return [find_operator($arr, BRACKET_OPEN), find_operator($arr, BRACKET_OPEN)];
            } : false;


            break;
        case 2:
            $op_div = find_operator($arr, DIVIDE);

            if ($op_div) {
                $output = '';
                if ($op_div) {
                    foreach ($op_div as $op) {
                        $result = number_format($string[$op - 1] / $string[$op + 1]);
                        $output = substr($string, 0, $op - 1) . $result . substr($string, $op + 2, strlen($string) - 1 === $op + 2 ? 0 : strlen($string) - 1);
                    }
                    $string = $output;
                    $string_arr = str_split($string, 1);
                    $string = run($string_arr, $string);
                }
            }
            break;
        case 3:
            $op_mul = find_operator($arr, MULTIPLY);

            if ($op_mul) {
                $output = '';
                if ($op_mul) {
                    foreach ($op_mul as $op) {
                        $result = $string[$op - 1] * $string[$op + 1];
                        $output = substr($string, 0, $op - 1) . $result . substr($string, $op + 2, strlen($string) - 1 === $op + 2 ? 0 : strlen($string) - 1);
                    }
                    $string = $output;
                    $string_arr = str_split($string, 1);
                    $string = run($string_arr, $string);
                }
            }
            break;
        case 4:
            $op_add = find_operator($arr, ADD);

            if ($op_add) {
                $output = '';
                if ($op_add) {
                    foreach ($op_add as $op) {
                        $result = $string[$op - 1] + $string[$op + 1];
                        $output = substr($string, 0, $op - 1) . $result . substr($string, $op + 2, strlen($string) - 1 === $op + 2 ? 0 : strlen($string) - 1);
                    }
                    $string = $output;
                    $string_arr = str_split($string, 1);
                    $string = run($string_arr, $string);
                }
            }
            break;

        case 5:
            $op_sub = find_operator($arr, SUBTRACT);

            if ($op_sub) {
                $output = '';
                if ($op_sub) {
                    foreach ($op_sub as $op) {
                        $result = $string[$op - 1] - $string[$op + 1];
                        $output = substr($string, 0, $op - 1) . $result . substr($string, $op + 2, strlen($string) - 1 === $op + 2 ? 0 : strlen($string) - 1);
                    }
                    $string = $output;
                    $string_arr = str_split($string, 1);
                    $string = run($string_arr, $string);
                }
            }
            break;
    }

    return $string;
}

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