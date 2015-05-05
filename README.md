# AppKit (Updated 5/5/15)

Change notes
------------

* Dropped Javascript, Routing, and the abstract Class AppKit
* Rewrote the Database class to only use mysqli 
* Docs hand-written to avoid useless data generation
* Main focus is on basic CRUD for mysql databases

## Class AppKit
Main class 

#### static class [Database](Database.md "Database") ( $hostname, $username, $password, $database )
Returns a new instance of the Database class
```php
$Database = AppKit::Database("localhost", "username", "passwd", "database_name");
```

#### static class [Session](Session.md "Session") Session ( )
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

#### static open ( $url )
Returns the remote file contents
```php
echo AppKit::open('http://github.com');
```

#### static isValid( $variable )
Returns if a variable isset and is not null (perfect for GET and POST)
```php
if(AppKit::isValid($video)) {
	echo $video;
}
```

#### static scrubString ( $string )
Scrubs the string escaping html char and regexing incorrect artifacts
```php
echo AppKit::scrubString(AppKit::GET('password'));
```

#### static render( $filePath, $array_of_variables )
Includes a file and extracts the variables in the array into the file
```php
echo AppKit::render("view.php", array("username" => "Test") );
```


