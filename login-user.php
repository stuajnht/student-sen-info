<?php
/**
 * This file is part of student-sen-info.
 *
 * student-sen-info is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * student-sen-info is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with student-sen-info.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Jonathan Hart
 */

/**
 * Checks the login information with the database and sees if the user is allowed
 * to log in to the website
 *
 * This file is called from AJAX calls to check the session cookie on the first page
 * load, or with a username and password that needs to be checked against the allowed
 * users from the database
 */

// Setting up the define RUNNING_FROM, so it is known if the website is being
// accessed in the correct manner
define('RUNNING_FROM', 'ajax');

// Checking to see if the config.php file exists
if (!file_exists('./config.php')) {
	// The config file wasn't found, so quit with an error message
	die('<h2>The config file was not found. Contact your network admin.</h2>');
}

// Getting any settings from the config file
require('./config.php');

// Loading the functions file
require('./functions.php');

// Connecting to the database and saving the connection to it for use later
$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);

// Seeing if we are using a cookie to log in or a username and password
if (isset($_POST['cookie'])) {
	// Sanitising the cookie
    $cookie = $databaseConnection->real_escape_string($_POST['cookie']);
	
	// Generating the search query and running it
	// Note: searchTerms[0] should be the forename, searchTerms[1] the surname
	$sql = "SELECT * FROM `sen_info`.`tbl_sessions` WHERE (SessionID = '$cookie')";
	$queryResult = dbSelect($sql, $databaseConnection);
	
	// Seeing if any results were found
	if (dbSelectCountRows($queryResult) > 0) {
		// Checking to make sure that the session hasn't expired
		$tableRows = dbSelectGetRows($queryResult);
		
		foreach ($tableRows as $row) {
			if ($row['Expires'] > date("Y-m-d H:i:s")) {
				// We can successfully log the user in
				echo "success";
			}
		}
	}
} else {
	// Seeing if there wasn't a username and/or password passed to this file
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		
	} else {
		// There was no username and/or password entered, so let the user know
		echo "The username and / or password is empty";
	}
}

// Closing the connection to the database
dbClose($databaseConnection);
?>