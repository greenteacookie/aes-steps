<?php
function addRoundKey($state, $w, $rnd, $Nb)
{
    for ($r = 0; $r < 4; $r++) {
        for ($c = 0; $c < $Nb; $c++) {
            $state[$r][$c] ^= $w[$rnd * 4 + $c][$r];
        }
    }
    return $state;
}

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

    foreach ($processedArray['ar'] as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $processedArray['ar'][$key][$key2] = hexdec($value2);
        }
    }

    foreach ($processedArray['key'] as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $processedArray['key'][$key][$key2] = hexdec($value2);
        }
    }

    $mixedArray = addRoundKey($processedArray['ar'], $processedArray['key'], 0, 4);

    foreach ($mixedArray as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $resultArray[$key][$key2] = strToUpper(dechex($value2));
        }
    }
}

?>

<div style="text-align: center">

<div style="color:red;background-color: blue;"><?= $postMessage ?></div>
<form action="" method="post">
<div style="display: inline-block;">
<h1>MESSAGE</h1>
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
</div>
<div style="display: inline-block;width: 100px">
</div>
<div style="display: inline-block;">

<h1>KEY</h1>
<input type="text" name="key[0][0]" required size="2" value="<?= isset($defaultArray['key'][0][0]) ? $defaultArray['key'][0][0] : '' ?>" />
<input type="text" name="key[1][0]" required size="2" value="<?= isset($defaultArray['key'][1][0]) ? $defaultArray['key'][1][0] : '' ?>" />
<input type="text" name="key[2][0]" required size="2" value="<?= isset($defaultArray['key'][2][0]) ? $defaultArray['key'][2][0] : '' ?>" />
<input type="text" name="key[3][0]" required size="2" value="<?= isset($defaultArray['key'][3][0]) ? $defaultArray['key'][3][0] : '' ?>" />
<br/>

<input type="text" name="key[0][1]" required size="2" value="<?= isset($defaultArray['key'][0][1]) ? $defaultArray['key'][0][1] : '' ?>" />
<input type="text" name="key[1][1]" required size="2" value="<?= isset($defaultArray['key'][1][1]) ? $defaultArray['key'][1][1] : '' ?>" />
<input type="text" name="key[2][1]" required size="2" value="<?= isset($defaultArray['key'][2][1]) ? $defaultArray['key'][2][1] : '' ?>" />
<input type="text" name="key[3][1]" required size="2" value="<?= isset($defaultArray['key'][3][1]) ? $defaultArray['key'][3][1] : '' ?>" />
<br/>

<input type="text" name="key[0][2]" required size="2" value="<?= isset($defaultArray['key'][0][2]) ? $defaultArray['key'][0][2] : '' ?>" />
<input type="text" name="key[1][2]" required size="2" value="<?= isset($defaultArray['key'][1][2]) ? $defaultArray['key'][1][2] : '' ?>" />
<input type="text" name="key[2][2]" required size="2" value="<?= isset($defaultArray['key'][2][2]) ? $defaultArray['key'][2][2] : '' ?>" />
<input type="text" name="key[3][2]" required size="2" value="<?= isset($defaultArray['key'][3][2]) ? $defaultArray['key'][3][2] : '' ?>" />
<br/>
<input type="text" name="key[0][3]" required size="2" value="<?= isset($defaultArray['key'][0][3]) ? $defaultArray['key'][0][3] : '' ?>" />
<input type="text" name="key[1][3]" required size="2" value="<?= isset($defaultArray['key'][1][3]) ? $defaultArray['key'][1][3] : '' ?>" />
<input type="text" name="key[2][3]" required size="2" value="<?= isset($defaultArray['key'][2][3]) ? $defaultArray['key'][2][3] : '' ?>" />
<input type="text" name="key[3][3]" required size="2" value="<?= isset($defaultArray['key'][3][3]) ? $defaultArray['key'][3][3] : '' ?>" />
<br/>
</div>

 <p><input type="submit" /></p>
</form>

<?php if($postReq): ?>
<h1>XOR RESULTS</h1>
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