function obfuscate(string, recursionNumber) {

  let obfuscatedArray = string.split('');
  
  for (let i = 0; i < recursionNumber; i++) {

    for (let j = 0; j < obfuscatedArray.length; j++) {

      obfuscatedArray[j] = window.btoa(obfuscatedArray[j]);
      obfuscatedArray[j] = obfuscatedArray[j].replace('=', '');
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
