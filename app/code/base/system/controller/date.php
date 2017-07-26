<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Date {
  
  public function getTime($format = "l jS \of F Y h:i:s A") {
    return date($format, strtotime('-30 days'));
  }
}