function deobfuscate($Obfuscated_String) {

  $Block_Length = intval(substr($Obfuscated_String, (strlen($Obfuscated_String) - 7), 1).substr($Obfuscated_String, 6, 1));
  $Obfuscated_String = substr($Obfuscated_String, 0, 6).substr($Obfuscated_String, 7, (strlen($Obfuscated_String) - 14)).substr($Obfuscated_String, (strlen($Obfuscated_String) - 6));

  $Obfuscated_String = preg_replace('/(.{'.(strlen($Obfuscated_String) / $Block_Length).'})/', '$1|', $Obfuscated_String);
  $Obfuscated_Array = explode('|', $Obfuscated_String);
  array_pop($Obfuscated_Array);

  while (count(str_split($Obfuscated_Array[0])) > 1) {

    for ($i = 0; $i < count($Obfuscated_Array); $i++) {

      $Obfuscated_Array[$i] = strrev($Obfuscated_Array[$i]);
      $Obfuscated_Array[$i] = base64_decode($Obfuscated_Array[$i]);
      $Obfuscated_Array[$i] = str_replace('=', '', $Obfuscated_Array[$i]);
    }
  }

  $String = implode('', $Obfuscated_Array);

  return $String;
}
