<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

Class Dashboard_Controller_Cmd extends Frontend_Controller_Action {

	public function __construct() {
		#Core::middleware("auth");
	}

	/**
	 *	Default controller action
	 */
	public function indexAction() {
		$this->setPageTitle("CMD");
		$data = Core::getSingleton("url/request")->getRequest('cmd');
        $cmd = Core::getSingleton("console/core");
        $data = explode(" ", $data);
        $newData[] = 'bot'; 
        if( is_array($data) ) {
            foreach( $data as $dt ) {
                $newData[] = $dt;
            }
        }
        $cmd->setArgs($newData);
        echo "<pre>";
        $cmd->run();
        echo "</pre>";
		echo '
		<div class="col-md-12">
                            <div class="card">
                                <form id="RangeValidation" class="form-horizontal" action="" method="GET" novalidate="novalidate">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title">Terminal</h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Enter command:</label>
                                            <div class="col-sm-7">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input class="form-control valid" type="text" name="cmd" minlength="5">
                                                <span class="material-input"></span></div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-rose btn-fill">Send Command<div class="ripple-container"></div></button>
                                        <a href="'. Core::getBaseUrl() .'" class="btn btn-rose btn-fill">Home</a>
                                    </div>
                                </form>
                            </div>
                        </div>
		';
	}
}
