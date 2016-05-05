<?php
/**
 *
 * MIT License
 *
 * Copyright (c) 2016 Ramon Alexis Celis
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

 Class Hash_Controller_Password {

 	/**
 	 *	PHP version
 	 */
 	const VERSION_CONFLICT = false;

 	public function __construct() {

 		if (version_compare(phpversion(), '5.5.0', '<')===true) {
		    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
		<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
		<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
		This password hash controller will not work with the current verion of your php. -Lexi</p></div>';
		    exit;
		}
 	}

 	public function hash($pass) {
 		if(isset($pass) && $pass != null) {
 			$pass = password_hash($pass, PASSWORD_DEFAULT);
 		}
 		return $pass;
 	}

 	public function verify($pass, $hashedPass) {
 		if($pass != null && isset($pass) && isset($hashedPass) && $hashedPass != null) {
 			if(password_verify($pass, $hashedPass)) {
 				return true;
 			}else{
 				return false;
 			}
 		}
 	}
 }