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
 * Index page to load either the login screen or the search (results) page
 *
 * This file loads either the login page if the user is not yet logged in,
 * or presents the search (results) page or student info if the user is
 * logged in.
 */

// Setting up the define RUNNING_FROM, so it is known if the website is being
// accessed in the correct manner
define('RUNNING_FROM', 'web');

// Checking to see if the config.php file exists
if (!file_exists('./config.php')) {
	// The config file wasn't found, so quit with an error message
	die('<h2>The config file was not found. Contact your network admin.</h2>');
}

// Getting any settings from the config file
require('./config.php');

// Load the HTML head section, as this is needed for all users
require('./header.php');

// Load the footer section, as this is needed for all users
require('./footer.php');
?>