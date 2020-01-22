# Skyline CLI Package
The CLI Package adds a plugin to your application that interact on command line requests.  
By default, the file ```~/Public/skyline.php``` gets called by apache or another webserver to deliver your webpage.

If this file gets performed under command line, you will get an error, because the routing never will success.  
This Package installed it will listen for command line calls and forward to registered tasks.

#### Installation
```bin
$ composer require skyline/cli
```

#### Usage
The package introduces a new configuration file:  
``processes.cfg.php``  
All files with this name are collected while compiling and they should declare a process info.

Such a config file might look like:
```php
<?php
// File MyClass.php
class MyClass {
    // Constructor must not expect arguments.
    // If you need so, specify as service and define with ProcessConfig::PROCESS_SERVICE_NAME
    public function __construct() {}
    
    public function run($argc, $argv) {
        // Do stuff
    }
}

// File: processes.cfg.php

use Skyline\CLI\Config\ProcessConfig;

return [
    [
        ProcessConfig::PROCESS_NAME => 'my-process',
        ProcessConfig::PROCESS_METHOD => 'run',
        ProcessConfig::PROCESS_CLASS_NAME => stdClass::class
    ]
];
```


