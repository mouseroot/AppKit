## Session Class

#### static start ( )
enables sessions
```php
Session::start();
```

#### exists ( $key )
Returns true if the key exists in the session object
```php
if($Session->exists("loggedin")) {
  echo "Loged in";
}
```

#### static stop ( )
disables sessions
```php
Session::stop();
```

#### get ( $key )
Returns the key in the session object if its set
```php
echo "Welcome, " . $Session->get("username");
```

#### set ( $Key, $value )
Sets the key and value pair in the session object
```php
$Seesion->set("username", $_GET["username"] );
```

#### delete ( $key )
Removes or 'unsets' the key in the session object
```php
$Session->delete("loggedin");
echo "Goodbye.";
```

