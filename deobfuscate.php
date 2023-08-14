<?php

function deobfuscate($Obfuscated_String) {

  $String_Segments = [];
  $Obfuscated_String_Segments = explode('_', $Obfuscated_String);
  
  for ($s = 0; $s < count($Obfuscated_String_Segments); $s++) {
  	
    $Obfuscated_String_Segment = $Obfuscated_String_Segments[$s];

    $Block_Length = intval(substr($Obfuscated_String_Segment, (strlen($Obfuscated_String_Segment) - 7), 1).substr($Obfuscated_String_Segment, 6, 1));

    if ($Block_Length === 0) {return FALSE;}

    $Obfuscated_String_Segment = substr($Obfuscated_String_Segment, 0, 6).substr($Obfuscated_String_Segment, 7, (strlen($Obfuscated_String_Segment) - 14)).substr($Obfuscated_String_Segment, (strlen($Obfuscated_String_Segment) - 6));
    $Obfuscated_String_Segment = preg_replace('/(.{'.(strlen($Obfuscated_String_Segment) / $Block_Length).'})/', '$1|', $Obfuscated_String_Segment);
    
    $Obfuscated_Array = explode('|', $Obfuscated_String_Segment);
    array_pop($Obfuscated_Array);

    while (count(str_split($Obfuscated_Array[0])) > 1) {

      for ($i = 0; $i < count($Obfuscated_Array); $i++) {

        $Obfuscated_Array[$i] = strrev($Obfuscated_Array[$i]);
        $Obfuscated_Array[$i] = base64_decode($Obfuscated_Array[$i]);
      }
    }

    $String_Segment = implode('', $Obfuscated_Array);

    $String_Segment = str_replace(' [(...)]', '', $String_Segment);
    
    $String_Segments[$s] = $String_Segment; 
  }

  return implode('', $String_Segments);
}

?>
