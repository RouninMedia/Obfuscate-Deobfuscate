# Obfuscating and Deobfuscating JSON

```php

<?php

  //*****************//
 // OBFUSCATE ARRAY //
//*****************//

function obfuscateArray ($myArray) {
	
  $Keys = array_Keys($myArray);
 
  foreach($Keys as $Key) {
  	
  	if (is_array($myArray[$Key])) {
  	  
  	  $myArray[obfuscate($Key, 3)] = obfuscateArray($myArray[$Key]);
  	  
      unset($myArray[$Key]);
  	}
  	
  	else if (is_string($myArray[$Key])) {
 	
      $myArray[obfuscate($Key, 3)] = obfuscate($myArray[$Key], 4);
      
      unset($myArray[$Key]);
  	}
  }

  return $myArray;	
}


  //*******************//
 // DEOBFUSCATE ARRAY //
//*******************//

function deobfuscateArray ($ObfuscatedArray) {
	
  $Keys = array_Keys($ObfuscatedArray);
 
  foreach($Keys as $Key) {
  	
  	if (is_array($ObfuscatedArray[$Key])) {
  	  
  	  $ObfuscatedArray[deobfuscate($Key)] = deobfuscateArray($ObfuscatedArray[$Key]);
  	  
      unset($ObfuscatedArray[$Key]);
  	}
  	
  	else if (is_string($ObfuscatedArray[$Key])) {
 	
      $ObfuscatedArray[deobfuscate($Key)] = deobfuscate($ObfuscatedArray[$Key]);
      
      unset($ObfuscatedArray[$Key]);
  	}
  }

  return $ObfuscatedArray;	
}


$myJSON = '{"Example":{"JSON":"File"}}';
$myArray = json_decode($myJSON, TRUE);

$ObfuscatedArray = obfuscateArray($myArray);
$DeobfuscatedArray = deobfuscateArray($ObfuscatedArray);

echo $myJSON."\n\n"; // {"Example":{"JSON":"File"}}
echo json_encode($ObfuscatedArray)."\n\n"; // {"VZVSRd7VVVZ1aVdVSRdVTRd0VSVZ1b":{"aFTTkF4TVkF0TUaFTU":"wUUZUY4gUWRmVwUWRmU0gYxolV"}}
echo json_encode($DeobfuscatedArray)."\n\n"; // {"Example":{"JSON":"File"}}

?>
```

