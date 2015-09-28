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
 * Adds a new student to the database, so data can be kept about them
 *
 * The new students details are posted to this page via an AJAX call. Once
 * the student has been added, the ID for them in the database is returned.
 * If there was an error when creating the database row, -1 is returned
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

// Checking to make sure that there was something posted in the request
if (isset($_POST['forename'], $_POST['surname']) &&
	!empty($_POST['forename'] && !empty($_POST['surname']))) {
	// Cleaning up any post requests that are sent
	$forename = $databaseConnection->real_escape_string($_POST['forename']);
	$surname = $databaseConnection->real_escape_string($_POST['surname']);
	
	// Creating the SQL INSERT statement
	$sql = "INSERT INTO tbl_students (StudentForename, StudentSurname) VALUES ('$forename', '$surname')";
	$insertStatement = $databaseConnection->prepare($sql);
	
	$insertStatement->execute();
	
	echo $insertStatement->insert_id;
} else {
	// There was nothing sent in the POST request, so return -1
	echo "-1";
}

// Closing the connection to the database
dbClose($databaseConnection);
?>