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
 * Marks all messages passed to this page as deleted in the database
 *
 * This file is called from AJAX calls to update the messages database table
 * to mark the selected messages as deleted in the database
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

// Getting the message ID's passed. If there isn't anything, then we can just
// return 'empty'
if (isset($_POST['messages'])) {
	// Sanitising the query
    $fullMessageString = $databaseConnection->real_escape_string($_POST['messages']);
	
	/**
	 * Splitting the passed message string into a panel/message array, so that the individual messages
	 * can be marked as deleted.
	 */
	// Breaking apart each panel/message from the full string passed to this page
	$fullPanelMessages = explode(',', $fullMessageString);
	
	// Splitting into individual panel/message arrays
	foreach ($fullPanelMessages as $panelMessages) {
		// Ignoring any blank array values (which should be the last one as there
		// is a trailing comma)
		if ($panelMessages != '') {
			// Getting the ID of the message, which will be the last number after the last underscore
			$messageID = substr($panelMessages, strrpos($panelMessages, '_') + 1);
			
			// Generating the update SQL query
			$sql = "UPDATE `sen_info`.`tbl_messages` SET MessageStatus=-1 WHERE MessageID=" . $messageID;
			$updateResult = dbUpdate($sql, $databaseConnection);
		}
	}
		
	// Sending back 'success' so that the calling function knows that it has completed
	// marking the database rows as deleted
	echo 'success';
} else {
	echo 'empty';
}

// Closing the connection to the database
dbClose($databaseConnection);
?>