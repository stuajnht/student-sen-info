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
 * Form that is displayed to any user if they are not logged in
 *
 * To stop any person accessing information about the students, users
 * need to log in to access the data. This also has the additional
 * benefit of knowing who made what change.
 */

// Checking to make sure that this page is only called from ajax calls
if (isset($_POST['runningFrom'])) {
	if ($_POST['runningFrom'] == 'ajax') {
		define('RUNNING_FROM', 'ajax');
	}
}

// Seeing if the script is being called from another webpage, or directly
defined('RUNNING_FROM') || die('<h2>You cannot access this page directly.</h2>');

// Checking to see if the config.php file exists
if (!file_exists('./config.php')) {
	// The config file wasn't found, so quit with an error message
	die('<h2>The config file was not found. Contact your network admin.</h2>');
}

// Getting any settings from the config file
require('./config.php');

// Loading the functions file
require('./functions.php');

// Seeing if we are using a cookie to log out the user,
// or this is the first login from the user
if (isset($_POST['cookie'])) {
	// Connecting to the database and saving the connection to it for use later
	$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);
	
	// Sanitising the cookie
  $cookie = $databaseConnection->real_escape_string($_POST['cookie']);

	// Removing any sessions, to prevent the ability to log in with them,
	// as the user has requested them to be logged out
	$sqlDelete = "DELETE FROM `sen_info`.`tbl_sessions` WHERE `SessionID`='$cookie';";
	dbDelete($sqlDelete, $databaseConnection);
	
	// Closing the connection to the database
	dbClose($databaseConnection);
}

?><div class="mdl-grid">
	<div class="mdl-cell mdl-cell--4-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	<div class="mdl-cell mdl-cell--4-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 login-cell wow fadeInUp">
		<h4>
			Login
		</h4>
		<span id="login-message">Please log in to access the SEN information</span>
		<form action="#">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="text" id="username" />
				<label class="mdl-textfield__label" for="username">Username</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				<input class="mdl-textfield__input" type="password" id="password" />
				<label class="mdl-textfield__label" for="password">Password</label>
			</div>
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored pull-right" onclick="loginUser(false, true);">
				<i class="material-icons">arrow_forward</i>
			</button>
		</form>
	</div>
</div>