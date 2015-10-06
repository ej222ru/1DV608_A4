<?php

namespace controller;

class RegisterController {

	private $model;
	private $view;

	public function __construct(\model\RegisterModel $model, \view\RegisterView $view) {
		$this->model = $model;
		$this->view =  $view;
	}    
        public function registerUser($isLoggedIn, $lv, $dtv) {
                $message = "";
                $savedOK = false;
                $userRegister = $this->view->userRegister();
                
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
                        $savedOK = true;
                        // render login
                    }
                }                
                $this->view->setMessage($message);
                
                if ($savedOK)
                {
                    return $message;
                    //$this->view->redirect_index($message);
                }
                else
                {
                    $lv->renderRegister($isLoggedIn,$this->view,$dtv);
                }
        }
}
