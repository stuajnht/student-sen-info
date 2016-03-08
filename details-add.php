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
 * Adds a new message thread to the relevant panels
 *
 * This file is called from AJAX calls to add a new message thread
 * about a particular student
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
$messageTitle = $databaseConnection->real_escape_string($_POST['title']);
$messageBody = $databaseConnection->real_escape_string($_POST['message']);
$studentID = $databaseConnection->real_escape_string($_POST['studentID']);
$panelID = $databaseConnection->real_escape_string($_POST['panelID']);
$messageThreadID = $databaseConnection->real_escape_string($_POST['messageThreadID']);

// Getting the time the message was posted at in MySQL datetime format
$messagePosted = date("Y-m-d H:i:s");

// Getting the username for the staff member
$sqlStaffUsername = "SELECT StaffUsername FROM `sen_info`.`tbl_sessions` WHERE (SessionID = '$sessionID')";
$queryResultStaffUsername = dbSelect($sqlStaffUsername, $databaseConnection);
$tableRows = dbSelectGetRows($queryResultStaffUsername);
$staffUsername = $tableRows[0]['StaffUsername'];

// Seeing if this is a new message or one that we are
// appending a comment to
$newMessage = false;
if ($messageThreadID == "new") {
	$newMessage = true;
	// Getting the full staff member name
	$sqlStaffFullName = "SELECT StaffForename, StaffSurname FROM `sen_info`.`tbl_staff` WHERE (StaffUsername = '$staffUsername')";
	$queryResultStaffFullname = dbSelect($sqlStaffFullName, $databaseConnection);
	$tableRows = dbSelectGetRows($queryResultStaffFullname);
	$staffForename = $tableRows[0]['StaffForename'];
	$staffSurname = $tableRows[0]['StaffSurname'];

	// Adding the message title to tbl_messages
	$sqlInsertMessage = "INSERT INTO `sen_info`.`tbl_messages` (`MessageTitle`, `StudentID`, `StaffUsername`, `MessageDate`, `MessageStatus`, `PanelID`) VALUES ('$messageTitle', $studentID, '$staffUsername', '$messagePosted', 0, $panelID);";
	$insertResultMessage = dbInsert($sqlInsertMessage, $databaseConnection);
	$messageThreadID = dbInsertID($databaseConnection);
}

// Adding the comment to tbl_comments
// Note: $messageThreadID will either be assigned from the
//       POST to this page or when the message is added above
$sqlInsertComment = "INSERT INTO `sen_info`.`tbl_comments` (`Comment`, `MessageID`, `StaffUsername`, `CommentDate`) VALUES ('$messageBody', $messageThreadID, '$staffUsername', '$messagePosted');";
$insertResultComment = dbInsert($sqlInsertComment, $databaseConnection);

// Seeing if a new table row should be sent back, or just a
// success message
if ($newMessage) {
	// Creating a new HTML table row to pass back to the calling AJAX function
	echo '<tr id="panel_'.$panelID.'-message_'.$messageThreadID.'">';
	echo '<td>';
	echo '<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect mdl-data-table__select" for="row['.$messageThreadID.']">';
	echo '<input type="checkbox" id="row['.$messageThreadID.']" class="mdl-checkbox__input" />';
	echo '</label>';
	echo '</td>';
	echo '<td class="mdl-data-table__cell--non-numeric data-table__cell-overflow-ellipsis" id="panel_'.$panelID.'-message_'.$messageThreadID.'-title">'.$messageTitle.'</td>';
	echo '<td class="mdl-data-table__cell--non-numeric">'.substr($staffForename, 0, 1) . ". " . $staffSurname .'</td>';
	echo '<td class="mdl-data-table__cell--non-numeric">'.substr($messagePosted, 0, 10) .'</td>';
	echo '</tr>';
} else {
	echo 'comment-added';
}

// Closing the connection to the database
dbClose($databaseConnection);
?>