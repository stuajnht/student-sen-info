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

/*
 * All functions that need to be used between pages can be stored here, as well
 * as database connections and statements
 */

// Seeing if the script is being called from another webpage, or directly
defined('RUNNING_FROM') || die('<h2>You cannot access this page directly.</h2>');

// Checking to see if the config.php file exists
if (!file_exists('./config.php')) {
	// The config file wasn't found, so quit with an error message
	die('<h2>The config file was not found. Contact your network admin.</h2>');
}

// Getting any settings from the config file
require('./config.php');

/**
 * Connect to the database, and pass the connection information back to the
 * caling function
 *
 * @param string $host The server the database is on, usually $CFG['DBHost']
 * @param string $user The user account to connect to the database with, usually $CFG['DBUser']
 * @param string $pass The password for the given user account, usually $CFG['DBPass']
 * @param string $name The name of the database to use, usually $CFG['DBName']
 * @return mixed A connection to the database or null if it failed
 */
function dbConnect($host, $user, $pass, $name) {
	$connection = new mysqli($host, $user, $pass, $name);
	
	// Check that the connection was successful
	if ($connection->connect_error) {
		die('<h2>The database connection was not successful. Contact your network admin.</h2><p>The error was: '.$connection->connect_error.'</p>');
		return null;
	} else {
		return $connection;
	}
}

/**
 * Closing the connection to the database
 *
 * @param mixed The connection to the database that is to be closed
 */
function dbClose($connection) {
	$connection->close();
}
?>