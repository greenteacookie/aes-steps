<?php
function shiftRows($s, $Nb)
    {
        $t = array(4);
        for ($r = 1; $r < 4; $r++) {
            for ($c = 0; $c < 4; $c++) $t[$c] = $s[$r][($c + $r) % $Nb]; // shift into temp copy
            for ($c = 0; $c < 4; $c++) $s[$r][$c] = $t[$c]; // and copy back
        } // note that this will work for Nb=4,5,6, but not 7,8 (always 4 for AES):
        return $s; // see fp.gladman.plus.com/cryptography_technology/rijndael/aes.spec.311.pdf
    }

// $arcol[0] = [0xAF, 0x63, 0x76, 0x83];
// $arcol[1] = [0xC0, 0x47, 0xE2, 0x93];
// $arcol[2] = [0x1A, 0x6F, 0xA2, 0xA2];
// $arcol[3] = [0x47, 0xAF, 0xFA, 0x12];

// $mixed = mixColumns($arcol);

// foreach ($mixed as $key => $value) {
// 	foreach ($value as $key2 => $value2) {
// 		echo strToUpper(dechex($value2))." ";
// 	}
// }
echo "<br/>";

$postReq = false;
$postMessage = "";
$defaultArray = [];
$resultArray = [];
$mixedArray = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $defaultArray = $_POST;
    $processedArray = $defaultArray;
    $postReq = true;
    // foreach ($_POST as $key => $value) {
    //     if (ctype_xdigit($value)) {
    //     } else {
    //         $dgt = ltrim($key, "ar");
    //         $postMessage = "Array : ".$dgt." is not a hexadecimal (".$value.")";
    //     }
    // }

$arcol[0] = [0x63, 0xEB, 0x9F, 0xA0];
$arcol[1] = [0x2F, 0x93, 0x92, 0xC0];
$arcol[2] = [0xAF, 0xC7, 0xAB, 0x30];
$arcol[3] = [0xA2, 0x20, 0xCB, 0x2B];

foreach ($processedArray['ar'] as $key => $value) {
    foreach ($value as $key2 => $value2) {
        $processedArray['ar'][$key][$key2] = hexdec($value2);
    }
}

    $mixedArray = shiftRows($processedArray['ar'], 4);

    foreach ($mixedArray as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $resultArray[$key][$key2] = strToUpper(dechex($value2))." ";
        }
    }
}

?>


<div style="text-align: center">

<div style="color:red;background-color: blue;"><?= $postMessage ?></div>
<form action="" method="post">
<h1>SHIFT ROWS</h1>
<input type="text" name="ar[0][0]" required size="2" value="<?= isset($defaultArray['ar'][0][0]) ? $defaultArray['ar'][0][0] : '' ?>" />
<input type="text" name="ar[0][1]" required size="2" value="<?= isset($defaultArray['ar'][0][1]) ? $defaultArray['ar'][0][1] : '' ?>" />
<input type="text" name="ar[0][2]" required size="2" value="<?= isset($defaultArray['ar'][0][2]) ? $defaultArray['ar'][0][2] : '' ?>" />
<input type="text" name="ar[0][3]" required size="2" value="<?= isset($defaultArray['ar'][0][3]) ? $defaultArray['ar'][0][3] : '' ?>" />
<br/>

<input type="text" name="ar[1][0]" required size="2" value="<?= isset($defaultArray['ar'][1][0]) ? $defaultArray['ar'][1][0] : '' ?>" />
<input type="text" name="ar[1][1]" required size="2" value="<?= isset($defaultArray['ar'][1][1]) ? $defaultArray['ar'][1][1] : '' ?>" />
<input type="text" name="ar[1][2]" required size="2" value="<?= isset($defaultArray['ar'][1][2]) ? $defaultArray['ar'][1][2] : '' ?>" />
<input type="text" name="ar[1][3]" required size="2" value="<?= isset($defaultArray['ar'][1][3]) ? $defaultArray['ar'][1][3] : '' ?>" />
<br/>

<input type="text" name="ar[2][0]" required size="2" value="<?= isset($defaultArray['ar'][2][0]) ? $defaultArray['ar'][2][0] : '' ?>" />
<input type="text" name="ar[2][1]" required size="2" value="<?= isset($defaultArray['ar'][2][1]) ? $defaultArray['ar'][2][1] : '' ?>" />
<input type="text" name="ar[2][2]" required size="2" value="<?= isset($defaultArray['ar'][2][2]) ? $defaultArray['ar'][2][2] : '' ?>" />
<input type="text" name="ar[2][3]" required size="2" value="<?= isset($defaultArray['ar'][2][3]) ? $defaultArray['ar'][2][3] : '' ?>" />
<br/>
<input type="text" name="ar[3][0]" required size="2" value="<?= isset($defaultArray['ar'][3][0]) ? $defaultArray['ar'][3][0] : '' ?>" />
<input type="text" name="ar[3][1]" required size="2" value="<?= isset($defaultArray['ar'][3][1]) ? $defaultArray['ar'][3][1] : '' ?>" />
<input type="text" name="ar[3][2]" required size="2" value="<?= isset($defaultArray['ar'][3][2]) ? $defaultArray['ar'][3][2] : '' ?>" />
<input type="text" name="ar[3][3]" required size="2" value="<?= isset($defaultArray['ar'][3][3]) ? $defaultArray['ar'][3][3] : '' ?>" />
<br/>
 <p><input type="submit" /></p>
</form>

<?php if($postReq): ?>
<h1>RESULTS</h1>
<input type="text" name="ar00-result" required disabled size="2" value="<?= isset($resultArray[0][0]) ? $resultArray[0][0] : '' ?>" />
<input type="text" name="ar01-result" required disabled size="2" value="<?= isset($resultArray[0][1]) ? $resultArray[0][1] : '' ?>" />
<input type="text" name="ar02-result" required disabled size="2" value="<?= isset($resultArray[0][2]) ? $resultArray[0][2] : '' ?>" />
<input type="text" name="ar03-result" required disabled size="2" value="<?= isset($resultArray[0][3]) ? $resultArray[0][3] : '' ?>" />
<br/>
<input type="text" name="ar10-result" required disabled size="2" value="<?= isset($resultArray[1][0]) ? $resultArray[1][0] : '' ?>" />
<input type="text" name="ar11-result" required disabled size="2" value="<?= isset($resultArray[1][1]) ? $resultArray[1][1] : '' ?>" />
<input type="text" name="ar12-result" required disabled size="2" value="<?= isset($resultArray[1][2]) ? $resultArray[1][2] : '' ?>" />
<input type="text" name="ar13-result" required disabled size="2" value="<?= isset($resultArray[1][3]) ? $resultArray[1][3] : '' ?>" />
<br/>
<input type="text" name="ar20-result" required disabled size="2" value="<?= isset($resultArray[2][0]) ? $resultArray[2][0] : '' ?>" />
<input type="text" name="ar21-result" required disabled size="2" value="<?= isset($resultArray[2][1]) ? $resultArray[2][1] : '' ?>" />
<input type="text" name="ar22-result" required disabled size="2" value="<?= isset($resultArray[2][2]) ? $resultArray[2][2] : '' ?>" />
<input type="text" name="ar23-result" required disabled size="2" value="<?= isset($resultArray[2][3]) ? $resultArray[2][3] : '' ?>" />
<br/>
<input type="text" name="ar30-result" required disabled size="2" value="<?= isset($resultArray[3][0]) ? $resultArray[3][0] : '' ?>" />
<input type="text" name="ar31-result" required disabled size="2" value="<?= isset($resultArray[3][1]) ? $resultArray[3][1] : '' ?>" />
<input type="text" name="ar32-result" required disabled size="2" value="<?= isset($resultArray[3][2]) ? $resultArray[3][2] : '' ?>" />
<input type="text" name="ar33-result" required disabled size="2" value="<?= isset($resultArray[3][3]) ? $resultArray[3][3] : '' ?>" />
<br/>

<?php endif; ?>

</div>