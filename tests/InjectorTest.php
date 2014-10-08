<?php 
/**
 * @author Moncef HASSEIN-BEY.
 */

namespace DI\Test;

use DI\Injector;
use DI\Tests\Exemples\ConstructorInject\Person;
use DI\Tests\Exemples\ConstructorInject\CellPhone;
use DI\Tests\Exemples\ConstructorInject\Signal;

class InjectorTest extends \PHPUnit_Framework_TestCase
{
	public function testThatInjectorIsCreatedWhenUsingTheConstructor()
	{
		$this->assertInstanceOf('\DI\Injector', new Injector);
	}

	public function testInjectionOfCellPhoneInPerson()
	{
		$injector = new Injector;
		$person = $injector->getInstanceOf('Person');
		$this->assertObjectHasAttribute('cellphone', $person);
		$this->assertInstanceOf(
			'DI\Tests\Exemples\ConstructorInject\CellPhone', 
			$person->cellphone
		);
	}
	
	public function testThatSecondLevelDependencySignalIsInjectedToo()
	{
		$injector = new Injector;
		$person = $injector->getInstanceOf('Person');
		$this->assertObjectHasAttribute('DI\Tests\Exemples\Signal', $person->cellphone);
		$this->assertInstanceOf('\DI\Tests\Exemples\CellPhone', $person->cellphone->signal);
	}	
}