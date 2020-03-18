
<?php

$belakang_koma = 3;
$a = "";
$b = "";
$h = "";
$n="";
$input = "";
if(isset($_POST['proses'])){
    $a = $_POST['a'];
    $b = $_POST['b'];
    if($_POST['h'] == "") {
        $n = $_POST['n'];
        $h = ($b - $a) / $n;
    } else {
        $h = $_POST['h'];
        $n = ($b - $a) / $h;
    }

    $x = 0;
    $sigma_f = 0;
    $sigma_f_ganjil = 0;
    $sigma_f_genap = 0;
    $sigma_f_38_ganjil = 0;
    $sigma_f_38_genap = 0;
    $arr_f = [];
    $input = $_POST['fungsi'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>MathJax AsciiMath Test Page</title>
<script>
MathJax = {
  loader: {load: ['input/asciimath', 'output/chtml']}
}
</script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js">
</script>
<body>

<form action="" method="post">
    <input type="text" placeholder="a" name="a" value="<?php echo $a ?>"><br>
    <input type="text" placeholder="b" name="b" value="<?php echo $b ?>"><br>
    <input type="text" placeholder="n" name="n" value="<?php echo $n ?>"><br>
    <input type="text" placeholder="h" name="h" value="<?php echo $h ?>"><br>
    <input type="text" placeholder="fungsi" name="fungsi" value="<?php echo $input ?>"><br>
    <input type="submit" value="Hitung" name="proses">
</form>
<?php if(isset($_POST['proses'])){ ?>
<table width="50%">
    <tr>
        <td align="center" style="border-bottom: 1px solid black" width="20%">`x`</td>
        <td align="center" style="border-bottom: 1px solid black" colspan="2">`f(x)`</td>
    </tr>
    <?php 
    $n += 1;
    
    for($i = 0; $i < $n; $i++) { ?>

    <?php 
    
    if($i == 0){
        $x = $a;
    } else {
        $x += $h;
    }

    $input = $_POST['fungsi'];
    $label_input = substr($input, 0, 1) == 'e' ? 'e^' .$x : str_replace('$x', $x, $input);

    $f = eval('return round(('. $input .'),'.$belakang_koma .');');
    $arr_f[] = $f;

    if($i != 0 && $i != ($n - 1)) {
        $sigma_f += $f;

        if($i % 2 == 0) {
            $sigma_f_genap += $f;
        } else {
            $sigma_f_ganjil += $f;
        }

        if($i % 3 == 0) {
            $sigma_f_38_ganjil += $f;
        } else {
            $sigma_f_38_genap += $f;
        }
    }

    ?>
        <tr>
            <td style="border-right: 1px solid black">
                `<?php echo 'x_'. $i ?> = <?php echo  $x?>`
            </td>
            <td width="30%">
                `f_<?php echo $i ?> = f(x_<?php echo $i ?>) = <?php echo $label_input ?>`
            </td>
            <td>`= <?php echo $f ?>`</td>
        </tr>
    <?php } ?>
</table>
<h2>Metode Trapsaida</h2>
<p>&#224; `=<?php echo $h . '/2 ( ' . $arr_f[0] . '+ 2(' . $sigma_f . ') +' . $arr_f[count($arr_f) - 1] .' )';?>`</p>
<p>&#224; `=<?php echo ($h/2) * ($arr_f[0] + (2*$sigma_f) + $arr_f[count($arr_f) - 1]);?>`</p>
<h2>Metode Simson `1/3`</h2>
<p>&#224; `=<?php echo $h . '/3 ( ' . $arr_f[0] . '+ 4(' . $sigma_f_ganjil . ') + 2(' .$sigma_f_genap.') +' . $arr_f[count($arr_f) - 1] .' )'?>`</p>
<p>&#224; `=<?php echo round(($h/3), $belakang_koma) . ' ( ' . $arr_f[0] . '+ ' . 4*$sigma_f_ganjil . ' + ' . 2*$sigma_f_genap .' +' . $arr_f[count($arr_f) - 1] .' )'?>`</p>
<p>&#224; `=<?php echo round(($h/3), $belakang_koma) . ' ( ' .($arr_f[0] + (4*$sigma_f_ganjil) + (2* $sigma_f_genap) + $arr_f[count($arr_f) - 1]). ' )'?>`</p>
<p>&#224; `=<?php echo round(($h/3), $belakang_koma) * ($arr_f[0] + (4*$sigma_f_ganjil) + (2* $sigma_f_genap) + $arr_f[count($arr_f) - 1]);?>`</p>
<h2>Metode Simson `3/8`</h2>
<p>&#224; `=(<?php echo '3('. $h . '))/8 ( ' . $arr_f[0] . '+ 3(' . $sigma_f_38_genap . ') + 2(' .$sigma_f_38_ganjil.') +' . $arr_f[count($arr_f) - 1] .' )'?>`</p>
<p>&#224; `=<?php echo  (3*$h)/8 . ' ( ' . $arr_f[0] . '+ (' . 3*$sigma_f_38_genap . ') + (' . 2*$sigma_f_38_ganjil.') +' . $arr_f[count($arr_f) - 1] .' )'?>`</p>
<p>&#224; `=<?php echo round((3*$h/8), $belakang_koma) * ($arr_f[0] + (3*$sigma_f_38_genap) + (2* $sigma_f_38_ganjil) + $arr_f[count($arr_f) - 1]);?>`</p>
<h2>`\int_0^1 x^2 \,dx=`</h2>
<?php } ?>
</body>
</html>