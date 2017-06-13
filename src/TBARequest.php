<?php

namespace TheBlueAlliance_PHPWrapper;

include 'Callable.php';
use TheBlueAlliance_PHPWrapper\Utils\cURLCallable as cURLCallable;

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
	    "district_key" 		=> "2016fim"
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
	 * The Constructor allows us to actually create our cURLCallable object
	 * that we will use to make our cURL request the The Blue Alliance.
	 * This Constructor takes in the information that we need for the unique
	 * header that we have to send as well as build that header for us
	 * @param String | String $__api_key              - API Key for your app generated on The Blue Alliance
     *                                                @param Boolean return_json - Whether you want to be returned
     *                                                                             a JSON array straight from the API,
     *                                                                             or an object that can easily be manipulated
     *                                                                             by PHP
	 */
	public function  __construct($__api_key, $__options = []) {
		parent::__construct($__api_key, $__options);
	}

	/*----------------------------------------------------------------------
	----------------------------------TBA-----------------------------------
	----------------------------------------------------------------------*/

	public function getStatus($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("status", $headers, $full_response);
	}

	/*----------------------------------------------------------------------
	----------------------------------Team----------------------------------
	----------------------------------------------------------------------*/

	/**
	 * Gets a list of Team objects, paginated in groups of 500.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeams($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/{$request_parameters['page_num']}", $headers, $full_response);
	}

	/**
	 * Gets a list of short form Team_Simple objects, paginated in groups of 500.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamsSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/{$request_parameters['page_num']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of Team keys, paginated in groups of 500. (Note, each page will
	 * not have 500 teams, but will include the teams within that range of 500.)
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamsKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/{$request_parameters['page_num']}/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of Team objects that competed in the given year, paginated in groups of 500.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamsByYear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/year/{$request_parameters['page_num']}", $headers, $full_response);
	}

	/**
	 * Gets a list of short form Team_Simple objects that competed in the given year, paginated in groups of 500.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamsByYearSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/year/{$request_parameters['page_num']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list Team Keys that competed in the given year, paginated in groups of 500.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param page_num: Integer
	 *                                          A page of teams, zero-indexed. Each page
	 *                                          consists of teams whose numbers start at
	 *                                          start = 500 * page_num and end at
	 *                                          end = start + 499, inclusive.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamsByYearkeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("teams/year/{$request_parameters['page_num']}/keys", $headers, $full_response);
	}

	/**
	 * Gets a Team object for the team referenced by the given key.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeam($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}", $headers, $full_response);
	}

	/**
	 * Gets a Team_Simple object for the team referenced by the given key.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of years in which the team participated in at least one competition.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamYearsParticipated($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/years_participated", $headers, $full_response);
	}

	/**
	 * Gets a list or year and district pairs to denote each year the team was in a
	 * district. Will return an empty array if the team was never in a district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamDistricts($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/districts", $headers, $full_response);
	}

	/**
	 * Gets a list of year and robot name pairs for each year that a robot name was
	 * provided. Will return an empty array if the team has never named a robot.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamRobots($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/robots", $headers, $full_response);
	}

	/**
	 * Gets a list of all events this team has competed at.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEvents($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of all events this team has competed at.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventsSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of the event keys for all events this team has competed at
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventsKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of events this team has competed at in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventsForYear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of events this team has competed at in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventsForYearSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events/{$request_parameters['year']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of the event keys for events this team has competed at in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamEventsForYearKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/events/{$request_parameters['year']}/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of matches for the given team and event.
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
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/event/{$request_parameters['event_key']}/matches", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of matches for the given team and event.
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
	public function getTeamEventMatchesSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/event/{$request_parameters['event_key']}/matches/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of match keys for matches for the given team and event.
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
	public function getTeamEventMatchesKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/event/{$request_parameters['event_key']}/matches/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of awards the given team won at the given event.
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
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/event/{$request_parameters['event_key']}/awards", $headers, $full_response);
	}

	/**
	 * Gets the competition rank and status of the team at the given event.
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
	public function getTeamEventStatus($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/event/{$request_parameters['event_key']}/status", $headers, $full_response);
	}

	/**
	 * Gets a list of awards the given team has won.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamAwards($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/awards", $headers, $full_response);
	}

	/**
	 * Gets a list of awards the given team has won in a given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamAwardsForYear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/awards/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a list of matches for the given team and year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamMatchesForYear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/matches/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of matches for the given team and year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamMatchesForYearSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/matches/{$request_parameters['year']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of match keys for matches for the given team and year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamMatchesForYearKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/matches/{$request_parameters['year']}/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of Media (videos / pictures) for the given team and year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 *                                          @param year: String
	 *                                          The year that you want to search for in the format
	 *                                          yyyy
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamMediaForyear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/media/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a list of Media (social media) for the given team.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param team_key: String
	 *                                          A team key name where the format is frcyyyy where
	 *                                          yyyy is the a valid, official team number issued
	 *                                          by FIRST
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getTeamSocialMedia($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->team_base_params, $request_parameters);
		return $this->call("team/{$request_parameters['team_key']}/social_media", $headers, $full_response);
	}

	/*----------------------------------------------------------------------
	--------------------------------District--------------------------------
	----------------------------------------------------------------------*/

	/**
	 * Gets a list of districts and their corresponding district key, for the given year.
	 * year
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistricts($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a list of events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictEvents($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictEventsSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of event keys for events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictEventsKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of Team objects that competed in events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictTeams($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/teams", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of Team objects that competed in events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictTeamsSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/teams/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of Team objects that competed in events in the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictTeamsKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/teams/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of team district rankings for the given district.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param district_key: String
	 *                                          TBA district key with the format yyyy[DISTRICT_CODE],
	 *                                          where yyyy is the year, and DISTRICT_CODE is the
	 *                                          district code of the specific district.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getDistrictRankings($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->district_base_params, $request_parameters);
		return $this->call("districts/{$request_parameters['district_key']}/rankings", $headers, $full_response);
	}

	/*----------------------------------------------------------------------
	---------------------------------Event----------------------------------
	----------------------------------------------------------------------*/

	/**
	 * Gets a list of events in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventsForYear($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("events/{$request_parameters['year']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of events in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventsForYearSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("events/{$request_parameters['year']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of event keys in the given year.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param year: Integer
	 *                                          A specific year you would like to grab data for
	 *                                          this team. Defaults to current year if not provided.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventsForYearKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("events/{$request_parameters['year']}/keys", $headers, $full_response);
	}

	/**
	 * Gets an Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEvent($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of Elimination Alliances for the given Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventAlliances($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/alliances", $headers, $full_response);
	}

	/**
	 * Gets a set of Event-specific insights for the given Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventInsights($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/insights", $headers, $full_response);
	}

	/**
	 * Gets a set of Event OPRs (including OPR, DPR, and CCWM) for the given Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventOPRs($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/oprs", $headers, $full_response);
	}

	/**
	 * Gets information on TBA-generated predictions for the given Event.
	 * Contains year-specific information. WARNING This endpoint is currently
	 * under development and may change at any time.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventPredictions($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/predictions", $headers, $full_response);
	}

	/**
	 * Gets a list of team rankings for the Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventRankings($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/rankings", $headers, $full_response);
	}

	/**
	 * Gets a list of team rankings for the Event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventDistrictPoints($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/district_points", $headers, $full_response);
	}

	/**
	 * Gets a list of Team objects that competed in the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventTeams($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/teams", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of Team objects that competed in the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventTeamsSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/teams/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of Team keys that competed in the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventTeamsKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/teams/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of matches for the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventMatches($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/matches", $headers, $full_response);
	}

	/**
	 * Gets a short-form list of matches for the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventMatchesSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/matches/simple", $headers, $full_response);
	}

	/**
	 * Gets a list of match keys for the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventMatchesKeys($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/matches/keys", $headers, $full_response);
	}

	/**
	 * Gets a list of awards from the given event.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param event_key: String
	 *                                          TBA event key with the format yyyy[EVENT_CODE],
	 *                                          where yyyy is the year, and EVENT_CODE is the
	 *                                          event code of the event.
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getEventAwards($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->event_base_params, $request_parameters);
		return $this->call("event/{$request_parameters['event_key']}/awards", $headers, $full_response);
	}

	/*----------------------------------------------------------------------
	---------------------------------Match----------------------------------
	----------------------------------------------------------------------*/

	/**
	 * Gets a Match object for the given match key.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param match_key: String
	 *                                          Key for the match you want to request data for
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getMatch($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->match_base_params, $request_parameters);
		return $this->call("match/{$request_parameters['match_key']}", $headers, $full_response);
	}

	/**
	 * Gets a short-form Match object for the given match key.
	 * @param  {[Array]}   $request_parameters  - Options for the URL
	 *                                          @param match_key: String
	 *                                          Key for the match you want to request data for
	 * @return {[JSON]}            				- Response from the request
	 */
	public function getMatchSimple($request_parameters, $headers = [], $full_response = false) {
		$request_parameters = array_merge($this->match_base_params, $request_parameters);
		return $this->call("match/{$request_parameters['match_key']}", $headers, $full_response);
	}
}
