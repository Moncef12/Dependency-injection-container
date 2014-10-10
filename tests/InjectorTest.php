<?php 
/**
 * @author Moncef HASSEIN-BEY.
 */

namespace DI\Test;

use DI\Injector;
use DI\Test\Exemples\ConstructorInject\Person;
use DI\Test\Exemples\ConstructorInject\CellPhone;
use DI\Test\Exemples\ConstructorInject\Signal;

class InjectorTest extends \PHPUnit_Framework_TestCase
{
	public function testThatInjectorIsCreatedWhenUsingTheConstructor()
	{
		$this->assertInstanceOf('\DI\Injector', new Injector);
	}

	public function testInjectionOfCellPhoneInPerson()
	{
		$injector = new Injector;
		$person = $injector->getInstanceOf('\DI\Test\Exemples\ConstructorInject\Person');
		$this->assertObjectHasAttribute('cellphone', $person);
		$this->assertInstanceOf(
			'\DI\Test\Exemples\ConstructorInject\CellPhone', 
			$person->cellphone
		);
	}
	
	public function testThatSecondLevelDependencySignalIsInjectedToo()
	{
		$injector = new Injector;
		$person = $injector->getInstanceOf('\DI\Test\Exemples\ConstructorInject\Person');
		$this->assertObjectHasAttribute('signal', 
			$person->cellphone
		);
		$this->assertInstanceOf('\DI\Test\Exemples\ConstructorInject\Signal', 
			$person->cellphone->signal
		);
	}

	public function testThatLookForObjectToInject()
	{
		$lookForObject = self::getNonPublicMethod('_lookForObjectToInject');
		$objs_to_inject = $lookForObject->invokeArgs(new Injector, array(
			'\DI\Test\Exemples\ConstructorInject\Person'
		));
		$this->assertEquals(array(
			'DI\Test\Exemples\ConstructorInject\CellPhone'), 
			$objs_to_inject
		);
	}

	protected static function getNonPublicMethod($name) 
	{
  		$class = new \ReflectionClass('\DI\Injector');
  		$method = $class->getMethod($name);
  		$method->setAccessible(true);
  		return $method;
	}	
}