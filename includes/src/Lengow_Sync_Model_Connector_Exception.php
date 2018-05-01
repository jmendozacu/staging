<?php
/**
 * Thrown when an API call returns an exception.
 *
 * @author Ludovic Drin <ludovic@lengow.com>
 */
class Lengow_Sync_Model_Connector_Exception extends Exception {

	/**
	 * The result from the API server that represents the exception information.
	 */
	protected $result;

	/**
	 * Make a new API Exception with the given result.
	 *
	 * @param array $result The error result
	 */
	public function __construct($result, $noerror) {
		$this->result = $result;
		if(is_array($result))
			$msg = $result['message'];
		else
			$msg = $result;
		parent::__construct($msg, $noerror);
	}

	/**
	 * Return the associated result object returned by the API server.
	 *
	 * @return array The result from the API server
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * Returns the associated type for the error. 
	 *
	 * @return string
	 */
	public function getType() {
		if(isset($this->result['type']))
			return $this->result['type'];
		return 'Lengow_Sync_Model_Connector_Exception';
	}

	/**
	 * To make debugging easier.
	 *
	 * @return string The string representation of the error
	 */
	public function __toString() {
		if(isset($this->result['message']))
			return $this->result['message'];
		return $this->message;
	}
}	