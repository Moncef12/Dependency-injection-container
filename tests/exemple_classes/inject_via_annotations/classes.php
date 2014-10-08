<?php 

namespace DI\Tests\Exemples\AnnocationsInject;;

class Person
{
	protected $_mobile;

	/**
	 * @inject
	 */
	public function __construct(CellPhone $cellphone)
	{
		$this->_mobile = $cellphone;	
	}	
}

class CellPhone
{
	protected $_signal;

	/**
	 * @inject
	 */
	public function __construct(Signal $signal) {
		$this->_signal = $foo;
	}
}

class Signal 	
{

}