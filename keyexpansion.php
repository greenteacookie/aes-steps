<?php

function subWord($w)
{
    $sBox = array(
        0x63, 0x7c, 0x77, 0x7b, 0xf2, 0x6b, 0x6f, 0xc5, 0x30, 0x01, 0x67, 0x2b, 0xfe, 0xd7, 0xab, 0x76,
        0xca, 0x82, 0xc9, 0x7d, 0xfa, 0x59, 0x47, 0xf0, 0xad, 0xd4, 0xa2, 0xaf, 0x9c, 0xa4, 0x72, 0xc0,
        0xb7, 0xfd, 0x93, 0x26, 0x36, 0x3f, 0xf7, 0xcc, 0x34, 0xa5, 0xe5, 0xf1, 0x71, 0xd8, 0x31, 0x15,
        0x04, 0xc7, 0x23, 0xc3, 0x18, 0x96, 0x05, 0x9a, 0x07, 0x12, 0x80, 0xe2, 0xeb, 0x27, 0xb2, 0x75,
        0x09, 0x83, 0x2c, 0x1a, 0x1b, 0x6e, 0x5a, 0xa0, 0x52, 0x3b, 0xd6, 0xb3, 0x29, 0xe3, 0x2f, 0x84,
        0x53, 0xd1, 0x00, 0xed, 0x20, 0xfc, 0xb1, 0x5b, 0x6a, 0xcb, 0xbe, 0x39, 0x4a, 0x4c, 0x58, 0xcf,
        0xd0, 0xef, 0xaa, 0xfb, 0x43, 0x4d, 0x33, 0x85, 0x45, 0xf9, 0x02, 0x7f, 0x50, 0x3c, 0x9f, 0xa8,
        0x51, 0xa3, 0x40, 0x8f, 0x92, 0x9d, 0x38, 0xf5, 0xbc, 0xb6, 0xda, 0x21, 0x10, 0xff, 0xf3, 0xd2,
        0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17, 0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73,
        0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88, 0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb,
        0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c, 0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79,
        0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9, 0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08,
        0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6, 0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a,
        0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e, 0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e,
        0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94, 0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf,
        0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68, 0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0xbb, 0x16);

    for ($i = 0; $i < 4; $i++) $w[$i] = $sBox[$w[$i]];
    return $w;
}

function rotWord($w)
{
    $tmp = $w[0];
    for ($i = 0; $i < 3; $i++) $w[$i] = $w[$i + 1];
    $w[3] = $tmp;
    return $w;
}


function keyExpansion($key)
    {
        $rCon = array(
                    array(0x00, 0x00, 0x00, 0x00),
                    array(0x01, 0x00, 0x00, 0x00),
                    array(0x02, 0x00, 0x00, 0x00),
                    array(0x04, 0x00, 0x00, 0x00),
                    array(0x08, 0x00, 0x00, 0x00),
                    array(0x10, 0x00, 0x00, 0x00),
                    array(0x20, 0x00, 0x00, 0x00),
                    array(0x40, 0x00, 0x00, 0x00),
                    array(0x80, 0x00, 0x00, 0x00),
                    array(0x1b, 0x00, 0x00, 0x00),
                    array(0x36, 0x00, 0x00, 0x00)
        );


        $Nb = 4; // block size (in words): no of columns in state (fixed at 4 for AES)
        $Nk = count($key) / 4; // key length (in words): 4/6/8 for 128/192/256-bit keys
        $Nr = $Nk + 6; // no of rounds: 10/12/14 for 128/192/256-bit keys

        $w = array();
        $temp = array();

        for ($i = 0; $i < $Nk; $i++) {
            $r = array($key[4 * $i], $key[4 * $i + 1], $key[4 * $i + 2], $key[4 * $i + 3]);
            $w[$i] = $r;
        }

        // foreach ($w as $key => $value) {
        //     echo "w[".$key."]->";
        //     foreach ($value as $key2 => $value2) {
        //         $abc .= dechex($value2)."-";
        //     }
        //     echo rtrim($abc, "-");echo"<br/>";
        //     $abc = "";
        // }
        // die;


        for ($i = $Nk; $i < ($Nb * ($Nr + 1)); $i++) {
            $w[$i] = array();
            for ($t = 0; $t < 4; $t++) $temp[$t] = $w[$i - 1][$t];
            if ($i % $Nk == 0) {
                $temp = subWord(rotWord($temp));
                for ($t = 0; $t < 4; $t++) {
                    // var_dump(dechex($temp[$t]));
                    $temp[$t] ^= $rCon[$i / $Nk][$t];
                    // var_dump(dechex($temp[$t]));
                    // echo "<br/>";
                } 
            } else if ($Nk > 6 && $i % $Nk == 4) {
                $temp = subWord($temp);
            }
            for ($t = 0; $t < 4; $t++) $w[$i][$t] = $w[$i - $Nk][$t] ^ $temp[$t];
        }
        return $w;
    }


$postReq = false;
$postMessage = "";
$defaultArray = [];
$resultArray = [];
$mixedArray = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $defaultArray = $_POST;
    $processedArray = $defaultArray;
    $postReq = true;


$abc = $processedArray['ar'];
foreach ($processedArray['ar'] as $key => $value) {
    $processedArray['ar'][$key] = hexdec($value);
}

    // $keyInput = [0x4D, 0x47, 0x69, 0x6F, 0x20, 0x4C, 0x6F, 0x76, 0x65, 0x73, 0x20, 0x4D, 0x61, 0x74, 0x68, 0x73];
    // $keyInput = [0x54, 0x68, 0x61, 0x74, 0x73, 0x20, 0x6D, 0x79, 0x20, 0x4B, 0x75, 0x6E, 0x67, 0x20, 0x46, 0x75];
    $keyInput = $processedArray['ar'];
    $mixedArray = keyExpansion($keyInput);
    foreach ($mixedArray as $round => $b) {
        foreach ($b as $c => $d) {
            $resultArray[$round][$c] = strToUpper(dechex($d));
        }
    }
    // var_dump($resultArray);die;

    // $z = 0;
    // foreach ($mixedArray as $a => $b) {
    //     foreach ($b as $c => $d) {
    //         $resultArray[$z] = strToUpper(dechex($d));
    //         $z++;
    //     }
    // }
}
?>


<div style="text-align: center">

<div style="color:red;background-color: blue;"><?= $postMessage ?></div>
<form action="" method="post">
<h1>Key Expansion </h1>
<input type="text" size="2" name="ar[0]" required value="<?= isset($defaultArray['ar'][0]) ? $defaultArray['ar'][0] : '' ?>" />
<input type="text" size="2" name="ar[1]" required value="<?= isset($defaultArray['ar'][1]) ? $defaultArray['ar'][1] : '' ?>" />
<input type="text" size="2" name="ar[2]" required value="<?= isset($defaultArray['ar'][2]) ? $defaultArray['ar'][2] : '' ?>" />
<input type="text" size="2" name="ar[3]" required value="<?= isset($defaultArray['ar'][3]) ? $defaultArray['ar'][3] : '' ?>" />
<input type="text" size="2" name="ar[4]" required value="<?= isset($defaultArray['ar'][4]) ? $defaultArray['ar'][4] : '' ?>" />
<input type="text" size="2" name="ar[5]" required value="<?= isset($defaultArray['ar'][5]) ? $defaultArray['ar'][5] : '' ?>" />
<input type="text" size="2" name="ar[6]" required value="<?= isset($defaultArray['ar'][6]) ? $defaultArray['ar'][6] : '' ?>" />
<input type="text" size="2" name="ar[7]" required value="<?= isset($defaultArray['ar'][7]) ? $defaultArray['ar'][7] : '' ?>" />
<input type="text" size="2" name="ar[8]" required value="<?= isset($defaultArray['ar'][8]) ? $defaultArray['ar'][8] : '' ?>" />
<input type="text" size="2" name="ar[9]" required value="<?= isset($defaultArray['ar'][9]) ? $defaultArray['ar'][9] : '' ?>" />
<input type="text" size="2" name="ar[10]" required value="<?= isset($defaultArray['ar'][10]) ? $defaultArray['ar'][10] : '' ?>" />
<input type="text" size="2" name="ar[11]" required value="<?= isset($defaultArray['ar'][11]) ? $defaultArray['ar'][11] : '' ?>" />
<input type="text" size="2" name="ar[12]" required value="<?= isset($defaultArray['ar'][12]) ? $defaultArray['ar'][12] : '' ?>" />
<input type="text" size="2" name="ar[13]" required value="<?= isset($defaultArray['ar'][13]) ? $defaultArray['ar'][13] : '' ?>" />
<input type="text" size="2" name="ar[14]" required value="<?= isset($defaultArray['ar'][14]) ? $defaultArray['ar'][14] : '' ?>" />
<input type="text" size="2" name="ar[15]" required value="<?= isset($defaultArray['ar'][15]) ? $defaultArray['ar'][15] : '' ?>" />
 <p><input type="submit" /></p>
</form>

<?php if($postReq): ?>
<?php
    $x = 0;
    $y = 0;
    foreach ($resultArray as $a => $value) {
        $round = $x / 4;
        if ($x % 4 == 0) echo "<p>Round <b>".$round."</b></p>";
        foreach ($value as $key2 => $value2) {
            echo $value2." ";
        }
        $x++;
    }
?>
<!-- <input type="text" size="5" name="ar0-result" required value="<?= isset($resultArray[0]) ? $resultArray[0] : '' ?>" />
<input type="text" size="5" name="ar1-result" required value="<?= isset($resultArray[1]) ? $resultArray[1] : '' ?>" />
<input type="text" size="5" name="ar2-result" required value="<?= isset($resultArray[2]) ? $resultArray[2] : '' ?>" />
<input type="text" size="5" name="ar3-result" required value="<?= isset($resultArray[3]) ? $resultArray[3] : '' ?>" />
<input type="text" size="5" name="ar4-result" required value="<?= isset($resultArray[4]) ? $resultArray[4] : '' ?>" />
<input type="text" size="5" name="ar5-result" required value="<?= isset($resultArray[5]) ? $resultArray[5] : '' ?>" />
<input type="text" size="5" name="ar6-result" required value="<?= isset($resultArray[6]) ? $resultArray[6] : '' ?>" />
<input type="text" size="5" name="ar7-result" required value="<?= isset($resultArray[7]) ? $resultArray[7] : '' ?>" />
<input type="text" size="5" name="ar8-result" required value="<?= isset($resultArray[8]) ? $resultArray[8] : '' ?>" />
<input type="text" size="5" name="ar9-result" required value="<?= isset($resultArray[9]) ? $resultArray[9] : '' ?>" />
<input type="text" size="5" name="ar10-result" required value="<?= isset($resultArray[10]) ? $resultArray[10] : '' ?>" />
<input type="text" size="5" name="ar11-result" required value="<?= isset($resultArray[11]) ? $resultArray[11] : '' ?>" />
<input type="text" size="5" name="ar12-result" required value="<?= isset($resultArray[12]) ? $resultArray[12] : '' ?>" />
<input type="text" size="5" name="ar13-result" required value="<?= isset($resultArray[13]) ? $resultArray[13] : '' ?>" />
<input type="text" size="5" name="ar14-result" required value="<?= isset($resultArray[14]) ? $resultArray[14] : '' ?>" />
<input type="text" size="5" name="ar15-result" required value="<?= isset($resultArray[15]) ? $resultArray[15] : '' ?>" /> -->
<br/>

<?php endif; ?>
</div>