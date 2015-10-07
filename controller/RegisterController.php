<?php

namespace controller;

class RegisterController {

	private $model;
	private $view;
	private $loginView;

	public function __construct(\model\RegisterModel $model, \view\RegisterView $view, \view\LoginView $loginView) {
		$this->model = $model;
		$this->view =  $view;
		$this->loginView =  $loginView;
	}    
        public function registerUser($isLoggedIn, $lv, $dtv) {
                $message = "";
                $savedOK = false;
                $userRegister = $this->view->userRegister();
                 if (preg_match('/[^A-Za-z0-9.#\\-$]/', $this->view->getUserName())) {
                    $message =  "Username contains invalid characters.";
                    $this->view->setAdjustedRequestUserName(strip_tags($this->view->getUserName()));
                }
                        
                if ($userRegister && (mb_strlen($this->view->getUserName(),'UTF-8') < 3)) {
			$message =  "Username has too few characters, at least 3 characters.<br>";
		} 
                if ($userRegister && (mb_strlen($this->view->getPassword(),'UTF-8') < 6)) {
			$message .=  "Password has too few characters, at least 6 characters.<br>";
		} 

                if ($userRegister && strcmp($this->view->getPassword(), $this->view->getRepeatPassword()) != 0) {
			$message .=  "Passwords do not match.<br>";
		} 
                if (strlen($message) == 0){
                    if ($userRegister && $this->model->getUser($this->view->getUserName())) {
                            $message .=  "User exists, pick another username.";
                    } 
                    else if ($userRegister) {
                        $this->model->saveUser($this->view->getUserName(), $this->view->getPassword());
                        $message .= "Registered new user.";
                        $this->loginView->setAdjustedRequestUserName(strip_tags($this->view->getUserName()));
                        $savedOK = true;
                        // render login
                    }
                }                
                $this->view->setMessage($message);
                
                if ($savedOK) {
                    return $message;
                }
                else {
                    $lv->renderRegister($isLoggedIn,$this->view,$dtv);
                }
        }
}
