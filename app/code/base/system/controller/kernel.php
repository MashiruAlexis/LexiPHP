<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class System_Controller_Kernel {

	/**
	 *	Current Running App
	 */
	private $app = "dashboard";

	/**
	 *	Current Running Controller
	 */
	private $controller = "index";

	/**
	 *	Current Running Method
	 */
	private $method = "indexAction";

	/**
	 *	Config Directory Name
	 */
	const CONFIG_DIR_NAME = "config";

	/**
	 *	Config Default Path
	 */
	protected $configDefaultPath;

	/**
	 *	Kernel on boot
	 */
	public function __construct() {
		$config = $this->getConfig("system");
		$session = Core::getSingleton("system/session");
		if( isset($config["app"]) ) {
			$this->setApp( $config["app"] );
		}

		$debug = isset($config["debug"]) ? $config["debug"] : false;

		// start session
		$session->start();
	}

	/**
	 *	Autoloader
	 */
	public function autoload() {
		$paths = $this->getConfig("autoload");
		foreach( $paths as $mod => $path ) {
			if( file_exists($path) ) {
				include $path;
			}
		}
		return;
	}

	/**
	 *	Get Config
	 *	@return array $config
	 */
	public function getConfig( $config ) {
		$configFilePath = BP . DS . "app" . DS . "config" . DS . $config . ".php";
		if( file_exists($configFilePath) ) {
			return include($configFilePath);
		}
		return false;
	}

	/**
	 *	Set App
	 *	@var string $app
	 *	@return
	 */
	public function setApp( $app ) {
		$this->app = $app;
		return;
	}

	/**
	 *	Get App
	 *	@return string $app
	 */
	public function getApp() {
		return $this->app;
	}

	/**
	 *	Set Controller
	 *	@var string $controller
	 *	@return
	 */
	public function setController( $controller ) {
		$this->controller = $controller;
		return;
	}

	/**
	 *	Get Controller
	 *	@return string $controller
	 */
	public function getController() {
		return $this->controller;
	}

	/**
	 *	Set Method
	 *	@var string $method
	 *	@return
	 */
	public function setMethod( $method ) {
		$this->method = $method;
		return;
	}

	/**
	 *	Get Method
	 *	@return string $method
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 *	detect current os
	 */
	public function getUserOs() {
		if ( isset( $_SERVER ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
		}
		else {
			global $HTTP_SERVER_VARS;
			if ( isset( $HTTP_SERVER_VARS ) ) {
				$agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
			}
			else {
				global $HTTP_USER_AGENT;
				$agent = $HTTP_USER_AGENT;
			}
		}
		$ros[] = array('Windows XP', 'Windows XP');
		$ros[] = array('Windows NT 5.1|Windows NT5.1)', 'Windows XP');
		$ros[] = array('Windows 2000', 'Windows 2000');
		$ros[] = array('Windows NT 5.0', 'Windows 2000');
		$ros[] = array('Windows NT 4.0|WinNT4.0', 'Windows NT');
		$ros[] = array('Windows NT 5.2', 'Windows Server 2003');
		$ros[] = array('Windows NT 6.0', 'Windows Vista');
		$ros[] = array('Windows NT 7.0', 'Windows 7');
		$ros[] = array('Windows CE', 'Windows CE');
		$ros[] = array('(media center pc).([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center');
		$ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows');
		$ros[] = array('(win)([0-9]{2})', 'Windows');
		$ros[] = array('(windows)([0-9x]{2})', 'Windows');
		// Doesn't seem like these are necessary...not totally sure though..
		//$ros[] = array('(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'Windows NT');
		//$ros[] = array('(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})', 'Windows NT'); // fix by bg
		$ros[] = array('Windows ME', 'Windows ME');
		$ros[] = array('Win 9x 4.90', 'Windows ME');
		$ros[] = array('Windows 98|Win98', 'Windows 98');
		$ros[] = array('Windows 95', 'Windows 95');
		$ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows');
		$ros[] = array('win32', 'Windows');
		$ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
		$ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
		$ros[] = array('dos x86', 'DOS');
		$ros[] = array('unix', 'Unix');
		$ros[] = array('Mac OS X', 'Mac OS X');
		$ros[] = array('Mac_PowerPC', 'Macintosh PowerPC');
		$ros[] = array('(mac|Macintosh)', 'Mac OS');
		$ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
		$ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
		$ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
		$ros[] = array('os/2', 'OS/2');
		$ros[] = array('freebsd', 'FreeBSD');
		$ros[] = array('openbsd', 'OpenBSD');
		$ros[] = array('netbsd', 'NetBSD');
		$ros[] = array('irix', 'IRIX');
		$ros[] = array('plan9', 'Plan9');
		$ros[] = array('osf', 'OSF');
		$ros[] = array('aix', 'AIX');
		$ros[] = array('GNU Hurd', 'GNU Hurd');
		$ros[] = array('(fedora)', 'Linux - Fedora');
		$ros[] = array('(kubuntu)', 'Linux - Kubuntu');
		$ros[] = array('(ubuntu)', 'Linux - Ubuntu');
		$ros[] = array('(debian)', 'Linux - Debian');
		$ros[] = array('(CentOS)', 'Linux - CentOS');
		$ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva');
		$ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE');
		$ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)');
		$ros[] = array('(ASPLinux)', 'Linux - ASPLinux');
		$ros[] = array('(Red Hat)', 'Linux - Red Hat');
		// Loads of Linux machines will be detected as unix.
		// Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
		//$ros[] = array('X11', 'Unix');
		$ros[] = array('(linux)', 'Linux');
		$ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
		$ros[] = array('amiga-aweb', 'AmigaOS');
		$ros[] = array('amiga', 'Amiga');
		$ros[] = array('AvantGo', 'PalmOS');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}', 'Linux');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}', 'Linux');
		//$ros[] = array('(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})', 'Linux');
		$ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})', 'Linux');
		$ros[] = array('(webtv)/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
		$ros[] = array('Dreamcast', 'Dreamcast OS');
		$ros[] = array('GetRight', 'Windows');
		$ros[] = array('go!zilla', 'Windows');
		$ros[] = array('gozilla', 'Windows');
		$ros[] = array('gulliver', 'Windows');
		$ros[] = array('ia archiver', 'Windows');
		$ros[] = array('NetPositive', 'Windows');
		$ros[] = array('mass downloader', 'Windows');
		$ros[] = array('microsoft', 'Windows');
		$ros[] = array('offline explorer', 'Windows');
		$ros[] = array('teleport', 'Windows');
		$ros[] = array('web downloader', 'Windows');
		$ros[] = array('webcapture', 'Windows');
		$ros[] = array('webcollage', 'Windows');
		$ros[] = array('webcopier', 'Windows');
		$ros[] = array('webstripper', 'Windows');
		$ros[] = array('webzip', 'Windows');
		$ros[] = array('wget', 'Windows');
		$ros[] = array('Java', 'Unknown');
		$ros[] = array('flashget', 'Windows');
		// delete next line if the script show not the right OS
		//$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
		$ros[] = array('MS FrontPage', 'Windows');
		$ros[] = array('(msproxy)/([0-9]{1,2}.[0-9]{1,2})', 'Windows');
		$ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows');
		$ros[] = array('libwww-perl', 'Unix');
		$ros[] = array('UP.Browser', 'Windows CE');
		$ros[] = array('NetAnts', 'Windows');
		$file = count ( $ros );
		$os = '';
		for ( $n=0 ; $n<$file ; $n++ ){
			if ( preg_match('/'.$ros[$n][0].'/i' , $agent, $name)){
				$os = @$ros[$n][1].' '.@$name[2];
				break;
			}
		}
		return trim ( $os );
	}
}