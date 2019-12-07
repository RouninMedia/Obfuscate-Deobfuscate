# Obfuscate-Deobfuscate
A simple obfuscation which works both server-side in PHP and client-side in Javascript

**Obfuscation** is a technique which makes a given piece of data *more difficult* for humans to read, understand and process and, at the same time, ensures that the data is *no more difficult* for computers to read, understand and process.

This obfuscation repeatedly applies **Base64 Encoding** (which can be encoded and decoded by both PHP and Javascript) and **string reversal** to a given string.

The obfuscation works both server-side and client-side, which means that a string can be obfuscated on the server initially and deobfuscated in the browser, later. 

## PHP Obfuscate
```
function obfuscate($String, $Recursion_Number) {

  $Obfuscated_Array = str_split($String);
  
  for ($i = 0; $i < $Recursion_Number; $i++) {

    for ($j = 0; $j < count($Obfuscated_Array); $j++) {

      $Obfuscated_Array[$j] = base64_encode($Obfuscated_Array[$j]);
      $Obfuscated_Array[$j] = str_replace('=', '', $Obfuscated_Array[$j]);
      $Obfuscated_Array[$j] = strrev($Obfuscated_Array[$j]);
    }
  }

  $Obfuscated_String = implode('', $Obfuscated_Array);

  return $Obfuscated_String;
}
```

## PHP Deobfuscate
```
function deobfuscate($Obfuscated_String, $Recursion_Number) {

  $Obfuscated_String = preg_replace('/(.{'.(strlen($Obfuscated_String) / 6).'})/', '$1|', $Obfuscated_String);
  $Obfuscated_Array = explode('|', $Obfuscated_String);
  array_pop($Obfuscated_Array);

  for ($i = 0; $i < count($Obfuscated_Array); $i++) {

    for ($j = 0; $j < $Recursion_Number; $j++) {

      $Obfuscated_Array[$i] = strrev($Obfuscated_Array[$i]);
      $Obfuscated_Array[$i] = base64_decode($Obfuscated_Array[$i]);
    }
  }

  $Deobfuscated_String = implode('', $Obfuscated_Array);

  return $Deobfuscated_String;
}
```

## Javascript Obfuscate
```
const obfuscate(string, recursionNumber) => {

  let obfuscatedArray = string.split('');
  
  for (let i = 0; i < recursionNumber; i++) {

    for (let j = 0; j < count(obfuscatedArray); j++) {

      obfuscatedArray[j] = window.btoa(obfuscatedArray[j]);
      obfuscatedArray[j] = obfuscatedArray[j].replace('=', '');
      obfuscatedArray[i] = obfuscatedArray[i].split('').reverse().join('');
    }
  }

  let obfuscatedString = obfuscatedArray.join('');

  return obfuscatedString;
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
    }
  }

  let string = obfuscatedArray.join('');
  return string;
}
```
