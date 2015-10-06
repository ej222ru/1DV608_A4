<?php

namespace view;

class RegisterView {
        private static $name = "RegisterView::UserName";
        private static $password = "RegisterView::Password";
        private static $passwordRepeat = "RegisterView::PasswordRepeat";
        private static $registration = "RegisterView::Register";
	private static $messageId = "RegisterView::Message";
        private static $register = "register";
        
        
	public function userWantsToRegister() {
		return isset($_GET[self::$register]) ;            
	}        
	public function userRegister() {
		return isset($_POST[self::$registration]);
	}             
        
	public function response() {

            return $this->doRegisterForm();
        }    

	private function doRegisterForm() {
		$message = "";
		//Correct messages
                if ($this->userRegister() && mb_strlen($this->getUserName() < 7)) {
			$message =  "<p>Username has too few characters, at least 3 characters.</p>";
		} 
                if ($this->userRegister() && mb_strlen($this->getPassword() < 4)) {
			$message .=  "<p>Password has too few characters, at least 6 characters.</p>";
		} 
                if ($this->userRegister() && $this->checkUserExist()) {
			$message .=  "User exists, pick another username.\n";
		} 
                
/*                
                else if ($this->userWantsToLogin() && $this->getRequestUserName() == "") {
			$message =  "Username is missing";
		} else if ($this->userWantsToLogin() && $this->getPassword() == "") {
			$message =  "Password is missing";
		} else if ($this->loginHasFailed === true) {
			$message =  "Wrong name or password";
		} else {
			$message = $this->getSessionMessage();
		}
*/
		//cookies
//		$this->unsetCookies();
		
		//generate HTML
		return $this->generateRegisterFormHTML($message);
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
            return true;
        }        
        
	private function getRequestUserName() {
		if (isset($_POST[self::$name]))
			return trim($_POST[self::$name]);
		return "";
	}  
        
	private function getUserName() {
		if (isset($_POST[self::$name]))
			return trim($_POST[self::$name]);

//		if (isset($_COOKIE[self::$cookieName]))
//			return trim($_COOKIE[self::$cookieName]);
		return "";
	}        
        
	private function getPassword() {
		if (isset($_POST[self::$password]))
			return trim($_POST[self::$password]);
		return "";
	}        
}
