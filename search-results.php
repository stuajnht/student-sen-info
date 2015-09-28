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
 * Searches the student database to find a match with what has been typed in
 *
 * This file is called from AJAX calls to generate a search card with a list
 * of possible students as results which are returned as a HTML file
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
 * Generates a button to add a new student
 *
 * If there are no results found for the search terms given,
 * give the user an opportunity to add a new student by clicking
 * on a button, which will open a modal on the search form
 * for them to fill in the required details. This button also shows
 * if there are results found, but it's not the person the user is
 * looking for
 *
 * @param string $forename The forname of the student from the search terms
 * @param string $surname The surname of the student from the search terms
 * @return string The HTML code for displaying a 'new student' button
 */
function addStudentButton($forename = "", $surname = "") {
	$html = '<div class="mdl-layout-spacer"></div>';
	$html .= '<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="search--button-add">';
	$html .= 'Add';
	$html .= '</button>';
	$html .= '<span id="search--add-student-forename" style="display:none;">'.$forename.'</span>';
	
	// If there isn't a difference between the forename and surname, such as
	// only one word was entered in the search, don't include the surname
	if (strcasecmp($forename, $surname) !== 0) {
		$html .= '<span id="search--add-student-surname" style="display:none;">'.$surname.'</span>';
	}
	
	return $html;
}

// Connecting to the database and saving the connection to it for use later
$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);

// Getting the search query passed. If there isn't anything, then we can just
// return 'no results found'
if (isset($_POST['query'])) {
	// Sanitising the query
    $searchQuery = $databaseConnection->real_escape_string($_POST['query']);
	
	// Splitting the search query on spaces, if they exist
	$searchTerms = explode(" ", $searchQuery);
	
	// Seeing if there's anything in searchTerms[1]. If not, make it the same as
	// searchTerms[0], to prevent undefined offset errors.
	if (strpos($searchQuery, ' ') === FALSE) {
		$searchTerms[1] = $searchTerms[0];
	}
	
	$studentResults = array();
	
	// Generating the search query and running it
	// Note: searchTerms[0] should be the forename, searchTerms[1] the surname
	$sql = "SELECT * FROM `sen_info`.`tbl_students` WHERE (studentForename LIKE '%$searchTerms[0]%') OR (studentSurname LIKE '%$searchTerms[1]%')";
	$queryResult = dbSelect($sql, $databaseConnection);
	
	// Seeing if any results were found
	if (dbSelectCountRows($queryResult) > 0) {
		echo "Results found";
	} else {
		echo "No results found";
	}
	
	// Showing the add button, with the name parts filled in
	echo addStudentButton($searchTerms[0], $searchTerms[1]);
} else {
	echo "No results found";
	
	// Showing the add button, without the name parts filled in
	echo addStudentButton();
}

// Closing the connection to the database
dbClose($databaseConnection);
?>