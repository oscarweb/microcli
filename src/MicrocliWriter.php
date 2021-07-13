<?php
namespace Microcli;

class MicrocliWriter{
	/**
	* @var string
	*/
	protected $prefix = '';
	
	/**
	* @var array
	*/
	protected $colors = [
		'default' => 39,
		'success' => 32,
		'alert'   => 33,
		'error'   => 91,
		'danger'  => 91,
		'info'    => 94,
		'magenta' => 35,
		'success_alt'=> 42,
		'alert_alt'  => 43,
		'error_alt'  => 41,
		'danger_alt' => 41,
		'info_alt'   => 44,
		'magenta_alt' => 45,		
	];

	/**
	* @var string
	*/
	protected $color_base = 'default';
	
	/**
	* @var string
	*/
	protected $color = 'default';

	/**
	* @var int
	*/
	protected $buffer_length = 0;

	/**
	* @param string $text
	* @param bool $replace
	*/
	public function run($text = '', $replace = false){
		$text_length = strlen($text)+strlen($this->prefix);

		if($replace && $text_length > $this->buffer_length){
			$this->buffer_length = $text_length;
		}

		if($this->buffer_length > $text_length){
			$text = str_pad($text, $this->buffer_length);
		}		

		$this->out($text, $replace);
		$this->setColor($this->color_base);
	}

	/**
	* @param string $text
	* @param bool $replace
	*/
	public function out($text = '', $replace = false){
		echo "\e[".$this->getColor()."m{$this->prefix}{$text}\e[0m".(($replace)? "\r" : PHP_EOL);
	}

	/**
	* @param string $name
	*/
	public function setColor($name){
		if(isset($this->colors[$name])){
			$this->color = $name;
		}
	}

	/**
	* @param string $name
	*/
	public function setColorBase($name){
		if(isset($this->colors[$name])){
			$this->color_base = $name;
		}
	}

	/**
	* @param string $name
	* @param int $code
	*/
	public function addColor($name, $code){
		$this->colors[$name] = $code;
	}

	/**
	* @return int
	*/
	public function getColor(){
		return $this->colors[$this->color];
	}

	/**
	* @return array
	*/
	public function getColors(){
		return $this->colors;
	}

	/**
	* @param string $character
	* @param int $length
	*/
	public function line($character = '-', $length = 40){
		$buffer_prefix = $this->prefix;
		$this->prefix = '';
		$this->out(str_pad($character, ($length - strlen($character)), $character));
		$this->prefix = $buffer_prefix;
	}

	/**
	* @param stirng $character
	*/
	public function setPrefix($character = ''){
		if(empty($character)){
			$this->prefix = '';
		}
		$this->prefix = (empty($character))? '' : $character.' ';
	}

	/**
	* @return string
	*/
	public function getPrefix(){
		return $this->prefix;
	}
}