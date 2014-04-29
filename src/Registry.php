<?php 

namespace mDimDev\PageController;

/*!
* @class
* @desc 	- A singleton implementation that allows system wide access to various objects
* @category	- Singleton, Registry
* @author 	- Dimension Development
* @author 	- Matt Shanks
* @see  	- DimController!, DimCommandResolver!, Request!, DimCommand!
* @version 	- v1.0
* @license	- http://www.php.net/license/3_01.txt
*
!*/
class Registry {

	//! @staticParam - Registry & @see - instance()
	private static $instance;

	//! @staticParam - PDO & @static & @see - instance() 
	private static $pdo;

	//! @staticParam - Request & @see - setRequest(), getRequest()
	private $request;

	/*! 
	 * @method
	 * @desc 	- only way to instantiate this type is to call instance()
	 * @access 	- private
	!*/
	private function __construct(){ } 
	// }}}()

	/*! 
	 * @staticMethod
	 * @static
	 * @desc 	- checks if it exsists, creates itself or returns itself
	 * @access 	- public
	 * @return 	- Registry!
	!*/
	static function instance(){
		if(! isset(self::$instance)) { 
			self::$instance = new self(); 
		}

		return self::$instance;

	} 
	//! }}}()

	/*! 
	 * @staticMethod
	 * @desc 	- sets the PDO param
	 * @access 	- public
	!*/
	static function setPDO(){
		if(! isset(self::$pdo)) { 
			$host = "localhost";
			$name = "dimension";
			$user = "root";
			$pass = "";

			self::$pdo = new PDO("mysql:host=$host;dbname=$name", $user, $pass); 
			self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		
	}
	//! }}}()

	/*! 
	 * @staticMethod
	 * @desc 	- Does the dirty work for building a SELECT WHERE statement and fetching data
	 * @param 	- IdentityObj - MUST BE POPULATED WITH AT LEAST ONE FIELD
	 * @param 	- SelectionFactory
	 * @return 	- Array (of data)
	 * @access  - public
	!*/
	static function spawnData(IdentityObj $idObj, SelectionFactory $sf){
		//! @param - Array(query, values)
		$qa = $sf->buildQuery($idObj);
		//! @param - Array
		$fetch = array();

		//! execute query with values
		$result = Registry::instance()->forgeQuery($qa[0], $qa[1]);

		//! get next row in db while theres a march and add to $ftrFetch
		while($row = $result['handle']->fetch(PDO::FETCH_ASSOC)){

			array_push($fetch, $row);
		}	

		return $fetch;	
	}
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- Handles obtaining a PDO, preparing a statement, and executing that statement
	 * @param 	- String (query)
	 * @param 	- Array (values to add to query) 
	 * @access 	- public
	!*/
	function forgeQuery($query, Array $values){
		self::setPDO(); //! call static method to set the PDO

		$handle = self::$pdo->prepare($query); //! prepare the query
		$handle->closeCursor(); //! free up db connection, but leave statement in a state it can run again
		$result = $handle->execute($values); //! execute the query
		$lastId = self::$pdo->lastInsertid(); //! get inserted id

		return Array('result'=>$result, 'handle'=>$handle, 'lastId'=>$lastId);

	}
	//! }}}()



	/*! 
	 * @method
	 * @desc 	- Sets the request property to the provided Request object
	 * @param 	- Request
	 * @access 	- public
	!*/
	function setRequest(Request $request){
		$this->request = $request;

	} 
	//! }}}()

	/*! 
	 * @method
	 * @desc 	- Returns the contained Request object
	 * @return 	- Request
	 * @access 	- public
	!*/
	function getRequest(){
		return $this->request;
		
	} 
	//! }}}()

} 
//! Registry!

?>