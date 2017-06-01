# thebluealliance-phpwrapper
A PHP wrapper that assists in the use of the API provided by http://www.thebluealliance.com

# Installation

### Composer
Installing the application through Composer is the fastest way to get all setup.
To do this navigate to the root of your project in the terminal and run

`composer require dacotahharvey/thebluealliance-phpwrapper`

Then when you use the project include the two following lines at the top of your file

```
require_once __DIR__ . '/lib/vendor/autoload.php';
use TheBlueAlliance_PHPWrapper\TBARequest;
```

### Manually Cloning

1. In your project make a new folder called tbaAPI
2. Download this repository.
3. Unzip the files that you downloaded and place them in the tbaAPI folder that you previously created.
4. Include the following line at the top of the file that you wish to use the wrapper in

```
include __DIR__ . '/tbaapi/TBARequest.php';
```

# Library Usage

5. Create a new reference to the library like so

```
$tbaRequest = new tbaAPI\TBARequest(team_number_or_name, application_name, application_version);
```

6. Call the functions provided to retrieve your data like so

```
echo $tbaRequest->getDistrictList(['year' => 2016]);
```

All of the functions provided by the wrapper take the same three paramters

1. $request_parameters - Any paramters that that the endpoint needs for the query
2. $headers - Any additional headers that you want to send with the request
3. $full_response - Whether you want the full response or just the JSON returned by The Blue Alliance

Lets say for example we wanted to make a request to get the team 1114.
We can find the documentation for this function [here](https://www.thebluealliance.com/apidocs#team-request)
Using the var `tba` from above we can do the following

```
$result = $tbaRequest->getTeam(['team' => 1114]);
```

# Executing a Premade Script
Executing a php script is very easy once the initial setup has been taken care of.
The scripts provided with this project will work best with PHP 7, however they will
also perform with a lower version. Running the scripts that are contained within this repository is simple. It can be accomplished using the three following steps

1. Clone the repository
2. In each of the sciripts you will find the library initalization. You must change this in each of the scripts that you wish to run as currently they empty. You can find more information on how to do this in the Library Usage section of this Readme.
3. Use the following commands in the terminal. Note that the composer install is only used once to generate the autoload file that must exist to properly use the plugin

```
composer install
cd scripts
cd 2017
```

Then choose the file that you want to run. Each script will contain instructions on how to run it. If you try to run a script with improper commands it will tell you how it should be run. An example of a script being executed once you are in the proper directory is

```
php team-match-turnaround.php 2017dar frc1114
```

The script will then run in your terminal instance.

### PHP Installation in Mac OSX

Mac OSX comes with PHP by default! If you are ambitious you can upgrade to PHP7.
The tutorial steps below will help with that.

1. Homebrew is the best way to upgrade your Mac instance to PHP7. Homebrew is a tool
that will allow you to install packages via the terminal. A fantastic tutorial on what
Homebrew is and how to use it can be found here:
https://www.howtogeek.com/211541/homebrew-for-os-x-easily-installs-desktop-apps-and-terminal-utilities/

2. This tutorial is a fantastic reference point for upgrading to PHP7. You can also
perform the steps in reverse to downgrade back to PHP5!
https://developerjack.com/blog/2015/12/11/Installing-PHP7-with-homebrew/


### PHP Installation on Windows

Installing PHP through the command line is an arduous task on windows. The PHP library
offers a tutorial on this that can be found here http://php.net/manual/pl/install.windows.commandline.php

Alternatively you can use Xxamp. The homepage for Xxamp with a download link can
be found here https://www.apachefriends.org/index.html and a fantastic tutorial on
how to use xxamp can be found here https://blog.udemy.com/xampp-tutorial/

# Contact Me

If you have any questions or concerns feel free to contact me at dacotahj.harvey@gmail.com
I am always more than willing to help write a script or setup an environment that
will allow you to execute your own scripts!
