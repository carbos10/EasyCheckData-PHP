<?php 
/*
 * (c) Luigi Carbos
 * 
 * License Free
 *
 */

/**
 * Class for EasyCheckData
 * @author Luigi Carbos
 * @version 1.5
 */

class EasyCheckData 
{

	/**
	 * @var string[] Errors in Italian
	 */
	private $errorsIt = array(
		"isDef" => "Il campo %NAME% è vuoto", // Se è vuota
		"minLen" => "Il campo %NAME% deve essere minimo di %LEN% caratteri", 
		"maxLen" => "Il campo %NAME% deve essere massimo di %LEN% caratteri",
		"isEmail" => "Il campo %NAME% non è un email corretta",
		"isEqual1" => "Il campo %NAME% non è uguale al campo %NAME2%",
		"isEqual2" => "Il campo %NAME% non è uguale all'altro campo",
		"isChecked" => "Il campo %NAME% non è stato selezionato",
		"isNumber" => "Il campo %NAME% deve essere un numero"
	);


	/**
	 * @var string 		The language to use
	 */
	private static $lang ;

	/**
	 * @var string[] Errors
	 */
	private $errors;
	
	/**
	 * @var int Position of the select variable
	 */
	private $pos; 

	/**
	 * @var mixed[] All variables to check
	 */
	private $vars = array();

	/**
	 * @var string[] 	Errors of vars
	 */
	private $error = array();

	/**
	 * @param mixed 	$var 			Reference to variable
	 * @param string 	$nameField 		Name to use in the Error strings
	 */
	public function __construct($var = NULL, $nameField = NULL)
	{
		if(isset($var) && isset($nameField)){
			$this->setVar($var, $nameField);
		}		
		$this->chooseErrorsLan();
	}

	/**
	 * @param mixed 	$var 			Reference to variable
	 * @param string 	$nameField 		Name to use in the Error strings
	 * @return $this
	 */
	public function setVar($var, $nameField)
	{
		$this->vars[] = array("name" => $nameField, "value" => $var);
		$this->pos = count($this->vars)-1;
		return $this;
	}

	public static function setLanguage($lang)
	{
		self::$lang = $lang;
	}

	private function chooseErrorsLan()
	{
		switch(self::$lang){
			case "it":
				$this->errors = $this->errorsIt;
				break;

			default:
				$this->errors = $this->errorsIt;
				break;
		}
	}

	/**
	 * Change Text of Errors
	 *
	 * @param string $nameFunction 	Name function to change text
	 * @param string $text 			Text to replace 
	 *
	 * @return null
	 */
	public function changeTextError($nameError, $text)
	{
		$this->errors[$nameError] = $text;
	}

	/**
	 * Get you the first element of errors array
	 *
	 * @param string $fieldName 	Name of field
	 *
	 * @return string 	The first error
	 */
	public function getFirstError($fieldName = null)
	{
		return isset($fieldName) ? $this->error[$fieldName][0] : $this->error[$this->vars[$this->pos]['name']][0];
	}

	/**
	 * Get you the Array of errors
	 *
	 * @param string $fieldName 	Name of field
	 *
	 * @return string 	The first error
	 */
	public function getErrors($fieldName = null)
	{
		return isset($fieldName) ? $this->error[$fieldName] : $this->error[$this->vars[$this->pos]['name']];
	}

	/**
	 * Get you the all Array Errors
	 *
	 * @return string[]	Array with all Errors
	 */
	public function getAllError()
	{
		return $this->error;
	}

	/**
	 * Merge all errors of selected This-Class
	 *
	 * @param multi EasyCheckData 	All EasyCheckData that you use
	 *
	 * @return string[]		Merging errors' array of each EasyCheckData 
	 */
	public static function mixAllErrors()
	{
		$error = array();
		$args = func_get_args();
		for($i = 0; $i < func_num_args(); $i++){
			$errors = $args[$i]->getAllError();
			foreach($errors as $val){
				$error[] = $val;
			}		
		}

		return $error;
	}

	/**
	 * Control if has error
	 *
	 * @return boolean 
	 */
	public function hasError()
	{
		return isset($this->error[0]);
	}

	/**
	 * Control if is Set 
	 *
	 * @return reference to object
	 */
	public function isDef()
	{
		if(empty($this->vars[$this->pos]['value'])){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isDef"]);
		}

		return $this;
	}

	/**
	 * Control the minimum length of var
	 *
	 * @param int $len		Min length
	 *
	 * @return reference to object
	 */
	public function minLen($len)
	{
		if(strlen($this->vars[$this->pos]['value']) < $len){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%", "%LEN%"), array($this->vars[$this->pos]['name'], $len), $this->errors["minLen"]);
		}

		return $this;
	}

	/**
	 * Control the maximum length of var
	 *
	 * @param int $len		Max length
	 *
	 * @return reference to object
	 */
	public function maxLen($len)
	{
		if(strlen($this->vars[$this->pos]['value']) > $len){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%", "%LEN%"), array($this->vars[$this->pos]['name'], $len), $this->errors["maxLen"]);
		}

		return $this;
	}

	/**
	 * Check if is email
	 *
	 * @return reference to object
 	 */
	public function isEmail()
	{
		if(!filter_var($this->vars[$this->pos]['value'], FILTER_VALIDATE_EMAIL)){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isEmail"]);
		}

		return $this;
	}

	/**
	 * Check if is equal to another string
	 *
	 * @param string $string 	String to compare
	 * @param string $name 		Name of second field to compare
	 *
	 * @return reference to object
	 */
	public function isEqual($string, $name = "")
	{
		if($this->vars[$this->pos]['value'] !== $pass){
			if($name !== ""){
				$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%", "%NAME2%"), array($this->vars[$this->pos]['name'], $name), $this->errors["isEqual1"]);
			} else {
				$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isEqual2"]);
			}
		}

		return $this;
	}

	/**
	 * Check if the var is true
	 *
	 * @return reference to object
	 */
	public function isChecked()
	{
		if($this->vars[$this->pos]['value'] !== true){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isChecked"]);
		}

		return $this;
	}

	public function isNumber()
	{
		if(!is_numeric($this->vars[$this->pos]['value'])){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isNumber"]);
		}

		return $this;
	}
}
