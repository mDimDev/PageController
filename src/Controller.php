<?php 

namespace mDimDev\PageController;

/*!
* @class
* @desc 	- abstract parent setting the 'interface' for all PageController! children
			- holds a request, runs processing, and forwards on
* @category	- Request
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @see  	- DimController!, DimCommandResolver!, DimRegistry!, DimCommand!
* @version 	- v1.0
* @license 	- http://www.php.net/license/3_01.txt
*
!*/
abstract class Controller{
	private $request;

	function __construct(){
		$this->request = new DimRequest();
	}//!()

	abstract function process();

	function forward( $resource ){
		include( $resource );
		exit(0);
	}//!()

	function getRequest(){
		return $this->request;
	}//!()

}//!


?>