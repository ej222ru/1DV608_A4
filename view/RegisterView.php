<?php

namespace view;

class RegisterView {
        private static $name = "RegisterView::UserName";
        private static $password = "RegisterView::Password";
        private static $passwordRepeat = "RegisterView::PasswordRepeat";
        private static $registration = "RegisterView::Register";
	private static $messageId = "RegisterView::Message";
        private static $register = "register";
        
        private $message = "";
        private static $sessionSaveLocation = "\\view\\LoginView\\message";
        
	public function userWantsToRegister() {
		return isset($_GET[self::$register]) || isset($_POST[self::$registration]) ;            
	}        
	public function userRegister() {
		return isset($_POST[self::$registration]);
	}             
        
	public function response() {

            return $this->doRegisterForm();
        }    

	private function doRegisterForm() {
		
		//Correct messages
/*                
                var_dump(mb_strlen($this->getUserName(),'UTF-8'));
                if ($this->userRegister() && (mb_strlen($this->getUserName(),'UTF-8') < 3)) {
			$message =  "Username has too few characters, at least 3 characters.<br>";
		} 
                if ($this->userRegister() && (mb_strlen($this->getPassword(),'UTF-8') < 6)) {
			$message .=  "Password has too few characters, at least 6 characters.<br>";
		} 
                if ($this->userRegister() && strcmp($this->getPassword(), $this->getRepeatPassword() != 0)) {
			$message .=  "Passwords do not match.<br>";
		} 
                if ($this->userRegister() && $this->checkUserExist()) {
			$message .=  "User exists, pick another username.";
		} 
*/
               // $message = $this->getSessionMessage();

		//cookies
//		$this->unsetCookies();
		
		//generate HTML
		return $this->generateRegisterFormHTML($this->message);
	}      

        
  
        

        
	private function redirect($message) {
		$_SESSION[self::$sessionSaveLocation] = $message;
		$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		header("Location: $actual_link");
	}
        private function getSessionMessage() {
            if (isset($_SESSION[self::$sessionSaveLocation])) {
                    $message = $_SESSION[self::$sessionSaveLocation];
                    unset($_SESSION[self::$sessionSaveLocation]);
                    return $message;
            }
            return "";
	}
 	private function generateRegisterFormHTML($message) {
		return 
                        "<h2>Register new user</h2>
                        <form method='post' > 
				<fieldset>
					<legend>Register a new user - Write username and password</legend>
					<p id='".self::$messageId."'>$message</p>
                                        <div>
					<label for='".self::$name."'>Username :</label>
					<input type='text' id='".self::$name."' name='".self::$name."' value='".$this->getRequestUserName()."'/>
                                        </div>
                                        <div>
					<label for='".self::$password."'>Password :</label>
					<input type='password' id='".self::$password."' name='".self::$password."'/>
                                        </div>
                                        <div>
					<label for='".self::$passwordRepeat."'>Repeat password :</label>
					<input type='password' id='".self::$passwordRepeat."' name='".self::$passwordRepeat."'/>
                                        </div>

    					<input type='submit' name='".self::$registration."' value='Register'/>
				</fieldset>
			</form>
		";
	}             
        
        
        // temp move
	private function checkUserExist() {
            return false;
        }        
        
	public function getRequestUserName() {
		if (isset($_POST[self::$name]))
			return trim($_POST[self::$name]);
		return "";
	}  
        
	public function getUserName() {
		if (isset($_POST[self::$name]))
			return trim($_POST[self::$name]);

//		if (isset($_COOKIE[self::$cookieName]))
//			return trim($_COOKIE[self::$cookieName]);
		return "";
	}        
        
	public function getPassword() {
		if (isset($_POST[self::$password]))
			return trim($_POST[self::$password]);
		return "";
	}   
	public function getRepeatPassword() {
		if (isset($_POST[self::$passwordRepeat]))
			return trim($_POST[self::$passwordRepeat]);
		return "";
	}                
	public function setMessage($message) {
		$this->message = $message;
	}                
}
