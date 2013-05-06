AppKit
======

## Contents
+	AppKit - abstract base class
+	Database - class to manage the database
+	Sessions - class to manage user sessions
+	Javascript - handle/create serverside javascript functions
+	Router - class to handle web routing
+	Main - Main Appkit class
+	.htaccess - Important apache config file that tells apache what todo when a route is hit by a browser

## Requirments
+	PHP 5.3+ (for clolsures)
+	Apache module mod_rewrire (if you choose to use my routing system)
+	MySQL (if you choose to use my database class)

## TODO
+	commandline
+	config reader/writer	

## The idea
+	Appkit is a class you can extend to give
	your classes the singleton pattern.
+	AppKit is an all-in-one toolkit to bootstrap your php apps
+	If your class is extended from AppKit you can add methods and variables onto the class on the fly
+	Dont like the way I have a method named? you can create a shortcut with a shoter name
+	There is no pre-defined folder structure arrange the files however you like
+	Routing is a bit different instead of /some/path you use it more like /some-path/params/more-params
	
## Useage
+	create a class and have it extend Appkit
	then get a single instance useing the getExt method
	
## Examples

Extending an existing class
```php
	class myClass extends Appkit
	$singleInstanceOfClass = $Appkit->getExt("myClass");
	$singleInstanceOfClass->method();
```
Connect to a database
```php
	include "AppKit.php"
	$db = $AppKit->getExt("Database");
	$db->connect("localhost","user","pass","db_name");
```
Create a selection statement WITH a condition
```php
	$selector = $db->select(array("a_field","another_feild"),"table","where_clause");
	//Returns a sql statement string "SELECT ("a_field","another_feild") FROM "table" WHERE where_clause"
```
Create a selection statement WITHOUT a condition
```php
	$selector = $db->select(array("a_feild","another_feild"),"table");
	//Returns a sql statment string "SELECT ("a_field","another_field") FROM "table"
```

Useing the selection statement to query the database
```php
	$db->query($selector,function($row)
	{
		echo $row["a_feild"];
	});
```

Storing the query result into an array
```php
	$output = array();
	$db->query($selector,function($data) use (&$output) {
		$output[] = $data;
	});
	var_dump($output);
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
Routing
```php
	$Router = $AppKit->getExt("Router");
	$Router->on("some_route",function($param)
	{
		echo "Some_route executed with $param";
	});
	$Router->start();
```
Rendering a view
```php
	$some_data = array(
		"color" => "purple",
		"name" => "mouseroot");
	$output = $App->render("views/some_file.php",$some_data);
	echo $output;
```
