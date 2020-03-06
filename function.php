<?php 
function utf8_strlen($str){
    $c = strlen($str);
    $l = 0;
    for ($i = 0; $i < $c; ++$i){
       if ((ord($str[$i]) & 0xC0) != 0x80)
       {
          ++$l;
       }
    }
    return $l;
 }

function utf8_str_pad($input, $length, $padStr = ' ', $type = STR_PAD_RIGHT){
  $inputLen = utf8_strlen($input);
  if ($length <= $inputLen) {
      return $input;
  }
  $padStrLen = utf8_strlen($padStr);
  $padLen = $length - $inputLen;
  if ($type == STR_PAD_RIGHT) {
      $repeatTimes = ceil($padLen / $padStrLen);
      return utf8_substr($input . str_repeat($padStr, $repeatTimes), 0, $length);
  }
  if ($type == STR_PAD_LEFT) {
      $repeatTimes = ceil($padLen / $padStrLen);
      return utf8_substr(str_repeat($padStr, $repeatTimes), 0, floor($padLen)) . $input;
  }
  if ($type == STR_PAD_BOTH) {
      $padLen /= 2;
      $padAmountLeft = floor($padLen);
      $padAmountRight = ceil($padLen);
      $repeatTimesLeft = ceil($padAmountLeft / $padStrLen);
      $repeatTimesRight = ceil($padAmountRight / $padStrLen);
      $paddingLeft = utf8_substr(str_repeat($padStr, $repeatTimesLeft), 0, $padAmountLeft);
      $paddingRight = utf8_substr(str_repeat($padStr, $repeatTimesRight), 0, $padAmountLeft);
      return $paddingLeft . $input . $paddingRight;
  }
  trigger_error('utf8_str_pad: Unknown padding type (' . $type . ')', E_USER_ERROR);
}

  function utf8_substr($str,$start,$len=null)    {
    if (!strcmp($len,'0'))    return '';
  
    $byte_start = @utf8_char2byte_pos($str,$start);
    if ($byte_start === false)    {
      if ($start > 0)    {
        return false;    // $start outside string length
      } else {
        $start = 0;
      }
    }
  
    $str = substr($str,$byte_start);
  
    if ($len!=null)    {
      $byte_end = @utf8_char2byte_pos($str,$len);
      if ($byte_end === false)    // $len outside actual string length
        return $len<0 ? '' : $str;    // When length is less than zero and exceeds, then we return blank string.
      else
        return substr($str,0,$byte_end);
    }
    else    return $str;
  }


  function utf8_char2byte_pos($str,$pos)    {
    $n = 0;                // number of characters found
    $p = abs($pos);        // number of characters wanted
  
    if ($pos >= 0)    {
      $i = 0;
      $d = 1;
    } else {
      $i = strlen($str)-1;
      $d = -1;
    }
  
    for( ; strlen($str{$i}) && $n<$p; $i+=$d)    {
      $c = (int)ord($str{$i});
      if (!($c & 0x80))    // single-byte (0xxxxxx)
        $n++;
      elseif (($c & 0xC0) == 0xC0)    // multi-byte starting byte (11xxxxxx)
        $n++;
    }
    if (!strlen($str{$i}))    return false; // offset beyond string length
  
    if ($pos >= 0)    {
      // skip trailing multi-byte data bytes
      while ((ord($str{$i}) & 0x80) && !(ord($str{$i}) & 0x40)) { $i++; }
    } else {
      // correct offset
      $i++;
    }
  
    return $i;
  }

function saraThai($str){
$thaisub= ['่', //อ่
'้', //อ้
'๊', //อ๊
'๋', //อ๋
'ิ', //อิ
'ี', //อี
'ึ', //อึ
'ื', //อื
'ุ', //อุ
'ู', //อู
'ั', //อั
'์', //ิ
'็', //อ็
];
$count = 0;
foreach($thaisub as $sub){
 $count += substr_count($str,$sub );
}
return  $count;
}
