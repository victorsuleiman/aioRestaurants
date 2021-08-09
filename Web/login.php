<?php

require_once("inc/Utilities/RestAPI.class.php");
require_once("inc/Utilities/LoginManager.class.php");
require_once("inc/Utilities/Page.class.php");
  
if(!empty($_POST)){

    if( isset($_POST['usernameL'])){
        $username = $_POST['usernameL'];
        $authUser = RestAPI::getUser($username);
        
        if (
            (gettype($authUser) == "object") &&
            (get_class($authUser) == "UserSession")
        ) {
            LoginManager::login($authUser);
        }
    }
} else {
    LoginManager::logout();
}

Page::pageHeader();
Page::leftMenuGuest();
Page::pageContentTop();

Page::loginForm();

Page::pageContentBottom();
Page::pageFooter();