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
 * Footer page to close all of the HTML code
 */
?></main>
</div>
<script src="//storage.googleapis.com/code.getmdl.io/1.0.2/material.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/animsition/3.5.2/js/jquery.animsition.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/simplemodal/1.4.4/jquery.simplemodal.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script>new WOW().init();</script>
<script>
	$(document).ready(function(){
		// Controlling the search form being shown
		$("#button--show-search").click(function() {
			$('.mdl-layout__content').addClass('animated fadeOut');
			$('.mdl-layout__content').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
				$('.mdl-layout__content').empty();
				$('.mdl-layout__content').removeClass('animated fadeOut');

				if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				} else {// code for IE6, IE5
					xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function() {
					// Seeing what was returned
					if (xmlhttp.readyState==4 && xmlhttp.status!=200) {
						// Any HTTP error results in an error message being shown
						alert('Unable to load the search form. Please try again.');
					}
					if (xmlhttp.readyState==4 && xmlhttp.status==200) {
						// Displaying the results in the div
						result = xmlhttp.responseText;
						//alert(result);
						$('.mdl-layout__content').html(result);
						// Updating the DOM so that all MDL elements get updated
						componentHandler.upgradeDom();
						// Give focus to the search textbox
						$('#search--search-box').focus();
					}
				}
				xmlhttp.open("GET","search.php",true);
				xmlhttp.send();
			});
		});
		
		// Attempting to log in the user when they open the site for the first time
		loginUser(true, false);
	});
</script>
<script>
	// Displaying the details of a student that has been searched for or added
	function showStudent(studentID) {
		// Remove the search form
		$('.mdl-layout__content').addClass('animated fadeOut');
		$('.mdl-layout__content').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
			$('.mdl-layout__content').empty();
			$('.mdl-layout__content').removeClass('animated fadeOut');
			
			// Load the details page with the student information
			var getStudentDetails = $.post( 'details.php', { student: studentID } );
			
			// Displaying the student details in the div
			getStudentDetails.done(function( data ) {
				$('.mdl-layout__content').html(data);
				// Updating the DOM so that all MDL elements get updated
				componentHandler.upgradeDom();
			});
		});
	}
</script>
<script>
	// Attempts to log in the user with the details from the login page or the cookie
	// @param usingCookie bool Should we try to log the user on with the session cookie
	// @param usingForm bool Has the user pressed the log in button from the login page
	function loginUser(usingCookie, usingForm) {
		// Attempt to log in with the cookie value first, otherwise display the login
		// page and wait to call this function again when the user presses the login button
		if (usingCookie) {
			// Sending off an AJAX request with the current session cookie
			var checkLogin = $.post( 'login-user.php', { cookie: $.cookie("sessionID") });
			
			// Seeing if we are able to log the user in successfully and open the search page
			checkLogin.done(function( data ) {
				if (data == 'success') {
					// The user has successfully been able to log in, so show the search page
					// Load the details page with the student information
					var getSearchPage = $.post( 'search.php' );

					// Displaying the search page in the div
					getSearchPage.done(function( data ) {
						$('.mdl-layout__content').html(data);
						// Showing the search and menu buttons
						$('#button--show-search').show();
						$('#hdrbtn').show();
						// Updating the DOM so that all MDL elements get updated
						componentHandler.upgradeDom();
					});
				} else {
					// We haven't been able to log the user in from the cookie, so load the login page
					var getLoginPage = $.post( 'login.php', { runningFrom: 'ajax'} );

					// Displaying the login page in the div
					getLoginPage.done(function( data ) {
						$('.mdl-layout__content').html(data);
						// Updating the DOM so that all MDL elements get updated
						componentHandler.upgradeDom();
					});
				}
			});
		}
		
		// Attempt to log the user in with the information from the login form
		if (usingForm) {
			// Sending off an AJAX request with the users login details
			var checkLogin = $.post( 'login-user.php', { username: $('#username').val(), password: $('#password').val() });
			
			// Seeing if we are able to log the user in successfully and open the search page
			checkLogin.done(function( data ) {
				if (data == 'success') {
					// The user has successfully been able to log in, so show the search page
					// Load the details page with the student information
					var getSearchPage = $.post( 'search.php' );

					// Displaying the search page in the div
					getSearchPage.done(function( data ) {
						$('.mdl-layout__content').html(data);
						// Showing the search and menu buttons
						$('#button--show-search').show();
						$('#hdrbtn').show();
						// Updating the DOM so that all MDL elements get updated
						componentHandler.upgradeDom();
					});
				} else {
					// We haven't been able to log the user in with the details they passed
					// so let them know there was a problem
					$('#login-message').text(data);
					// Updating the DOM so that all MDL elements get updated
					componentHandler.upgradeDom();
				}
			});
		}
	}
</script>
</body>
</html>