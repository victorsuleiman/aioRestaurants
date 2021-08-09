<?php

date_default_timezone_set('America/Vancouver');

    class LoginManager{
        private static $login;

        public static function checkLogin(){
            self::$login = false;
            if(!isset($_SESSION)){
                session_start();
            }
            if(
                isset($_SESSION['loggedin']) &&
                self::isLoginSessionExpired()
            ){
                self::$login = true;
            } else {
                session_destroy();
                self::$login = false;
                header("Location: login.php");
            }
            return self::$login;
        }

        public static function login(UserSession $authUser){
            if($authUser->checkPassword($_POST['password'])){
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION['username'] = $authUser;

                $time = new DateTime();
                $time->add(new DateInterval('PT' . 30 . 'M'));
                $_SESSION['stamp'] = $time->format('H:i');

                header("Location: index.php?page=dashboard");
                exit();
            } else {
                Page::modalMessage("Wrong password or username!");
            }
        }
        
        public static function logout(){
            session_start();
            unset($_SESSION["loggedin"]);
            unset($_SESSION["username"]);
            $url = "login.php";

            if(isset($_GET["session_expired"])) {
                $url .= "?session_expired=1";
            }
            session_destroy();
        }

        private static function isLoginSessionExpired() {
            if( isset($_SESSION["username"]) ){  
                if(date("H:i") <= $_SESSION['stamp']){ 
                    return true; 
                } 
            }
            return false;
        }
    }