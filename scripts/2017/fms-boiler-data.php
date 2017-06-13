<?php

    /*
     * This script is used to compile information from the FMS system. Currently
     * it only pulls informaton about the balls scored in the boiler. However it can
     * be modified very easily to include more. You can add the key match information in the
     * foreach statement found at the top of the iteration. Additional match details
     * can we added in the iteration found closer to the bottom that loops over
     * score_breakdown.
     */

    require_once __DIR__ . '/../../vendor/autoload.php';
    use TheBlueAlliance_PHPWrapper\TBARequest;

    // This chunk of the code is what handles the evnet that we want to read out of
    // An alternative would be commenting this section out and then hardcoding the
    // target_event and the target_team
    $target_event = null;
    if (isset($argv[1])) {
        $target_event = $argv[1];
    } else {
        print_r(
            "Please provide an event as an argument. The proper execution for this script is \n" .
            "php fms-boiler-data.php {event_code}"
        );
        die();
    }

    // Initialize the Library with the required information
    $tbaRequest = new TBARequest();

    // Fetch all the matches from the event that we want to look at
    $matches = $tbaRequest->getEventMatches(['event_key' => $target_event]);

    // TBA doesn't always return the data in proper order. We sort here to ensure
    // that the array is sorted by match number
    usort($matches, function($first_match, $second_match) {
        return $second_match->match_number < $first_match->match_number;
    });

    // Container that we are going to use for our output
    $export_rows = [];

    foreach ($matches as $key => $match) {

        // Since this script is setup to output 2 rows per match (1 for red alliance,
        // 1 for blue alliance) we have to store out data seperately. These
        // Rows will contain the match data for each row
        $blue_data = [];
        $red_data = [];

        // Step one is to add the match number to the array. Any additional columns
        // that you want can be added to the array below
        foreach ($match as $match_key => $match_datum) {
            if (in_array($match_key, ['match_number'])) {
                $red_data[$match_key] = $match_datum;
                $blue_data[$match_key] = $match_datum;
            }
        }

        // Now that we have the preliminary data that we wanted at the front
        // of our CSV, we can start adding the rest of the information. Step two
        // is to add in the teams that belong to each respective alliance colour
        foreach ($match->alliances as $alliance_colour => $alliance_result) {

            // If the alliance Score is -1 we can skip this iteration becuase the game
            // hasn't been played yet
            if ($alliance_result->score === -1) {
                continue 2;
            }

            // Keep track of the robot position. This will increase as we go through
            // the robot iterations. This will reset back to 1 when we go to the
            // next alliance colour. The robot position is used for the column
            // header
            $robot_position = 1;
            foreach ($alliance_result->team_keys as $alliance_team_number) {

                // Put the data that we want into the proper array
                if ($alliance_colour === 'red') {
                    $red_data[$robot_position] = $alliance_team_number;
                } else {
                    $blue_data[$robot_position] = $alliance_team_number;
                }

                $robot_position++;
            }
        }

        // Now that we have built our array of teams and match information we can
        // start adding the actual score breakdown to the array. Step 3 is to
        // iterate over each of the scores for each alliance and add the datapoints
        // that we want.
        foreach ($match->score_breakdown as $alliance_colour => $alliance_result) {

            foreach ($alliance_result as $alliance_key => $alliance_datum) {

                // The array check below will ensure that we are only retrieving
                // data that we want in our array. It is then split up and put into
                // the appropriate array based on it's colour
                if (in_array($alliance_key, ['autoFuelHigh', 'teleopFuelHigh', 'autoFuelLow', 'teleopFuelLow'])) {
                    if ($alliance_colour === 'red') {
                        $red_data[$alliance_key] = $alliance_datum;
                    } else {
                        $blue_data[$alliance_key] = $alliance_datum;
                    }
                }
            }
        }

        // Our Red alliance and Blue alliance data is properly built now. We can
        // add it to our parent container. This will be used when generating the CSV
        $export_rows[] = $red_data;
        $export_rows[] = $blue_data;
    }

    // Step one is to determine what our header row is going to be. This can be done
    // by iterating over our first result set and grabbing the KEYS from the JSON
    // object. We add them to an array and then call the fputcsv function to add
    // them to the CSV as if they were a normal row
    $headers = [];
    foreach ($export_rows[0] as $header => $value) {
        $headers[] = $header;
    }

    // Step one is to open the file path that we want to use. This will create the
    // CSV if it doesn't already exist
    $file_pointer = fopen("fms-boiler-data-{$target_event}.csv", 'w');

    // Step two is to add our headers to the CSV that we just opened
    fputcsv($file_pointer, $headers);

    // Step three is to iterate over the data that we want to input and do so
    foreach($export_rows as $export_row) {
        fputcsv($file_pointer, $export_row);
    }

    // Step four is to close the pointer
    fclose($file_pointer);
