<?php
/**
 * Copyright © Ramon Alexis Celis All rights reserved.
 * See license file for more info.
 */
Class Syntax_Controller_Highlight extends Frontend_Controller_Action {

	public function index() {
		// $this->setJs("syntax/highlight");
		// $this->setCss("syntax/sublime");
		$this->assets();
		$this->setPageTitle("Syntax");
		$this->setBlock("syntax/main");
		$this->render();
	}

	public function assets() {
		echo "HALLO";
		$this->linkCss("//tutsplus.github.io/syntax-highlighter-demos/highlighters/highlightjs/styles/monokai_sublime.css");
		$this->linkJs("//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js");
	}
}