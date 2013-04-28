AppKit
======

## Contents
+	AppKit - abstract base class
+	DbManager - class to manage the database
+	Main - Main Appkit class

## TODO
+	commandline/web routing.
+	config reader/writer
+	break the parts up and such.

## The idea
+	Appkit is a class you can extend to give
	your classes the singleton pattern.
	
## Useage
+	create a class and have it extend Appkit
	then store the instance using the 
	getInstance method.
	
## Example

Extending an existing class
```php
	class myClass extends Appkit	
	$singleInstanceOfClass = $Appkit->getExt(myClass);
	$singleInstanceOfClass->method();
```
Simply using the singleton to connect to a database
```php
	include "AppKit.php"
	$db = $Appkit->getExt("DbManager");
	$db->connect("localhost","user","pass","db_name");
	$data = array(
		"table_column" => "value",
		"another_column" => "another_value"
	);
	$db->insertInto("table_name",$data);
```
