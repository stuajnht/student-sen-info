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
 * Generates the search form so that users can search for people
 *
 * This file is called from AJAX calls to generate a search form with a list
 * of possible students as results, which when clicked load their details
 */

?><div class="mdl-grid wow-overflow-hidden">
	<!-- Search Form -->
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp">
		<div class="mdl-card__title mdl-color--accent mdl-color-text--white">
			<h2 class="mdl-card__title-text">Search</h2>
		</div>
		<div class="mdl-card__supporting-text">
			<form action="#">
				<span class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label search-textfield">
					<input class="mdl-textfield__input" type="text" id="search--search-box" />
					<label class="mdl-textfield__label" for="search--search-box">Search for person</label>
				</span>
				<span class="mdl-spinner mdl-js-spinner" id="search--loading-spinner"></span>
			</form>
		</div>
		<div class="mdl-card__actions" id="search--search-results">
		</div>
	</div>
</div>
<!-- Modal Box -->
<div class="mdl-card mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 modal-box wow fadeIn" id="modal-box--add-student" data-wow-duration="0.5s">
	<div class="mdl-card__title mdl-color--accent mdl-color-text--white" id="modal-box--title-div">
		<h2 class="mdl-card__title-text">Add Student</h2>
	</div>
	<div class="mdl-card__supporting-text modal-supporting-text">
		<form action="#">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="modal-add-forename-div">
				<input class="mdl-textfield__input" type="text" id="modal-add-forename" />
				<label class="mdl-textfield__label" for="modal-title">Forename</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" id="modal-add-surname-div">
				<input class="mdl-textfield__input" type="text" id="modal-add-surname" />
				<label class="mdl-textfield__label" for="modal-title">Surname</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label modal-textfield">
				<textarea class="mdl-textfield__input" type="text" rows= "10" id="modal-message" ></textarea>
				<label class="mdl-textfield__label" for="modal-message">Message</label>
			</div>
		</form>
	</div>
	<div class="mdl-card__actions mdl-card--border">
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" id="modal-box--button-save">
			Save
		</button>
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect pull-right" id="modal-box--buton-close">
			Cancel
		</button>
	</div>
</div>
<script>
	$(document).ready(function() {
		var thread = null;
		
		$('#search--search-box').keyup(function() {
			clearTimeout(thread);
			thread = setTimeout(function() {
				// Making sure that something is typed, to prevent searching the whole database table
				if ($.trim($('#search--search-box').val()).length>=1) {
					$('#search--loading-spinner').addClass('is-active');
					
					var searchQuery = $('#search--search-box').val(),
						url = "search-results.php";
					
					// Send the data using post
					var posting = $.post( url, { query: searchQuery } );
					
					// Put the results in a div
					posting.done(function( data ) {
						$('#search--search-results').html(data);
						
					});
					
					// Removing the spinner active class
					posting.always(function() {
						$('#search--loading-spinner').removeClass('is-active');
					});
				}
			}, 500);
		});
	});
	$( "#modal-box--buton-close" ).click(function() {
		$.modal.close();
	});
</script>