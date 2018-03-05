<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */

 Class Test_Controller_Deans extends Frontend_Controller_Action {

 	/**
 	 *	Default controller action
 	 */
 	public function indexAction() {
 		$evaluationSelfDb = Core::getModel("evaluation/evaluationself");
 		return $evaluationSelfDb->getDeansTeachers(2);
 	}
 }