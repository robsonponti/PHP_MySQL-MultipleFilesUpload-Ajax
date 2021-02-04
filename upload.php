<?php
//teste

require("db.php"); //your connection file here

$date = date("Y-m-d H:i:s");

    if(count($_FILES['file']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['file']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['file']['tmp_name'][$i];
            $imageFileType = strtolower(pathinfo(basename($_FILES["file"]["name"][$i]),PATHINFO_EXTENSION));

            //this line make sure we've a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = 'file'.rand().'_'.$date.'.'.$imageFileType; //you can customize this line, here is name of the file we are uploading.

                //save the url and the file
               
                $filePath = "youdirtoupload/"; //insert your dir
                $finalPath = $filePath.$shortname;
                
                //Upload the file into the temp dir
                if(move_uploaded_file($tmpFilePath, $finalPath)) {

                    $files[] = $shortname;
                    //here we insert into db 
                    //$shortname for the filename
                    //$filePath for the url file

                    $stmt = $connection->prepare("INSERT INTO multiplefileuploads (path, filename, created) VALUES(?, ?, ?)");
                    $stmt->bindParam(1, $filePath);
                    $stmt->bindParam(2, $shortname);
                    $stmt->bindParam(3, $date);
                    if($stmt->execute()){
                      echo "Uploaded file with sucess";
                    }
                    else{
                      echor "Sorry. Error uploading file."; 
                    }

                }
            }
        }
    }


?>
