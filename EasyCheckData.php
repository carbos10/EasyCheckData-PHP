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
     * @var array string
     */
    private $errorsIt = array(
        0 => "vuoto", // Se è vuota
        1 => "deve essere minimo di caratteri",
        2 => "deve essere massimo di caratteri",
        3 => "non è un email corretta",
        4 => "non è uguale all'altra/o",
        5 => "non sono stati accettati"
    );
 
    /**
     * @var array string
     */
    private $errors;
   
    /**
     * @var string   Name to use in the errors
     */
    private $name ;
 
    /**
     * @var mixed       Var to check
     */
    private $var ;
 
    /**
     * @var array string    Errors of var
     */
    private $error = array();
 
    /**
     * @param mixed     $var            Reference to variable
     * @param string    $nameField      Name to use in the Error strings
     * @param string    $lang           Language to use for errors
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
     * Get you the first error.
     *
     * @return string   The first error
     */
    public function getFirstError()
    {
        return $this->error[0];
    }
 
    /**
     * Get you the Array of Errors
     *
     * @return array string     Array with all Errors
     */
    public function getErrorArray()
    {
        return $this->error;
    }
 
 
    /**
     * Merge all errors of selected This-Class
     *
     * @param multi EasyCheckData   All EasyCheckData that you use
     *
     * @return array string         Merging errors' array of each EasyCheckData
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
     * @param multi EasyCheckData   All EasyCheckData that you use
     *
     * @return array string         Merging first error of each EasyCheckData
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
            $this->error[] = $this->name." ".$this->errors[0];
        }
        return $this;
    }
 
    /**
     * Control the minimum length of var
     *
     * @param int       Min length
     *
     * @return reference to object
     */
    public function minLen($len)
    {
        if(strlen($this->var) < $len){
            $this->error[] = $this->name." ".$this->errors[1]." ".$len;
        }
        return $this;
    }
 
    /**
     * Control the maximum length of var
     *
     * @param int       Max length
     *
     * @return reference to object
     */
    public function maxLen($len)
    {
        if(strlen($this->var) > $len){
            $this->error[] = $this->name." ".$this->errors[2]." ".$len;
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
            $this->error[] = $this->name." ".$this->errors[3];
        }
        return $this;
    }
 
    /**
     * Check if is equal to another string
     *
     * @param string    String to compare
     *
     * @return reference to object
     */
    public function isEqual($string)
    {
        if($this->var !== $pass){
            $this->error[] = $this->errors[4];
        }
        return $this;
    }
 
    /**
     * Check if the var is true
     *
     * @return reference to object
     */
    public function isTrue()
    {
        if($this->var !== true){
            $this->error[] = $this->errors[5];
        }
        return $this;
    }
 
}
