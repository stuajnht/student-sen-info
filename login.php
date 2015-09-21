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

// Seeing if the script is being called from another webpage, or directly
defined('RUNNING_FROM') || die('<h2>You cannot access this page directly.</h2>');

?>