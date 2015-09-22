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
?><div class="mdl-grid">
	<!-- Student Details -->
	<div class="mdl-cell mdl-card mdl-cell--12-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800">
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
<div class="mdl-grid">
	<!-- SEN Infomation -->
	<div class="mdl-cell mdl-card mdl-cell--4-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--purple-200">
			<h2 class="mdl-card__title-text">SEN Info</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-sen-info">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-sen-info">
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text">
			Student details.
		</div>
		<div class="mdl-card__actions mdl-card--border">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored pull-right">
				<i class="material-icons">add</i>
		</div>
	</div>
	<!-- Key Worker -->
	<div class="mdl-cell mdl-card mdl-cell--4-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800">
		<div class="mdl-card__title mdl-color-text--grey-800 colour--light-green-200">
			<h2 class="mdl-card__title-text">Key Worker</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-key-worker">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-key-worker">
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text">
			Student details.
		</div>
		<div class="mdl-card__actions mdl-card--border">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored pull-right">
				<i class="material-icons">add</i>
		</div>
	</div>
	<!-- Pastoral -->
	<div class="mdl-cell mdl-card mdl-cell--4-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800">
		<div class="mdl-card__title mdl-color-text--grey-800 color--orange-200">
			<h2 class="mdl-card__title-text">Pastoral</h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-pastoral">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-pastoral">
				<li class="mdl-menu__item"><i class="material-icons">edit</i> Edit</li>
				<li class="mdl-menu__item"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text">
			Student details.
		</div>
		<div class="mdl-card__actions mdl-card--border">
			<button class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored pull-right">
				<i class="material-icons">add</i>
		</div>
	</div>
</div>