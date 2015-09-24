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

/**
 * All database SELECT queries should be passed through here
 *
 * The relevant page should generate a fully formatted and sanitised
 * SQL query, which is then executed by this function. The results
 * will be passed back as a MySQLi object, which can then be accessed
 * via dbSelectGetArray or dbSelectGetRow, or the rows counted via
 * dbSelectCountRows
 *
 * @see dbSelectGetRows
 * @see dbSelectGetRow
 * @see dbSelectCountRows
 * @param string $sql The full sanitised SQL query
 * @param mixed $connection The connection to the database
 * @return mixed An object to the SQL result, or null if it failed
 */
function dbSelect($sql, $connection) {
	$queryResult = $connection->query($sql);
	
	if ($queryResult === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $connection->error, E_USER_ERROR);
		return null;
	} else {
		return $queryResult;
	}
}

/**
 * Counts the number of rows returned from the database SELECT query
 *
 * @see dbSelect
 * @see dbSelectGetRows
 * @see dbSelectGetRow
 * @param mixed $queryResult The object that holds the results of a SQL query
 * @return int The number of rows returned from the query
 */
function dbSelectCountRows($queryResult) {
	return $queryResult->num_rows;
}

/**
 * Gets a specific row result from the database SELECT query
 *
 * @see dbSelect
 * @see dbSelectGetRows
 * @see dbSelectCountRows
 * @param mixed $queryResult The object that holds the results of a SQL query
 * @param int $resultRowNumber The row number that we want to get the data from
 * @return array The data from the selected row
 */
function dbSelectGetRow($queryResult, $resultRowNumber = 0) {
	$queryResult->data_seek($resultRowNumber);
	return $queryResult->fetch_array(MYSQLI_ASSOC);
}

/**
 * Gets all rows returned from the result of the database SELECT query
 *
 * @see dbSelect
 * @see dbSelectGetRow
 * @see dbSelectCountRows
 * @param mixed $queryResult The object that holds the results of a SQL query
 * @return array The data from the selected rows
 */
function dbSelectGetRows($queryResult) {
	$allRows = array();
	
	$totalRows = dbSelectCountRows($queryResult);
	
	for ($row = 0; $row <= ($totalRows - 1); $row++) {
		$allRows[] = dbSelectGetRow($queryResult, $row);
	}
	
	return $allRows;
}
?>