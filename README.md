# thebluealliance-phpwrapper
A PHP wrapper that assists in the use of the API provided by http://www.thebluealliance.com

# Usage
Currently the project is not included in Composer. Because of that the inclusion
of it has to be be done manually.

1. In your project make a new folder called tbaAPI
2. Download this repository.
3. Unzip the files that you downloaded and place them in the tbaAPI folder that you previously created.
4. Include the following line at the top of the file that you wish to use the wrapper in

```
include $_SERVER['DOCUMENT_ROOT'] . '/tbaapi/TBARequest.php';
```

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

# Executing a Script
Executing a php script is very easy once the initial setup has been taken care of.
The scripts provided with this project will work best with PHP 7, however they will
also perform with a lower version. To run a PHP script navigate to the folder where
your script is contained and run

```
php script_name
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
