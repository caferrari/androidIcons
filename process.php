<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('location: index.php');
    exit();
}



$formats = array(
    'hdpi' => array(38, 48, 72),
    'ldpi' => array(19, 24, 36),
    'mdpi' => array(25, 32, 48)
);

$valid_types = array(
    'image/gif',
    'image/png',
    'image/jpeg'
);

$files = count($_FILES['image']['name']);
if ($files == 0) exit('Please, select some files =)');

$zip = new ZipArchive;
$zip_file = tempnam('tmp', 'zip'); 
$zip->open($zip_file, ZIPARCHIVE::OVERWRITE);

for ($file_id = 0; $file_id < $files; $file_id++){
    if ($_FILES['image']['error'][$file_id] > 0) continue;

    $type = mime_content_type($_FILES['image']['tmp_name'][$file_id]);
    
    if (!in_array($type, $valid_types)) die ("Invalid file format: $type");
    
    $file = file_get_contents($_FILES['image']['tmp_name'][$file_id]);
    
    $name = preg_replace('@\.[a-z]+$@', '', $_FILES['image']['name'][$file_id]);
    
    $image = new Imagick();	
    $image->readImageBlob($file);
    $image->setImageFormat('png');
    $image->setImageCompressionQuality(90);
    foreach (array_keys($formats) as $screen){
        foreach ($formats[$screen] as $resolution){
            $current = clone $image;
            $current->cropThumbnailImage($resolution, $resolution);
            $zip->addFromString("{$screen}/{$name}_{$resolution}x{$resolution}.png", (string)$current);
            $current->clear();
            $current->destroy(); 
        }

    }
    $image->clear();
    $image->destroy();
}

$zip->close();
header("Content-Type: application/zip");
header("Content-Length: " . filesize($zip_file));
header("Content-Disposition: attachment; filename=\"icons.zip\""); 
readfile($zip_file);
@unlink($zip_file);
