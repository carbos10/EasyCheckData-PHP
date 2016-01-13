# EasyCheckData-PHP
Simple check of data

This class helps you to check data and print errors.
### How to use
Include the [EasyCheckData] class 
```
<?php 
require_once 'EasyCheckData.php';
```

Create object and variable to check:
```
<?php
$CheckUser = new EasyCheckData($username, "Username");
$CheckUser->isDef()->minLen(6)->maxLen(30);
// For get errors:
$errors = $CheckUser->getErrorArray();
```
[EasyCheckData]: <https://github.com/carbos10/EasyCheckData-PHP/blob/master/EasyCheckData.php>

