<?php

function obfuscate($String, $Recursion_Number) {
  
  $Obfuscated_String_Segments = [];
  $String_Segments = (strlen($String) > 99) ? explode('#', preg_replace('/(.{99})/', '$1#', $String)) : [$String];
  
  for ($s = 0; $s < count($String_Segments); $s++) {
    
    $String_Segment = $String_Segments[$s];

    if (strlen($String_Segment) < 4) {$String_Segment .= ' [(...)]';}

    $Obfuscated_Array = str_split($String_Segment);
  
    for ($i = 0; $i < $Recursion_Number; $i++) {

      for ($j = 0; $j < count($Obfuscated_Array); $j++) {

        $Obfuscated_Array[$j] = base64_encode($Obfuscated_Array[$j]);
        $Obfuscated_Array[$j] = str_replace('=', '', $Obfuscated_Array[$j]);
        $Obfuscated_Array[$j] = strrev($Obfuscated_Array[$j]);
      }
    }

    $Obfuscated_String_Segment = implode('', $Obfuscated_Array);
    $String_Segment_Length = str_split(sprintf('%02d', strlen($String_Segment)));

    $Obfuscated_String_Segment_With_Key = '';
    $Obfuscated_String_Segment_With_Key .= substr($Obfuscated_String_Segment, 0, 6);
    $Obfuscated_String_Segment_With_Key .= $String_Segment_Length[1];
    $Obfuscated_String_Segment_With_Key .= substr($Obfuscated_String_Segment, 6, (strlen($Obfuscated_String_Segment) - 12));
    $Obfuscated_String_Segment_With_Key .= $String_Segment_Length[0];
    $Obfuscated_String_Segment_With_Key .= substr($Obfuscated_String_Segment, (strlen($Obfuscated_String_Segment) - 6));

    $Obfuscated_String_Segments[$s] = $Obfuscated_String_Segment_With_Key;
  }
  
  return implode('_', $Obfuscated_String_Segments);
}

?>
