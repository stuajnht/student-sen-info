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
				<span class="mdl-spinner mdl-js-spinner is-active" id="search--loading-spinner"></span>
			</form>
		</div>
		<div class="mdl-card__actions" id="search--search-results">
		</div>
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
					$('#search--results-loading').addClass('is-active');
					if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
						xmlhttp=new XMLHttpRequest();
					} else {// code for IE6, IE5
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
					
					xmlhttp.onreadystatechange=function() {
						// Seeing what was returned
						if (xmlhttp.readyState==4 && xmlhttp.status!=200) {
							// Any HTTP error results in an error message being shown
							alert('AJAX error');
						}
						if (xmlhttp.readyState==4 && xmlhttp.status==200) {
							// Displaying the results in the div
							result = xmlhttp.responseText;
							//alert(result);
							$('#search--search-results').html(result);
							$('#search--results-loading').removeClass('is-active');
						}
					}
					
					xmlhttp.open("POST","search-results.php",true);
					xmlhttp.send("query="+$('#search--search-box').val());
				}
			}, 500);
		});
	});
</script>