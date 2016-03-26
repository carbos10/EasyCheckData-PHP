# EasyCheckData-PHP
Simple check of data

This class helps you to check data and print errors.
## Installation
Include the [EasyCheckData] class 
```
<?php 
require_once 'src/EasyCheckData.php';
```

## Usage
### setVar($var, $nameField) 
For many/single variable
Create the object
```
$ECD = new EasyCheckData();
$ECD->setVar($_POST['username'], "Username")->isDef()->minLen(6)->maxLen(30);
$ECD->setVar($_POST['email'], "Email")->isDef()->isEmail();
$ECD->setVar($_POST['check'], "Terms")->isChecked();
$ECD->setVar($_POST['age'], "Age")->isDef()->isNumber();
```
and after for print errors of all data
```
echo(implode("<br>", $ECD->getFirstErrors()));
```
### Another method for a single variable
```
$ECD = new EasyCheckData($var, "value");
$ECD->isDef()->minLen(6)->maxLen(30);
echo $ECD->getFirstError();
```
## List of Checks
### isDef()
Check if the variable is defined
```
$ECD->isDef();
```
### minLen($len)
Check if the variable is shorter than $len characters
```
$ECD->minLen(6);
```
### maxLen($len)
Check if the variable is longer than $len characters
```
$ECD->maxLen(30);
```
### isEmail()
Check if the variable is an Email
```
$ECD->isEmail();
```
### isEqual($var2, $name="")
Check if the variable is equal to $var2, $name is optional, for print the name of second element in the error message
```
$ECD->isEqual($pass2, "Repeat Password");
```
### isChecked()
Check if the variable is checked
```
$ECD->isChecked();
```
### isNumber()
Check if the variable is a number
```
$ECD->isNumber();
```
## Display Errors Methods
### hasError()
Check if there are errors
```
$ECD->hasError();
```
### hasErrorInField($fieldName = null)
Check if there are errors in a Field
```
$ECD->hasErrorInField();
```
### getFirstError($nameField = null)
Get you the first error found in $nameField, return String.
N.B. if $nameField is null, get you the error of last variables checked
```
$ECD->getFirstError();
```
### getFirstErrors()
Get you the first error of all variable in Object, return Array.
```
$ECD->getFirstErrors();
```
### getErrors($nameField = null)
Get you the all errors of the $nameField selected. Return Array.
N.B. if $nameField is null, get you the error of last variables checked
```
$ECD->getErrors();
```
### getAllErrors()
Get you the all errors of the object. Return Array.
```
$ECD->getAllErrors();
```
### static mixAllErrors()
For join all errors of EasyCheckData objects.
```
EasyCheckData::mixAllErrors($ECD1, $ECD2, ...);
```
## Config Methods
### static setLanguage($lang) 
Set the language to print errors, (for now only "it" and "en")
```
EasyCheckData::setLanguage("it");
```
### changeTextError($nameError, $text)
For change Errors Text.
N.B. Control in the code for see how to change (with %NAME%, %LEN% ecc)
```
$ECD->changeTextError("isDef", "Please enter %NAME%");
```

[EasyCheckData]: <https://github.com/carbos10/EasyCheckData-PHP/blob/master/src/EasyCheckData.php>

