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
	public function getInstanceOf($className, $args=array())
	{
		// Classe names of the objects to inject ...
		$clsNames_objs_to_inject = $this->_lookForObjectToInject($className);
		// Get Instance of the objects to inject.
		$objs_to_inject = array();
		foreach ($clsNames_objs_to_inject as $clsName_obj) {
			$objs_to_inject[$clsName_obj] = $this->getInstanceOf($clsName_obj);
		}
		// Finally, Create instance of the object...
		$obj = $this->_createInstance($className, $objs_to_inject);
		return $obj;
	}

	/**
	 * @param  String classe name of the object to instantiate. 
	 * @param  Array  Collection of objects to inject.
	 * @return Object. 
	 */
	protected function _createInstance($className, $objs_to_inject)
	{
		$r  = new \ReflectionClass($className);
		return $r->newInstanceArgs($objs_to_inject);
	}	

	/**
	 * Will look in the constructor's block comment
	 * for @inject annotations, and then find what to inject and
	 * return them.
	 * @param  String  Optional name of the class to look into it.
	 * @return array|false.
	 */
	protected function _lookForObjectToInject($className)
	{
		if($className)
			$r = new \ReflectionClass($className);
		else
			throw new \Exception("No object provided to look into it");
		$constructor = $r->getMethod('__construct');
		$constructor_params = $constructor->getParameters();
		$objecs_names_to_inject=array();
		foreach ($constructor_params as $c_param){
			$class_name_param = $c_param->getClass();
			$objecs_names_to_inject[] = $class_name_param->name;
		}

		return $objecs_names_to_inject;
	}
}