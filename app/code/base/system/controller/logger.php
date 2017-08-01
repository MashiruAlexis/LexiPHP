<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Logger {
  
  /**
   *  Default Log File Name
   */
  public $filename = "systemlog.txt";
  
  /**
   *  Default Log Location
   */
  public $logLocation = "/var/log/";
  
  /**
   *  Log Proccess
   */
  public function log($varString) {
    $date = Core::getSingleton("system/date");
    Core::log($date->getTitme());
  }
}