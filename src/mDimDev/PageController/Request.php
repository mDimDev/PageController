<?php

namespace mDimDev\PageController;

/*!
* @class
* @desc 	- Holds REQUEST METHOD data in an array and allows manipulation of this array and a
* 			feedback array
* @category	- Request
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @see  	- DimController!, DimCommandResolver!, Registry!, DimCommand!
* @version 	- v1.0
* @license 	- http://www.php.net/license/3_01.txt
*
!*/
class Request {

	//! @param - Array (of request data) & @see - getProperty(), setProperty()
	private $properties;

	//! @param - Array (messages needing passing) & @see - addFeedback(),getFeedback(), getFeedbackString()
	private $feedback = array();


	/*! 
	 * @method
	 * @desc 	- delegates to the init method
	 * @access 	- public
	 * @see 	- init()
	!*/
	function __construct() {	
		$this->init();
	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- checks if a request method (get, post, file) is set and initializes the properties array
	 * @access 	- public
	!*/
	function init() {
		if( isset( $_SERVER['REQUEST_METHOD'] ) ) {

			//! set the properties Array to the clean Array of data and application logic
			$this->properties = $_REQUEST;
			
			return;
		} 

	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- checks if a property was set in the url string (ex. '?cmd=home')
	 * @return 	- (the value at desired key)
	 * @access 	- public
	!*/
	function getProperty( $key ) {
		if( isset( $this->properties[$key] ) ) {
			return $this->properties[$key];
		}

	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- checks if a property was set in the url string (ex. '?cmd=home')
	 * @return 	- Array ($properties)
	 * @access 	- public
	!*/
	function getProperties(){
		return $this->properties;
	}
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- Removes application logic query string parameteres from the properties array, leaving
	 *			 only the data sent by a form
	 * @return 	- Array (stripped of application logic)
	 * @access 	- public
	!*/
	function getRawData(){

		$raw = array();

		foreach($this->properties as $key => $val){
			if($key !=='cmd' && $key !=='type' && $key !== 'id'){
				$raw[$key] = $val;
			}
		}

		return $raw;
	}
	//}}}()

	/*! 
	 * @method
	 * @desc 	- set a property in the properties array
	 * @param 	- (the array key)
	 * @param 	- (the value)
	 * @access 	- public
	!*/
	function setProperty( $key, $val ) {
		$this->properties[$key] = $val;

	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- adds a property in the feedback array
	 * @param 	- (the message to add)
	!*/
	function addFeedback( $msg ) {
		array_push( $this->feedback, $msg );

	} 
	//! }}}()


	/*! 
	 * @method
	 * @desc 	- adds a property in the feedback array
	 * @return 	- Array ($feedback)
	!*/
	function getFeedback() {
		return $this->feedback;

	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- converts the feedback array to a string
	 * @return 	- String ($feedback)
	!*/
	function getFeedbackString( $seperator = "\n" ) {
		return implode( $seperator, $this->feedback );

	} 
	//! }}}()

} 
//! }}} Request!

?>