<?php

Class Login_Controller_Index extends Frontend_Controller_Action {

  public function index() {
    $this->setPageTitle("Login");
    $this->setBlock("login/body");
    $this->render();
  }
}