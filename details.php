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

/*
 * The individual student details template page, which is filled in via AJAX
 *
 * This file holds the main template for the details of the student, with most
 * of the information being filled in through AJAX calls
 */

/**
 * Sets meta information about the student
 *
 * Collects any meta information for the student from the meta database table, so that it can
 * be shown on the box at the top of the window. This information is stored in an array, which
 * can be accessed as and when by the getMeta function
 *
 * @see getMeta
 * @param int $studentID The ID of the student passed to this file
 * @param mixed $databaseConnection A link to the current database connection
 * @returns array An array of student meta information
 */
function setMeta($studentID, $databaseConnection) {
	// Array to hold the information about the student, which is returned when the function ends
	$metaInformation = array();
	
	// Making sure that there is an ID for the student passed
	if (!empty($studentID)) {
		// Sanitising the query
		$studentID = $databaseConnection->real_escape_string($studentID);
		$metaInformation["studentID"] = $studentID;
		
		// Getting the name of the student
		$sqlStudentName = "SELECT StudentForename, StudentSurname FROM `sen_info`.`tbl_students` WHERE (studentID = $studentID)";
		$queryResultStudentName = dbSelect($sqlStudentName, $databaseConnection);
		
		// Seeing if any results were found, and filling in the meta information array
		if (dbSelectCountRows($queryResultStudentName) > 0) {
			foreach (dbSelectGetRows($queryResultStudentName) as $row) {
				$metaInformation["studentForename"] = $row['StudentForename'];
				$metaInformation["studentSurname"] = $row['StudentSurname'];
			}
		}
		
		// Getting additional meta information about the student
		$sqlStudentMeta = "SELECT * FROM `sen_info`.`tbl_student_meta` WHERE (studentID = $studentID)";
		$queryResultStudentMeta = dbSelect($sqlStudentMeta, $databaseConnection);
		
		// Seeing if any results were found, and filling in the meta information array
		if (dbSelectCountRows($queryResultStudentMeta) > 0) {
			foreach (dbSelectGetRows($queryResultStudentMeta) as $row) {
				$metaInformation["yearGroup"] = $row['YearGroup'];
				$metaInformation["house"] = $row['House'];
				$metaInformation["form"] = $row['Form'];
				$metaInformation["dob"] = $row['DoB'];
				$metaInformation["comment"] = $row['Comment'];
				// Note: Any additional rows added to the meta table should be added here
			}
		}
	}
	
	// Return any meta information that has been collected
	return $metaInformation;
}

/**
 * Gets the value stored for the meta information about a student
 *
 * Returns a string with the value collected from the database about the current
 * student, which was created with setMeta
 *
 * @see setMeta
 * @param string $metaName The name of the meta informtaion that is being requested
 * @param array $metaArray The array that holds the meta information
 * @returns string The value collected from the database
 */
function getMeta($metaName, &$metaArray) {	
	// Returning the value from the array
	return $metaArray[0][$metaName];
}

// Connecting to the database and saving the connection to it for use later
$databaseConnection = dbConnect($CFG['DBHost'], $CFG['DBUser'], $CFG['DBPass'], $CFG['DBName']);

// Array to hold the meta information collected about the student
$studentMetaInformation[] = setMeta($_POST['student'], $databaseConnection);
?><div class="mdl-grid wow-overflow-hidden">
	<!-- Student Details -->
	<div class="mdl-cell mdl-card mdl-cell--12-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp">
		<div class="mdl-card__title mdl-color--accent mdl-color-text--white">
			<h2 class="mdl-card__title-text"><?php echo getMeta("studentForename", $studentMetaInformation) . ' ' . getMeta("studentSurname", $studentMetaInformation); ?></h2>
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
			<div class="mdl-grid">
				<div class="mdl-cell mdl-cell--3-col">
					Year Group: <?php echo getMeta("yearGroup", $studentMetaInformation); ?>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					House: <?php echo getMeta("house", $studentMetaInformation); ?>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					Form: <?php echo getMeta("form", $studentMetaInformation); ?>
				</div>
				<div class="mdl-cell mdl-cell--3-col">
					Date of Birth: <?php echo getMeta("dob", $studentMetaInformation); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="mdl-grid wow-overflow-hidden">
	<?php
	/**
	 * Generating the panels that are shown on the page, which are pulled from the
	 * database
	 */

	// Loading the panels that are needed to be shown, and in what order they should
	// be displayed
	$sqlPanels = "SELECT * FROM `sen_info`.`tbl_panels` WHERE (PanelHidden = 0) ORDER BY DisplayOrder";
	$queryResultPanels = dbSelect($sqlPanels, $databaseConnection);

	// The default animation delay for the first panel to be shown
	$animationDelay = 0.2;

	// Array to hold the panel names and colours, to be used for generating the modal
	$panelData = array(array());

	if (dbSelectCountRows($queryResultPanels) > 0) {
		foreach (dbSelectGetRows($queryResultPanels) as $panel) {
			// Increasing the delay in the panels being animated in
			$animationDelay += 0.1;
			
			// Filling in the panel data array
			$panelData[$panel['PanelID'] - 1]['panelID'] = $panel['PanelID'];
			$panelData[$panel['PanelID'] - 1]['panelTitle'] = $panel['PanelTitle'];
			$panelData[$panel['PanelID'] - 1]['colour'] = $panel['Colour'];
			$panelData[$panel['PanelID'] - 1]['textColour'] = $panel['TextColour'];
			$panelData[$panel['PanelID'] - 1]['panelMenuID'] = strtolower(str_replace(" ", "-", $panel['PanelTitle']));
	?>
	<!-- <?php echo $panel['PanelTitle']; ?> -->
	<div class="mdl-cell mdl-card mdl-cell--6-col mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 wow fadeInUp" data-wow-delay="<?php echo $animationDelay; ?>s">
		<div class="mdl-card__title mdl-color-text--<?php echo $panel['TextColour']; ?> colour--<?php echo $panel['Colour']; ?>-200">
			<h2 class="mdl-card__title-text"><?php echo $panel['PanelTitle']; ?></h2>
			<div class="mdl-layout-spacer"></div>
			<button class="mdl-button mdl-js-button mdl-button--icon" id="menu-<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>">
				<i class="material-icons">more_vert</i>
			</button>
			<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="menu-<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>">
				<li class="mdl-menu__item" id="modal-view--<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>"><i class="material-icons">view_day</i> View</li>
				<li class="mdl-menu__item" id="modal-add--<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>"><i class="material-icons">add</i> Add</li>
				<li class="mdl-menu__item" id="modal-complete--<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>"><i class="material-icons">done</i> Complete</li>
				<li class="mdl-menu__item" id="modal-delete--<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>"><i class="material-icons">delete</i> Delete</li>
			</ul>
		</div>
		<div class="mdl-card__supporting-text supporting-text-table-container">
			<table class="mdl-data-table mdl-js-data-table mdl-data-table--selectable supporting-text-table" id="table--<?php echo strtolower(str_replace(" ", "-", $panel['PanelTitle'])); ?>">
				<thead>
					<tr>
						<th class="mdl-data-table__cell--non-numeric">Title</th>
						<th class="mdl-data-table__cell--non-numeric">Staff</th>
						<th class="mdl-data-table__cell--non-numeric">Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Generating a list of messages relevant to this panel and student
					// and displaying them for the user to see and select from
					$sqlMessages = "SELECT * FROM `sen_info`.`tbl_messages` WHERE ((PanelID = ".$panel['PanelID'].") AND (StudentID = ".$databaseConnection->real_escape_string($_POST['student']).") AND (MessageStatus = 0)) ORDER BY MessageDate DESC";
					$queryResultMessages = dbSelect($sqlMessages, $databaseConnection);
					
					if (dbSelectCountRows($queryResultMessages) > 0) {
						foreach (dbSelectGetRows($queryResultMessages) as $message) {
							// Getting the name of the staff member who wrote the comment
							$sqlStaffMember = "SELECT * FROM `sen_info`.`tbl_staff` WHERE (StaffUsername = '".$message['StaffUsername']."')";
							$queryResultStaffMember = dbSelect($sqlStaffMember, $databaseConnection);
							$staffMember = dbSelectGetRows($queryResultStaffMember);
					?>
					<tr id="<?php echo 'panel_'.$panel['PanelID'].'-message_'.$message['MessageID']; ?>">
						<td class="mdl-data-table__cell--non-numeric"><?php echo $message['MessageTitle']; ?></td>
						<td class="mdl-data-table__cell--non-numeric"><?php echo substr($staffMember[0]['StaffForename'], 0, 1) . ". " . $staffMember[0]['StaffSurname']; ?></td>
						<td class="mdl-data-table__cell--non-numeric"><?php echo substr($message['MessageDate'], 0, 10); ?></td>
					</tr>
					<?php
					// End of messages foreach and if statements
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
	// End of panel generation loop and if statement
		}
	}
	?>
</div>

<!-- Modal Box -->
<div class="mdl-card mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 modal-box wow fadeIn" id="modal-box--modal" data-wow-duration="0.5s">
	<div class="mdl-card__title" id="modal-box--title-div">
		<h2 class="mdl-card__title-text" id="modal-box--title-text"></h2>
	</div>
	<div class="mdl-card__supporting-text modal-supporting-text">
		<form action="#">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label modal-textfield">
				<input class="mdl-textfield__input" type="text" id="modal-title" />
				<label class="mdl-textfield__label" for="modal-title">Title</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label modal-textfield">
				<textarea class="mdl-textfield__input" type="text" rows= "10" id="modal-message" ></textarea>
				<label class="mdl-textfield__label" for="modal-message">Message</label>
			</div>
			<input type="hidden" name="modal-student-id" id="modal-student-id" value="<?php echo getMeta("studentID", $studentMetaInformation); ?>">
			<input type="hidden" name="modal-panel-id" id="modal-panel-id" value="">
			<input type="hidden" name="modal-panel-id" id="modal-panel-menu-id" value="">
		</form>
	</div>
	<div class="mdl-card__actions mdl-card--border">
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect" id="modal-box--button-save">
			Save
		</button>
		<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect pull-right" id="modal-box--buton-close">
			Cancel
		</button>
	</div>
</div>
<script>
	<?php
	// Loading the values from the panelData array, so that the buttons on the
	// panels  menu either display the correct modal box information or perform
	// their relavant actions
	foreach($panelData as $panelValues) {
	?>
		$( "#modal-add--<?php echo $panelValues['panelMenuID']; ?>" ).click(function() {
			$( "#modal-box--title-div" ).addClass("colour--<?php echo $panelValues['colour']; ?>-200 mdl-color-text--<?php echo $panelValues['textColour']; ?>");
			$( "#modal-box--button-save" ).addClass("colour--<?php echo $panelValues['colour']; ?>-400");
			$( "#modal-box--title-text" ).text("Add <?php echo $panelValues['panelTitle']; ?>");
			$( "#modal-panel-id" ).val("<?php echo $panelValues['panelID']; ?>");
			$( "#modal-panel-menu-id" ).val("<?php echo strtolower(str_replace(" ", "-", $panelValues['panelMenuID'])); ?>");
			$( "#modal-box--modal" ).modal({persist:true,opacity:60,overlayCss: {backgroundColor:"#000"}});
		});
		var complete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = '';
		$( "#modal-complete--<?php echo $panelValues['panelMenuID']; ?>" ).click(function() {
			$("#table--<?php echo strtolower(str_replace(" ", "-", $panelValues['panelMenuID'])); ?> tr.is-selected").each(function() {
				complete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> += $(this).attr('id') + ',';
			});
			// Marking all selected messages as complete
			var markComplete<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = $.post( 'details-complete.php', { messages: complete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> } );
			
			// Updating the relevant table rows
			markComplete<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?>.done(function( data ) {
				if (data == 'success') {
					$.each(complete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?>.split(','), function(index, trID) {
						$('#table--<?php echo strtolower(str_replace(" ", "-", $panelValues['panelMenuID'])); ?> tr#'+trID).remove();
					});
				}
				// Emptying the list of selected table rows
				complete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = '';
				// Updating the DOM so that all MDL elements get updated
				componentHandler.upgradeDom();
			});
		});
		var delete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = '';
		$( "#modal-delete--<?php echo $panelValues['panelMenuID']; ?>" ).click(function() {
			$("#table--<?php echo strtolower(str_replace(" ", "-", $panelValues['panelMenuID'])); ?> tr.is-selected").each(function() {
				delete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> += $(this).attr('id') + ',';
			});
			// Marking all selected messages as deleted
			var markDeleted<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = $.post( 'details-delete.php', { messages: delete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> } );
			
			// Updating the relevant table rows
			markDeleted<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?>.done(function( data ) {
				if (data == 'success') {
					$.each(delete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?>.split(','), function(index, trID) {
						$('#table--<?php echo strtolower(str_replace(" ", "-", $panelValues['panelMenuID'])); ?> tr#'+trID).remove();
					});
				}
				// Emptying the list of selected table rows
				delete_<?php echo strtolower(str_replace(" ", "_", $panelValues['panelTitle'])); ?> = '';
				// Updating the DOM so that all MDL elements get updated
				componentHandler.upgradeDom();
			});
		});
	<?php
	// End foreach loop to generate the panel menu buttons code
	}
	?>
	$( "#modal-box--button-save" ).click(function() {
		// Posting the new message about the student
		var addNewMessage = $.post( 'details-add.php', { cookie: $.cookie("sessionID"), title: $('#modal-title').val(), message: $('#modal-message').val(), studentID: $('#modal-student-id').val(), panelID: $('#modal-panel-id').val() } );
		
		// Updating the relevant tables with the new message
		addNewMessage.done(function( data ) {
			// Adding the new row to the top of the table. The HTML has been generated
			// by the details-add.php file
			$(data).prependTo("#table--"+ $('#modal-panel-menu-id').val() +" > tbody");
			
			// Closing the modal
			$.modal.close();
			$( "#modal-box--title-div" ).removeClass("colour--purple-200 colour--light-green-200 colour--orange-200 colour--red-200 mdl-color-text--white mdl-color-text--grey-800");
			$( "#modal-box--button-save" ).removeClass("colour--purple-400 colour--light-green-400 colour--orange-400 colour--red-400");
			// Updating the DOM so that all MDL elements get updated
			componentHandler.upgradeDom();
		});
	});
	$( "#modal-box--buton-close" ).click(function() {
		$.modal.close();
		$( "#modal-box--title-div" ).removeClass("colour--purple-200 colour--light-green-200 colour--orange-200 colour--red-200 mdl-color-text--white mdl-color-text--grey-800");
		$( "#modal-box--button-save" ).removeClass("colour--purple-400 colour--light-green-400 colour--orange-400 colour--red-400");
	});
</script>