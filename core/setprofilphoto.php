<?php
    require_once("config.php");
    $sessionid = session('user_id');
    $dbconn = $db->connect();
    // gettting image using post
    $profileimage = post('profileimage');
    
    // function for saving image
    function saveImage($profileimage){
        list($type, $profileimage) = explode(';', $profileimage);   
        list(, $profileimage) = explode(',', $profileimage);
        $profileimage = base64_decode($profileimage);
        $imagename = time().rand(0,100000).'.png'; 
        file_put_contents('../assets/profileimages/'.$imagename, $profileimage);
        if(file_exists('../assets/profileimages/'.$imagename)){
            return $imagename;
        }
    }
    function deleteImage($image){
        unlink('../assets/profileimages/'.$image);
        if(!file_exists('../assets/profileimages/'.$image)){
            return true;
        }    
    }

   
    // control and set photo
    $controlImage = $dbconn->prepare("SELECT * FROM users WHERE user_profileimage = :im AND user_id = :id");
    $controlImage->execute([':im' => '' , ':id' =>$sessionid ]);
    if($controlImage->rowCount()){
        $image = saveImage($profileimage);

        $setProfileImage = $dbconn->prepare("UPDATE  users SET user_profileimage = :im WHERE user_id =:id");
        $setProfileImage->execute([':im' => $image , ':id' => $sessionid]);
        if($setProfileImage->rowCount()){
            echo 'successful';
        }else{
            echo 'unsuccessful';
        }

    }else{
        $getProfileImage = $dbconn->prepare("SELECT user_profileimage FROM users WHERE user_id = :id");
        $getProfileImage->execute([':id' => $sessionid]);
        
        $oldImage = $getProfileImage->fetchColumn();


        if(file_exists('../assets/profileimages/'.$oldImage)){
            deleteImage($oldImage);
        }
        $newImage = saveImage($profileimage);

        $updateProfileImage = $dbconn->prepare("UPDATE users SET user_profileimage = :im WHERE user_id = :id");
        $updateProfileImage->execute([':im'=>$newImage,':id'=> $sessionid]);
        if($updateProfileImage->rowCount()){
            echo 'updated';
        }else{
            echo 'unsuccessful';
        }
    }
    
?>