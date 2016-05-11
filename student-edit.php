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
 * Updates the meta information for a student
 *
 * This file is called from AJAX calls or the add student functions
 * to update the meta table in the database with the student data
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

// Getting the session ID passed. If there isn't anything, then we can just
// return 'empty'
if (isset($_POST['cookie'])) {
	// Sanitising the query
	$studentID = $databaseConnection->real_escape_string($_POST['studentID']);
	$yearGroup = $databaseConnection->real_escape_string($_POST['yearGroup']);
	$house = $databaseConnection->real_escape_string($_POST['house']);
	$form = $databaseConnection->real_escape_string($_POST['form']);
	$dob = $databaseConnection->real_escape_string($_POST['dob']);
	
	// Generating the update SQL query
	$sql = "UPDATE `sen_info`.`tbl_student_meta` SET `YearGroup`='$yearGroup', `House`='$house', `Form`='$form', `DoB`='$dob' WHERE  `StudentID`=" . $studentID;
	$updateResult = dbUpdate($sql, $databaseConnection);
	
	// Sending back 'success' so that the calling function knows that it has completed
	echo 'success';
} else {
	echo 'empty';
}

// Closing the connection to the database
dbClose($databaseConnection);
?>