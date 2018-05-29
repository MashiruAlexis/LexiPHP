<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
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
	 *	Child Block Directory
	 */
	public $childBlockDir = 'blocks';

	/**
	 *	Page Title
	 */
	public $pageTitle = "LexiPHP Framework";

	/**
	 *	Load defaults [Deprecated]
	 */
	public function setDefault() {
		$this->linkCss("http://fonts.googleapis.com/icon?family=Material+Icons");
		$this->setCss("default/materialize");
		$this->setCss("default/style");
		$this->setJs("default/jquery-2.1.1.min");
		$this->setJs("default/materialize");
		$this->setJs("default/init");
	}

	/**
	 *	Get Child Block
	 *	@var string $child
	 *	@param int|string|array $data
	 *	@return $blocks
	 */
	public function getChildBlock( $child, $data = false ) {
		$config = Core::getSingleton("system/kernel")->getConfig("system");
		$key = explode("/", $child);
		foreach( Core::$paths as $path ) {
			$path = $path . $key[0] . DS . "view" . DS . $this->childBlockDir . DS . $key[1] . ".phtml";
			if( file_exists($path) ) {
				// check if child block hint is enabled
				if( $config["childBlockHints"] ) {
					echo "<div class='container childblockhints'>";
					echo "<span class='childBlockTextPath'>". $path ."</span>";
					include $path;
					echo "</div>";
					return;
				}
				return include $path;			
			}
		}
		return false;
	}

	/**
	 *	Get Images
	 *	@var string $image
	 *	@return string $image
	 */
	public function getImage( $image ) {
		$image = str_replace("/", DS, $image);
		foreach( Core::$skinPath as $path ) {
			if( file_exists($path . $image) ) {
				return str_replace("\\", "/", str_replace(BP . DS, Core::getBaseUrl(), $path.$image));;
			}
		}
		return 'Image does not exist.';
	}

	/**
	 *	Get Font
	 *	@param string $font
	 *	@return string $font url
	 */
	public function getFont( $font ) {
		$font = explode("/", $font);
		foreach( Core::$skinPath as $path ) {
			$fontPath = $path . $font[0] . DS . "font" . DS . $font[1];
			if( file_exists($fontPath) ) {
				return str_replace("\\", "/", str_replace(BP . DS, Core::getBaseUrl(), $fontPath));
			}
		}
	}

	/**
	 *	load the resources from theme
	 */
	public function loadThemeResource() {
		$theme = Core::getSingleton("system/kernel")->getConfig("theme");
		if( isset($theme["css"]) ) {
			foreach( $theme["css"] as $css ) {
				$this->setCss( $css );
			}
		}

		if( isset($theme["js"]) ) {
			foreach( $theme["js"] as $js ) {
				$this->setJs( $js );
			}
		}
		return;
	}

	/**
	 *	Set CSS [new Update]
	 */
	public function setCss($varCss) {
		$varCss = explode(BS, $varCss);
		$config = Core::getSingleton("system/config");
		$paths = $config->getSkinPath();
		$baseurl = $config->getBaseUrl();
		foreach($paths as $cssPath) {
			$fileLoc = BP . DS . "skin" . DS . $cssPath . DS . $varCss[0] . DS . "css" . DS . $varCss[1] . ".css";
			if(file_exists($fileLoc)) {
				$this->css[] = "<link rel='stylesheet' href='" . $baseurl . "skin" . BS . $cssPath . BS . $varCss[0] . BS . "css" . BS . $varCss[1] . ".css'>";			
			}
		}
	}

	/**
	 *	Set JS [New Update]
	 */
	public function setJs($varJs) {
		$varJs = explode(BS, $varJs);
		$config = Core::getSingleton("system/config");
		$paths = $config->getSkinPath();
		$baseurl = $config->getBaseUrl();
		foreach($paths as $jsPaths) {
			$fileLoc = BP . DS . "skin" . DS . $jsPaths . DS . $varJs[0] . DS . "js" . DS . $varJs[1] . ".js";
			// if( strpos( $fileLoc, US ) !== false ) {
			// 	$fileLoc = str_replace(US, DS, $fileLoc);
			// 	$varJs[1] = str_replace(US, DS, $varJs[1]);
			// }
			if(file_exists($fileLoc)) {
				$this->js[] = "<script src='" . $baseurl . "skin" . BS . $jsPaths . BS . $varJs[0] . BS . "js" . BS . $varJs[1] . ".js'></script>";
			}
		}
	}

	/**
	 *	Link external css file
	 */
	public function linkCss($varLinkCss) {
		$this->css[] = '<link href="'.$varLinkCss.'" rel="stylesheet">';
	}

	/**
	 *	Link External JS
	 */
	public function linkJs($varJs) {
		$this->js[] = '<script src="' . $varJs . '"></script>';
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
	public function setBlock( $block, $data = false ) {
		$block = explode(BS, $block);
		foreach( Core::$paths as $path ) {
			$path = $path . $block[0] . DS . "view" . DS . $block[1] . ".phtml";
			if( file_exists($path) ) {
				$this->blocks[] = $path;
				return true;
			}
		}
		return false;
	}

	/**
	 *	Create Url Links
	 */
	public function genLink($varUrl) {
		$baseurl = Core::getSingleton("system/config")->loadConfigFile()->system->url;
		return $baseurl . $varUrl;
	}

	/**
	 *	Get the block and insert
	 */
	public function getBlock( $block = false ) {
		if(! strpos($block, '/') ) {
			return false;
		}
		$blocks = explode("/", $block);
		foreach( Core::$paths as $path ) {
			$template = $path . $blocks[0] . DS . 'view' . DS . $blocks[1] . '.phtml';
			if( file_exists($template) ) {
				return include $template;
			}
		}
		return false;
	}

	/**
	 *	Redirect
	 */
	public function _redirect( $urlKey ) {
		header("location: " . $urlKey);
		exit();
	}

	/**
	 *	Render all the blocks
	 */
	public function render() {
		return include dirname(dirname(__FILE__)) . DS . "view" . DS . "main.phtml";
	}

	/**
	 *	Clear the blocks [pending removal]
	 */
	public function clear() {
		$this->css = null;
		$this->js = null;
		$this->blocks = null;
		return $this;
	}

	/**
	 *	set Page title
	 *	@var string $title
	 *	@return null
	 */
	public function setPageTitle( $title ) {
		$this->pageTitle = $title;
		return;
	}

	/**
	 *	Get Page Title
	 *	@return string $pageTitle
	 */
	public function getPageTitle() {
		return $this->pageTitle;
	}

	/**
	 *	Get Css
	 *	@return array $this->css
	 */
	public function getCss() {
		return $this->css;
	}

	/**
	 *	Get Js
	 *	@return array $this->js
	 */
	public function getJs() {
		return $this->js;
	}

	/**
	 *	Get blocks
	 *	@return array $this->blocks
	 */
	public function getBlocks() {
		return $this->blocks;
	}

	/**
	 *	Middleware
	 *	@param string $name
	 *	@return
	 */
	public function middleware( $name ) {
		return $middleware = new $name;
	}
}