#

```php

<?php

$DataPodJSON = '{"Example":{"JSON":"File"}}';


function obfuscateDataPod ($DataPodArray) {
	
  $Keys = array_Keys($DataPodArray);
 
  foreach($Keys as $Key) {
  	
  	if (is_array($DataPodArray[$Key])) {
  	  
  	  $DataPodArray[obfuscate($Key, 3)] = obfuscateDataPod($DataPodArray[$Key]);
  	  
      unset($DataPodArray[$Key]);
  	}
  	
  	else if (is_string($DataPodArray[$Key])) {
 	
      $DataPodArray[obfuscate($Key, 3)] = obfuscate($DataPodArray[$Key], 4);
      
      unset($DataPodArray[$Key]);
  	}
  }

  return $DataPodArray;	
}


function deobfuscateDataPod ($ObfuscatedDataPodArray) {
	
  $Keys = array_Keys($ObfuscatedDataPodArray);
 
  foreach($Keys as $Key) {
  	
  	if (is_array($ObfuscatedDataPodArray[$Key])) {
  	  
  	  $ObfuscatedDataPodArray[deobfuscate($Key)] = deobfuscateDataPod($ObfuscatedDataPodArray[$Key]);
  	  
      unset($ObfuscatedDataPodArray[$Key]);
  	}
  	
  	else if (is_string($ObfuscatedDataPodArray[$Key])) {
 	
      $ObfuscatedDataPodArray[deobfuscate($Key)] = deobfuscate($ObfuscatedDataPodArray[$Key]);
      
      unset($ObfuscatedDataPodArray[$Key]);
  	}
  }

  return $ObfuscatedDataPodArray;	
}



$DataPodArray = json_decode($DataPodJSON, TRUE);

$ObfuscatedDataPodArray = obfuscateDataPod($DataPodArray);
$DeobfuscatedDataPodArray = deobfuscateDataPod($ObfuscatedDataPodArray);

echo json_encode($ObfuscatedDataPodArray)."\n\n";
echo json_encode($DeobfuscatedDataPodArray)."\n\n";

?>
```

