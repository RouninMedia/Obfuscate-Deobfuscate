function deobfuscate(obfuscatedString)  {

  let blockCount = parseInt(obfuscatedString.substr(-7, 1) + obfuscatedString.substr(6, 1));
  obfuscatedString = obfuscatedString.substr(0, 6) + obfuscatedString.substr(7, (obfuscatedString.length - 14)) + obfuscatedString.substr(obfuscatedString.length - 6);
  
  var regex = new RegExp('(.{' + (obfuscatedString.length / blockCount) + '})', 'g');
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
