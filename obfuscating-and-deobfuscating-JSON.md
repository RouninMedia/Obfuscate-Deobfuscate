# Obfuscating and Deobfuscating JSON

```php

<?php

  //*********//
 // IS_JSON //
//*********//

function is_JSON($data) {

  return (is_null(json_decode($data))) ? FALSE : TRUE;
}


  //****************//
 // OBFUSCATE DATA //
//****************//

function obfuscateData ($data) {

  if (!is_array($data)) {$data = json_decode($data, TRUE);}
	
  $obfuscatedData = [];

  // ORDINAL ARRAYS
  if ((is_array($data)) && (array_is_list($data))) {
  	
    for ($i = 0; $i < count($data); $i++) {
  		
      switch (TRUE) {
  	  	
        case (is_string($data[$i])): $obfuscatedData[] = obfuscate($data[$i], 4); break;
        case (is_array($data[$i])): $obfuscatedData[] = obfuscateData($data[$i]); break;
        case (is_null($data[$i])): $obfuscatedData[] = obfuscate('@null', 4); break;
        case ((is_bool($data[$i])) && ($data[$i] === TRUE)): $obfuscatedData[] = obfuscate('@true', 4); break;
        case ((is_bool($data[$i])) && ($data[$i] === FALSE)): $obfuscatedData[] = obfuscate('@false', 4); break;
      }
    }
  }
  
  // ASSOCIATIVE ARRAYS
  else if (is_array($data)) {
    	
    $keys = array_keys($data);
    $values = array_values($data);
  	
    for ($i = 0; $i < count($keys); $i++) {
  		
      $key = $keys[$i];
      $value = $values[$i];
  	
      switch (TRUE) {
  	  	
        case (is_string($value)): $obfuscatedData[obfuscate($key, 3)] = obfuscate($value, 4); break;
        case (is_array($value)): $obfuscatedData[obfuscate($key, 3)] = obfuscateData($value); break;
        case (is_null($value)): $obfuscatedData[obfuscate($key, 3)] = obfuscate('@null', 4); break;
        case ((is_bool($value)) && ($value === TRUE)): $obfuscatedData[obfuscate($key, 3)] = obfuscate('@true', 4); break;
        case ((is_bool($value)) && ($value === FALSE)): $obfuscatedData[obfuscate($key, 3)] = obfuscate('@false', 4); break;
      }
    }
  }
  
  return $obfuscatedData;
}



  //******************//
 // DEOBFUSCATE DATA //
//******************//

function deobfuscateData ($obfuscatedData) {
	
  if (!is_array($obfuscatedData)) {$obfuscatedData = json_decode($obfuscatedData, TRUE);}
	
  $deobfuscatedData = [];

  // ORDINAL ARRAYS
  if ((is_array($obfuscatedData)) && (array_is_list($obfuscatedData))) {
  	
    for ($i = 0; $i < count($obfuscatedData); $i++) {
  		
      switch (TRUE) {
  	  	
        case (is_string($obfuscatedData[$i])):
  	      
          if (deobfuscate($obfuscatedData[$i]) === '@true') {$deobfuscatedData[] = TRUE;}
          elseif (deobfuscate($obfuscatedData[$i]) === '@false') {$deobfuscatedData[] = FALSE;}
          elseif (deobfuscate($obfuscatedData[$i]) === '@null') {$deobfuscatedData[] = NULL;}
          else {$deobfuscatedData[] = deobfuscate($obfuscatedData[$i]);}
          break;
  	      
        case (is_array($obfuscatedData[$i])):

          $deobfuscatedData[] = deobfuscateData($obfuscatedData[$i]);
          break;
      }
    }
  }
  
  // ASSOCIATIVE ARRAYS
  else if (is_array($obfuscatedData)) {
    	
    $keys = array_keys($obfuscatedData);
    $values = array_values($obfuscatedData);
  	
    for ($i = 0; $i < count($keys); $i++) {
  		
      $key = $keys[$i];
      $value = $values[$i];
  	
      switch (TRUE) {
  	  	
        case (is_string($value)):
  	    
          if (deobfuscate($value) === '@true') {$deobfuscatedData[deobfuscate($key)] = TRUE;}
          elseif (deobfuscate($value) === '@false') {$deobfuscatedData[deobfuscate($key)] = FALSE;}
          elseif (deobfuscate($value) === '@null') {$deobfuscatedData[deobfuscate($key)] = NULL;}
          else {$deobfuscatedData[deobfuscate($key)] = deobfuscate($value);}
          break;
  	      
        case (is_array($value)):

          $deobfuscatedData[deobfuscate($key)] = deobfuscateData($value);
          break;
      }
    }
  }
  
  return $deobfuscatedData;
}

?>
```

