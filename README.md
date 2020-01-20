composer-wrapper-php
==============

A simple PHP wrapper for **composer** dependency manager.

About 
==============

In some cases you might want to use the dependency manager composer on your server
directly from a PHP script. For e.g. if you don't want to force your user to install
your software project manually via SSH or the access to SSH is not granted.

Be aware that this is definitely not the best approach, but especially for user which only
want to install your application and are not familar with composer and dependency management,
this could be a real alternative.

Installation
==============

To install this wrapper, you only need to clone this repo and run composer one time to
install the composer API itself. 

Simply type `composer install` in your command line. When composer finished the installation,
you can start using the wrapper.

Usage & Hints
==============

To use the library you need to take advantage of the `Composer` class. This class is your
port to work with composer via PHP.

```
$composer = Composer::getInstance(__DIR__ . '/../composer.json');
$composer->install();
``` 

This code snippet runs the `composer install` command in the directory above with the `composer.json` file
specified as first parameter. You can set the composer working dir as second parameter optionally.

With an instance of `Composer` you can run the commands `about`, `list`, `install`, `require`,
`update` and `remove` by calling the corresponding method as shown above. Some of these methods
require a package name as parameter. Please take a look into source code for this - It's well documentated!

Alternatively you can run every command with the `executeCommand` method. It takes the command
name as first parameter und the other arguments as second parameter optionally.

Every method echos the output of composer directly to the client. You can set the `-q` flag to
force composer to be quiet.

License
==============

This project is licensed under the MIT License. See [LICENSE](LICENSE) for more information.
