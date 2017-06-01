<?php

    /**
     * This script is used to determine the turnaround time that a team will
     * see at a given event. This script will tell you the number of matches
     * that a team will sit out before their next match, as well as the estimated
     * time until their next match
     *
     * To use this script copy and paste it into a directly alongside the TBARequest.php
     * file. You must also change the $tbaRequest = new tbaAPI\TBARequest(); found on line 36
     * to your specific credentials. See the project ReadMe for help.
     */

    require_once __DIR__ . '/../../vendor/autoload.php';
    use TheBlueAlliance_PHPWrapper\TBARequest;

    // This chunk of the code is what handles the evnet that we want to read out of
    // An alternative would be commenting this section out and then hardcoding the
    // target_event and the target_team
    $target_event = null;
    $target_team = null;
    if (isset($argv[1])) {
        $target_event = $argv[1];
    } else {
        print_r(
            "Please provide an event as an argument. The proper execution for this script is \n" .
            "php team-match-turnaround.php {event_code} {team_number}"
        );
        die();
    }

    if (isset($argv[2])) {
        $target_team = $argv[2];
    } else {
        print_r(
            "Please provide an event as an argument. The proper execution for this script is \n" .
            "php team-match-turnaround.php {event_code} {team_number}"
        );
        die();
    }

    // Initialize the Library with the required information
    $tbaRequest = new TBARequest();

    // Retrieve all of the matches that are scheduled to take place at a given
    // event
    $matches = $tbaRequest->getEventMatches(['event_key' => $target_event]);

    // An array of matches that the team took part in. The reason why we have
    // to store them like this is becuase the API returns the matches in
    // the wrong order. So we build an array of all the target matches and then
    // sort it.
    $target_matches = [];

    foreach ($matches as $match) {
        foreach ($match->alliances as $alliance_colour => $alliance) {
            foreach ($alliance->teams as $key => $team) {
                if ($team == $target_team) {
                    $target_matches[] = $match;

                    // Skip the rest of this match iteration. We already know that
                    // this is a target match so we can save some time by skipping
                    // any additional iterations we may have to do
                    continue 3;
                }
            }
        }
    }

    // Now that we have found all of the matches we can sort the array
    // to ensure that they are in the proper order (by time)
    usort($target_matches, function($first_value, $second_value) {

        // If the first match we are comparing occurred before the second match
        // we can return a 0. This will ensure that we are properly ordering everything
        return ($first_value->time <= $second_value->time) ? 0 : 1;
    });

    // This variable is used becuase we use the counted matches twice. One of those
    // counts occur inside the for statement. We save a ton of computations by keeping
    // this variable above
    $match_count = count($target_matches);

    // Iterate over each of the matches that we have stored. We are going to output
    // the information for each of them. We use a for statement here instead of a
    // foreach becuase we need to draw comparisons against the next match in the
    // array
    for ($i = 0; $i < $match_count; $i++) {

        // A shorthand reference to the current match that we are viewing
        $current_iteration_match = $target_matches[$i];

        // These variables are what we use for the comparisons. We default them
        // as null so that we can tell if we need to show the information below.
        $next_iteration_match = null;
        $matches_between = null;
        $time_between = null;

        // If the match isn't the last one in the array then we can draw conclusions
        // for the time until next match / number of matches between the current match
        // and the next one
        if ($i < $match_count - 1) {

            // A shorthand reference to the next match in the iteration. We are going
            // to compare against this match
            $next_iteration_match = $target_matches[$i + 1];
            $matches_between = $next_iteration_match->match_number - $current_iteration_match->match_number;

            // To figure out how much time is between two dates we can compare
            // the datetimes. Using some math on the period of time returned
            // by date_diff we can determine the minutes between matches
            $current_iteration_match_date = new DateTime('@' . $current_iteration_match->time);
            $next_iteration_match_date = new DateTime('@' . $next_iteration_match->time);

            $date_difference = date_diff($current_iteration_match_date, $next_iteration_match_date);
            $difference = (($date_difference->y * 365.25 + $date_difference->m * 30 + $date_difference->d) * 24 + $date_difference->h) * 60 + $date_difference->i + $date_difference->s/60;

            // Now that we have the difference between two matches in minutes
            // we can make a bit of a prettier string. We do this by splitting
            // difference string into X hours and Y minutes
            // The minutes can be calculcated by finding the remaining minutes
            // after dividing the minute_difference by 60. The / 60 will find
            // the hours. The remaining time will be minutes outside hours
            $minute_difference = $difference % 60;
            $minute_verbage = "minutes";
            if ($minute_difference === 1) {
                $minute_verbage = "minute";
            }

            $output_string = "{$minute_difference} {$minute_verbage}";
            if ($difference > 60) {

                // If the difference was > 60 then we have more than 1 hour
                // until our next match. We can build the nicer string with this
                $hour_difference = floor($difference / 60);

                $hour_verbage = "hour";
                if ($hour_difference > 1) {
                    $hour_verbage = "hours";
                }

                $output_string = "{$hour_difference} {$hour_verbage} and {$minute_difference} {$minute_verbage}";
            }
        }

        // The match number is the main information that we want to show. We will
        // ALWAYS have this as the team has to play in the matches they are scheduled
        // for
        echo "Match Number: {$current_iteration_match->comp_level}{$current_iteration_match->match_number}\n";

        // This condition is met when the team has more matches left to play.
        // This two things that will result in this condition NOT being met are
        // 1. The match is the final match that the team is playing in
        // 2. The matches wont be shown if the team is progressing from one state to another
        //    I.E from Quarter Finals -> Semi Finals, from Semi Finals -> Finals
        if (!is_null($next_iteration_match)) {
            if ($matches_between > 0) {
                echo "Matches until next: {$matches_between}\n";
            }
            echo "Time until next: {$output_string}\n";
        }

        // This is just a line break so you can easily see the change in matches
        // it can be whatever you want, or commented out.
        echo "----------------------------------------------------------------\n";
    }
