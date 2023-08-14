function obfuscate($String, $Recursion_Number) {
  
  $SeparatedString = (strlen($String) > 99) ? explode('#', preg_replace('/(.{99})/', '$1#', $String)) : $Array = [$String];
  
  for ($s = 0; $s < count($SeparatedString); $s++) {

    if (strlen($SeparatedString[$s]) < 4) {$SeparatedString[$s] .= ' [(...)]';}

    $Obfuscated_Array = str_split($SeparatedString[$s]);
  
    for ($i = 0; $i < $Recursion_Number; $i++) {

      for ($j = 0; $j < count($Obfuscated_Array); $j++) {

        $Obfuscated_Array[$j] = base64_encode($Obfuscated_Array[$j]);
        $Obfuscated_Array[$j] = str_replace('=', '', $Obfuscated_Array[$j]);
        $Obfuscated_Array[$j] = strrev($Obfuscated_Array[$j]);
      }
    }

    $Obfuscated_String = implode('', $Obfuscated_Array);
    $String_Length = str_split(sprintf('%02d', strlen($SeparatedString[$s])));

    $Obfuscated_String_With_Key = '';
    $Obfuscated_String_With_Key .= substr($Obfuscated_String, 0, 6);
    $Obfuscated_String_With_Key .= $String_Length[1];
    $Obfuscated_String_With_Key .= substr($Obfuscated_String, 6, (strlen($Obfuscated_String) - 12));
    $Obfuscated_String_With_Key .= $String_Length[0];
    $Obfuscated_String_With_Key .= substr($Obfuscated_String, (strlen($Obfuscated_String) - 6));

    $SeparatedString[$s] = $Obfuscated_String_With_Key;
  }
  
  return implode('_', $SeparatedString);
}
