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
 * This config file holds the configuration information for this site to run.
 * Make sure that all needed information is filled in, and is renamed to config.php
 */

// Seeing if the script is being called from another webpage, or directly
defined('RUNNING_FROM') || die('<h2>You cannot access this page directly.</h2>');

// Database related information
$CFG['DBHost'] = '';
$CFG['DBPort'] = '';
$CFG['DBUser'] = '';
$CFG['DBPass'] = '';
$CFG['DBName'] = '';

// LDAP server logon information
$CFG['LDAP_Enabled'] = false;
$CFG['LDAP_Server'] = 'dc.example.com';
$CFG['LDAP_UPN'] = 'example.com';
$CFG['LDAP_DN'] = 'DC=example,DC=com';
$CFG['LDAP_StaffGroups'] = ['All Staff', 'Staff Full Access'];

// Student meta details (year group ranges, forms, houses)
$CFG['StudentMeta_YearGroupStart'] = 7;
$CFG['StudentMeta_YearGroupEnd'] = 11;
$CFG['StudentMeta_Houses'] = ['Purple', 'Red', 'Green', 'Yellow'];
$CFG['StudentMeta_Forms'] = ['Purple', 'Red', 'Green', 'Yellow'];
?>
