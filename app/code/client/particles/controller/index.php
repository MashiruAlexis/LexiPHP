<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
Class Particles_Controller_Index extends Frontend_Controller_Action {

	public function index() {
		$this->setCss("particles/base");
		$this->setCss("particles/main");
		$this->setCss("particles/vendor");
		$this->setJs("particles/jquery-2.1.3.min");
		$this->setJs("particles/modernizr");
		$this->setJs("particles/plugins");
		$this->setJs("particles/main");
		$this->setBlock("particles/main");
		$this->render();
	}
}