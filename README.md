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
```

## PHP Deobfuscate
```
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
```

## Javascript Obfuscate
```
function obfuscate(string, recursionNumber) {

  let stringSegments;
  let obfuscatedStringSegments = [];

  if (string.length > 99) {

    const regex = new RegExp('(.{99})', 'g');
    stringSegments = string.replace(regex, '$1#').split('#');
  }

  else {

    stringSegments = [string];
  }

  for (let s = 0; s < stringSegments.length; s++) {

    let stringSegment = stringSegments[s];

    if (stringSegment.length < 4) {stringSegment += ' [(...)]';}

    let obfuscatedArray = stringSegment.split('');
  
    for (let i = 0; i < recursionNumber; i++) {

      for (let j = 0; j < obfuscatedArray.length; j++) {

        obfuscatedArray[j] = window.btoa(obfuscatedArray[j]);
        obfuscatedArray[j] = obfuscatedArray[j].replace(/\=/g, '');
        obfuscatedArray[j] = obfuscatedArray[j].split('').reverse().join('');
      }
    }

    let obfuscatedStringSegment = obfuscatedArray.join('');
    let stringSegmentLength = stringSegment.length.toString().padStart(2, '0').split('');

    let obfuscatedStringSegmentWithKey = '';
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(0, 6);
    obfuscatedStringSegmentWithKey += stringSegmentLength[1];
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(6, (obfuscatedStringSegment.length - 12));
    obfuscatedStringSegmentWithKey += stringSegmentLength[0];
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(obfuscatedStringSegment.length - 6);

    obfuscatedStringSegments[s] = obfuscatedStringSegmentWithKey;
  }

  return obfuscatedStringSegments.join('_');
}
```

## Javascript Deobfuscate
```
function deobfuscate(obfuscatedString)  {

  let stringSegments = [];
  let obfuscatedStringSegments = obfuscatedString.split('_');
  
  for (let s = 0; s < obfuscatedStringSegments.length; s++) {
  	
    let obfuscatedStringSegment = obfuscatedStringSegments[s];

    let blockCount = parseInt(obfuscatedStringSegment.substr(-7, 1) + obfuscatedStringSegment.substr(6, 1));
    obfuscatedStringSegment = obfuscatedStringSegment.substr(0, 6) + obfuscatedStringSegment.substr(7, (obfuscatedStringSegment.length - 14)) + obfuscatedStringSegment.substr(obfuscatedStringSegment.length - 6);
  
    const regex = new RegExp('(.{' + (obfuscatedStringSegment.length / blockCount) + '})', 'g');
    let obfuscatedArray = obfuscatedStringSegment.replace(regex, '$1|').split('|');
    obfuscatedArray.pop();

    while (obfuscatedArray[0].split('').length > 1) {

      for (let i = 0; i < obfuscatedArray.length; i++) {

        obfuscatedArray[i] = obfuscatedArray[i].split('').reverse().join('');
        obfuscatedArray[i] = window.atob(obfuscatedArray[i]);
        obfuscatedArray[i] = obfuscatedArray[i].replace(/\=/g, '');
      }
    }

    let stringSegment = obfuscatedArray.join('');
    stringSegment = stringSegment.replace(' [(...)]', '');
    stringSegments[s] = stringSegment;
  }
  
  return stringSegments.join('');
}
```
