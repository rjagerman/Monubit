Monubit
========================

This document contains information on how to configure Monubit so it
runs on your webserver.

1) Requirements
----------------------------------
To run Monubit you will need a web server capable of running the Symfony2
framework. This means we require the following:

* An HTTP server (Apache for example)
* PHP 5.4 or higher
* MySQL or a similar database management system
* Composer (script included in the root directory)

Furthermore, we recommend you install the following, even though it is
not required to run the application:

* A PHP bytecode cache (APC v3.13+ or XCache)
* The PHP intl package
* A command line interface with basic linux command functionality
  This means that if you are running windows we recommend you install
  conemu (terminal emulator) and cygwin (linux functionality)

2) Cloning from git
----------------------------------

You have to clone this git repository into a directory of your webserver.
Usually you will want to clone it into `htdocs` so that the /Monubit/web/
folder can directly be accessed by the browser, however other valid 
configurations do exist.

3) Checking your System Configuration
-------------------------------------

Before starting, make sure that your local system is properly configured
for the Symfony2 framework.

Open the cloned repository's root directory in a command line and execute
the following:

    php app/check.php

If you get any warnings or recommendations, fix them before moving on.

4) Configuring your database information
--------------------------------

Run the following command in the command line to copy the default
configuration parameters:

    cp ./app/config/parameters.yml.dist ./app/config/parameters.yml

Now open your web browser and browse to the configuration script
to enter your database information:

    http://localhost/Monubit/web/config.php

Follow all the steps there and your application should be configured
correctly.

5) Installing and updating vendor scripts
-------------------------------

Before you can use Monubit you will have to install and update all
of its dependencies. Assuming you have composer installed, simply
run the following command in the command line from the root of your
cloned repository:

    php composer.phar install
    
Now run the following command to update everything to the latest
version:

    php composer.phar update

6) Done!
---------------

You can now start using Monubit at the following URL:

	http://localhost/Monubit/web/
	
To run the project in the development environment for better
debugging tools, start Monubit at the following URL:

	http://localhost/Monubit/web/app_dev.php/


