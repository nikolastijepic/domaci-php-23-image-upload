<?php

if(!isset($_FILES['profileImage'])){
    die('Niste prosledili profilnu sliku!');
}

// Provera velicine slike //////////////////////////////////////////////////////////
$imageSize = $_FILES['profileImage']['size'];

$maxFileSize = 2 * 1024 * 1024;

if($imageSize > $maxFileSize){
    die("Slika je prevelika! Maksimalna dozvoljena velicina je 2MB.");
}

// Provera maksimalne rezolucije slike (1920x1024) /////////////////////////////////
$imageDimensions = getimagesize($_FILES['profileImage']['tmp_name']);
$maxWidth = 1920;
$maxHeight = 1024;

if($imageDimensions[0] > $maxWidth || $imageDimensions[1] > $maxHeight){
    die("Slika je prevelike rezolucije! Maksimalna dozvoljena rezolucija slike je 1920x1024.");
}

// Provera formata slike ///////////////////////////////////////////////////////////
$allowedExtensions = ['jpeg', 'jpg', 'png', 'gif'];

$imageType = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);

if(!in_array($imageType, $allowedExtensions)){
    die("Format slike nije dobar, mora biti: ".implode(', ', $allowedExtensions));
}

// Generisanje imena slike /////////////////////////////////////////////////////////
$imageName = time().".".$imageType;

$finalPath = "./uploads/$imageName";
$tmpFileName = $_FILES['profileImage']['tmp_name'];

if(!is_dir('./uploads')){
    mkdir('./uploads', permissions: 0755, recursive: true);
}

$imageUploaded = move_uploaded_file($tmpFileName, $finalPath);

if($imageUploaded){
    die("Slika je uspesno uploadovana!");
} else {
    die("Doslo je do greske prilikom uploadovanja slike!");
}