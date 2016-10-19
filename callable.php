<?php

namespace tbaAPI;

/**
 * The cURLCallable class is what allows us to make all of our cURL requests
 * to the API. This gives us a centralized point that we can do all of the
 * tedious work such as setting the app header that The Blue Alliance requests
 * as well as actually make our cURL request
 */
class cURLCallable {

	// Base information about the request we are going to make
	private $team;
	private $project_description;
	private $project_version;
	private $app_header;

	// Base URL that we are going to call
	private $base_url = "https://thebluealliance.com/api/v2/";

	/**
	 * The Constructor allows us to actually create our cURLCallable object
	 * that we will use to make our cURL request the The Blue Alliance.
	 * This Constructor takes in the information that we need for the unique
	 * header that we have to send as well as build that header for us
	 * @param String $__team                - Team Number / Your Name
	 * @param String $__project_description - Short description of what your app is meant to accomplish
	 * @param String $__project_version     - The version that your app is currently in
	 */
	public function  __construct($__team, $__project_description, $__project_version) {
		$this->team 				= $__team;
		$this->project_description 	= $__project_description;
		$this->project_version 		= $__project_version;
		$this->app_header 			= "{$this->team}:{$this->project_description}:{$this->project_version}";
	}

	/**
	 * Our actual cURL request to the Blue Alliance Server. This is where we
	 * compile all of our headers as well as any other information thar we need
	 * to actually make the request. This is where the bulk of the work is done
	 * @param  [type]  $url                    [description]
	 * @param  [type]  $request_parameters     [description]
	 * @param  boolean $return_response_status [description]
	 * @return [type]                          [description]
	 */
	public function call($url, $request_parameters = [], $return_response_status = false) {

		$curl = curl_init();

		// Set our default headers that we know will be set everytime
		$request_headers = [
			"X-TBA-App-Id: {$this->app_header}"
		];

		// Set our conditional headers that might of been passed throught the function
		foreach ($request_parameters as $request_parameter_key => $request_parameter_value) {
			$request_headers[$request_parameter_key] = $request_parameter_value;
		}

		// Build our cURL request
		curl_setopt_array(
			$curl,
			[
				CURLOPT_URL 			=> $this->base_url . $url,
				CURLOPT_RETURNTRANSFER 	=> true,
				CURLOPT_VERBOSE			=> true,
				CURLOPT_SSL_VERIFYPEER 	=> false,
				CURLOPT_FOLLOWLOCATION 	=> true,
				CURLOPT_HTTPHEADER		=> $request_headers
			]
		);

		// Execute the cURL request
	    $result 		= curl_exec($curl);

		// check our cURL request for the status. This will give us more information
		// about the response
		$result_status 	= curl_getinfo($curl);

		// End the cURL request to free up data
	    curl_close($curl);

		// Return our response to the user
		if ($result_status['http_code'] == 200) {
			if ($return_response_status) {
				$result_status['data'] = $result;
				return $result_status;
			}

			return $result;
		} elseif ($result_status['http_code'] == 404) {
			throw new NotFoundException("The requested URL was not found.");
		} elseif ($result_status['http_code'] == 301) {
			throw new MovedException("The requested URL has moved.");
		} else {
			throw new Exception("An error has occured with code {$result_status['http_code']}");
		}
	}
}
