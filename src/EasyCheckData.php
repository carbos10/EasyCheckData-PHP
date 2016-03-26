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
 * @version 1.5.1
 */

class EasyCheckData 
{

	/**
	 * @var string[] Errors in Italian
	 */
	private $errorsIt = array(
		"isDef" => "Il campo %NAME% è vuoto", 
		"minLen" => "Il campo %NAME% deve essere minimo di %LEN% caratteri", 
		"maxLen" => "Il campo %NAME% deve essere massimo di %LEN% caratteri",
		"isEmail" => "Il campo %NAME% non è un email corretta",
		"isEqual1" => "Il campo %NAME% non è uguale al campo %NAME2%",
		"isEqual2" => "Il campo %NAME% non è uguale all'altro campo",
		"isChecked" => "Il campo %NAME% non è stato selezionato",
		"isNumber" => "Il campo %NAME% deve essere un numero"
	);

	/**
	 * @var string[] Errors in English
	 */
	private $errorsEn = array(
		"isDef" => "The field %NAME% is empty",
		"minLen" => "The field %NAME% must have at least %LEN% characters", 
		"maxLen" => "The field %NAME% must have at most %LEN% characters",
		"isEmail" => "The field %NAME% isn't a valid email",
		"isEqual1" => "The field %NAME% isn't equal to the field %NAME2%",
		"isEqual2" => "The field %NAME% isn't equal to the other field",
		"isChecked" => "The field %NAME% hasn't been selected",
		"isNumber" => "The field %NAME% must be a number"
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
		if (isset($var) && isset($nameField)) {
			$this->setVar($var, $nameField);
		}		
		$this->chooseErrorsLan();
	}

	/**
	 *	Set the variable to check
	 *
	 * @param mixed 	$var 			Reference to variable (the value)
	 * @param string 	$nameField 		Name to use in the Error strings
	 *
	 * @return $this
	 */
	public function setVar($var, $nameField)
	{
		$this->vars[] = array("name" => $nameField, "value" => $var);
		$this->pos = count($this->vars) - 1;
		return $this;
	}

	/**
	 * Set language to display
	 *
	 * @param char[2] 	$lang 		The language for display errors
	 *
	 * @return void
	 */
	public static function setLanguage($lang)
	{
		self::$lang = $lang;
	}

	/**
	 * Choose the Language of errors
	 *
	 * @return void
	 */
	private function chooseErrorsLan()
	{
		switch(self::$lang){
			# Just waste of memory
			#case "it":
			#	$this->errors = $this->errorsIt;
			#	break;
			case "en":
				$this->errors = $this->errorsEn;
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
	 * Get you the first element of the array errors of the field
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
	 * Get you the first element of errors array off all field
	 *
	 * @param string $fieldName 	Name of field
	 *
	 * @return string[] 	List of all first errors of variable in the object
	 */
	public function getFirstErrors()
	{
		$error = array();
		foreach($this->error as $error_val)
		{
			$error[] = $error_val[0];
		}
		return $error;
	}

	/**
	 * Get you the Array of errors
	 *
	 * @param string $fieldName 	Name of field
	 *
	 * @return string[] 	The first error
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
	public function getAllErrors()
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
			$errors = $args[$i]->getAllErrors();
			foreach($errors as $error_val){
				$error[] = $error_val;
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
		return count($this->error) > 0 ? true : false;
	}

	/**
	 * Control if has error in FieldName
	 *
	 * @param string $fieldName Name of field to check, if null is the last checked
	 *
	 * @return boolean 
	 */
	public function hasErrorInField($fieldName = null)
	{	
		if(!isset($fieldName)) $fieldName = $this->vars[$this->pos]['name'];
		return count($this->error[$fieldName])> 0 ? true : false;
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
	public function isEqual($var2, $name = "")
	{
		if($this->vars[$this->pos]['value'] !== $var2){
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
		if(empty($this->vars[$this->pos]['value'])){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isChecked"]);
		}

		return $this;
	}

	/**
	 * Check if the var is a Number
	 *
	 * @return $this 
	 */
	public function isNumber()
	{
		if(!is_numeric($this->vars[$this->pos]['value'])){
			$this->error[$this->vars[$this->pos]['name']][] = str_replace(array("%NAME%"), array($this->vars[$this->pos]['name']), $this->errors["isNumber"]);
		}

		return $this;
	}
}
