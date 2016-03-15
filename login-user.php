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
 * Checks the login information with the database and sees if the user is allowed
 * to log in to the website
 *
 * This file is called from AJAX calls to check the session cookie on the first page
 * load, or with a username and password that needs to be checked against the allowed
 * users from the database
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
 * Sets the information about the current login session in the database
 * and the cookie sent to the client browser
 *
 * @param string $username The username of the current logged in user
 * @param object $databaseConnection The connection to the database
 * @returns string The session ID that has been created
 */
function setSessionInformation($username, $databaseConnection) {
	// Creating a unique session ID and expiration date
	$sessionID = bin2hex(openssl_random_pseudo_bytes(32));
	$expires = time()+60*60*24;
	
	// Converting the expires time into a MySQL datetime format
	$dbExpirary = date("Y-m-d H:i:s", $expires);
	
	// Setting the cookie
	setcookie('sessionID', $sessionID, $expires, '/');
	
	// Updating the database with this information, so the user
	// can log in from the cookie, and also checks to make sure the
	// user should be able to access the pages complete successfully
	$sql = "INSERT INTO `sen_info`.`tbl_sessions` (`SessionID`, `StaffUsername`, `Expires`, `IPAddress`) VALUES ('$sessionID', '$username', '$dbExpirary', '".$_SERVER['REMOTE_ADDR']."');";
	$insertResult = dbInsert($sql, $databaseConnection);
	
	return $sessionID;
}

/**
 * Attempts to log the user in using their LDAP user account
 * instead of the password stored in the database
 *
 * If a user hasn't logged into the site before, then attempt
 * to log them in, then create a record for them in the database
 * so that it can be checked again in the future
 *
 * See: https://merchantprotocol.com/3564/user-login-using-ldap-and-php/
 * See: https://samjlevy.com/php-login-script-using-ldap-verify-group-membership/
 * See: https://www.exchangecore.com/blog/how-use-ldap-active-directory-authentication-php/
 *
 * @param string $username The username of the user to try logging on with
 * @param string $password The password of the above named user
 * @param string $ldapServer A reference to the config.php LDAP server address
 * @param string $ldapUPN A reference to the config.php LDAP UPN
 * @param string $ldapDN A reference to the config.php LDAP DN
 * @param bool $createUser If the username can't be found in the database, should an account be created if sucessful login
 */
function ldapLogin($username, $password, $ldapServer, $ldapUPN, $ldapDN, $createUser = false) {
	$adServer = "ldap://" . $ldapServer;
	
	$ldapConnection = ldap_connect($adServer) or die("Could not connect to $ldapServer");
	
	$ldaprdn = $username . '@' . $ldapUPN;
	
	ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
	
	$bind = @ldap_bind($ldapConnection, $ldaprdn, $password);
	
	if ($bind) {
		// Searching to find the current username, to check the
		// groups they are part of
		$filter = "(sAMAccountName=$username)";
		$result = ldap_search($ldapConnection, $ldapDN, $filter);
		ldap_sort($ldapConnection, $result,"sn");
		$info = ldap_get_entries($ldapConnection, $result);
		
		for ($i=0; $i<$info["count"]; $i++) {
			if($info['count'] > 1) break;
			
			echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
			echo '<pre>';
			var_dump($info);
			echo '</pre>';
			$userDn = $info[$i]["distinguishedname"][0]; 
		}
	} else {
		// There was a problem of some sort when attempting to
		// bind with the LDAP server, so print the error message
		echo ldap_error( $ldapConnection );
	}
	
	// Closing any open connections to the LDAP server
	@ldap_close($ldap);
}

// Connecting to the database and saving the connection to it for use later
$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);

// Removing any expired sessions, to prevent the ability to log in with them
// Converting the expires time into a MySQL datetime format
$timeNow = date("Y-m-d H:i:s");
$sqlDelete = "DELETE FROM `sen_info`.`tbl_sessions` WHERE `Expires`<'$timeNow';";
dbDelete($sqlDelete, $databaseConnection);

// Seeing if we are using a cookie to log in or a username and password
if (isset($_POST['cookie'])) {
	// Sanitising the cookie
    $cookie = $databaseConnection->real_escape_string($_POST['cookie']);
	
	// Generating the search query and running it
	$sql = "SELECT * FROM `sen_info`.`tbl_sessions` WHERE (SessionID = '$cookie')";
	$queryResult = dbSelect($sql, $databaseConnection);
	
	// Seeing if any results were found
	if (dbSelectCountRows($queryResult) > 0) {
		// Checking to make sure that the session hasn't expired
		$tableRows = dbSelectGetRows($queryResult);
		
		foreach ($tableRows as $row) {
			if ($row['Expires'] > date("Y-m-d H:i:s")) {
				// We can successfully log the user in
				echo "success";
			}
		}
	}
} else {
	// Seeing if there wasn't a username and/or password passed to this file
	if (!empty($_POST['username']) && !empty($_POST['password'])) {
		// Sanitising the username and password
		$username = $databaseConnection->real_escape_string($_POST['username']);
		$password = $databaseConnection->real_escape_string($_POST['password']);
		
		// Generating the search query and running it
		$sql = "SELECT StaffPassword FROM `sen_info`.`tbl_staff` WHERE (StaffUsername = '$username')";
		$queryResult = dbSelect($sql, $databaseConnection);
		
		// Checking to see if there were any rows returned
		if (dbSelectCountRows($queryResult) > 0) {
			// Checking to see if the password typed matches what is in the database
			$tableRows = dbSelectGetRows($queryResult);
			
			// Seeing if we should try logging the user in with a request
			// to a LDAP server, or just against what is stored in the
			// staff database table
			if (($CFG['LDAP_Enabled']) && ($tableRows[0]['StaffPassword'] == "ldap")) {
				ldapLogin($username, $password, $CFG['LDAP_Server'], $CFG['LDAP_UPN'], $CFG['LDAP_DN'], false);
			} else {
				if (password_verify($password, $tableRows[0]['StaffPassword'])) {
					// Updating the sessions table and cookie
					setSessionInformation($username, $databaseConnection);
					echo 'success';
				} else {
					echo 'The password is incorrect';
				}
			}
		} else {
			// The username doesn't exist, so either attempt to create
			// the new user from a successful LDAP bind, or if it's not
			// enabled, let the user know that the username is incorrect
			if ($CFG['LDAP_Enabled']) {
				ldapLogin($username, $password, $CFG['LDAP_Server'], $CFG['LDAP_UPN'], $CFG['LDAP_DN'], true);
			} else {
				echo "The username is incorrect";
			}
		}
	} else {
		// There was no username and/or password entered, so let the user know
		echo "The username and / or password is empty";
	}
}

// Closing the connection to the database
dbClose($databaseConnection);
?>