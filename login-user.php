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

/**
 * Sets the information about the current login session in the database
 * and the cookie sent to the client browser
 *
 * @param string $username The username of the current logged in user
 * @param object $databaseConnection The connection to the database
 * @returns string The session ID that has been created
 */
function setSessionInformation($username, $databaseConnection) {
	// Creating a unique session ID and expiration date
	$sessionID = bin2hex(uniqid('', true));
	$expires = time()+60*60*24;
	
	// Converting the expires time into a MySQL datetime format
	$dbExpirary = date("Y-m-d H:i:s", $expires);
	
	// Setting the cookie
	setcookie('sessionID', $sessionID, $expires, '/');
	
	// Updating the database with this information, so the user
	// can log in from the cookie, and also checks to make sure the
	// user should be able to access the pages complete successfully
	$sql = "INSERT INTO `sen_info`.`tbl_sessions` (`SessionID`, `StaffUsername`, `Expires`, `IPAddress`) VALUES ('$sessionID', '$username', '$dbExpirary', '".$_SERVER['REMOTE_ADDR']."');";
	$insertResult = dbSelect($sql, $databaseConnection);
	
	return $sessionID;
}

// Connecting to the database and saving the connection to it for use later
$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);

// Removing any expired sessions, to prevent the ability to log in with them
// Converting the expires time into a MySQL datetime format
$timeNow = date("Y-m-d H:i:s");
$sqlDelete = "DELETE FROM `sen_info`.`tbl_sessions` WHERE `Expires`<'$timeNow';";
dbDelete($sqlDelete, $databaseConnection);

// Seeing if we are using a cookie to log in or a username and password
if (isset($_POST['cookie'])) {
	// Sanitising the cookie
    $cookie = $databaseConnection->real_escape_string($_POST['cookie']);
	
	// Generating the search query and running it
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
		// Sanitising the username and password
		$username = $databaseConnection->real_escape_string($_POST['username']);
		$password = $databaseConnection->real_escape_string($_POST['password']);
		
		// Generating the search query and running it
		$sql = "SELECT StaffPassword FROM `sen_info`.`tbl_staff` WHERE (StaffUsername = '$username')";
		$queryResult = dbSelect($sql, $databaseConnection);
		
		// Checking to see if there were any rows returned
		if (dbSelectCountRows($queryResult) > 0) {
			// Checking to see if the password typed matches what is in the database
			$tableRows = dbSelectGetRows($queryResult);
			
			if (password_verify($password, $tableRows[0]['StaffPassword'])) {
				// Updating the sessions table and cookie
				setSessionInformation($username, $databaseConnection);
				echo 'success';
			} else {
				echo 'The password is incorrect';
			}
		} else {
			// The username doesn't exist, so let the user know
			echo "The username is incorrect";
		}
	} else {
		// There was no username and/or password entered, so let the user know
		echo "The username and / or password is empty";
	}
}

// Closing the connection to the database
dbClose($databaseConnection);
?>