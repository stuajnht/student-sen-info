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
 * Loads the message thread for the currently viewed message
 *
 * This file is called from AJAX calls to view the message thread
 * about a particular student's message
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

// Sanitising all POSTS to this page
$sessionID = $databaseConnection->real_escape_string($_POST['cookie']);
$messageID = $databaseConnection->real_escape_string($_POST['messageID']);

// Generating a list of comments relevant to this message thread
// and displaying them for the user to see
$sqlMessageThread = "SELECT * FROM `sen_info`.`tbl_comments` WHERE (MessageID = ".$messageID.")";
$queryResultMessageThread = dbSelect($sqlMessageThread, $databaseConnection);

if (dbSelectCountRows($queryResultMessageThread) > 0) {
	foreach (dbSelectGetRows($queryResultMessageThread) as $message) {
		// Getting the name of the staff member who wrote the comment
		$sqlStaffFullName = "SELECT StaffForename, StaffSurname FROM `sen_info`.`tbl_staff` WHERE (StaffUsername = '".$message['StaffUsername']."')";
		$queryResultStaffFullname = dbSelect($sqlStaffFullName, $databaseConnection);
		$tableRows = dbSelectGetRows($queryResultStaffFullname);
		$staffForename = $tableRows[0]['StaffForename'];
		$staffSurname = $tableRows[0]['StaffSurname'];
		$staffFullName = $staffForename . " " . $staffSurname;
		
		// Creating the message thread HTML code, to pass back to the AJAX call
		echo '';
	}
}

// Closing the connection to the database
dbClose($databaseConnection);
?>