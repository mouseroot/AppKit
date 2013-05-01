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
connect to a database
```php
	include "AppKit.php"
	$db = $AppKit->getExt("DbManager");
	$db->connect("localhost","user","pass","db_name");
```

Insert some values into a table
```php
	$data = array(
		"table_column" => "value",
		"another_column" => "another_value"
	);
	$db->insertInto("table_name",$data);
```
Enable,set,get and destory sessions
```php
	$Session = $App->getExt("Sessions");
	$Session->start();
	$Session->set("key","value");
	if($Session->exists("key"))
	{
		echo $Session->get("key");
	}
	$Session->stop();
```
Simple Routing
```php
	$Router = $AppKit->getExt("Router");
	$Router->on("some_route",function($param)
	{
		echo "Some_route executed with $param";
	});
	$Router->start();
```
Advanced Routing
```php
	echo "Currently working on!";
```
