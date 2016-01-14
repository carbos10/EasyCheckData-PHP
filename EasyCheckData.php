<?php 
/*
 * (c) Luigi Carbos
 * 
 * License Free
 *
 */

/*
 * Class for EasyCheckData
 *
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
		"isTrue" => "Il campo %NAME% non è stato selezionato"
	);

	/**
	 * @var string[] Errors
	 */
	private $errors;
	
	/**
	 * @var string   Name to use in the errors
	 */
	private $name ;

	/**
	 * @var mixed   	Var to check
	 */
	private $var ;

	/**
	 * @var string[] 	Errors of var
	 */
	private $error = array();

	/**
	 * @param mixed 	$var 			Reference to variable
	 * @param string 	$nameField 		Name to use in the Error strings
	 * @param string 	$lang 			Language to use for errors
	 */
	public function __construct($var, $nameField, $lang = "it")
	{
		$this->var = $var;
		$this->name = $nameField;

		switch($lang){
			case "it":
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
	 * Get you the first error.
	 *
	 * @return string 	The first error
	 */
	public function getFirstError()
	{
		return $this->error[0];
	}

	/**
	 * Get you the Array of Errors
	 *
	 * @return string[]	Array with all Errors
	 */
	public function getErrorArray()
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
			$errors = $args[$i]->getErrorArray();
			foreach($errors as $val){
				$error[] = $val;
			}		
		}

		return $error;
	}

	/**
	 * Merge all first errors of selected This-Class
	 *
	 * @param multi EasyCheckData 	All EasyCheckData that you use
	 *
	 * @return string[]		Merging first error of each EasyCheckData 
	 */
	public static function mixFirstErrors()
	{
		$error = array();
		$args = func_get_args();
		for($i = 0; $i < func_num_args(); $i++){
			$error[] = $args[$i]->getFirstError();			
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
		if(empty($this->var)){
			$this->error[] = str_replace(array("%NAME%"), array($this->name), $this->errors["isDef"]);
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
		if(strlen($this->var) < $len){
			$this->error[] = str_replace(array("%NAME%", "%LEN%"), array($this->name, $len), $this->errors["minLen"]);
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
		if(strlen($this->var) > $len){
			$this->error[] = str_replace(array("%NAME%", "%LEN%"), array($this->name, $len), $this->errors["maxLen"]);
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
		if(!filter_var($this->var, FILTER_VALIDATE_EMAIL)){
			$this->error[] = str_replace(array("%NAME%"), array($this->name), $this->errors["isEmail"]);
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
		if($this->var !== $pass){
			if($name !== ""){
				$this->error[] = str_replace(array("%NAME%", "%NAME2%"), array($this->name, $name), $this->errors["isEqual1"]);
			} else {
				$this->error[] = str_replace(array("%NAME%"), array($this->name), $this->errors["isEqual2"]);
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
		if($this->var !== true){
			$this->error[] = str_replace(array("%NAME%"), array($this->name), $this->errors["isChecked"]);
		}

		return $this;
	}

}
