[AppKit]


Contents:
	AppKit - abstract base class
	DbManager - class to manage the database
	Main - Main Appkit class

TODO:
	commandline/web routing.
	config reader/writer
	break the parts up and such.

The idea: 
	Appkit is a class you can extend to give
	your classes the singleton pattern.
	
usage:
	create a class and have it extend Appkit
	then store the instance using the 
	getInstance method.
	
example:
	class myClass extends Appkit	
	$singleInstanceOfClass = $Appkit->getExt(myClass);
	$singleInstanceOfClass->method();