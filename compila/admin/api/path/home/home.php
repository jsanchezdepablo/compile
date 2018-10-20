<?php
	class RestHome{
		static public function initHome(){
			header('Content-Type: text/html; charset=utf-8');
			readfile("path/home/home.html");
		}
	}
?>