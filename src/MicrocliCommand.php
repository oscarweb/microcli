<?php
namespace Microcli;

class MicrocliCommand{
	protected $commands = [];

	public function run($name, $argv){
		call_user_func($this->commands[$name], $argv);
	}

	public function add($name, $callable){
		$this->commands[$name] = $callable;
	}

	public function exist($name){
		return (isset($this->commands[$name]))? true : false;
	}
}