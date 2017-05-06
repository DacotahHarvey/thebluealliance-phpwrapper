<?php

    /**
     * This Script is used to compile statistics about a given event.
     * These insights are replicas of those provided by the Blue Alliance
     * for a given week. Note that you can change the output type by commenting
     * out the "Pretty Output" field at the bottom of the script and uncommenting
     * the JSON output
     *
     * To use this script copy and paste it into a directly alongside the TBARequest.php
     * file. You must also change the $tbaRequest = new tbaAPI\TBARequest(); found on line 41
     * to your specific credentials. See the project ReadMe for help.
     *
     * The following statistics are returned from this script
     * - Total Alliances Competed
     * - Average Red Score
     * - Average Blue Score
     * - Average Combined Score
     * - % Chance to see Four Rotors Per Alliance
     * - % Chance to see 40 kPa Per Alliance
     * - % Chance to see all 3 Robots Ready for Takeoff Per Alliance
     * - % Chance to see Four Rotors Per match
     * - % Chance to see 40 kPa per Match
     * - % Chance to see all 6 Robots Ready for Takeoff Per Match
     */

    require_once __DIR__ . '/../../vendor/autoload.php';
    use TheBlueAlliance_PHPWrapper\TBARequest;

    // This chunk of the code is what handles the evnet that we want to read out of
    // An alternative would be commenting this section out and then hardcoding the
    // event into the code on line 48 (look for instances of $target_event_code)
    $target_event_code = null;
    if (isset($argv[1])) {
        $target_event_code = $argv[1];
    } else {
        print_r(
            "Please provide an event as an argument. The proper execution for this script is \n" .
            "php statistics_per_event.php {event_code}"
        );
        die();
    }

    // Initialize the Library with the required information
    $tbaRequest = new tbaAPI\TBARequest();

    // This array contains all of the items that we are going to keep track of that
    // relate to each alliance. For example if 1 match was played and each alliance
    // had 4 rotors turning, then you would have a '2' in the 'alliances_with_4_rotor'
    // category
    $alliance_data_container = [
        'alliances_with_4_rotor' => 0,
        'alliances_with_2_rotor_auto' => 0,
        'alliances_with_40_kpa' => 0,
        'alliances_with_40_kpa_auto' => 0,
        'alliances_with_40_kpa_teleop' => 0,
        'alliances_with_all_robots_ready_for_takeoff' => 0,
        'alliance_cumulative_scores' => [
            'blue' => 0,
            'red' => 0
        ],
    ];

    // This array contains all of the items that we are going to keep track of that
    // relate to the match as a whole. For example if 1 match was played and the
    // Blue Alliance scored 100 while the Red Alliance scored 120, the match_count
    // would be '1' while the match_cumulative_score would be '220'
    $match_data_container = [
        'match_count' => 0,
        'match_cumulative_score' => 0,
        'match_with_4_rotors' => 0,
        'match_with_40_kpa' => 0,
        'match_with_all_robots_ready_for_takeoff' => 0,
    ];

    // Fetch all of the events that we want to fetch for a given year
    $matches = $tbaRequest->getEventMatches(['event_key' => $target_event_code]);

    // Iterate over each of the matches that we found in our request. This is where
    // we will populate the $alliance_data_container and the match_data_container
    foreach ($matches as $match) {

        // The match data that is returned is split into two allainces. The first
        // step is to iterate over those alliances to determine some of the basic
        // information about the score
        foreach ($match->alliances as $alliance_colour => $alliance_result) {

            // If the alliance Score is -1 we can skip this iteration becuase the game
            // hasn't been played yet
            if ($alliance_result->score === -1) {
                continue 2;
            }

            $alliance_data_container['alliance_cumulative_scores'][$alliance_colour] += $alliance_result->score;
            $match_data_container['match_cumulative_score'] += $alliance_result->score;
        }

        // Increment the total number of matches so we can find the average score
        // at the end. This is done here becuase we filter out unplayed matches
        // in the alliance iteration above
        $match_data_container['match_count']++;

        // These variables are used to keep track of items that we keep track
        // of on a match level. For example if the first alliance we check had
        // 40kPa then we would ignore it for the second alliance. This ensures
        // that it only gets counted once per match. The other variables work
        // in a similar fashion
        $first_alliance_had_all_robots_ready = false;
        $kpa_counted = false;
        $rotor_counted = false;

        // Iterate over each of the score breakdowns that are provided. This will give
        // us detailed information about how each of the alliances performed
        foreach ($match->score_breakdown as $alliance_colour => $alliance_result) {

            foreach ($alliance_result as $alliance_key => $alliance_datum) {

                // The switch below will help us filter and find the events that
                // we are looking for. Each individual case has it's own criteria
                // that we check to ensure we have valid datum
                switch ($alliance_key) {
                    case 'rotor4Engaged':

                        // If the $alliance_datum variable is considered true then
                        // 4 rotors were engaged by the alliance that we are checking
                        if ($alliance_datum) {
                            $alliance_data_container['alliances_with_4_rotor']++;

                            // If the rotor wasn't already counted towards out match
                            // total then we will add it. This occurs when the
                            // second alliance checked gets 4 rotors but the first did not
                            if (!$rotor_counted) {
                                $match_data_container['match_with_4_rotors']++;
                                $rotor_counted = true;
                            }
                        }
                    break;

                    case 'rotor2Auto':

                        // If the $alliance_datum variable is considered true then
                        // the alliance achieved 2 rotors turning in their Auto period
                        if ($alliance_datum) {
                            $alliance_data_container['alliances_with_2_rotor_auto']++;
                        }
                    break;

                    case 'kPaRankingPointAchieved':

                        // If the $alliance_datum variable is considered true then
                        // the alliance achieved 40 kPa at some point during their match
                        if ($alliance_datum) {
                            $alliance_data_container['alliances_with_40_kpa']++;

                            // If the kPa wasn't already counted towards out match
                            // total then we will add it. This occurs when the
                            // second alliance checked gets 40 kPa but the first did not
                            if (!$kpa_counted) {
                                $match_data_container['match_with_40_kpa']++;
                                $kpa_counted = true;
                            }
                        }
                    break;

                    case 'autoFuelHigh':

                        // If the alliance achieved more than 40 kPa in their autonomous
                        // period then we increment this count
                        if ($alliance_datum >= 40) {
                            $alliance_data_container['alliances_with_40_kpa_auto']++;
                        }
                    break;

                    case 'teleopFuelHigh':

                        // If the alliances achieved more than 40 kPa in their teleop
                        // period then we increment this count
                        if ($alliance_datum >= 40) {
                            $alliance_data_container['alliances_with_40_kpa_teleop']++;
                        }
                    break;

                    case 'teleopTakeoffPoints':

                        // If the alliance datum was higher than 150 then all three
                        // of the robotos on an alliance performed a successful climb
                        if ($alliance_datum === 150) {
                            $alliance_data_container['alliances_with_all_robots_ready_for_takeoff']++;

                            // If the last alliance we checked also had 3 robots climbing
                            // then we can increment the count. This will ensure that
                            // we only count the match when both robots has 3 successful hangs.
                            // If the alliance had 3 successful hangs but the previous one
                            // didn't then we flip the variable for the next iteration.
                            // This is safe to do since there will only ever be 2
                            // alliances playing so we can never get any false positives
                            if ($first_alliance_had_all_robots_ready) {
                                $match_data_container['match_with_all_robots_ready_for_takeoff']++;
                            } else {
                                $first_alliance_had_all_robots_ready = true;
                            }
                        }
                    break;
                }
            }
        }
    }

    // The first step is to add all of the alliance_data_container information
    // since it is all relevant to us
    foreach ($alliance_data_container as $key => $value) {
        $match_data_container[$key] = $value;
    }

    // The next step is to add the match_data_container data. This involves
    // directly mapping some of the $match_data_container variables as well as
    // perfomring some calculcations to get some derived fields
    $match_data_container['total_alliances_competed'] = $match_data_container['match_count'] * 2;
    $match_data_container['average_red_score'] = round($match_data_container['alliance_cumulative_scores']['red'] / $match_data_container['match_count']);
    $match_data_container['average_blue_score'] = round($match_data_container['alliance_cumulative_scores']['blue'] / $match_data_container['match_count']);
    $match_data_container['average_combined_score'] = round($match_data_container['match_cumulative_score'] / $match_data_container['total_alliances_competed']);
    $match_data_container['chance_to_see_four_rotors_per_alliance'] = round(($match_data_container['alliances_with_4_rotor'] / $match_data_container['total_alliances_competed'] * 100)) . "%";
    $match_data_container['chance_to_see_forty_kpa_per_alliance'] = round(($match_data_container['alliances_with_40_kpa'] / $match_data_container['total_alliances_competed'] * 100)) . "%";
    $match_data_container['chance_to_see_all_ready_for_takeoff_per_alliance'] = round(($match_data_container['alliances_with_all_robots_ready_for_takeoff'] / $match_data_container['total_alliances_competed'] * 100)) . "%";
    $match_data_container['chance_to_see_four_rotors_per_match'] = round(($match_data_container['match_with_4_rotors'] / $match_data_container['match_count'] * 100)) . "%";
    $match_data_container['chance_to_see_fourty_kpa_per_match'] = round(($match_data_container['match_with_40_kpa'] / $match_data_container['match_count'] * 100)) . "%";
    $match_data_container['chance_to_see_all_six_in_match_ready_for_takeoff'] = round(($match_data_container['match_with_all_robots_ready_for_takeoff'] / $match_data_container['match_count'] * 100)) . "%";

    // Now that we have gathered and computed all of our information we can output
    // it for the user to see (commented out by default)
    // echo "\n\nJSON Output:\n";
    // print_r(json_encode($match_data_container));
    echo "\n\nPretty Output:\n";

    // This chunk of the code is a nicer output that you can use to view the data
    // inline. It allows us to see it easier without having to run the data through a
    // JSON formatter
    foreach ($match_data_container as $match_data_key => $match_data_value) {
        if (is_array($match_data_value)) {
            foreach ($match_data_value as $inner_key => $inner_value) {
                print_r($match_data_key . " -> " . $inner_key . ": " . $inner_value);
                echo "\n";
            }

            continue;
        }

        print_r($match_data_key . ": " . $match_data_value);
        echo "\n";
    }
