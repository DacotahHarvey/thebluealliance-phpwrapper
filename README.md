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
