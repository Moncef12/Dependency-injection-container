<?php 
/**
 * @author Moncef HASSEIN-BEY.
 */

namespace DI;

/**
* Simple Dependency injector.
*/
class Injector
{
	protected $_reflection;

	/**
	 * Create after injection an object from the class given.
	 * @param string The class name of the object. 
	 * @param array  Other arguments needed by the object to be created.
	 * @return object.
	 *
	 * @todo : injection via : 1/ annotations, and 2/ configuration. 
	 */
	public function getInstanceOf($className, $args)
	{
		// Get the class instance.
		$obj = new $className;
		// Create a reflection object.
		$this->_reflection = new ReflectionClass($className);
		// Classe names of the objects to inject ...
		$clsNames_obj_to_inject = $this->_lookForObjectToInject();
		// Get Instance of the objects to inject.
		$objs_to_inject = array();
		foreach ($clsNames_objs_to_inject as $clsName_obj) {
			$objs_to_inject[$clsName_obj] = $this->getInstanceOf($clsName_obj);
		}
		// Finally, Create instance of the object...
		return $obj;
	}


	protected function _createInstance($className, $objs_to_inject)
	{
		$r  = new ReflectionClass($className);
		return $r->newInstanceArgs($objs_to_inject);
	}	

	/**
	 * Will look in the constructor's block comment
	 * for @inject annotations, and then find what to inject and
	 * return them.
	 * @param  String  Optional name of the class to look into it.
	 * @return array|false.
	 */
	protected function _lookForObjectToInject($className=null)
	{
		if($className)
			$r = new ReflectionClass($className);
		else if($this->_reflection instanceof ReflectionClass)
			$r = $this->_reflection;
		else
			throw new Exception("No object provided to look into it");
	}
}