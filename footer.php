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
<script>new WOW().init();</script>
<script>
	// Controlling the search form being shown
	$(document).ready( "#button--show-search" ).click(function() {
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
				}
			}
			xmlhttp.open("GET","search.php",true);
			xmlhttp.send();
		});
	});
</script>
</body>
</html>