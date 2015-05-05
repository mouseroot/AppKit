AppKit v1.1
===========

## Docs

# AppKit Class


#### static [Database](Database.md "Database") ( $hostname, $username, $password, $database )
Returns a new instance of the Database class
```php
$Database = AppKit::Database("localhost", "username", "passwd", "database_name");
```

#### static Session ( )
Returns a new instance of the Session class
```php
$Session = AppKit::Session();
```

#### static GET ( $variable )
Returns the $_GET variable if it passes the isValid function
```php
echo AppKit::GET('userid');
```

#### static POST ( $variable )
Returns the $_POST variable if it passes the isValid function
```php
echo AppKit::POST('userid');
```

#### static download ( $url )
Returns the remote file contents
```php
echo AppKit::download('http://github.com');
```

#### static isValid( $variable )
Returns if a variable isset and is not null (perfect for GET and POST)
```php
if(AppKit::isValid($video)) {
	echo $video;
}
```


#### static render( $filePath, $array_of_variables )
Includes a file and extracts the variables in the array into the file
```php
echo AppKit::render("view.php", array("username" => "Test") );
```


