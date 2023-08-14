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
