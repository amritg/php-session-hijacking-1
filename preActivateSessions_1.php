<?php 
    require("config.php");
    /* 
        Everytime when any users login in successfully,
        1. Loop through all the users, whose session is to be pre-activated, in order to Check if the session has already started.
        2. If there is no pre-activated session, create session for each users by setting the session_id(), incrementing interger number by 5, fetched from db.
    */
    $preActivateSessionUsers = ["amritg","admin","a"]; // Users whose session will start automatically

    for($i = 0;$i < (count($preActivateSessionUsers)); $i++){
        $sessionUser = "sess_" . bin2hex($preActivateSessionUsers[$i]); // Encode Users in hexcode
        if(!checkStoredSession($sessionUser)){
            $searchUser = mysqli_query($conn,"SELECT * FROM users where name = '$preActivateSessionUsers[$i]'");
            $rowUser = mysqli_fetch_array($searchUser, MYSQLI_ASSOC);
            if($rowUser){
                $userName = $rowUser["name"];
                
                // Create new session
                session_id(bin2hex($userName));
                // echo session_id()+"<br>";
                session_start();
                $_SESSION['userName']= $userName;
                // echo "<pre>", print_r($_SESSION, 1), "</pre>";
                session_write_close();
            }
        }
    }
    // chechStoredSession function loop through all the stored session to check if the session has already be set or not for Users where $sessionVariable(userName) is to be set automatically!!
    function checkStoredSession($sessionId){
        $allStoredSession = scandir(session_save_path()); // return arrayList of all file names inside the directroy where all sessions are stored
        for($j = 0; $j < (count($allStoredSession)); $j++){
            $pSession = $allStoredSession[$j];
            if($pSession == $sessionId){
                return true;
            }
        }
    }
?>