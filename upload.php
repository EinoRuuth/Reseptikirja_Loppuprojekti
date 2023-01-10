<?php
include 'dbConfig.php';
session_start();
$statusMsg = '';
if (isset($_POST["valmis"])) {
    $recipename = $_POST["reseptinimipost"];
    $ingredients = $_POST["ainekset"];
    $recipe = $_POST["ohjeet"];
    $creator = $_SESSION["id"];
    $course = $_POST["ruokalaji"];
}


// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["valmis"]) && !empty($_FILES["file"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $lisays = "INSERT INTO resepti (nimi, kuva, ruokalaji, ainekset, valmistuohje, kirjoittaja) VALUES ('$recipename', '$fileName', '$course', '$ingredients', '$recipe', '$creator')";
            $insert = $yhteys->query($lisays);
            if($insert){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }
}else{
    $statusMsg = 'Please select a file to upload.';
}

// Display status message
echo $statusMsg;
if ($insert ===TRUE) {
    echo "Resepti lisätty";
    header("Location: /php/etusivu.php");
    exit();
} else {
    echo "Virhe: ". $lisays. "<br>". $yhteys->error;
}
?>