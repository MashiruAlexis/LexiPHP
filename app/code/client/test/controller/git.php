<?php

/**
 *  Git PHP
 *  @author Ramon Alexis Celis [celisramon@ymail.com]
 */

Class Test_Controller_Git extends Frontend_Controller_Action {
  
  /**
   *  Git Username
   */
  public $username = "";
  
  /**
   *  Git Password
   */
  public $password = "";
  
  
  public function run($code) {
    return core::log(system($code));
  }
  
  public function index() {
//     Core::log(nl2br($this->run("git status")));
//     Core::log(nl2br($this->run("git pull")));
//     Core::log(nl2br($this->run("git checkout 1.0.1")));
    $this->setTitle("Git Mode");
    $this->setBlock("test/index");
    $this->render();
  }
}