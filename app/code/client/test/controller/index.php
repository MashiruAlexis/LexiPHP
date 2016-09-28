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

Class Test_Controller_Index extends Frontend_Controller_Action {

	public function index() {
		$this->setPageTitle("Javascript");
		$this->linkCss("//tutsplus.github.io/syntax-highlighter-demos/highlighters/highlightjs/styles/monokai_sublime.css");
		$this->linkJs("//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.4.0/highlight.min.js");
		// Core::getSingleton("syntax/highlight")->assets();
		$this->setBlock("test/index");
		$this->setBlock("syntax/main");
		$this->render();
	}

	public function formula() {
		$varAmount = 800;
		$baseAmount = 500;

		$result = (($varAmount / $baseAmount) * 100);
		echo $result . "%";
	}

	public function ipLookUp() {
		$this->setPageTitle("IP Look UP");
		// $_SERVER['REMOTE_ADDR']
		$ip = Core::getSingleton("url/request")->getRequest("ip");
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		Core::log($details); // -> "Mountain View"

		$this->render();
	}

	public function sidebar() {
		$this->setPageTitle("Side Nav Bar");
		$this->setBlock("test/sidebar");
		$this->render();
	}

	public function rdTags($string, $tagname)
{
    $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
    preg_match($pattern, $string, $matches);
    return $matches[1];
}
	public function autoSink() {
		// Core::log(file_get_contents("http://www.megadiscountstore.com.sg/search?q=washing*+machine*&type=product"));
		preg_match_all('/<div class="product-json">(.*?)<div>/', file_get_contents("http://www.megadiscountstore.com.sg/search?q=washing*+machine*&type=product"), $matches);
		// preg_match("'<div class=\"product-json\">(.*?)</div>'si", file_get_contents("http://www.megadiscountstore.com.sg/search?q=washing*+machine*&type=product"), $match);
		Core::log($matches);
	}
}