<?php
namespace Microcli;

class Microcli{
	/**
	* @var MicrocliWriter
	*/
	protected $writer;

	/**
	* @var int
	*/
	protected $timer = 0;

	/**
	* @var string
	*/
	protected $timer_text = '<s>';
	
	/**
	* @var string
	*/
	protected $timer_color = 'default';

	/**
	* @var MicrocliCommand
	*/
	protected $command;

	/**
	* @var array
	*/
	protected $argv = [];

	/**
	* Microcli constructor
	* -
	* @param array $config
	*/
	public function __construct(
		$config = ['color_base' => 'default', 'prefix' => '']
	){
		$this->writer = new MicrocliWriter;
		$this->command = new MicrocliCommand;

		$this->colorBase($config['color_base']);
		$this->prefix($config['prefix']);
	}

	/**
	* @param array $argv
	*/
	public function run($argv){
		$command_name = 'help';

		if(isset($argv[1])){
			$command_name = $argv[1];
		}


		if($this->command->exist($command_name)){
			return $this->command->run($command_name, $argv);
		}
		else{
			$this->color('danger')->line();
			$this->color('danger')->write('Command not found: "'.$command_name.'"');
			$this->color('danger')->line();
		}
	}

	/**
	* @param string $name
	* @param callable $callable
	*/
	public function addCommand($name, $callable){
		$this->command->add($name, $callable);
	}

	/**
	* @param string $text
	*/
	public function write($text){
		if($this->timer > 0){
			$this->timer_text = $text;
			
			if(strpos($this->timer_text, '<s>') !== false){
				$replace_text = str_replace('<s>', $this->timer, $this->timer_text);
			}

			$this->replace($replace_text);

			sleep(1);

			$this->timer = $this->timer - 1;
			
			if($this->timer > 0){
				$this->color($this->timer_color)->write($this->timer_text);
			}
		}
		else{
			$this->writer->run($text);
		}
		return $this;
	}
	
	public function exit(){
		exit();
	}

	/**
	* @param string $character
	* @param int $length
	*/
	public function line($character = '-', $length = 40){
		$this->writer->line($character, $length);
		return $this;
	}

	public function break(){
		$this->writer->run('');
	}

	/**
	* @param string
	*/
	public function replace($text){
		$this->writer->run($text, true);
	}

	/**
	* @param int $n
	*/
	public function timer($n = 1){
		$this->timer = $n;
		return $this;
	}

	/**
	* @param string $name
	*/
	public function color($name = 'default'){
		$this->writer->setColor($name);
		$this->timer_color = ($this->timer > 0)? $name : 'default';
		return $this;
	}

	/**
	* @param string $name
	*/
	public function colorBase($name = 'default'){
		$this->writer->setColorBase($name);
	}

	/**
	* @param string $name
	* @param int $code
	*/
	public function addColor($name = 'default', $code = 39){
		$this->writer->addColor($name, $code);
	}

	/**
	* @return array
	*/
	public function getColors(){
		return $this->writer->getColors();
	}

	/**
	* @param string $character
	*/
	public function prefix($character = ''){
		$this->writer->setPrefix($character);
	}

	/**
	* @param string $str
	*/
	public function header($str = ''){
		if(!empty($str)){
			$prefix = $this->writer->getPrefix();
			$this->prefix('');
			$this->writer->run($str);
			$this->prefix($prefix);
		}
	}
}