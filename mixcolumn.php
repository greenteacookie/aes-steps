<?php
function mixColumns($s, $Nb = 4)
{
    for ($c = 0; $c < 4; $c++) {
        $a = array(4); // 'a' is a copy of the current column from 's'
        $b = array(4); // 'b' is a•{02} in GF(2^8)
        for ($i = 0; $i < 4; $i++) {
            $a[$i] = $s[$i][$c];
            $b[$i] = $s[$i][$c] & 0x80 ? $s[$i][$c] << 1 ^ 0x011b : $s[$i][$c] << 1;
        }
        // a[n] ^ b[n] is a•{03} in GF(2^8)
        $s[0][$c] = $b[0] ^ $a[1] ^ $b[1] ^ $a[2] ^ $a[3]; // 2*a0 + 3*a1 + a2 + a3
        $s[1][$c] = $a[0] ^ $b[1] ^ $a[2] ^ $b[2] ^ $a[3]; // a0 * 2*a1 + 3*a2 + a3
        $s[2][$c] = $a[0] ^ $a[1] ^ $b[2] ^ $a[3] ^ $b[3]; // a0 + a1 + 2*a2 + 3*a3
        $s[3][$c] = $a[0] ^ $b[0] ^ $a[1] ^ $a[2] ^ $b[3]; // 3*a0 + a1 + a2 + 2*a3
    }
    return $s;
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

    $mixedArray = mixColumns($processedArray['ar']);
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
<h1>MIX COLUMN</h1>
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