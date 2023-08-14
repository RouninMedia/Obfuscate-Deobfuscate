# Obfuscate-Deobfuscate
A simple obfuscation which works both server-side in PHP and client-side in Javascript

**N.B.** *Obfuscation* is a very specific process. It is not *Encryption* and is not suitable as a stand-in for the latter.

**Obfuscation** is a technique which makes a given piece of data *more difficult* for humans to read, understand and process and, at the same time, ensures that the data is *no more difficult* for computers to read, understand and process.

This obfuscation repeatedly applies **Base64 Encoding** (which can be encoded and decoded by both PHP and Javascript) and **string reversal** to a given string.

The obfuscation works _both server-side and client-side_, which means (just one example) that a string may be:

 - **obfuscated** on the server initially; and
 - **deobfuscated** in the browser, later. 

## PHP Obfuscate
```
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
```

## PHP Deobfuscate
```
function deobfuscate($Obfuscated_String) {

  $Separated_String = [];
  $Separated_Obfuscated_String = explode('_', $Obfuscated_String);
  
  for ($s = 0; $s < count($Separated_Obfuscated_String); $s++) {
  	
    $Obfuscated_String = $Separated_Obfuscated_String[$s];

    $Block_Length = intval(substr($Obfuscated_String, (strlen($Obfuscated_String) - 7), 1).substr($Obfuscated_String, 6, 1));

    if ($Block_Length === 0) {return FALSE;}

    $Obfuscated_String = substr($Obfuscated_String, 0, 6).substr($Obfuscated_String, 7, (strlen($Obfuscated_String) - 14)).substr($Obfuscated_String, (strlen($Obfuscated_String) - 6));
    $Obfuscated_String = preg_replace('/(.{'.(strlen($Obfuscated_String) / $Block_Length).'})/', '$1|', $Obfuscated_String);
    
    $Obfuscated_Array = explode('|', $Obfuscated_String);
    array_pop($Obfuscated_Array);

    while (count(str_split($Obfuscated_Array[0])) > 1) {

      for ($i = 0; $i < count($Obfuscated_Array); $i++) {

        $Obfuscated_Array[$i] = strrev($Obfuscated_Array[$i]);
        $Obfuscated_Array[$i] = base64_decode($Obfuscated_Array[$i]);
      }
    }

    $String = implode('', $Obfuscated_Array);

    $String = str_replace(' [(...)]', '', $String);
    
    $Separated_String[$s] = $String; 
  }

  return implode('', $Separated_String);
}
```

## Javascript Obfuscate
```
function obfuscate(string, recursionNumber) {

  let obfuscatedArray = string.split('');
  
  for (let i = 0; i < recursionNumber; i++) {

    for (let j = 0; j < obfuscatedArray.length; j++) {

      obfuscatedArray[j] = window.btoa(obfuscatedArray[j]);
      obfuscatedArray[j] = obfuscatedArray[j].replace(/\=/g, '');
      obfuscatedArray[j] = obfuscatedArray[j].split('').reverse().join('');
    }
  }

  let obfuscatedString = obfuscatedArray.join('');

  let stringLength = string.length.toString().padStart(2, '0').split('');

  let obfuscatedStringWithKey = '';
  obfuscatedStringWithKey += obfuscatedString.substr(0, 6);
  obfuscatedStringWithKey += stringLength[1];
  obfuscatedStringWithKey += obfuscatedString.substr(6, (obfuscatedString.length - 12));
  obfuscatedStringWithKey += stringLength[0];
  obfuscatedStringWithKey += obfuscatedString.substr(obfuscatedString.length - 6);

  return obfuscatedStringWithKey;
}
```

## Javascript Deobfuscate
```
function deobfuscate(obfuscatedString)  {

  let blockLength = parseInt(obfuscatedString.substr(-7, 1) + obfuscatedString.substr(6, 1));
  obfuscatedString = obfuscatedString.substr(0, 6) + obfuscatedString.substr(7, (obfuscatedString.length - 14)) + obfuscatedString.substr(obfuscatedString.length - 6);
  
  var regex = new RegExp('(.{' + (obfuscatedString.length / blockLength) + '})', 'g');
  let obfuscatedArray = obfuscatedString.replace(regex, '$1|').split('|');
  obfuscatedArray.pop();


  while (obfuscatedArray[0].split('').length > 1) {

    for (let i = 0; i < obfuscatedArray.length; i++) {

      obfuscatedArray[i] = obfuscatedArray[i].split('').reverse().join('');
      obfuscatedArray[i] = window.atob(obfuscatedArray[i]);
      obfuscatedArray[i] = obfuscatedArray[i].replace(/\=/g, '');
    }
  }

  let string = obfuscatedArray.join('');
  
  return string;
}
```
