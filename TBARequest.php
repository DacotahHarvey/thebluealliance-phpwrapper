<?php

namespace tbaAPI;

include 'callable.php';

use tbaAPI\cURLCallable as cURLCallable;

class TBARequest extends cURLCallable {

	/*
	 * Base params for all of our endpoints. Each of these arrays require the
	 * bare minimum that we need to make all of our requests. We override these arrays
	 * when we actually make the request to the API (see the array_merge function).
	 * This will ensure that we will always have the bare minimum required. These
	 * example are also pulled directly the The Blue Alliance website
	 */
	public $district_base_params =
	[
		"year" 				=> 2016,
	    "district_short" 	=> "ne"
	];

	public $event_base_params =
	[
		"year" 		=>  2016,
	    "event_key" =>  "2014cmp"
	];

	public $match_base_params =
	[
		"match_key" => "2014cmp_f1m1"
	];

	public $team_base_params =
	[
		"page_num" 	=> 1,
	    "team_key" 	=> "frc1114",
	    "event_key" => "2014cmp",
	    "year" 		=> 2016
	];

	/**
	 * The Constructor is what we use to actually build our reference. In this case
	 * it accepts everything the cURLCallable constructor takes and hands it up
	 * to the parent object.
	 * @param String $__team                - Team Number / Your Name
	 * @param String $__project_description - Short description of what your app is meant to accomplish
	 * @param String $__project_version     - The version that your app is currently in
	 */
	public function  __construct($__team, $__project_description, $__project_version) {
		parent::__construct($__team, $__project_description, $__project_version);
	}

	/**
	 * A simple function that allows us to display the response of the server
	 * in a nice manner. Since everything is returned as JSON you could also use
	 * a website such as https://jsonformatter.curiousconcept.com/
	 * @param  ANY $array - The item that you want to display.
	 * @return [type]        [description]
	 */
	public function prettyPrint($array) {
		echo "<pre>{$array}</pre>";
	}

	//======================================================================
	// DISTRICT REQUESTS API https://www.thebluealliance.com/apidocs#district-requests
	//======================================================================

	/**
	 * Returns a list of all Districts and where they take place in a given
	 * year
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictList($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters->year}", $headers, $full_response);
	}

	/**
	 * Returns detailed information about all the district events
	 * in a given district (defined by the short code) in a given year
	 * @see For more Information on District Codes see https://github.com/the-blue-alliance/the-blue-alliance/blob/master/consts/district_type.py#L38
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_short: String
	 *                                          The district abbreviation you want data for.
	 *                                          See above for more information on District Codes
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictEvents($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("district/{$request_parameters->district_short}/{$request_parameters->year}/events", $headers, $full_response);
	}

	/**
	 * Returns information about all teams competing at a given district event
	 * (defined by the short code) in a given year
	 * @see For more Information on District Codes see https://github.com/the-blue-alliance/the-blue-alliance/blob/master/consts/district_type.py#L38
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_short: String
	 *                                          The district abbreviation you want data for.
	 *                                          See above for more information on District Codes
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictRankings($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("district/{$request_parameters->district_short}/{$request_parameters->year}/teams", $headers, $full_response);
	}

	//======================================================================
	// EVENT REQUESTS API https://www.thebluealliance.com/apidocs#event-requests
	//======================================================================

	/**
	 * Returns all events that took place in a given year
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEvents($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("events/{$request_parameters->year}", $headers, $full_response);
	}

	/**
	 * Returns information about a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEvent($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}", $headers, $full_response);
	}

	/**
	 * Returns a list of teams the participated at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventTeams($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/teams", $headers, $full_response);
	}

	/**
	 * Returns the resuls of all matches at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventMatches($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/matches", $headers, $full_response);
	}

	/**
	 * Returns detailed statistics for all teams at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventStats($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/stats", $headers, $full_response);
	}

	/**
	 * Returns detailed information regarding all teams that participated
	 * at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventRankings($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/rankings", $headers, $full_response);
	}

	/**
	 * Returns information regarding all awards awarded at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventAwards($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/awards", $headers, $full_response);
	}

	/**
	 * Returns informaton regarding distric points at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventDistricPoints($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters->event_key}/district_points", $headers, $full_response);
	}

	//======================================================================
	// MATCH REQUESTS API https://www.thebluealliance.com/apidocs#match-requests
	//======================================================================

	/**
	 * returns all information regarding a single match.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param match_key: String
	 *                                          Key for the match you want to request data for
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getSingleMatch($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("match/{$request_parameters->match_key}", $headers, $full_response);
	}

	//======================================================================
	// TEAM REQUESTS API https://www.thebluealliance.com/apidocs#team-requests
	//======================================================================

	/**
	 * Returns all teams in a pages format
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeams($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("teams/{$request_parameters->page_num}", $headers, $full_response);
	}

	/**
	 * Returns all information about a given team
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeam($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}", $headers, $full_response);
	}

	/**
	 * Returns all information regarding all events a given team attended
	 * in a given year
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEvents($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/events", $headers, $full_response);
	}

	/**
	 * Returns all awards won by a given team at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventAwards($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/event/{$request_parameters->event_key}/awards", $headers, $full_response);
	}

	/**
	 * Returns all matches that a given team participated in at a given event
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventMatches($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/event/{$request_parameters->event_key}/matches", $headers, $full_response);
	}

	/**
	 * Returns all the years that a given team has participated in FRC
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamYearsParticipated($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/years_participated", $headers, $full_response);
	}

	/**
	 * Returns any media that is stored on hand for a given team
	 * (Such as a youtube channel)
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamMedia($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/{$request_parameters->year}/media", $headers, $full_response);
	}

	//======================================================================
	// TEAM HISTORY REQUESTS API https://www.thebluealliance.com/apidocs#team-requests
	//======================================================================

	/**
	 * Returns the outcome of a given team at every event they have competed in
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventHistory($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/history/events", $headers, $full_response);
	}

	/**
	 * Returns any awards that a given team has won at any event they have attended
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamAwardHistory($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/history/awards", $headers, $full_response);
	}

	/**
	 * Returns information on the Robot that a given team has used
	 * in every respective year that they have competed
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamRobotHistory($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/history/robots", $headers, $full_response);
	}

	/**
	 * Returns information about a given team at any distric they have
	 * attended
	 * @param  {[Array]}   options  - Options for the URL
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamDistricHistory($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("team/{$request_parameters->team_key}/history/districts", $headers, $full_response);
	}
}
