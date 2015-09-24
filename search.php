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
 * of possible students as results, which when clicked load their details
 */

?><div class="mdl-grid wow-overflow-hidden">
	<!-- Student Details -->
	<div class="mdl-cell mdl-card mdl-cell--12-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp">
		<div class="mdl-card__title mdl-color--accent mdl-color-text--white">
			<h2 class="mdl-card__title-text">Search Results</h2>
		</div>
		<div class="mdl-card__supporting-text">
			Student details.
		</div>
	</div>
</div>