function obfuscate(string, recursionNumber) {

  let stringSegments;
  let obfuscatedStringSegments = [];

  if (string.length > 99) {

    let regex = new RegExp('(.{99})', 'g');
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
    let stringLength = string.length.toString().padStart(2, '0').split('');

    let obfuscatedStringSegmentWithKey = '';
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(0, 6);
    obfuscatedStringSegmentWithKey += stringLength[1];
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(6, (obfuscatedStringSegment.length - 12));
    obfuscatedStringSegmentWithKey += stringLength[0];
    obfuscatedStringSegmentWithKey += obfuscatedStringSegment.substr(obfuscatedStringSegment.length - 6);

    obfuscatedStringSegments[s] = obfuscatedStringSegmentWithKey;
  }

  return obfuscatedStringSegments.join('_');
}
