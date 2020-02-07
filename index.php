<?php
/**
* 1) Place FileZilla queue XML file in same directory as index.php
* 2) Set $fileName
* 3) Set $filterFileName to whatever filename should be removed. 
     Could be ".zip" to remove all zip files, or "_default" to remove all filenames containing "_default"
* 4) Run index.php until it echos "Finished!"
*/

$fileName = 'FileZilla.xml';
$filterFileName = '_default';
$stopAt = 1000;
$stopCounter = 0;
$document = new DOMDocument();
$document->formatOutput = false;
$document->Load($fileName);

foreach ($document->getElementsByTagName('File') as $fileNode) {
    foreach ($fileNode->getElementsByTagName('LocalFile') as $localFileNode) {
        if (strpos((string)$localFileNode->nodeValue, $filterFileName) !== false) {
            $fileNode->parentNode->removeChild($fileNode);
            $stopCounter++;
        }
    }
    if($stopAt == $stopCounter) {
        break;
    }
}

$document->Save($fileName);

echo 'Removed ' . $stopCounter . ' nodes.';

if($stopCounter > 0) {
    die('<script type="text/javascript"> location.reload(); </script>');
}

echo '<br/><br/><span style="color:green">Finished!</span>';
