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


Class Frontend_Controller_Action {

	/**
	 *	Block
	 */
	public $blocks = array();

	/**
	 *	CSS
	 */
	public $css = array();

	/**
	 *	Javascript
	 */
	public $js = array();

	/**
	 *	Path to Blocks
	 */
	public $paths = array();

	/**
	 *	Path to CSS
	 */
	public $pathCss = array();

	/**
	 *	Main Block
	 */
	public $mainBlock = "";

	/**
	 *	Page Title
	 */
	public $pageTitle = "lexi";

	public function __construct() {
		$this->setDefault();
	}

	/**
	 *	Load defaults
	 */
	public function setDefault() {
		$this->linkCss("http://fonts.googleapis.com/icon?family=Material+Icons");
		$this->setBaseCss("default/materialize");
		$this->setBaseCss("default/style");
		$this->setBaseJs("default/jquery-2.1.1.min");
		$this->setBaseJs("default/materialize");
		$this->setBaseJs("default/init");
	}

	/**
	 * Set CSS
	 */
	public function setBaseCss($varCss) {
		$varCss = explode(BS, $varCss);
		$dir = Core::getSingleton("system/config")->loadConfigFile()->frontend->directory;
		$sysConfig = Core::getSingleton("system/config")->loadConfigFile();
		$baseurl = $sysConfig->system->url;
		$this->css[] = "<link rel='stylesheet' href='" . $baseurl . $dir->skin . BS . $dir->base . BS . $varCss[0] . BS . $dir->css . BS . $varCss[1] . ".css'>";
	}

	/**
	 *	Link external css file
	 */
	public function linkCss($varLinkCss) {
		$this->css[] = '<link href="'.$varLinkCss.'" rel="stylesheet">';
	}

	/**
	 *	Set JS
	 */
	public function setBaseJs($varJs) {
		$varJs = explode(BS, $varJs);
		// Core::log($varJs[1]);
		$dir = Core::getSingleton("system/config")->loadConfigFile()->frontend->directory;
		$sysConfig = Core::getSingleton("system/config")->loadConfigFile();
		$baseurl = $sysConfig->system->url;
		$this->js[] = "<script src='" . $baseurl . $dir->skin . BS . $dir->base . BS . $varJs[0] . BS . $dir->js . BS . $varJs[1] . ".js'></script>";
	}

	/**
	 *	Get Images from Skin
	 */
	public function getBaseImage($varImage) {
		$varImage = explode(BS, $varImage);
		$dir = Core::getSingleton("system/config")->loadConfigFile()->frontend->directory;
		$sysConfig = Core::getSingleton("system/config")->loadConfigFile();
		$baseurl = $sysConfig->system->url;
		return $baseurl . $dir->skin . BS . $dir->base . BS . $varImage[0] . BS . $dir->images . BS . $varImage[1];
	}

	/**
	 *	Set Blocks
	 */
	public function setBlock($varBlock) {
		$varBlock = explode(BS, $varBlock);
		$dir = Core::getSingleton("system/config")->loadConfigFile()->frontend->directory;
		$this->blocks[] = BP . DS . $dir->app . DS . $dir->code . DS . $dir->client . DS . $varBlock[0] . DS . $dir->view . DS . $varBlock[1] . ".phtml";
	}

	/**
	 *	Create Url Links
	 */
	public function genLink($varUrl) {
		$baseurl = Core::getSingleton("system/config")->loadConfigFile()->system->url;
		return $baseurl . $varUrl;
	}

	public function render() {
		return include dirname(dirname(__FILE__)) . DS . "view" . DS . "main.phtml";
	}

	/**
	 *	Clear the blocks
	 */
	public function clear() {
		$this->css = null;
		$this->js = null;
		$this->blocks = null;
		return $this;
	}

	public function __call($method, $params = null) {

		$type = substr($method, 0, 3);
		$property = lcfirst(substr($method, 3));

		
		try {
			
			if($type == "set") {
				$this->$property = $params[0];
				return $this;
			}elseif($type == "get") {
				return $this->$property;
			}else{
				throw new Exception("Error Processing Request", 1);
			}
		} catch (Exception $e) {
			Core::log($e);
		}
	}
}