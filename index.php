<?php
$x = 5;
$t = '1/(x+ 1)';

echo $t;
die;
$a = 0;
$b = 1;
$h = 0.125;

$n = ($b - $a) / $h;

$x = 0;
$sigma_f = 0;
$sigma_f_ganjil = 0;
$sigma_f_genap = 0;
$arr_f = [];
for($i = 0; $i <= $n; $i++) {
    echo "x". $i ." = ";
    if($i == 0){
        $x = $a;
    } else {
        $x += $h;
    }

    echo $x;
    echo " -> f". $i . " = ";
    $f = eval('return round((1/($x+1)), 5);');
    echo $f;
    $arr_f[] = $f;
    if($i != 0 && $i != $n) {
        $sigma_f += $f;

        if($i % 2 == 0) {
            $sigma_f_genap += $f;
        } else {
            $sigma_f_ganjil += $f;
        }
    }

    echo "<br>";
}

echo '<br>';
echo 'F = ';
echo $h . '/2 ( ' . $arr_f[0] . '+ 2(' . $sigma_f . ') +' . $arr_f[count($arr_f) - 1] .' )';
echo '<br>';
echo "<br>";
echo 'F = ';
echo ($h/2) * ($arr_f[0] + (2*$sigma_f) + $arr_f[count($arr_f) - 1]);
echo '<br>';
echo '<br>';
echo 'F = ';
echo $h . '/3 ( ' . $arr_f[0] . '+ 4(' . $sigma_f_genap . ') + 2(' .$sigma_f_ganjil.') +' . $arr_f[count($arr_f) - 1] .' )';
echo '<br>';
echo "<br>";
echo 'F = ';
echo round(($h/3), 5) * ($arr_f[0] + (4*$sigma_f_genap) + (2* $sigma_f_ganjil) + $arr_f[count($arr_f) - 1]);
// echo eval('return exp(0.8);');