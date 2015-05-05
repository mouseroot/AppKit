AppKit v1.1
===========

## Database Class


#### constructor ( $hostname, $username, $password, $database )
Constructor for the Database class, call the connect function
```php
$Database = new Database("localhost", "root", "passwd", "example");
```

#### isConnected ( )
Returns if the database connection was established
```php
if($Database->isConnected()) {
  echo "Connected!";
}
```

#### connect ( $hostname, $username, $password, $database )
Creates a connection using mysqli and stores the connection handle into a variable
```php
$Database->connect("localhost", "root", "passwd", "example");
```

#### static select ( $items, $table, $where = null)
Returns a select string similar to 'SELECT * FROM table'
```php
$selectNames = Database::select(array("id", "name" ), "users");
$selectNames2 = Database::select(array("id", "name" ), "users", "id = 5" );
```

#### query ($query, $callback = null )
Executes the query and passes the result into the callback function
```php
$Database->query($selectNames, function( $row ) {
  echo $row["name"];
}
```

#### execute ( $query )
Executes the query returning the result
```php
if($Database->execute($selectNames2)) {
  echo 'Query executed!';
}
```

#### static update ( $table, $array, $where )
Returns an UPDATE sql string like 'UPDATE table SET ("id", "name" ) WHERE id = 5'
```php
$updateName = Database::update("users", array("id" => -1, "name" => "updated_user" ), "id = 5");
```
