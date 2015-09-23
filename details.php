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
 * The individual student details template page, which is filled in via AJAX
 *
 * This file holds the main template for the details of the student, with most
 * of the information being filled in through AJAX calls
 */
?><div class="mdl-grid wow-overflow-hidden">
	<!-- Student Details -->
	<div class="mdl-cell mdl-card mdl-cell--12-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp">
		<div class="mdl-card__title mdl-color--accent mdl-color-text--white">
			<h2 class="mdl-card__title-text">Student Name</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-student-details">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-student-details">
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text">
			Student details.
		</div>
	</div>
</div>
<div class="mdl-grid wow-overflow-hidden">
	<!-- SEN Infomation -->
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp" data-wow-delay="0.3s">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--purple-200">
			<h2 class="mdl-card__title-text">SEN Info</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-sen-info">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-sen-info">
				<li class="mdl-menu__item"><i class="material-icons">add</i> Add</li>
				<li class="mdl-menu__item"><i class="material-icons">done</i> Complete</li>
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text supporting-text-table-container">
			<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable supporting-text-table">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Staff</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- Key Worker -->
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp" data-wow-delay="0.4s">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--light-green-200">
			<h2 class="mdl-card__title-text">Key Worker</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-key-worker">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-key-worker">
				<li class="mdl-menu__item"><i class="material-icons">add</i> Add</li>
				<li class="mdl-menu__item"><i class="material-icons">done</i> Complete</li>
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text supporting-text-table-container">
			<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable supporting-text-table">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Staff</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="mdl-grid wow-overflow-hidden">
	<!-- Pastoral -->
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp" data-wow-delay="0.5s">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--orange-200">
			<h2 class="mdl-card__title-text">Pastoral</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-pastoral">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-pastoral">
				<li class="mdl-menu__item"><i class="material-icons">add</i> Add</li>
				<li class="mdl-menu__item"><i class="material-icons">done</i> Complete</li>
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text supporting-text-table-container">
			<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable supporting-text-table">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Staff</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- Curriculum Overview -->
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp" data-wow-delay="0.6s">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--red-200">
			<h2 class="mdl-card__title-text">Curriculum Overview</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-curriculum-overview">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-curriculum-overview">
				<li class="mdl-menu__item"><i class="material-icons">add</i> Add</li>
				<li class="mdl-menu__item"><i class="material-icons">done</i> Complete</li>
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text supporting-text-table-container">
			<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable supporting-text-table">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Staff</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
					<tr>
						<td class="mdl-data-table__cell--non-numeric">Test Message</td>
						<td class="mdl-data-table__cell--non-numeric">J. Smith</td>
						<td class="mdl-data-table__cell--non-numeric">2015-13-32</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>