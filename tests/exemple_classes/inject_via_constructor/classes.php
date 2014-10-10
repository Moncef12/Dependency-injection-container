<?php 

namespace DI\Test\Exemples\ConstructorInject;

class Person
{
	public $cellphone;

	/**
	 * @inject
	 */
	public function __construct(CellPhone $cellphone)
	{
		$this->cellphone = $cellphone;	
	}	
}

class CellPhone
{
	public $signal;

	/**
	 * @inject
	 */
	public function __construct(Signal $signal) {
		$this->signal = $signal;
	}
}

class Signal 	
{
	public function __construct()
	{
	}
}