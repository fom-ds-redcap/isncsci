<?php
/*
 * Display REDCap header.
 */
require_once APP_PATH_DOCROOT . 'ProjectGeneral/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>REDCap - ISCNSCI Form</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<head>
	<link rel="stylesheet" href="<?php echo $module->getUrl("app.css")?>">
	<link rel="stylesheet" href="<?php echo $module->getUrl("node_modules/jquery-timepicker/jquery.timepicker.css")?>">
	
	<script type="module" src="<?php echo $module->getUrl("app.js")?>"></script>
	<script src="<?php echo $module->getUrl("node_modules/jquery-timepicker/jquery.timepicker.js")?>"></script>
	<script src="<?php echo $module->getUrl("node_modules/jspdf/dist/jspdf.umd.min.js")?>"></script>
	<script src="<?php echo $module->getUrl("node_modules/html2canvas/dist/html2canvas.min.js")?>"></script>
</head>
<body>
	<div id="header">
		<div id="page-actions">
			<div id="actions-container">
				<ul>
					<li id="download"><span> <label> <a href="#">Download</a>
						</label>
					</span></li>
					<li id="calculator"><span> <label> <a href="#">Calculate</a>
						</label>
					</span></li>
					<li id="clearContent"><span> <label> <a href="#">Clear this form</a>
						</label>
					</span></li>
					<li id="help"><span> <label> <a
								href="https://www.isncscialgorithm.com/Home/Help"
								target="_blank">Help</a>
						</label>
					</span></li>
					<li id="resources"><span> <label> <a
								href="https://www.isncscialgorithm.com/Home/Resources"
								target="_blank">Resources</a>
						</label>
					</span></li>
				</ul>
			</div>
			<div id="save-data-section">
				<p>You may choose to save your data to a REDCap record, by filling
					out the fields below.</p>
				<form class="row">
					<div class="col-4">
						<select class="custom-select" id="redcap-record">
							<option value="" selected>Select an existing record</option>
                      	<?php
                    // Retrieve all records in project
                    $id_field = REDCap::getRecordIdField();
                    $records = REDCap::getData([
                        "project_id" => $module->getProjectId(),
                        "return_format" => "json",
                        "fields" => $id_field
                    ]);
                    $records = array_unique(array_column(json_decode($records, true), $id_field));

                    foreach ($records as $record) {
                        print "<option value='" . $record . "'>" . $record . "</option>";
                    }
                    ?>
                      </select>
					</div>
					<?php if (REDCap::isLongitudinal()): ?>
					<div class="col-4">
						<select class="custom-select" id="redcap-event">
							<option value="" selected>Select a REDCap event</option>
                      	<?php
        // Retrieve all events with the ISNSCI form assigned
        $unique_event_names = REDCap::getEventNames(true, true);
        foreach ($unique_event_names as $unique_event) {
            $fields = REDCap::getValidFieldsByEvents($module->getProjectId(), $unique_event);
            if (in_array("isncsci_instructions", $fields)) {
                print "<option value='" . $unique_event . "'>" . $unique_event . "</option>";
            }
        }
        ?>
                      </select>
					</div>
					<?php endif; ?>
					<div class="col-2">
						<button type="button" class="btn" id="save-data-btn">Save Data</button>
					</div>
				</form>
				<div id="confirm-alert" class="alert alert-info alert-dismissible"
					role="alert" style="margin-top: 20px; display: none">
					<h5 class="alert-heading">Please Confirm!</h5>
					<p>
						You've decided to save your form data to record <span
							id="alert-redcap-id"><b></b></span> in event <span
							id="alert-redcap-event"><b></b></span>. If this information is
						correct, please click 'Okay' to proceed. Otherwise correct your
						information.
					</p>
					<button type="button" class="close" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<hr>
					<button type="button" class="btn" id="confirm-save-data-btn">Okay</button>
				</div>
			</div>
			<div id="section">
				<div id="input-controls" class="row">
					<div class="col-sm-3">
						<div id="impairment-flags-explanation">
							Use the <strong>*</strong> symbol to indicate impairment not due
							to SCI.
						</div>
						<ul id="input-controls-value-buttons" class="container">
							<li class="combo-item"><span class="value sensory motor disabled"
								id="ValueButton" data-value="0">0</span><span
								class="flag sensory motor disabled" id="ValueButton"
								data-value="0*">*</span></li>
							<li class="combo-item sensory motor"><span
								class="value sensory motor disabled" id="ValueButton"
								data-value="1">1</span><span class="flag sensory motor disabled"
								id="ValueButton" data-value="1*">*</span></li>
							<li class="combo-item"><span class="value sensory motor disabled"
								id="ValueButton" data-value="2">2</span><span
								class="flag motor disabled" id="ValueButton" data-value="2*">*</span></li>
							<li class="combo-item"><span class="value motor disabled"
								id="ValueButton" data-value="3">3</span><span
								class="flag motor disabled" id="ValueButton" data-value="3*">*</span></li>
							<li class="combo-item"><span class="value motor disabled"
								id="ValueButton" data-value="4">4</span><span
								class="flag motor disabled" id="ValueButton" data-value="4*">*</span></li>
							<li class="combo-item normal-muscle"><span
								class="value motor disabled" id="ValueButton" data-value="5">5</span></li>
							<li class="combo-item nt"><span
								class="value sensory motor disabled" id="ValueButton"
								data-value="NT">NT</span><span
								class="flag sensory motor disabled" id="ValueButton"
								data-value="NT*">*</span></li>
						</ul>
					</div>
					<div class="col-sm-3 reason not-applicable"
						id="ConsiderationForNotSciContainer">
						<div id="extra-input-controls">
							<input type="checkbox" id="DisablePropagationBox"
								name="DisablePropagationBox" class="extra-input"> <label
								for="DisablePropagationBox" class="extra-input">Disable down
								value propagation</label>
						</div>
						<div class="label" id="ConsiderationForNotSciLabel">
							<label for="ConsiderationForImpairmentNotDueToSci"> Choose
								consider normal or not normal for classification: </label>
						</div>
						<div class="field">
							<select id="ConsiderationForImpairmentNotDueToSci"
								name="ConsiderationForImpairmentNotDueToSci" class="cell-input"
								id="ConsiderationForNotSci">
								<option></option>
								<option value="1">Consider Normal</option>
								<option value="2">Consider Not Normal</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3 reason not-applicable"
						id="ReasonNotSciContainer">
						<div class="label" id="ReasonNotSciLabel">
							<label for="ReasonForImpairmentNotDueToSci"> If impairment not
								due to SCI, please indicate reason: </label>
						</div>
						<div class="field">
							<select id="ReasonForImpairmentNotDueToSci"
								name="ReasonForImpairmentNotDueToSci" class="cell-input"
								id="ReasonNotSci">
								<option></option>
								<option value="1" class="cell-input">Plexopathy</option>
								<option value="2" class="cell-input">Peripheral neuropathy</option>
								<option value="3" class="cell-input">Pre-existing myoneural
									disease (e.g. Stroke, MS, etc.)</option>
								<option value="6" class="cell-input">Other (specify:)</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3 comments not-applicable"
						id="ReasonNotSciCommentContainer">
						<div class="label" id="ReasonNotSciCommentLabel">
							<label for="CommentsReasonForImpairmentNotDueToSci">
								Specify:&nbsp; </label>
						</div>
						<div class="field">
							<textarea id="CommentsReasonForImpairmentNotDueToSci"
								name="CommentsReasonForImpairmentNotDueToSci" rows="10"
								class="cell-input" id="ReasonNotSciComment"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="main-content" tabindex=0>
		<div id="exam-info">
			<div class="block">
				<div>
					<label for="exam-date">Date of Exam</label>
				</div>
				<input id="exam-date" type="date">
			</div>
			<div class="block">
				<div>
					<label for="exam-time">Time of Exam</label>
				</div>
				<input id="exam-time" class="timepicker">
			</div>
			<div class="block">
				<div>
					<label>Examiner Name</label>
				</div>
				<input id="examiner-name" type="text">
			</div>
			<div class="block">
				<div>
					<label>Examiner Position</label>
				</div>
				<input type="radio" value="0" class="examiner-position"
					name="examiner-position"><label>PT</label> <input type="radio"
					value="1" class="examiner-position" name="examiner-position"><label>Spine
					Surgeon</label> <input type="radio" value="2"
					class="examiner-position" name="examiner-position"><label>Physiatrist</label>
				<input type="radio" value="3" class="examiner-position"
					name="examiner-position"><label>CNS</label> <input type="radio"
					value="4" class="examiner-position" name="examiner-position"><label>RN</label>
				<input type="radio" value="5" class="examiner-position"
					name="examiner-position"><label>Resident</label> <input
					type="radio" value="6" class="examiner-position"
					name="examiner-position"><label>Fellow</label> <input type="radio"
					value="7" class="examiner-position" name="examiner-position"><label>NP</label>
				<input type="radio" value="8" class="examiner-position"
					name="examiner-position"><label>Other (specify)</label> <input
					id="other-examiner-text" type="text">
			</div>
		</div>
		<div id="body-data">
    		<div id="right-column">
    			<table>
    				<thead>
    					<tr>
    						<th colspan="2" rowspan="2" class="side-label">Right</th>
    						<th colspan="2" class="measurement-type">Motor</th>
    						<th colspan="2" class="measurement-type">Sensory</th>
    					</tr>
    					<tr>
    						<th colspan="2" class="measurement-subtype">Key<br>muscles
    						</th>
    						<th colspan="2" class="measurement-subtype">Key sensory<br>points
    						</th>
    					</tr>
    					<tr>
    						<th colspan="4">&nbsp</th>
    						<th class="measurement-technique">Light Touch (LT)</th>
    						<th class="measurement-technique">Pin Prick (PP)</th>
    					</tr>
    				</thead>
    				<tfoot>
    					<tr>
    						<td colspan="3" class="total-label">Right totals</td>
    						<td class="total" id="RightMotorTotal">&nbsp;</td>
    						<td class="total" id="RightTouchTotal">&nbsp;</td>
    						<td class="total" id="RightPrickTotal">&nbsp;</td>
    					</tr>
    					<tr>
    						<td colspan="3" class="maximum-label">(Maximum)</td>
    						<td class="maximum">(50)</td>
    						<td class="maximum">(56)</td>
    						<td class="maximum">(56)</td>
    					</tr>
    				</tfoot>
    				<tbody>
    					<tr>
    						<td colspan="3" rowspan="3">&nbsp;</td>
    						<td class="level-name">C2</td>
    						<td><input id="C2RightTouch"
    							class="smart-cell sensory touch right"
    							title="C2 light touch right"></td>
    						<td><input id="C2RightPrick"
    							class="smart-cell sensory prick right" title="C2 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">C3</td>
    						<td><input id="C3RightTouch"
    							class="smart-cell sensory touch right"
    							title="C3 light touch right"></td>
    						<td><input id="C3RightPrick"
    							class="smart-cell sensory prick right" title="C3 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">C4</td>
    						<td><input id="C4RightTouch"
    							class="smart-cell sensory touch right"
    							title="C4 light touch right"></td>
    						<td><input id="C4RightPrick"
    							class="smart-cell sensory prick right" title="C4 pin prick right"></td>
    					</tr>
    					<tr>
    						<td rowspan="5">
    							<div class="location">UER</div>
    							<div class="location-description">(Upper Extremity Right)</div>
    						</td>
    						<td class="helper">Elbow flexors</td>
    						<td class="level-name">C5</td>
    						<td><input id="C5RightMotor" class="smart-cell motor upper right"
    							title="C5 motor right"></td>
    						<td><input id="C5RightTouch"
    							class="smart-cell sensory touch right"
    							title="C5 light touch right"></td>
    						<td><input id="C5RightPrick"
    							class="smart-cell sensory prick right" title="C5 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Wrist extensors</td>
    						<td class="level-name">C6</td>
    						<td><input id="C6RightMotor" class="smart-cell motor upper right"
    							title="C6 motor right"></td>
    						<td><input id="C6RightTouch"
    							class="smart-cell sensory touch right"
    							title="C6 light touch right"></td>
    						<td><input id="C6RightPrick"
    							class="smart-cell sensory prick right" title="C6 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Elbow extensors</td>
    						<td class="level-name">C7</td>
    						<td><input id="C7RightMotor" class="smart-cell motor upper right"
    							title="C7 motor right"></td>
    						<td><input id="C7RightTouch"
    							class="smart-cell sensory touch right"
    							title="C7 light touch right"></td>
    						<td><input id="C7RightPrick"
    							class="smart-cell sensory prick right" title="C7 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Finger flexors</td>
    						<td class="level-name">C8</td>
    						<td><input id="C8RightMotor" class="smart-cell motor upper right"
    							title="C8 motor right"></td>
    						<td><input id="C8RightTouch"
    							class="smart-cell sensory touch right"
    							title="C8 light touch right"></td>
    						<td><input id="C8RightPrick"
    							class="smart-cell sensory prick right" title="C8 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Finger abductors <span>(little finger)</span></td>
    						<td class="level-name">T1</td>
    						<td><input id="T1RightMotor" class="smart-cell motor upper right"
    							title="T1 motor right"></td>
    						<td><input id="T1RightTouch"
    							class="smart-cell sensory touch right"
    							title="T1 light touch right"></td>
    						<td><input id="T1RightPrick"
    							class="smart-cell sensory prick right" title="T1 pin prick right"></td>
    					</tr>
    					<tr>
    						<td colspan="3" rowspan="12">
    							<div id="LowestNonKeyMuscleWithMotorFunction">
    								<h6>Lowest non-key muscles</h6>
    								<h6>with motor function:</h6>
    								<div>
    									<label for="RightLowestNonKeyMuscleWithMotorFunction">Right:</label>
    									<select id="RightLowestNonKeyMuscleWithMotorFunction"
    										name="RightLowestNonKeyMuscleWithMotorFunction"
    										id="RightLowestNonKeyMuscleWithMotorFunction">
    										<option></option>
    										<option value="C5">C5 - Shoulder: Flexion, extension,
    											abduction, adduction, internal and external rotation - Elbow:
    											Supination</option>
    										<option value="C6">C6 - Elbow: Pronation - Wrist: Flexion</option>
    										<option value="C7">C7 - Finger: Flexion at proximal joint,
    											extension. Thumb: Flexion, extension and abduction in plane
    											of thumb</option>
    										<option value="C8">C8 - Finger: Flexion at MCP joint Thumb:
    											Opposition, adduction and abduction perpendicular to palm</option>
    										<option value="T1">T1 - Finger: Abduction of the index finger</option>
    										<option value="L2">L2 - Hip: Adduction</option>
    										<option value="L3">L3 - Hip: External rotation</option>
    										<option value="L4">L4 - Hip: Extension, abduction, internal
    											rotation - Knee: Flexion - Ankle: Inversion and eversion -
    											Toe: MP and IP extension</option>
    										<option value="L5">L5 - Hallux and Toe: DIP and PIP flexion
    											and abduction</option>
    										<option value="S1">S1 - Hallux: Adduction</option>
    									</select>
    								</div>
    								<div>
    									<label for="LeftLowestNonKeyMuscleWithMotorFunction">Left:</label>
    									<select id="LeftLowestNonKeyMuscleWithMotorFunction"
    										name="LeftLowestNonKeyMuscleWithMotorFunction"
    										id="LeftLowestNonKeyMuscleWithMotorFunction">
    										<option></option>
    										<option value="C5">C5 - Shoulder: Flexion, extension,
    											abduction, adduction, internal and external rotation - Elbow:
    											Supination</option>
    										<option value="C6">C6 - Elbow: Pronation - Wrist: Flexion</option>
    										<option value="C7">C7 - Finger: Flexion at proximal joint,
    											extension. Thumb: Flexion, extension and abduction in plane
    											of thumb</option>
    										<option value="C8">C8 - Finger: Flexion at MCP joint Thumb:
    											Opposition, adduction and abduction perpendicular to palm</option>
    										<option value="T1">T1 - Finger: Abduction of the index finger</option>
    										<option value="L2">L2 - Hip: Adduction</option>
    										<option value="L3">L3 - Hip: External rotation</option>
    										<option value="L4">L4 - Hip: Extension, abduction, internal
    											rotation - Knee: Flexion - Ankle: Inversion and eversion -
    											Toe: MP and IP extension</option>
    										<option value="L5">L5 - Hallux and Toe: DIP and PIP flexion
    											and abduction</option>
    										<option value="S1">S1 - Hallux: Adduction</option>
    									</select>
    								</div>
    							</div>
    							<div id="CommentsContainer">
    								<h6>Comments:</h6>
    								<textarea id="Comments" name="Comments" cols="10" rows="10"
    									id="Comments"></textarea>
    							</div>
    						</td>
    						<td class="level-name">T2</td>
    						<td><input id="T2RightTouch"
    							class="smart-cell sensory touch right"
    							title="T2 light touch right"></td>
    						<td><input id="T2RightPrick"
    							class="smart-cell sensory prick right" title="T2 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T3</td>
    						<td><input id="T3RightTouch"
    							class="smart-cell sensory touch right"
    							title="T3 light touch right"></td>
    						<td><input id="T3RightPrick"
    							class="smart-cell sensory prick right" title="T3 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T4</td>
    						<td><input id="T4RightTouch"
    							class="smart-cell sensory touch right"
    							title="T4 light touch right"></td>
    						<td><input id="T4RightPrick"
    							class="smart-cell sensory prick right" title="T4 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T5</td>
    						<td><input id="T5RightTouch"
    							class="smart-cell sensory touch right"
    							title="T5 light touch right"></td>
    						<td><input id="T5RightPrick"
    							class="smart-cell sensory prick right" title="T5 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T6</td>
    						<td><input id="T6RightTouch"
    							class="smart-cell sensory touch right"
    							title="T6 light touch right"></td>
    						<td><input id="T6RightPrick"
    							class="smart-cell sensory prick right" title="T6 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T7</td>
    						<td><input id="T7RightTouch"
    							class="smart-cell sensory touch right"
    							title="T7 light touch right"></td>
    						<td><input id="T7RightPrick"
    							class="smart-cell sensory prick right" title="T7 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T8</td>
    						<td><input id="T8RightTouch"
    							class="smart-cell sensory touch right"
    							title="T8 light touch right"></td>
    						<td><input id="T8RightPrick"
    							class="smart-cell sensory prick right" title="T8 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T9</td>
    						<td><input id="T9RightTouch"
    							class="smart-cell sensory touch right"
    							title="T9 light touch right"></td>
    						<td><input id="T9RightPrick"
    							class="smart-cell sensory prick right" title="T9 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T10</td>
    						<td><input id="T10RightTouch"
    							class="smart-cell sensory touch right"
    							title="T10 light touch right"></td>
    						<td><input id="T10RightPrick"
    							class="smart-cell sensory prick right"
    							title="T10 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T11</td>
    						<td><input id="T11RightTouch"
    							class="smart-cell sensory touch right"
    							title="T11 light touch right"></td>
    						<td><input id="T11RightPrick"
    							class="smart-cell sensory prick right"
    							title="T11 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">T12</td>
    						<td><input id="T12RightTouch"
    							class="smart-cell sensory touch right"
    							title="T12 light touch right"></td>
    						<td><input id="T12RightPrick"
    							class="smart-cell sensory prick right"
    							title="T12 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">L1</td>
    						<td><input id="L1RightTouch"
    							class="smart-cell sensory touch right"
    							title="L1 light touch right"></td>
    						<td><input id="L1RightPrick"
    							class="smart-cell sensory prick right" title="L1 pin prick right"></td>
    					</tr>
    					<tr>
    						<td rowspan="5">
    							<div class="location">LER</div>
    							<div class="location-description">(Lower Extremity Right)</div>
    						</td>
    						<td class="helper">Hip flexors</td>
    						<td class="level-name">L2</td>
    						<td><input id="L2RightMotor" class="smart-cell motor upper right"
    							title="L2 motor right"></td>
    						<td><input id="L2RightTouch"
    							class="smart-cell sensory touch right"
    							title="L2 light touch right"></td>
    						<td><input id="L2RightPrick"
    							class="smart-cell sensory prick right" title="L2 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Knee extensors</td>
    						<td class="level-name">L3</td>
    						<td><input id="L3RightMotor" class="smart-cell motor upper right"
    							title="L3 motor right"></td>
    						<td><input id="L3RightTouch"
    							class="smart-cell sensory touch right"
    							title="L3 light touch right"></td>
    						<td><input id="L3RightPrick"
    							class="smart-cell sensory prick right" title="L3 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Ankle dorsiflexors</td>
    						<td class="level-name">L4</td>
    						<td><input id="L4RightMotor" class="smart-cell motor upper right"
    							title="L4 motor right"></td>
    						<td><input id="L4RightTouch"
    							class="smart-cell sensory touch right"
    							title="L4 light touch right"></td>
    						<td><input id="L4RightPrick"
    							class="smart-cell sensory prick right" title="L4 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Long toe extensors</td>
    						<td class="level-name">L5</td>
    						<td><input id="L5RightMotor" class="smart-cell motor upper right"
    							title="L5 motor right"></td>
    						<td><input id="L5RightTouch"
    							class="smart-cell sensory touch right"
    							title="L5 light touch right"></td>
    						<td><input id="L5RightPrick"
    							class="smart-cell sensory prick right" title="L5 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="helper">Ankle plantar flexors</td>
    						<td class="level-name">S1</td>
    						<td><input id="S1RightMotor" class="smart-cell motor upper right"
    							title="S1 motor right"></td>
    						<td><input id="S1RightTouch"
    							class="smart-cell sensory touch right"
    							title="S1 light touch right"></td>
    						<td><input id="S1RightPrick"
    							class="smart-cell sensory prick right" title="S1 pin prick right"></td>
    					</tr>
    					<tr>
    						<td colspan="3" rowspan="2">&nbsp;</td>
    						<td class="level-name">S2</td>
    						<td><input id="S2RightTouch"
    							class="smart-cell sensory touch right"
    							title="S2 light touch right"></td>
    						<td><input id="S2RightPrick"
    							class="smart-cell sensory prick right" title="S2 pin prick right"></td>
    					</tr>
    					<tr>
    						<td class="level-name">S3</td>
    						<td><input id="S3RightTouch"
    							class="smart-cell sensory touch right"
    							title="S3 light touch right"></td>
    						<td><input id="S3RightPrick"
    							class="smart-cell sensory prick right" title="S3 pin prick right"></td>
    					</tr>
    					<tr>
    						<td colspan="3"><label for="AnalContraction">(VAC) Voluntary anal
    								contraction</label> <select id="AnalContraction"
    							name="AnalContraction" id="AnalContraction">
    								<option></option>
    								<option value="Yes">Yes</option>
    								<option value="No">No</option>
    								<option value="NT">NT</option>
    						</select></td>
    						<td class="level-name">S4-5</td>
    						<td><input id="S4_5RightTouch"
    							class="smart-cell sensory touch right"
    							title="S-45 light touch right"></td>
    						<td><input id="S4_5RightPrick"
    							class="smart-cell sensory prick right"
    							title="S-45 pin prick right"></td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
    		<div id="diagram-column">
    			<svg version="1.1" xmlns="http://www.w3.org/2000/svg"
    				xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
    				width="360px" height="507px" viewBox="0 0 360 507"
    				enable-background="new 0 0 360 507" xml:space="preserve"
    				style="width: 360px; height: 507px;">
    					<g id="Man">
    						<path
    					d="M221.976,289.875c-1.376,3.25-2.274,11.875-2.899,18.375s1.75,22.25,1.75,28.875s-2.25,38-2.875,43.5
    							s1.125,16.625,1.75,24.5s-2.25,32.75-2.375,38.625s1,17.125,2.125,21.875s0.375,10.625,0,11.875s0.5,2.375,1.375,8.875
    							s-7.75,8.75-8.875,9.5s-4.5,4.125-5.625,5.375s-3.375,2.5-6.625,2.75c-3.375,4.25-7.375,2.375-8.625,1
    							c-1.5,0.125-2.625,0.25-3.375-0.75c-1.375,0-1.875-0.5-2.25-1.875c-2-1-1.875-2.25-1.375-3.25c-0.625-2,1.125-4,2.25-4.625
    							s8-5.875,10.125-7.625s3.75-4.625,5.75-6.375c2.875-38-12-55.625-13.75-72.75c-1.273-12.458,4.5-35.75,4.5-51.5
    							c0-21.503-16.396-52.082-14.167-113.583c0.917-25.292,6.542-38.542,6.999-52c0.261-7.691-8.333-41.167-10.833-49.833
    							c-1.5,3.667-6.667,17-9.5,26s-3.331,11.25-5.749,14.667c-2.111,2.984-2.375,12.375-6.251,21
    							c-1.741,3.875-12.5,20.667-19.833,30.167c-1,11-7.041,30.958-9.334,34.333c-1.383,2.035-4.666,2.667-5.666,2
    							c-0.833,1.5-1.84,2.119-3.334,1.667c-2.207-0.667-1.833-2-1.667-7.333c-2.501,4.166-6.415,10.541-9.999,8.833
    							c-2.762-1.315,2-9.667,3.5-14c-4,5.333-5.986,9.653-9.333,7.499c-2.783-1.791,1.333-8.166,2.999-10.832c1.666-2.667,3-5.5,3.834-8
    							c-5.041,3.667-6.909,3.017-9.167,1.167c-1.374-1.125,0.673-3.159,2.5-4.667c5.251-4.333,10-10.5,12.168-13.667s4.832-4.833,8.332-5
    							c3.001-11.292,5.126-25.167,9.5-36c3.06-7.579,9.205-16.56,11.251-19.667c3.375-5.125,4.012-15.88,5.583-23.167
    							c2.417-11.208,5.54-14.454,8.166-19.667c2.708-5.376,1.501-11.042,5.566-19.292c5.028-10.204,11.705-11.669,15.512-11.789
    							c3.96-0.125,5.048-2.711,23.588-9.919c11.148-4.334,9.501-12.333,9.168-17.333c-0.833-1.333-2.334-3.667-3.334-11
    							c-4.833,0-5.766-3.113-7.499-6.811c-2.667-5.689-1.699-11.856,1.999-11.523c-2.333-23.167,11.724-28,24.025-28
    							s26.358,4.833,24.025,28c3.698-0.333,4.666,5.833,1.999,11.523c-1.733,3.697-2.666,6.811-7.499,6.811
    							c-1,7.333-2.501,9.667-3.334,11c-0.333,5-1.98,12.999,9.168,17.333c18.54,7.208,19.628,9.794,23.588,9.919
    							c3.807,0.12,10.483,1.585,15.512,11.789c4.065,8.25,2.858,13.916,5.566,19.292c2.626,5.213,5.749,8.458,8.166,19.667
    							c1.571,7.286,2.208,18.042,5.583,23.167c2.046,3.107,8.191,12.088,11.251,19.667c4.374,10.833,6.499,24.708,9.5,36
    							c3.5,0.167,6.164,1.833,8.332,5s6.917,9.333,12.168,13.667c1.827,1.508,3.874,3.542,2.5,4.667c-2.258,1.85-4.126,2.5-9.167-1.167
    							c0.834,2.5,2.168,5.333,3.834,8c1.666,2.666,5.782,9.041,2.999,10.832c-3.347,2.154-5.333-2.166-9.333-7.499
    							c1.5,4.333,6.262,12.685,3.5,14c-3.584,1.708-7.498-4.667-9.999-8.833c0.166,5.333,0.54,6.666-1.667,7.333
    							c-1.494,0.452-2.501-0.167-3.334-1.667c-1,0.667-4.283,0.035-5.666-2c-2.293-3.375-8.334-23.333-9.334-34.333
    							c-7.333-9.5-18.092-26.292-19.833-30.167c-3.876-8.625-4.14-18.016-6.251-21c-2.418-3.417-2.916-5.667-5.749-14.667
    							s-8-22.334-9.5-26c-2.5,8.667-11.094,42.142-10.833,49.833c0.457,13.458,6.082,26.708,6.999,52
    							C267.396,304.168,251,334.747,251,356.25c0,15.75,5.773,39.042,4.5,51.5c-1.75,17.125-16.625,34.75-13.75,72.75
    							c2,1.75,3.625,4.625,5.75,6.375s9,7,10.125,7.625s2.875,2.625,2.25,4.625c0.5,1,0.625,2.25-1.375,3.25
    							c-0.375,1.375-0.875,1.875-2.25,1.875c-0.75,1-1.875,0.875-3.375,0.75c-1.25,1.375-5.25,3.25-8.625-1
    							c-3.25-0.25-5.5-1.5-6.625-2.75s-4.5-4.625-5.625-5.375s-9.75-3-8.875-9.5s1.75-7.625,1.375-8.875s-1.125-7.125,0-11.875
    							s2.25-16,2.125-21.875s-3-30.75-2.375-38.625s2.375-19,1.75-24.5s-2.875-36.875-2.875-43.5s2.375-22.375,1.75-28.875
    							S223.352,293.125,221.976,289.875z"></path>
    						<circle cx="290" cy="427.167" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 297 432.333)">
    				<tspan x="0" y="0" font-family="'TimesNewRomanPSMT'" font-size="13">Key</tspan>
    				<tspan x="0" y="15.6" font-family="'TimesNewRomanPSMT'"
    					font-size="13">Sensory</tspan>
    				<tspan x="0" y="31.2" font-family="'TimesNewRomanPSMT'"
    					font-size="13">Points</tspan></text>
    						<path fill="#FFFFFF"
    					d="M236.139,68.158c0.01-0.128,0.022-0.266,0.03-0.391l0.017-0.25l0.134-0.213
    							c0.854-1.365,2.231-3.487,3.19-10.522L239.628,56h0.873c3.748,0,4.696-2.163,6.131-5.312c0.149-0.329,0.303-0.708,0.463-1.048
    							c1.822-3.888,1.724-7.596,0.686-9.23c-0.424-0.667-0.97-0.966-1.689-0.903l-1.206,0.104l0.121-1.208
    							c0.913-9.064-0.681-15.935-4.737-20.42c-3.89-4.3-10.044-6.481-18.293-6.481s-14.403,2.18-18.293,6.48
    							c-4.057,4.485-5.65,11.355-4.737,20.419l0.121,1.205l-1.206-0.108c-0.714-0.066-1.264,0.226-1.688,0.893
    							c-1.039,1.634-1.138,5.323,0.685,9.21c0.16,0.341,0.313,0.761,0.463,1.09c1.435,3.148,2.383,5.312,6.131,5.312h0.873l0.118,0.781
    							c0.959,7.035,2.338,9.199,3.161,10.516l0.133,0.193l0.047,0.287c0.009,0.136,0.022,0.285,0.033,0.424
    							c3.01,3.555,9.35,5.532,14.16,5.532C226.787,73.733,233.13,71.72,236.139,68.158z"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M207.243,39.292
    							c1.042-1.083,2.583-2.583,4.875-2.333s3.125,0.833,5.375,3.208"></path>
    						<circle cx="212.701" cy="42.823" r="2.5"></circle>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M207.743,42.625
    							c1.542-1.375,2.542-2.417,4.625-2.292s2.709,0.792,5.292,3.083"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M217.493,55.131
    							c0-1.155,0.636-2.771,2.06-3.349"></path>
    						
    							<line fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10" x1="222.17" y1="57.902" x2="222.17"
    					y2="59.288"></line>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-linejoin="round" stroke-miterlimit="10"
    					d="M229.751,62.521
    							c-1.001-0.539-2.635-1.386-3.55-1.386s-2.493,0.193-3.84,0.924h0.001c-1.347-0.731-2.925-0.924-3.84-0.924s-2.549,0.847-3.55,1.386
    							"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M226.48,63.83
    							c-0.885,0.692-2.463,1.193-4.311,1.193s-3.426-0.5-4.311-1.193"></path>
    						<path
    					d="M220.04,54.953c0.622,0.005,1.053,0.524,1.245,0.678s0.223,0.977-0.604,0.822s-1.328-0.453-1.536-0.766
    							C218.97,55.424,219.196,54.946,220.04,54.953z"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M237.097,39.292
    							c-1.042-1.083-2.583-2.583-4.875-2.333s-3.125,0.833-5.375,3.208"></path>
    						<circle cx="231.639" cy="42.823" r="2.5"></circle>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M236.597,42.625
    							c-1.542-1.375-2.542-2.417-4.625-2.292s-2.709,0.792-5.292,3.083"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M244.225,43.417
    							c0.462-0.679,1.039-1.547,1.501-1.547s0.731,0.448,0.731,0.773s0,2.263,0,2.68c0,3.677-2.05,5.767-2.589,6.459
    							s-1.531-0.417-1.531-1.033s-0.074-1.508,0.002-1.893"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M200.232,43.417
    							c-0.462-0.679-1.039-1.547-1.501-1.547S198,42.318,198,42.644s0,2.263,0,2.68c0,3.677,2.05,5.767,2.589,6.459
    							s1.531-0.417,1.531-1.033s0.074-1.508-0.002-1.893"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M226.847,55.131
    							c0-1.155-0.636-2.771-2.06-3.349"></path>
    						<path
    					d="M224.3,54.953c-0.622,0.005-1.053,0.524-1.245,0.678s-0.223,0.977,0.604,0.822s1.328-0.453,1.536-0.766
    							C225.37,55.424,225.144,54.946,224.3,54.953z"></path>
    						<text transform="matrix(1 0 0 1 135 253)" font-family="'ArialMT'"
    					font-size="8">Palm</text>
    						<text transform="matrix(1 0 0 1 290 253)" font-family="'ArialMT'"
    					font-size="8">Palm</text>
    						<path
    					d="M85,435.208c0.094-1.302-0.333-2.041-1.542-1.791c0.104-1.448-1.146-2.354-2.271-2.386
    							c-0.291-1.167-0.688-1.469-2.094-1.406c-0.479-1.432-0.406-2.313-2.594-2.417c0.5-5.042,1.563-9.583,4.438-18.208
    							c3.672-11.016,5.813-25,5.813-33.5c0-13.719-3.094-22-4.844-29s-1.438-12.75-0.188-18.75s5.781-32.5,5.781-59.5
    							c0-38.125-4.469-58.25-6.719-71.5c-5.438-3.563-16.625-11.781-36.531-11.781s-31.094,8.219-36.531,11.781
    							C5.469,210,1,230.125,1,268.25c0,27,4.531,53.5,5.781,59.5s1.563,11.75-0.188,18.75s-4.844,15.281-4.844,29
    							c0,8.5,2.141,22.484,5.813,33.5c2.875,8.625,3.938,13.166,4.438,18.208c-2.188,0.104-2.115,0.985-2.594,2.417
    							c-1.406-0.063-1.803,0.239-2.094,1.406c-1.125,0.031-2.375,0.938-2.271,2.386c-1.209-0.25-1.636,0.489-1.542,1.791
    							c-2.281,0.542-2.055,1.979-1.792,2.876c0.479,1.635,1.332,1.457,1.791,2.499s0.907,1.698,2.293,2.834
    							c1.116,0.915,3.388,2.112,5.75,3.875c2.708,2.021,2.021,4.552,6.291,6.332c3.237,1.35,7.667,0.584,9.334-1.749s1.291-5.167,1.083-7
    							s-0.791-3.921-0.916-4.833c-0.146-1.073,0.208-1.541,0.708-2.083s1.25-1.501,1.25-2.376s-0.167-1.834-1-3.25
    							c0-14.396,8.076-26.552,8.076-47.084c0-19.655-3.274-31.937-2.118-38.374c1.163-6.476,4.625-10.625,4.625-21.25
    							S39,303.125,40.5,295.75s3.344-23.438,3.75-24.875c0.406,1.438,2.25,17.5,3.75,24.875s1.625,19.25,1.625,29.875
    							s3.462,14.774,4.625,21.25c1.156,6.438-2.118,18.719-2.118,38.374c0,20.532,8.076,32.688,8.076,47.084c-0.833,1.416-1,2.375-1,3.25
    							s0.75,1.834,1.25,2.376s0.854,1.01,0.708,2.083c-0.125,0.912-0.708,3-0.916,4.833s-0.584,4.667,1.083,7s6.097,3.099,9.334,1.749
    							c4.271-1.78,3.583-4.312,6.291-6.332c2.362-1.763,4.634-2.96,5.75-3.875c1.386-1.136,1.834-1.792,2.293-2.834
    							s1.312-0.864,1.791-2.499C87.055,437.187,87.281,435.75,85,435.208z"></path>
    						<path fill="#FFFFFF"
    					d="M79.868,197.345l-0.617-0.408c-5.774-3.833-16.521-10.968-35.001-10.968s-29.227,7.135-35.001,10.968
    							l-0.617,0.408c-0.239,1.393-0.501,2.86-0.778,4.416C5.522,214.829,2,234.576,2,268.25c0,6.814,0.299,13.658,0.763,20.178
    							c6.933-5.48,17.415-15.592,22.764-26.781c-2.381-4.75-4.003-10.393-4.003-16.896c0-19.162,11.709-29.502,22.727-29.502
    							c11.096,0,22.889,10.34,22.889,29.502c0,6.564-1.666,12.248-4.1,17.025c5.368,11.138,15.793,21.192,22.698,26.652
    							c0.464-6.52,0.763-13.363,0.763-20.178c0-33.674-3.522-53.421-5.854-66.489C80.369,200.206,80.107,198.738,79.868,197.345z"></path>
    						<path
    					d="M300.074,109.764h59.116c0-19.68-11.659-25.912-17.547-32.796c-3.394-3.968-3.134-17.129-0.627-20.053
    							s11.28-4.178,11.28-21.934S340.599,0.305,317.203,0.305c-9.042,0-21.307,6.267-23.187,7.52s-5.013,3.551-1.88,7.311
    							c-2.089,4.387-3.552,8.564-3.552,11.071s2.298,7.103,2.298,10.445s-4.386,10.445-5.222,11.907s-1.253,3.551,0,4.804
    							s2.297,0.626,3.133,1.671c-0.626,2.716-1.106,3.216,0.769,5.278c-0.625,1.125-1.188,2.75,1.25,3.313
    							c-0.438,3.313-0.5,5.438-0.438,6.625s0.774,5.21,7.61,4.29c3.25-0.438,7.202-1.478,8.265-1.728c0,1.25,0.063,3.688,0.063,4.5
    							s3.125,4.938,3.125,8.313C309.438,91.75,300.074,102.402,300.074,109.764z"></path>
    						<path fill="#FFFFFF"
    					d="M287.672,53.318c0.573,0.143,1.286,0.321,1.903,1.092l0.302,0.377l-0.108,0.472
    							c-0.083,0.358-0.163,0.679-0.235,0.969c-0.445,1.782-0.492,2.01,0.697,3.329c1.733,0.035,3.221,0.139,4.207,0.927
    							c0.216,0.173,0.25,0.487,0.078,0.703c-0.099,0.123-0.244,0.188-0.391,0.188c-0.11,0-0.22-0.036-0.313-0.109
    							c-0.681-0.545-1.854-0.66-3.247-0.699l-0.129,0.232c-0.49,0.882-0.429,1.233-0.38,1.343c0.088,0.197,0.454,0.388,0.98,0.509
    							l0.886,0.205l-0.119,0.901c-0.479,3.624-0.475,5.591-0.43,6.441c0.068,1.299,0.772,3.479,4.72,3.479
    							c0.543,0,1.134-0.043,1.758-0.127c2.699-0.363,5.928-1.159,7.479-1.542l1.919-0.458v0c1.719-0.649,4.246-1.665,6.482-2.607
    							c2.754-6.589,5.446-15.353,9.159-27.441c0.964-3.135,2-6.51,3.131-10.151c4.826-15.541,5.688-22.199,5.888-27.27
    							c-4.187-1.759-9.074-2.776-14.707-2.776c-8.582,0-20.686,6.054-22.632,7.352c-1.317,0.878-2.563,1.864-2.743,3.115
    							c-0.118,0.809,0.245,1.725,1.077,2.724l0.409,0.492l-0.274,0.578c-2.196,4.61-3.455,8.489-3.455,10.641
    							c0,1.014,0.477,2.567,0.981,4.213c0.647,2.109,1.316,4.291,1.316,6.232c0,2.914-2.683,7.854-5.021,11.832l-0.333,0.571
    							c-0.681,1.191-0.995,2.766-0.161,3.601C286.817,53.105,287.194,53.199,287.672,53.318z"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M292.354,29.435
    							c1.49,0,3.499,0.13,4.342,0.648s3.312,2.139,3.312,2.139"></path>
    						<path
    					d="M299.246,35.181c-1.847-0.591-3.877-1.562-5.717-2.733c-0.231-0.146-0.541-0.08-0.69,0.153
    							c-0.148,0.233-0.079,0.542,0.153,0.69c0.315,0.201,0.641,0.39,0.966,0.579c-0.17,1.193-0.011,2.511,1.075,3.967
    							c-0.068,0.051-0.135,0.094-0.207,0.153c-0.215,0.174-0.248,0.489-0.074,0.703c0.099,0.122,0.243,0.186,0.389,0.186
    							c0.11,0,0.222-0.037,0.314-0.111c0.473-0.382,0.836-0.542,1.257-0.727c0.695-0.306,1.484-0.653,2.752-2.047l0.522-0.576
    							L299.246,35.181z M296.811,36.888c-0.605-0.721-0.854-1.359-0.9-1.984c0.765,0.367,1.531,0.7,2.278,0.971
    							C297.626,36.418,297.203,36.688,296.811,36.888z"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M289,52.679
    							c0.784,0.568,1.487,0.406,2.353,1.136"></path>
    						<path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10"
    					d="M289.676,50.408
    							c0,0,0.107-0.378,0.5-0.459"></path>
    						
    							<line fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-miterlimit="10" x1="290.703"
    					y1="49.948" x2="291.353" y2="49.948"></line>
    						<rect x="4" y="123" fill="none" stroke="#000000"
    					stroke-width="1.0159" stroke-miterlimit="10" width="81" height="51"></rect>
    						<text transform="matrix(1 0 0 1 7.1436 134.5698)">
    				<tspan x="0" y="0" font-family="'Arial-ItalicMT'" font-size="9">0 = absent</tspan>
    				<tspan x="0" y="10.8" font-family="'Arial-ItalicMT'" font-size="9">1 = altered</tspan>
    				<tspan x="0" y="21.6" font-family="'Arial-ItalicMT'" font-size="9">2 = normal</tspan>
    				<tspan x="0" y="32.4" font-family="'Arial-ItalicMT'" font-size="9">NT = not testable</tspan></text>
    						<path
    					d="M154.177,328.416l-5.667-14.729l-1.156-0.813l-9.177-4.005l-0.049,0.025c-3.717,7.097-8.589,17.185-11.52,24.447
    							c-8.985,6.421-23.156,21.722-24.909,25.404c-1.058,2.222,0.059,5.376,1.139,5.902c-0.873,1.475-0.899,2.655,0.245,3.718
    							c1.692,1.567,2.654,0.57,7.171-2.267c-2.331,4.263-5.854,10.862-2.567,13.091c2.531,1.718,7.33-6.611,10.312-10.095
    							c-2.58,6.146-5.305,10.044-1.755,11.842c2.953,1.498,6.373-5.275,7.832-8.06c1.46-2.787,3.229-5.372,4.966-7.353
    							c-0.616,6.203,0.888,7.485,3.625,8.499c1.668,0.618,2.387-2.177,2.764-4.515c1.087-6.723,4.005-13.938,5.646-17.408
    							c1.634-3.47,1.727-6.611,0.102-9.715c4.197-4.233,9.088-8.609,13.821-13.108L154.177,328.416z"></path>
    						<text transform="matrix(1 0 0 1 138.4248 384)"
    					font-family="'ArialMT'" font-size="8">Dorsum</text>
    						<path
    					d="M297.097,327.416l5.667-14.729l1.156-0.813l9.177-4.005l0.049,0.025c3.717,7.097,8.589,17.185,11.52,24.447
    							c8.985,6.421,23.156,21.722,24.909,25.404c1.058,2.222-0.059,5.376-1.139,5.902c0.873,1.475,0.899,2.655-0.245,3.718
    							c-1.692,1.567-2.654,0.57-7.171-2.267c2.331,4.263,5.854,10.862,2.567,13.091c-2.531,1.718-7.33-6.611-10.312-10.095
    							c2.58,6.146,5.305,10.044,1.755,11.842c-2.953,1.498-6.373-5.275-7.832-8.06c-1.46-2.787-3.229-5.372-4.966-7.353
    							c0.616,6.203-0.888,7.485-3.625,8.499c-1.668,0.618-2.387-2.177-2.764-4.515c-1.087-6.723-4.005-13.938-5.646-17.408
    							c-1.634-3.47-1.727-6.611-0.102-9.715c-4.197-4.233-9.088-8.609-13.821-13.108L297.097,327.416z"></path>
    						<text transform="matrix(1 0 0 1 294 384)" font-family="'ArialMT'"
    					font-size="8">Dorsum</text>
    					</g>
    					<g>
    						<path class="background" id="S45_Left" fill="#FFFFFF"
    					d="M33.869,246.574C33.869,253.977,39,260,44,260v-26.852C39,233.148,33.869,239.172,33.869,246.574z"></path>
    						<path class="background" id="S45_Right" fill="#FFFFFF"
    					d="M44,233.148V260c6,0,10.131-6.023,10.131-13.426S50,233.148,44,233.148z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 91.0957 227.6255)"
    					font-family="'ArialMT'" font-size="6">S4-5</text>
    						</g>
    					    <circle cx="44.5" cy="257.021" r="2.5"></circle>
    					    <line fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10" x1="97.433" y1="229.367" x2="44.75"
    					y2="257.021"></line>
    					</g>
    					<g>
    						<path class="background" id="S3_Left" fill="#FFFFFF"
    					d="M32.869,246.574c0-7.954,5.131-14.426,11.131-14.426v-15.896c-11,0-21.598,9.789-21.598,28.498
    							c0,14.846,8.971,25.217,15.424,30.414c1.572-3.766,3.464-7.086,5.925-9.404L44,265.438V261C38,261,32.869,254.529,32.869,246.574z"></path>
    						<path class="background" id="S3_Right" fill="#FFFFFF"
    					d="M44,216.252v15.896c6,0,11.131,6.472,11.131,14.426C55.131,254.529,50,261,44,261v4.438l0.468,0.322
    							c2.467,2.324,4.519,5.654,6.094,9.434c6.504-5.189,15.417-15.57,15.417-30.443C65.979,226.041,55,216.252,44,216.252z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 38.9131 228.9165)"
    					font-family="'ArialMT'" font-size="6">S  3</text>
    						</g>
    						<circle cx="30.131" cy="258.499" r="1.85"></circle>
    						<circle cx="58.869" cy="258.499" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="S2_Right" fill="#FFFFFF"
    					d="M75.205,372.344c0.711-2.945,1.887-10.045,3.024-16.911c0.697-4.205,1.41-8.507,2.032-11.956
    							c-0.888-5.166-0.735-10.105,0.479-15.931c1.076-5.164,3.588-20.237,4.91-37.914c-6.865-5.341-17.589-15.526-23.251-26.899
    							c-3.259,6.025-7.692,10.518-11.395,13.408c3.271,8.355,4.605,18.608,4.605,25.079c0,2.322-0.125,4.05-0.27,6.05
    							c-0.193,2.679-0.412,5.716-0.412,11.193c0,9.383,1.959,18.667,3.666,25.706c1.163,4.799,0.398,20.17-0.16,31.394
    							c-0.014,0.272-0.026,0.534-0.04,0.803c2.357,3.619,4.576,5.691,7.58,5.691C72.043,382.057,74.047,377.146,75.205,372.344z"></path>
    						<path class="background" id="S2_Left" fill="#FFFFFF"
    					d="M26.101,262.732c-5.662,11.373-16.386,21.559-23.251,26.899c1.322,17.677,3.834,32.75,4.91,37.914
    							c1.214,5.825,1.366,10.765,0.479,15.931c0.622,3.449,1.335,7.751,2.032,11.956c1.138,6.866,2.313,13.966,3.024,16.911
    							c1.158,4.803,3.162,9.713,9.23,9.713c3.004,0,5.223-2.072,7.58-5.691c-0.014-0.269-0.026-0.53-0.04-0.803
    							c-0.559-11.224-1.323-26.595-0.16-31.394c1.707-7.039,3.666-16.323,3.666-25.706c0-5.478-0.219-8.515-0.412-11.193
    							c-0.145-2-0.27-3.728-0.27-6.05c0-6.471,1.335-16.724,4.605-25.079C33.793,273.25,29.359,268.758,26.101,262.732z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 12.5811 303.916)"
    					font-family="'ArialMT'" font-size="6">S2</text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 69.5811 303.916)"
    					font-family="'ArialMT'" font-size="6">S2</text>
    						</g>
    						<circle cx="19.225" cy="335.5" r="1.85"></circle>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M13.508,330.835
    							c0,4.168-0.887,3.413-0.887,5.409"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M29.115,329.771
    							c-0.134,1.241-0.444,3.388,0.398,5.729"></path>
    						<circle cx="69.775" cy="335.5" r="1.85"></circle>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M75.492,330.835
    							c0,4.168,0.887,3.413,0.887,5.409"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M59.885,329.771
    							c0.134,1.241,0.444,3.388-0.398,5.729"></path>
    					</g>
    					<g>
    						<path class="background" id="S1_Left" fill="#FFFFFF"
    					d="M258.8,499.208l0.121-0.383c0.437-1.397-0.907-2.966-1.781-3.452c-1.218-0.677-8.204-6.021-10.275-7.727
    							c-0.94-0.774-1.771-1.732-2.563-2.709c2.165,7.12,8.591,12.199,13.513,16.075c0.146,0.115,0.282,0.224,0.425,0.335
    							c0.397-0.217,0.82-0.513,0.923-0.881c0.066-0.237,0.007-0.527-0.181-0.902L258.8,499.208z"></path>
    						<path class="background" id="S1_Right" fill="#FFFFFF"
    					d="M201.489,482.674c-0.398,0.465-0.797,0.962-1.205,1.475c-0.985,1.236-2.004,2.516-3.197,3.498
    							c-2.071,1.706-9.058,7.051-10.275,7.728c-0.874,0.486-2.218,2.056-1.781,3.453l0.121,0.385l-0.181,0.36
    							c-0.188,0.375-0.247,0.673-0.181,0.91c0.118,0.426,0.668,0.778,1.108,0.998l0.399,0.2l0.068,0.178
    							c0.344-0.273,0.699-0.554,1.069-0.846C192.865,496.737,200.144,491.005,201.489,482.674z"></path>
    						<path class="background" id="S1_Right" fill="#FFFFFF"
    					d="M219.835,486.509c-0.062-0.457-0.123-0.879-0.184-1.284c-3.01,2.72-4.545,5.899-5.631,8.629
    							C216.696,492.628,220.365,490.442,219.835,486.509z"></path>
    						<path class="background" id="S1_Left" fill="#FFFFFF"
    					d="M224.45,484.271c-0.109,0.667-0.222,1.404-0.334,2.238c-0.627,4.654,4.631,6.867,7.158,7.93
    							c0.08,0.034,0.147,0.063,0.221,0.093C230.27,491.346,228.516,487.395,224.45,484.271z"></path>
    						<text transform="matrix(1 0 0 1 173.8311 493.8174)"
    					font-family="'ArialMT'" font-size="6">S1</text>
    						<text transform="matrix(1 0 0 1 218.9561 503.667)"
    					font-family="'ArialMT'" font-size="6">S1</text>
    						<text transform="matrix(1 0 0 1 264.0801 493.8174)"
    					font-family="'ArialMT'" font-size="6">S1</text>
    						<path class="background" id="S1_Left" fill="#FFFFFF"
    					d="M22.025,383.057c-1.692,0-3.101-0.348-4.28-0.943c1.389,7.164,3.563,20.52,3.563,33.846
    							c0,17.674-1.93,25.215-6.453,25.215c-2.471,0-6.352-4.173-8.763-7.087l0.042,0.577l-1.295-0.268
    							c-0.088-0.019-0.167-0.027-0.23-0.027c-0.031-0.033-0.156,0.151-0.112,0.767l0.062,0.849l-0.827,0.196
    							c-0.569,0.136-0.96,0.343-1.101,0.586c-0.159,0.273-0.055,0.723,0.037,1.036c0.192,0.656,0.411,0.841,0.743,1.121
    							c0.318,0.27,0.716,0.604,1.003,1.256c0.396,0.899,0.764,1.44,2.012,2.464c0.476,0.39,1.237,0.871,2.12,1.429
    							c1.028,0.649,2.308,1.458,3.594,2.418c1.26,0.94,1.888,1.992,2.441,2.921c0.755,1.267,1.406,2.36,3.637,3.29
    							c0.923,0.385,1.996,0.588,3.104,0.588c2.19,0,4.165-0.783,5.031-1.995c1.399-1.959,1.122-4.387,0.92-6.159l-0.017-0.147
    							c-0.123-1.077-0.388-2.276-0.6-3.24c-0.144-0.649-0.264-1.2-0.314-1.569c-0.066-0.488-0.044-0.893,0.029-1.246
    							c-1.208-2.777-1.206-6.847-1.196-11.134l0.002-1.125c0-2.943,1.05-7.393,2.065-11.694c0.685-2.904,1.332-5.646,1.631-7.795
    							c0.609-4.378,1.631-12.882,1.631-20.646c0-1.879-0.155-5.241-0.353-9.221C27.682,380.977,25.287,383.057,22.025,383.057z"></path>
    						<path class="background" id="S1_Right" fill="#FFFFFF"
    					d="M84.769,436.181l-0.827-0.196l0.062-0.849c0.044-0.61-0.073-0.79-0.075-0.791
    							c-0.102,0.024-0.179,0.033-0.268,0.052l-1.295,0.268l0.042-0.577c-2.411,2.914-6.292,7.087-8.763,7.087
    							c-4.523,0-6.453-7.541-6.453-25.215c0-13.313,2.171-26.655,3.563-33.846c-1.18,0.596-2.587,0.943-4.279,0.943
    							c-3.262,0-5.656-2.08-8.127-5.74c-0.197,3.979-0.353,7.342-0.353,9.221c0,7.765,1.021,16.269,1.631,20.646
    							c0.299,2.148,0.946,4.891,1.631,7.795c1.016,4.302,2.065,8.751,2.065,11.694l0.002,1.125c0.01,4.287,0.012,8.356-1.196,11.134
    							c0.073,0.353,0.096,0.757,0.029,1.245c-0.051,0.37-0.171,0.921-0.314,1.57c-0.212,0.964-0.477,2.163-0.6,3.24l-0.017,0.147
    							c-0.202,1.772-0.479,4.2,0.92,6.159c0.866,1.212,2.841,1.995,5.031,1.995c1.108,0,2.182-0.203,3.104-0.588
    							c2.23-0.93,2.882-2.023,3.637-3.29c0.554-0.929,1.182-1.98,2.441-2.921c1.286-0.96,2.565-1.769,3.594-2.418
    							c0.883-0.558,1.645-1.039,2.12-1.429c1.248-1.023,1.615-1.564,2.012-2.464c0.287-0.651,0.685-0.986,1.003-1.256
    							c0.332-0.28,0.551-0.465,0.743-1.121c0.092-0.313,0.196-0.763,0.037-1.036C85.729,436.523,85.338,436.316,84.769,436.181z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 21.3311 394)"
    					font-family="'ArialMT'" font-size="6">S1</text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 60.3311 394)"
    					font-family="'ArialMT'" font-size="6">S1</text>
    						</g>
    						<circle cx="17.375" cy="448.5" r="1.85"></circle>
    						<circle cx="71.625" cy="448.5" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="L5_Right" fill="#FFFFFF"
    					d="M212.727,494.418c1.154-3.028,2.742-6.783,6.282-9.961c-3.739-0.289-5.676-1.875-5.676-4.79
    							c0-16.467-12.98-90.649-19.7-116.307c-0.441,5.644-1.28,11.772-2.109,17.771c-1.416,10.239-2.753,19.911-2.077,26.517
    							c0.583,5.709,2.667,11.504,5.079,18.213c4.716,13.116,10.585,29.439,8.673,54.714l-0.031,0.408l-0.308,0.27
    							c-0.08,0.07-0.158,0.152-0.237,0.228c-0.802,9.45-8.718,15.712-14.567,20.318c-0.447,0.353-0.869,0.686-1.276,1.011
    							c0.191,0.195,0.449,0.19,0.923,0.19h0.5l0.3,0.525c0.211,0.28,0.465,0.495,1.2,0.495c0.356,0,0.745-0.003,1.167-0.038l0.616-0.035
    							l0.332,0.372c0.407,0.448,1.585,1.299,3.132,1.299c1.452,0,2.787-0.753,3.97-2.242l0.271-0.341l0.435-0.033
    							c3.768-0.289,5.514-1.926,5.959-2.421c1.078-1.198,4.566-4.707,5.813-5.538c0.268-0.178,0.67-0.348,1.28-0.604
    							C212.692,494.432,212.711,494.424,212.727,494.418z"></path>
    						<path class="background" id="L5_Left" fill="#FFFFFF"
    					d="M257.194,501.799c-5.503-4.333-12.834-10.133-14.354-18.672c-0.577-0.7-1.148-1.349-1.749-1.874
    							l-0.308-0.27l-0.031-0.408c-1.912-25.274,3.957-41.598,8.673-54.714c2.412-6.709,4.496-12.504,5.079-18.213
    							c0.676-6.605-0.661-16.277-2.077-26.517c-0.646-4.678-1.298-9.434-1.766-13.981c-6.93,28.525-18.746,96.747-18.746,112.517
    							c0,2.915-1.911,4.521-5.65,4.812c3.786,3.411,5.331,7.483,6.51,10.605c0.021,0.057,0.041,0.108,0.063,0.164
    							c1.425,1.091,4.524,4.216,5.53,5.333c0.445,0.495,2.191,2.132,5.959,2.422l0.435,0.033l0.271,0.342
    							c1.183,1.489,2.518,2.244,3.969,2.244c1.548,0,2.727-0.847,3.133-1.295l0.332-0.364l0.617,0.051
    							c0.421,0.036,0.81,0.069,1.166,0.069c0.735,0,0.989-0.277,1.2-0.558l0.3-0.525h0.5c0.796,0,0.991,0.025,1.266-0.947
    							C257.407,501.967,257.306,501.887,257.194,501.799z"></path>
    						<text transform="matrix(1 0 0 1 194.9961 417.167)"
    					font-family="'ArialMT'" font-size="6">L5</text>
    						<text transform="matrix(1 0 0 1 243.5801 417.167)"
    					font-family="'ArialMT'" font-size="6">L5</text>
    						<circle cx="199.074" cy="495.667" r="1.85"></circle>
    						<circle cx="246.175" cy="495.667" r="1.85"></circle>
    						<path class="background" id="L5_Left" fill="#FFFFFF"
    					d="M14.855,440.174c3.721,0,5.453-7.694,5.453-24.215c0-13.831-2.358-27.699-3.726-34.578
    							c-2.729-2.026-3.979-5.568-4.761-8.803c-0.719-2.98-1.846-9.781-3.039-16.981c-0.463-2.797-0.934-5.638-1.38-8.24
    							c-0.272,1.061-0.566,2.146-0.88,3.283c-1.682,6.109-3.773,13.713-3.773,24.86c0,7.901,1.979,21.837,5.761,33.184
    							c2.828,8.482,3.959,13.132,4.484,18.426l0.104,1.047l-1.051,0.051c-1.186,0.057-1.217,0.16-1.514,1.157
    							c-0.054,0.182-0.111,0.374-0.18,0.578l-0.239,0.715l-0.753-0.033c-0.099-0.004-0.191-0.007-0.279-0.007c-0.637,0-0.637,0-0.8,0.656
    							l-0.185,0.736l-0.759,0.021c-0.368,0.01-0.768,0.193-1.016,0.468c-0.045,0.05-0.063,0.109-0.097,0.163
    							C8.7,435.729,12.741,440.174,14.855,440.174z"></path>
    						<path class="background" id="L5_Right" fill="#FFFFFF"
    					d="M73.645,440.174c2.116,0,6.155-4.444,8.628-7.512c-0.034-0.054-0.052-0.113-0.097-0.163
    							c-0.248-0.274-0.647-0.458-1.016-0.468l-0.759-0.021l-0.185-0.736c-0.163-0.656-0.163-0.656-0.8-0.656
    							c-0.088,0-0.181,0.003-0.279,0.007l-0.753,0.033l-0.239-0.715c-0.068-0.204-0.126-0.396-0.18-0.578
    							c-0.297-0.997-0.328-1.101-1.514-1.157l-1.051-0.051l0.104-1.047c0.525-5.294,1.656-9.943,4.484-18.426
    							c3.782-11.347,5.761-25.282,5.761-33.184c0-11.147-2.092-18.751-3.773-24.86c-0.313-1.138-0.607-2.223-0.88-3.283
    							c-0.446,2.603-0.917,5.443-1.38,8.24c-1.193,7.2-2.32,14.001-3.039,16.981c-0.781,3.235-2.031,6.777-4.762,8.804
    							c-1.372,6.911-3.725,20.763-3.725,34.577C68.191,432.479,69.924,440.174,73.645,440.174z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 9.6631 403)"
    					font-family="'ArialMT'" font-size="6">L5</text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 73.6631 403)"
    					font-family="'ArialMT'" font-size="6">L5</text>
    						</g>
    					</g>
    					<g>
    						<path class="background" id="L4_Right" fill="#FFFFFF"
    					d="M218.718,480.292c-0.317-1.409-0.492-2.187-0.225-3.079c0.36-1.201,1.041-6.9-0.015-11.357
    							c-1.17-4.938-2.275-16.312-2.152-22.127c0.045-2.1,0.435-6.574,0.885-11.755c0.843-9.689,1.892-21.748,1.493-26.77
    							c-0.188-2.382-0.477-5.02-0.781-7.813c-0.694-6.363-1.413-12.942-0.965-16.88c0.061-0.536,0.14-1.361,0.231-2.394
    							c-5.177-1.648-13.572-5.141-22.349-14.085c6.691,26.159,19.492,99.55,19.492,115.634c0,2.436,1.623,3.657,5.038,3.837
    							C219.121,482.084,218.892,481.064,218.718,480.292z"></path>
    						<path class="background" id="L4_Left" fill="#FFFFFF"
    					d="M250.265,362.684c-9.598,10.315-18.941,13.96-23.506,15.403c0.093,1.048,0.173,1.883,0.234,2.425
    							c0.448,3.938-0.271,10.517-0.965,16.88c-0.305,2.793-0.593,5.431-0.781,7.813c-0.398,5.021,0.65,17.08,1.493,26.77
    							c0.45,5.181,0.84,9.655,0.885,11.755c0.123,5.815-0.982,17.189-2.152,22.127c-1.056,4.457-0.375,10.156-0.015,11.357
    							c0.268,0.893,0.093,1.67-0.225,3.079c-0.175,0.777-0.406,1.807-0.658,3.241c0.14,0.002,0.273,0.007,0.419,0.007
    							c1.746,0,3.062-0.226,4.02-0.688c1.28-0.618,1.902-1.66,1.902-3.185c0-16.537,12.812-89.474,19.465-115.521
    							C250.34,363.655,250.3,363.167,250.265,362.684z"></path>
    						<text transform="matrix(1 0 0 1 206.7529 401.334)"
    					font-family="'ArialMT'" font-size="6">L4</text>
    						<text transform="matrix(1 0 0 1 231.8223 401.334)"
    					font-family="'ArialMT'" font-size="6">L4</text>
    						<circle cx="217.25" cy="473.833" r="1.85"></circle>
    						<circle cx="227.999" cy="473.833" r="1.85"></circle>
    						<path class="background" id="L4_Left" fill="#FFFFFF"
    					d="M33.213,347.096l-2.397-2.397c-1.036,4.968-0.296,19.871,0.249,30.814c0.236,4.749,0.44,8.851,0.44,11.024
    							c0,7.825-1.028,16.381-1.641,20.785c-0.306,2.194-0.958,4.959-1.648,7.886c-1.002,4.246-2.038,8.638-2.038,11.465l-0.002,1.127
    							c-0.008,3.589-0.003,7.258,0.806,9.863c0.104-0.133,0.214-0.261,0.325-0.382c0.727-0.787,0.985-1.394,0.985-1.698
    							c0-0.664-0.104-1.455-0.862-2.743l-0.138-0.234v-0.272c0-6.695,1.719-12.942,3.539-19.557c2.127-7.728,4.537-16.487,4.537-27.527
    							c0-10.091-0.86-18.159-1.552-24.644C33.183,354.662,32.729,350.316,33.213,347.096z"></path>
    						<path class="background" id="L4_Right" fill="#FFFFFF"
    					d="M62.324,427.8l-0.002-1.127c0-2.827-1.036-7.219-2.038-11.465c-0.69-2.927-1.343-5.691-1.648-7.886
    							c-0.612-4.404-1.641-12.96-1.641-20.785c0-2.174,0.204-6.275,0.44-11.024c0.545-10.943,1.285-25.847,0.249-30.814l-2.397,2.397
    							c0.484,3.221,0.03,7.566-0.604,13.51c-0.691,6.484-1.552,14.553-1.552,24.644c0,11.04,2.41,19.8,4.537,27.527
    							c1.82,6.614,3.539,12.861,3.539,19.557v0.272l-0.138,0.234c-0.758,1.288-0.862,2.079-0.862,2.743c0,0.305,0.259,0.911,0.985,1.698
    							c0.111,0.121,0.221,0.249,0.325,0.382C62.327,435.058,62.332,431.389,62.324,427.8z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 31.5811 381.5)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">4</tspan></text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 53.8311 381.5)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">4</tspan></text>
    						</g>
    					</g>
    					<g>
    						<path class="background" id="L3_Right" fill="#FFFFFF"
    					d="M180.377,275.566c1.685,22.415,5.71,39.528,8.915,53.143c2.604,11.058,4.659,19.791,4.659,27.541
    							c0,1.654-0.07,3.399-0.182,5.196c9.063,9.984,17.929,13.839,23.51,15.648c0.844-9.857,2.547-34.288,2.547-39.97
    							c0-2.706-0.408-7.015-0.841-11.576c-0.234-2.477-0.472-4.984-0.658-7.357c-3.184,1.608-5.916,2.41-8.274,2.41
    							C197.187,320.602,186.707,294.186,180.377,275.566z"></path>
    						<path class="background" id="L3_Left" fill="#FFFFFF"
    					d="M250.176,361.332c-0.107-1.756-0.176-3.464-0.176-5.082c0-7.75,2.056-16.483,4.659-27.541
    							c3.205-13.615,7.231-30.729,8.915-53.146c-6.344,18.656-16.818,45.039-29.676,45.039c-2.356,0-5.089-0.802-8.274-2.41
    							c-0.187,2.373-0.424,4.881-0.658,7.357c-0.433,4.562-0.841,8.87-0.841,11.576c0,5.675,1.699,30.055,2.544,39.935
    							C232.278,375.228,241.135,371.338,250.176,361.332z"></path>
    						<text transform="matrix(1 0 0 1 197.5869 343.5)"
    					font-family="'ArialMT'" font-size="6">L3</text>
    						<text transform="matrix(1 0 0 1 239.582 343.5)"
    					font-family="'ArialMT'" font-size="6">L3</text>
    						<circle cx="216.25" cy="354.75" r="1.85"></circle>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M200.924,351.136
    							c0,1.034-0.163,3.806,1.536,5.948"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M212.842,351.801
    							c0,1.404,0.222,3.178-1.515,5.283"></path>
    						<circle cx="227.589" cy="354.75" r="1.85"></circle>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M242.915,351.136
    							c0,1.034,0.163,3.806-1.536,5.948"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M230.997,351.801
    							c0,1.404-0.222,3.178,1.515,5.283"></path>
    						<path class="background" id="L3_Left" fill="#FFFFFF"
    					d="M39.438,295.983c-1.823-0.001-3.477-1.186-5.011-2.864c-0.367,3.009-0.538,5.798-0.538,8.101
    							c0,2.286,0.123,3.997,0.267,5.978c0.194,2.696,0.415,5.752,0.415,11.266c0,9.121-1.822,18.102-3.491,25.086l2.355,2.355
    							c0.43-2.021,1.044-3.831,1.703-5.72c1.345-3.857,2.736-7.846,2.736-14.56c0-10.439,0.126-22.155,1.565-29.642H39.438
    							C39.438,295.983,39.438,295.983,39.438,295.983z"></path>
    						<path class="background" id="L3_Right" fill="#FFFFFF"
    					d="M53.929,318.463c0-5.514,0.221-8.569,0.415-11.266c0.144-1.98,0.267-3.691,0.267-5.978
    							c0-2.303-0.17-5.092-0.538-8.101c-1.534,1.679-3.188,2.864-5.011,2.864c-0.001,0-0.001,0-0.002,0
    							c1.439,7.486,1.565,19.202,1.565,29.642c0,6.714,1.392,10.702,2.736,14.56c0.659,1.889,1.273,3.699,1.703,5.72l2.355-2.355
    							C55.751,336.564,53.929,327.584,53.929,318.463z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 35.1553 300.75)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">3</tspan></text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 51.1553 300.75)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">3</tspan></text>
    						</g>
    					</g>
    					<g>
    						<path class="background" id="L2_Right" fill="#FFFFFF"
    					d="M220.506,291.125c-0.659-0.372-1.307-0.731-1.935-1.076c-2.413-1.323-4.693-2.574-7.257-4.596
    							c-3.877-3.058-10.558-11.953-13.02-20.703l-0.516-1.84c-2.516-8.986-6.316-22.566-9.442-25.711
    							c-2.951-2.969-4.275-3.268-7.814-4.068c-0.042-0.009-0.092-0.021-0.134-0.031c-0.271,2.996-0.481,6.179-0.605,9.603
    							c-0.381,10.501-0.21,20.102,0.327,28.916c5.856,17.646,16.976,47.982,29.942,47.982c2.283,0,4.985-0.819,8.193-2.486
    							c-0.259-3.557-0.379-6.742-0.165-8.961C218.725,301.453,219.465,294.869,220.506,291.125z"></path>
    						<path class="background" id="L2_Left" fill="#FFFFFF"
    					d="M255.613,237.199c-3.126,3.145-6.927,16.724-9.442,25.71l-0.516,1.841
    							c-2.462,8.75-9.143,17.646-13.02,20.703c-2.563,2.021-4.844,3.272-7.257,4.596c-0.628,0.345-1.274,0.704-1.934,1.075
    							c1.041,3.744,1.781,10.328,2.425,17.03c0.214,2.219,0.094,5.404-0.165,8.962c3.207,1.666,5.909,2.485,8.192,2.485
    							c12.979,0,24.105-30.392,29.943-47.984c0.537-8.814,0.708-18.413,0.327-28.914c-0.124-3.423-0.335-6.606-0.605-9.603
    							c-0.043,0.01-0.093,0.021-0.135,0.031C259.889,233.931,258.564,234.23,255.613,237.199z"></path>
    						<text transform="matrix(1 0 0 1 197.5869 295.875)"
    					font-family="'ArialMT'" font-size="6">L2</text>
    						<text transform="matrix(1 0 0 1 239.6895 295.875)"
    					font-family="'ArialMT'" font-size="6">L2</text>
    						<circle cx="211.281" cy="301.492" r="1.85"></circle>
    						<circle cx="232.669" cy="301.492" r="1.85"></circle>
    						<path class="background" id="L2_Left" fill="#FFFFFF"
    					d="M39.438,294.983L39.438,294.983c0.067,0,0.132-0.016,0.197-0.02c0.875-4.507,1.858-11.776,2.584-17.151
    							c0.584-4.32,0.896-6.604,1.068-7.209l0.462-1.636v-1.616c-5.104,5.556-7.942,15.728-9.15,24.44
    							C36.108,293.589,37.753,294.982,39.438,294.983z"></path>
    						<path class="background" id="L2_Right" fill="#FFFFFF"
    					d="M49.062,294.983c1.685,0,3.33-1.394,4.839-3.191c-1.208-8.713-4.046-18.884-9.15-24.44v1.616l0.462,1.636
    							c0.172,0.605,0.484,2.889,1.068,7.209c0.726,5.375,1.709,12.645,2.584,17.151C48.93,294.968,48.995,294.983,49.062,294.983z"></path>
    						<g>
    							<text transform="matrix(1 0 0 1 37.0811 286)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">2</tspan></text>
    						</g>
    						<g>
    							<text transform="matrix(1 0 0 1 49.0811 286)">
    				<tspan x="0" y="0" font-family="'ArialMT'" font-size="6">L</tspan>
    				<tspan x="0" y="6" font-family="'ArialMT'" font-size="6">2</tspan></text>
    						</g>
    					</g>
    					<g>
    						<path class="background" id="L1_Right" fill="#FFFFFF"
    					d="M195.422,234.154c-5.831-6.051-10.029-14.372-11.77-22.805c-1.18,6.031-2.394,12.683-3.168,20.747
    							c0.084,0.019,0.179,0.041,0.26,0.06c3.64,0.823,5.146,1.163,8.302,4.338c3.31,3.33,7.153,17.06,9.695,26.146l0.516,1.839
    							c2.403,8.545,8.906,17.215,12.676,20.188c2.498,1.97,4.743,3.201,7.119,4.504c0.564,0.31,1.158,0.645,1.75,0.979
    							c0.082-0.239-0.054-0.462,0.032-0.665l0.165-0.911c0-6.8,0-18.268,0-18.574c-3-4.515-8.061-14.359-9.236-20.821
    							c-0.049-0.271,0.241-0.532,0.513-0.581c0.268-0.053,0.6,0.129,0.649,0.402c1.115,6.134,6.074,15.417,9.074,20.015v-23.651
    							C212,245.365,202.49,241.488,195.422,234.154z"></path>
    						<path class="background" id="L1_Left" fill="#FFFFFF"
    					d="M260.305,211.35c-1.741,8.433-5.92,16.754-11.752,22.805c-7.066,7.334-16.553,11.21-26.553,11.21v23.651
    							c3-4.598,7.879-13.881,8.994-20.015c0.051-0.273,0.312-0.455,0.576-0.402c0.271,0.049,0.21,0.31,0.161,0.581
    							c-1.18,6.485-5.731,16.379-9.731,20.872c0,0.412,0,11.659,0,18.443l0.658,0.991c0.086,0.203,0.289,0.426,0.371,0.665
    							c0.592-0.334,1.245-0.669,1.81-0.979c2.376-1.303,4.651-2.534,7.149-4.504c3.77-2.974,10.287-11.644,12.69-20.188l0.522-1.839
    							c2.543-9.086,6.391-22.817,9.7-26.146c3.156-3.175,4.665-3.516,8.305-4.338c0.081-0.019,0.179-0.041,0.263-0.06
    							C262.694,224.032,261.484,217.38,260.305,211.35z"></path>
    						<text transform="matrix(1 0 0 1 194.6387 245.6514)"
    					font-family="'ArialMT'" font-size="6">L1</text>
    						<text transform="matrix(1 0 0 1 242.6387 245.6514)"
    					font-family="'ArialMT'" font-size="6">L1</text>
    						<circle cx="205.976" cy="258.651" r="1.85"></circle>
    						<circle cx="237.976" cy="258.651" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T12_Right" fill="#FFFFFF"
    					d="M188.337,203.539c-0.89-1.071-1.765-2.117-2.615-3.111c-0.438,2.635-0.974,5.356-1.548,8.254
    							c1.306,8.931,5.543,17.991,11.718,24.517c6.912,7.305,16.107,11.166,26.107,11.166v-19.213
    							C206,225.151,196.33,213.168,188.337,203.539z"></path>
    						<path class="background" id="T12_Left" fill="#FFFFFF"
    					d="M258.233,200.425c-0.851,0.997-1.708,2.041-2.597,3.112c-7.992,9.63-17.637,21.614-33.637,21.614v19.213
    							c10,0,19.172-3.861,26.084-11.166c6.176-6.526,10.396-15.586,11.701-24.517C259.211,205.783,258.673,203.062,258.233,200.425z"></path>
    						<text transform="matrix(1 0 0 1 216.8066 235.6514)"
    					font-family="'ArialMT'" font-size="6">T12</text>
    						<circle cx="203.976" cy="233.651" r="1.85"></circle>
    						<circle cx="239.976" cy="233.651" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T11_Right" fill="#FFFFFF"
    					d="M188.542,193.71c-0.622-0.597-1.23-1.173-1.822-1.736c-0.135,2.364-0.412,4.729-0.789,7.158
    							c1.017,1.174,2.077,2.435,3.18,3.764c7.858,9.47,17.89,21.256,32.89,21.256v-10C210,214.151,198.035,202.817,188.542,193.71z"></path>
    						<path class="background" id="T11_Left" fill="#FFFFFF"
    					d="M257.237,191.974c-0.592,0.563-1.181,1.14-1.804,1.736C245.939,202.817,234,214.151,222,214.151v10
    							c15,0,25.008-11.786,32.867-21.256c1.102-1.329,2.146-2.59,3.162-3.764C257.652,196.703,257.372,194.338,257.237,191.974z"></path>
    						<text transform="matrix(1 0 0 1 216.6807 221.6514)"
    					font-family="'ArialMT'" font-size="6">T11</text>
    						<circle cx="206.85" cy="215.651" r="1.85"></circle>
    						<circle cx="236.85" cy="215.651" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T10_Right" fill="#FFFFFF"
    					d="M186.63,182.304c-0.316-0.286-0.63-0.561-0.942-0.841c0.723,4.014,1.153,7.298,1.097,9.194
    							c0.785,0.746,1.609,1.525,2.45,2.332C198.6,201.972,210,213.151,222,213.151v-13C206,200.151,194.976,189.836,186.63,182.304z"></path>
    						<path class="background" id="T10_Left" fill="#FFFFFF"
    					d="M257.346,182.304C249,189.836,238,200.151,222,200.151v13c12,0,23.377-11.18,32.742-20.163
    							c0.84-0.807,1.647-1.586,2.433-2.332c-0.057-1.896,0.38-5.18,1.103-9.194C257.966,181.743,257.662,182.019,257.346,182.304z"></path>
    						<text transform="matrix(1 0 0 1 216.8066 210.6514)"
    					font-family="'ArialMT'" font-size="6">T10</text>
    						<circle cx="206.976" cy="203.651" r="1.85"></circle>
    						<circle cx="236.976" cy="203.651" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T9_Right" fill="#FFFFFF"
    					d="M183.897,172.551c0.558,2.557,1.061,5.022,1.493,7.3c0.625,0.558,1.269,1.129,1.914,1.71
    							c8.684,7.837,19.697,17.59,34.697,17.59v-11C207,188.151,193.4,179.341,183.897,172.551z"></path>
    						<path class="background" id="T9_Left" fill="#FFFFFF"
    					d="M222,188.151v11c15,0,25.992-9.753,34.676-17.59c0.645-0.582,1.271-1.153,1.897-1.71
    							c0.432-2.278,0.951-4.743,1.509-7.3C250.579,179.341,237,188.151,222,188.151z"></path>
    						<text transform="matrix(1 0 0 1 219.124 196.7061)"
    					font-family="'ArialMT'" font-size="6">T9</text>
    						<circle cx="206.625" cy="192.697" r="1.85"></circle>
    						<circle cx="236.976" cy="192.697" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T8_Right" fill="#FFFFFF"
    					d="M181.395,161.709c0.75,3.107,1.501,6.292,2.187,9.38c9.415,6.789,23.418,16.062,38.418,16.062v-10
    							C210,177.151,195.873,171.948,181.395,161.709z"></path>
    						<path class="background" id="T8_Left" fill="#FFFFFF"
    					d="M222,177.151v10c15,0,28.984-9.273,38.4-16.062c0.686-3.089,1.437-6.273,2.187-9.38
    							C248.109,171.948,234,177.151,222,177.151z"></path>
    						<text transform="matrix(1 0 0 1 219.124 184.7061)"
    					font-family="'ArialMT'" font-size="6">T8</text>
    						<circle cx="206.625" cy="180.697" r="1.85"></circle>
    						<circle cx="236.976" cy="180.697" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T7_Right" fill="#FFFFFF"
    					d="M178.975,149.075c-0.327-0.264-0.643-0.511-0.958-0.763c0.896,3.426,1.959,7.563,3.021,11.916
    							C195.694,170.787,209,176.151,222,176.151v-10C200,166.151,187.416,155.875,178.975,149.075z"></path>
    						<path class="background" id="T7_Left" fill="#FFFFFF"
    					d="M265,149.075c-8.439,6.8-21,17.077-43,17.077v10c12,0,26.285-5.364,40.939-15.924
    							c1.063-4.354,2.115-8.49,3.012-11.916C265.637,148.564,265.328,148.811,265,149.075z"></path>
    						<text transform="matrix(1 0 0 1 219.124 173.7061)"
    					font-family="'ArialMT'" font-size="6">T7</text>
    						<circle cx="206.625" cy="169.697" r="1.85"></circle>
    						<circle cx="236.976" cy="169.697" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T6_Right" fill="#FFFFFF"
    					d="M176.372,142.148c0.332,1.198,0.745,2.75,1.22,4.546c0.645,0.51,1.316,1.04,2.013,1.602
    							c8.332,6.712,21.395,16.855,42.395,16.855v-7.795C202,157.356,184.75,147.459,176.372,142.148z"></path>
    						<path class="background" id="T6_Left" fill="#FFFFFF"
    					d="M222,157.356v7.795c21,0,34.041-10.144,42.373-16.855c0.697-0.562,1.354-1.092,1.998-1.602
    							c0.476-1.797,0.904-3.348,1.236-4.546C259.229,147.459,242,157.356,222,157.356z"></path>
    						<text transform="matrix(1 0 0 1 219.124 163.7061)"
    					font-family="'ArialMT'" font-size="6">T6</text>
    						<circle cx="206.625" cy="159.697" r="1.85"></circle>
    						<circle cx="236.976" cy="159.697" r="1.85"></circle>
    					</g>
    					<g>
    					    <path class="background" id="T5_Right" fill="#FFFFFF"
    					d="M195.939,143.887l-0.284-0.044c-4.743-0.756-14.474-3.29-21.185-6.463l1.442,3.176
    							c0.013,0.044,0.041,0.102,0.054,0.148c7.935,5.075,25.034,15.653,46.034,15.653v-10C211,146.356,201.73,144.811,195.939,143.887z"></path>
    						<path class="background" id="T5_Left" fill="#FFFFFF"
    					d="M248.302,143.843l-0.265,0.044c-5.793,0.923-15.037,2.469-26.037,2.469v10c21,0,38.076-10.578,46.01-15.653
    							c0.014-0.046,0.023-0.104,0.036-0.148l1.44-3.176C262.775,140.553,253.045,143.087,248.302,143.843z"></path>
    						<text transform="matrix(1 0 0 1 219.124 153.1978)"
    					font-family="'ArialMT'" font-size="6">T5</text>
    						<circle cx="206.625" cy="150.198" r="1.85"></circle>
    						<circle cx="236.976" cy="150.198" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T4_Right" fill="#FFFFFF"
    					d="M209.951,133c-0.266,0.001-26.396,0.13-35.767,3.376c6.483,3.211,16.523,5.79,21.635,6.604
    							c5.346,0.852,15.18,2.438,26.18,2.438V133H209.951z"></path>
    						<path class="background" id="T4_Left" fill="#FFFFFF"
    					d="M233.998,133H222v12.419c10,0,19.873-1.529,25.594-2.442l0.556-0.09c5.227-0.833,15.323-3.39,21.618-6.496
    							C260.395,133.144,234.265,133.001,233.998,133z"></path>
    						<text transform="matrix(1 0 0 1 219.124 141.1978)"
    					font-family="'ArialMT'" font-size="6">T4</text>
    						<circle cx="206.625" cy="139.198" r="1.85"></circle>
    						<circle cx="236.976" cy="139.198" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T3_Right" fill="#FFFFFF"
    					d="M177.631,131.76c-1.938,0.664-3.427,1.175-4.36,1.449c0.099,0.379,0.191,0.755,0.281,1.118
    							c0.097,0.39,0.189,0.762,0.279,1.102c9.524-3.311,35.019-3.424,36.118-3.428H222v-7.933c-12,0-20.881,0.5-29.652,2.987
    							C186.679,128.662,181.444,130.452,177.631,131.76z"></path>
    						<path class="background" id="T3_Left" fill="#FFFFFF"
    					d="M266.378,131.884c-3.826-1.33-9.052-3.152-14.751-4.768c-8.955-2.539-17.627-3.049-29.627-3.049V132h12
    							c1.102,0.003,26.601,0.117,36.124,3.429c0.109-0.401,0.224-0.838,0.346-1.301l0.21-0.795
    							C269.756,133.059,268.287,132.548,266.378,131.884z"></path>
    						<text transform="matrix(1 0 0 1 219.124 130.1978)"
    					font-family="'ArialMT'" font-size="6">T3</text>
    						<circle cx="206.625" cy="128.198" r="1.85"></circle>
    						<circle cx="236.976" cy="128.198" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T2_Right" fill="#FFFFFF"
    					d="M205,119c-7.693,0-13.452-0.75-20.124-4.58c-1.88-1.079-3.607-2.127-5.22-3.169
    							c-3.67,5.34-8.661,13.89-11.289,20.227l-0.898,2.165c-2.515,6.06-5.362,12.921-6.948,17.166c0.851,5.844,2.497,9.083,5.217,11.932
    							c2.933-8.679,7.015-19.175,8.287-22.287l0.177-0.431c-0.22-0.764-0.424-1.453-0.63-2.146c-0.411-1.385-0.83-2.797-1.393-4.889
    							l-0.133-0.491l0.494-0.124c0.809-0.203,2.555-0.801,4.767-1.56c3.824-1.311,9.074-3.106,14.768-4.721
    							c8.884-2.519,17.925-3.025,29.925-3.025V119H205z"></path>
    						<path class="background" id="T2_Left" fill="#FFFFFF"
    					d="M277.108,133.699l-0.921-2.221c-2.644-6.375-7.68-14.991-11.356-20.324
    							c-1.696,1.078-3.338,2.017-4.835,2.875l-0.683,0.391c-6.672,3.83-12.431,4.58-20.124,4.58H222v4.067c12,0,21.018,0.506,29.9,3.025
    							c5.695,1.615,10.926,3.41,14.75,4.721c2.212,0.758,3.955,1.357,4.764,1.56l0.493,0.124l-0.134,0.491
    							c-0.563,2.092-0.982,3.504-1.394,4.889c-0.206,0.694-0.41,1.383-0.63,2.146l0.177,0.431c1.27,3.104,5.335,13.558,8.266,22.225
    							c2.889-3.056,4.52-6.565,5.291-13.322C281.849,145.119,279.332,139.055,277.108,133.699z"></path>
    						<text transform="matrix(1 0 0 1 179.7871 123.8872)"
    					font-family="'ArialMT'" font-size="6">T2</text>
    						<text transform="matrix(1 0 0 1 257.1621 123.8872)"
    					font-family="'ArialMT'" font-size="6">T2</text>
    						<circle cx="172.661" cy="132.047" r="1.85"></circle>
    						<circle cx="271.29" cy="132.047" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="T1_Right" fill="#FFFFFF"
    					d="M158.85,154.77c-2.231,19.855-21.105,57.985-27.486,69.139c0.192,5.53,0.884,7.406,1.574,8.001
    							c7.265-9.441,17.944-26.133,19.601-29.819c2.051-4.563,3.084-9.418,3.914-13.319c0.751-3.525,1.344-6.309,2.433-7.849
    							c2.012-2.843,2.615-4.78,4.614-11.199c0.299-0.96,0.629-2.018,0.997-3.19c0.274-0.872,0.57-1.783,0.882-2.72
    							c-2.796-2.79-4.568-5.836-5.562-11.09C159.593,153.277,159.27,153.963,158.85,154.77z"></path>
    						<path class="background" id="T1_Left" fill="#FFFFFF"
    					d="M313.096,223.908c-6.43-11.238-25.407-49.595-27.514-69.375c-0.461-0.901-0.797-1.646-0.998-2.217
    							c-0.106-0.305-0.226-0.634-0.354-0.983c-0.927,6.064-2.744,9.436-5.679,12.414c0.319,0.961,0.623,1.895,0.904,2.787
    							c0.368,1.172,0.698,2.229,0.997,3.19c1.999,6.419,2.603,8.356,4.614,11.199c1.089,1.54,1.682,4.324,2.433,7.849
    							c0.83,3.901,1.863,8.756,3.914,13.319c1.665,3.705,12.446,20.552,19.713,29.966l0.046,0.059
    							C311.962,231.849,312.87,230.379,313.096,223.908z"></path>
    						<text transform="matrix(1 0 0 1 148.3916 193.6665)"
    					font-family="'ArialMT'" font-size="6">T1</text>
    						<text transform="matrix(1 0 0 1 289.0645 193.6665)"
    					font-family="'ArialMT'" font-size="6">T1</text>
    						<circle cx="161.424" cy="169.667" r="1.85"></circle>
    						<circle cx="283.035" cy="169.667" r="1.85"></circle>
    						<path class="background" id="T1_Right" fill="#FFFFFF"
    					d="M139.073,309.262c-3.702,7.065-8.618,17.221-11.537,24.455l-0.028,0.069
    							c0.63,0.549,2.357,0.588,8.054-2.487c2.229-3.88,6.495-10.689,11.783-18.428L139.073,309.262z"></path>
    						<path class="background" id="T1_Left" fill="#FFFFFF"
    					d="M312.2,308.262c3.702,7.065,8.618,17.221,11.537,24.455l0.028,0.069c-0.63,0.549-2.357,0.588-8.054-2.487
    							c-2.229-3.88-6.495-10.689-11.783-18.428L312.2,308.262z"></path>
    					</g>
    					<g>
    						<path class="background" id="C8_Right" fill="#FFFFFF"
    					d="M108.171,366.238c0.468-0.298,0.98-0.627,1.551-0.984l1.506-0.945c3.835-6.307,14.022-20.793,22.834-30.142
    							l0.196-0.435c0.093-0.211,0.233-0.489,0.417-0.837c-4.423,2.259-6.769,2.722-7.905,1.566c-9.161,6.702-22.589,21.401-24.166,24.714
    							c-0.592,1.243-0.311,3.068,0.302,4.115c0.183,0.311,0.33,0.436,0.372,0.459l0.013,0.006c1.099-3.088,8.188-10.062,10.641-12.308
    							c0.202-0.186,0.518-0.172,0.706,0.03c0.188,0.207,0.174,0.52-0.031,0.707c-3.799,3.479-9.727,9.735-10.415,12.057l0,0l0,0
    							l-0.491,0.914c-0.67,1.132-0.53,1.665-0.332,2.003c0.093,0.154,0.225,0.314,0.396,0.475
    							C104.598,368.407,104.773,368.416,108.171,366.238z"></path>
    						<circle cx="108.593" cy="353" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 114.166 349)"
    					font-family="'ArialMT'" font-size="6">C8</text>
    						<path class="background" id="C8_Left" fill="#FFFFFF"
    					d="M343.103,365.238c-0.468-0.298-0.98-0.627-1.551-0.984l-1.506-0.945
    							c-3.835-6.307-14.022-20.793-22.834-30.142l-0.196-0.435c-0.093-0.211-0.233-0.489-0.417-0.837
    							c4.423,2.259,6.769,2.722,7.905,1.566c9.161,6.702,22.589,21.401,24.166,24.714c0.592,1.243,0.311,3.068-0.302,4.115
    							c-0.183,0.311-0.33,0.436-0.372,0.459l-0.013,0.006c-1.099-3.088-8.188-10.062-10.641-12.308c-0.202-0.186-0.518-0.172-0.706,0.03
    							c-0.188,0.207-0.174,0.52,0.031,0.707c3.799,3.479,9.727,9.735,10.415,12.057l0,0l0,0l0.491,0.914
    							c0.67,1.132,0.53,1.665,0.332,2.003c-0.093,0.154-0.225,0.314-0.396,0.475C346.676,367.407,346.5,367.416,343.103,365.238z"></path>
    						<circle cx="342.161" cy="351.351" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 329.2451 349)"
    					font-family="'ArialMT'" font-size="6">C8</text>
    						<path class="background" id="C8_Right" fill="#FFFFFF"
    					d="M130.434,225.481c-0.206,0.334-0.378,0.597-0.513,0.785l-0.275,0.386
    							c-3.795,12.952-11.729,30.099-15.006,35.923l-0.024,0.79c-0.021,0.673-0.045,1.283-0.066,1.836
    							c-0.161,4.033-0.064,4.18,1.023,4.509c0.225,0.067,0.43,0.102,0.61,0.102c0.392,0,0.922-0.147,1.561-1.297l0.526-0.948
    							c1.656-1.769,4.026-10.03,5.108-15.065c0.059-0.271,0.32-0.442,0.595-0.384c0.27,0.058,0.441,0.324,0.384,0.594
    							c-0.7,3.254-3.14,12.92-5.252,15.412l0.067,0.045c0.039,0.023,0.223,0.088,0.582,0.088c1.213-0.001,2.93-0.681,3.702-1.818
    							c2.075-3.054,8.029-22.272,9.132-33.537C131.34,232.174,130.688,229.898,130.434,225.481z"></path>
    						<path class="background" id="C8_Left" fill="#FFFFFF"
    					d="M329.402,265.201c-0.021-0.553-0.046-1.163-0.066-1.836l-0.056-1.776
    							c-3.501-6.496-10.854-22.608-14.467-34.937l-0.276-0.388c-0.135-0.188-0.306-0.45-0.512-0.784
    							c-0.286,4.958-1.072,7.216-2.643,7.615c1.152,11.29,7.049,30.306,9.112,33.342c0.772,1.139,2.489,1.818,3.702,1.818
    							c0.359,0,0.543-0.064,0.583-0.089l0.013-0.008c-2.109-2.508-4.544-12.151-5.243-15.401c-0.058-0.27,0.114-0.536,0.384-0.594
    							c0.274-0.058,0.536,0.113,0.595,0.384c1.082,5.035,3.484,13.313,5.141,15.081l0,0l0,0l0.539,0.886
    							c0.639,1.149,1.169,1.298,1.561,1.297c0.181,0,0.386-0.034,0.61-0.102C329.467,269.381,329.563,269.234,329.402,265.201z"></path>
    					</g>
    					<g>
    						<path class="background" id="C7_Right" fill="#FFFFFF"
    					d="M112.192,364.639l-1.059,1.94c-1.862,3.401-5.496,10.013-2.887,11.784c1.091,0.741,4.808-4.346,6.394-6.519
    							c0.934-1.278,1.817-2.487,2.597-3.399l2.365-2.762c4.583-9.415,10.18-21.916,13.176-28.635
    							C124.628,346.174,115.824,358.721,112.192,364.639z"></path>
    						<circle cx="112.292" cy="370.333" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 114.7588 363)"
    					font-family="'ArialMT'" font-size="6">C7</text>
    						<path class="background" id="C7_Left" fill="#FFFFFF"
    					d="M339.081,363.639l1.059,1.94c1.862,3.401,5.496,10.013,2.887,11.784c-1.091,0.741-4.808-4.346-6.394-6.519
    							c-0.934-1.278-1.817-2.487-2.597-3.399l-2.365-2.762c-4.583-9.415-10.18-21.916-13.176-28.635
    							C326.646,345.174,335.449,357.721,339.081,363.639z"></path>
    						<circle cx="337.619" cy="367.106" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 328.2451 361.4795)"
    					font-family="'ArialMT'" font-size="6">C7</text>
    						<path class="background" id="C7_Right" fill="#FFFFFF"
    					d="M104.047,271.264c2.865,1.367,6.718-5.121,8.712-8.445l1.977-3.292l-0.025,0.821
    							c3.378-6.452,9.467-19.868,13.099-31.131c-4.548,6.35-13.242,18.531-19.112,27.447l-0.634,1.83
    							c-0.393,1.134-0.989,2.506-1.621,3.959C105.369,264.92,102.857,270.697,104.047,271.264z"></path>
    						<path class="background" id="C7_Left" fill="#FFFFFF"
    					d="M330.055,260.924l1.138,1.895c1.995,3.326,5.862,9.803,8.711,8.445c1.19-0.566-1.321-6.344-2.394-8.811
    							c-0.632-1.453-1.229-2.825-1.621-3.959l-1.189-3.436c-5.808-8.712-13.766-19.861-18.049-25.842
    							C320.405,240.862,326.782,254.799,330.055,260.924z"></path>
    					</g>
    					<g>
    						<path class="background" id="C6_Left" fill="#FFFFFF"
    					d="M345.364,244.105c-6.256-5.164-11.391-12.463-12.356-13.874c-2.03-2.966-4.431-4.417-7.555-4.565
    							l-0.73-0.035l-0.188-0.708c-1-3.763-1.884-7.724-2.819-11.918c-1.843-8.259-3.748-16.799-6.642-23.964
    							c-0.165-0.41-0.341-0.824-0.523-1.24c-0.774-0.613-1.614-1.263-2.501-1.949c-2.501-1.936-5.337-4.129-8.188-6.621
    							c-5.92-5.173-13.652-16.435-17.289-22.869c3.396,22.341,25.455,65.018,28.53,69.322l1.245,1.74
    							c3.88,5.416,12.27,17.127,18.48,26.401l2.806,3.741c0.725,0.967,1.384,1.898,1.996,2.768c1.934,2.736,3.46,4.898,4.842,4.898
    							c0.352,0,0.729-0.133,1.154-0.406c1.238-0.798,0.181-3.895-3.146-9.205l-0.16-0.258c-1.653-2.646-3.051-5.562-3.935-8.213
    							l-0.988-2.961l2.524,1.836c2.313,1.682,3.976,2.465,5.233,2.465c0.975,0,1.76-0.483,2.712-1.263
    							c0.083-0.068,0.083-0.095,0.083-0.124C347.951,246.901,347.766,246.086,345.364,244.105z"></path>
    						<path class="background" id="C6_Right" fill="#FFFFFF"
    					d="M140.693,179.231c-2.851,2.491-5.687,4.685-8.188,6.621c-1.251,0.968-2.401,1.86-3.413,2.68
    							c-0.071,0.169-0.147,0.341-0.215,0.509c-2.894,7.165-4.799,15.705-6.642,23.964c-0.936,4.194-1.819,8.155-2.819,11.918
    							l-0.188,0.708l-0.73,0.035c-3.124,0.148-5.524,1.599-7.555,4.565c-0.966,1.411-6.101,8.71-12.356,13.874
    							c-2.401,1.981-2.587,2.796-2.586,2.999c0,0.028,0,0.055,0.083,0.124c0.952,0.78,1.737,1.263,2.712,1.263
    							c1.258,0,2.921-0.784,5.233-2.465l2.524-1.836l-0.988,2.961c-0.884,2.651-2.281,5.568-3.935,8.213l-0.16,0.258
    							c-3.326,5.311-4.384,8.407-3.146,9.205c0.426,0.273,0.803,0.406,1.154,0.406c1.382,0,2.908-2.162,4.842-4.9
    							c0.613-0.867,1.271-1.8,1.996-2.766l3.837-5.116l-0.162,0.47c6.146-9.13,14.117-20.257,17.871-25.497l1.244-1.739
    							c2.963-4.148,24.59-45.959,28.395-68.48C153.55,163.998,146.067,174.535,140.693,179.231z"></path>
    						<text transform="matrix(1 0 0 1 128.832 208)"
    					font-family="'ArialMT'" font-size="6">C6</text>
    						<text transform="matrix(1 0 0 1 307.957 208)"
    					font-family="'ArialMT'" font-size="6">C6</text>
    						<path class="background" id="C6_Right" fill="#FFFFFF"
    					d="M134.172,335.882c-2.712,6.085-8.577,19.242-13.441,29.289l-1.81,4.313c-0.47,1.114-0.938,2.152-1.381,3.12
    							c-1.383,3.052-2.479,5.461-1.778,6.654c0.176,0.302,0.481,0.563,0.933,0.791c1.314,0.664,3.452-1.813,6.354-7.367l0.141-0.268
    							c1.446-2.765,3.258-5.444,5.098-7.547l2.057-2.35l-0.308,3.107c-0.282,2.846-0.119,4.676,0.518,5.761
    							c0.49,0.842,1.307,1.272,2.46,1.701c0.101,0.036,0.124,0.023,0.147,0.01c0.179-0.104,0.787-0.674,1.28-3.746
    							c1.295-8.008,4.998-16.128,5.729-17.674c1.532-3.252,1.571-6.057,0.121-8.826l-0.337-0.649l0.512-0.52
    							c2.743-2.766,5.714-5.528,8.86-8.455c1.658-1.543,3.33-3.101,4.983-4.672l-0.133-0.139l-5.667-14.729l-0.511-0.358
    							c-6.924,10.125-12.042,18.56-12.955,20.6L134.172,335.882z"></path>
    						<circle cx="134.01" cy="361.75" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 130.1748 353.584)"
    					font-family="'ArialMT'" font-size="6">C6</text>
    						<path class="background" id="C6_Left" fill="#FFFFFF"
    					d="M317.102,334.882c2.712,6.085,8.577,19.242,13.441,29.289l1.81,4.313c0.47,1.114,0.938,2.152,1.381,3.12
    							c1.383,3.052,2.479,5.461,1.778,6.654c-0.176,0.302-0.481,0.563-0.933,0.791c-1.314,0.664-3.452-1.813-6.354-7.367l-0.141-0.268
    							c-1.446-2.765-3.258-5.444-5.098-7.547l-2.057-2.35l0.308,3.107c0.282,2.846,0.119,4.676-0.518,5.761
    							c-0.49,0.842-1.307,1.272-2.46,1.701c-0.101,0.036-0.124,0.023-0.147,0.01c-0.179-0.104-0.787-0.674-1.28-3.746
    							c-1.295-8.008-4.998-16.128-5.729-17.674c-1.532-3.252-1.571-6.057-0.121-8.826l0.337-0.649l-0.512-0.52
    							c-2.743-2.766-5.714-5.528-8.86-8.455c-1.658-1.543-3.33-3.101-4.983-4.672l0.133-0.139l5.667-14.729l0.511-0.358
    							c6.924,10.125,12.042,18.56,12.955,20.6L317.102,334.882z"></path>
    						<circle cx="317.99" cy="364.095" r="1.85"></circle>
    						<text transform="matrix(1 0 0 1 313.0547 355.4707)"
    					font-family="'ArialMT'" font-size="6">C6</text>
    					</g>
    					<g>
    						<path class="background" id="C5_Left" fill="#FFFFFF"
    					d="M313.629,185.811c-2.882-5.961-6.968-12.122-9.105-15.342l-0.608-0.919
    							c-2.516-3.82-3.532-10.302-4.516-16.571c-0.391-2.494-0.761-4.85-1.21-6.935c-1.814-8.417-4.01-12.217-6.133-15.893
    							c-0.647-1.122-1.317-2.282-1.949-3.535c-1.288-2.557-1.735-5.171-2.209-7.938c-0.559-3.263-1.192-6.96-3.361-11.361
    							c-1.448-2.939-3.122-5.297-5.004-7.089c-3.513,3.173-8.606,7.101-13.738,10.563c3.693,5.391,8.68,13.946,11.316,20.305l0.891,2.147
    							c2.867,6.909,6.117,14.739,7.525,18.741c1.58,4.492,12.037,20.417,18.992,26.495c2.828,2.472,5.651,4.656,8.142,6.583
    							C312.992,185.318,313.313,185.566,313.629,185.811z"></path>
    						<path class="background" id="C5_Right" fill="#FFFFFF"
    					d="M164.714,99.949c-2.004,1.821-3.775,4.276-5.3,7.369c-2.169,4.401-2.803,8.098-3.361,11.361
    							c-0.474,2.768-0.921,5.381-2.209,7.938c-0.632,1.253-1.302,2.413-1.949,3.535c-2.123,3.676-4.318,7.477-6.133,15.893
    							c-0.449,2.084-0.819,4.44-1.21,6.935c-0.983,6.269-2,12.751-4.516,16.571l-0.608,0.919c-2.228,3.355-6.573,9.904-9.465,16.092
    							c0.608-0.476,1.252-0.974,1.931-1.5c2.49-1.927,5.313-4.111,8.142-6.583c6.955-6.078,17.412-22.002,18.992-26.495
    							c1.408-4.002,4.658-11.833,7.525-18.741l0.891-2.147c2.637-6.359,7.623-14.914,11.316-20.305
    							C173.477,107.226,168.231,103.168,164.714,99.949z"></path>
    						<text transform="matrix(1 0 0 1 154.165 137.6665)"
    					font-family="'ArialMT'" font-size="6">C5</text>
    						<text transform="matrix(1 0 0 1 282.7188 137.6665)"
    					font-family="'ArialMT'" font-size="6">C5</text>
    						<circle cx="146.375" cy="161.375" r="1.85"></circle>
    						<circle cx="298.18" cy="161.375" r="1.85"></circle>
    					</g>
    					<g>
    					    <path class="background" id="C4_Right" fill="#FFFFFF"
    					d="M180.46,93.852c-2.935,1.488-4.273,2.167-6.4,2.234c-3.194,0.101-6.057,1.181-8.575,3.207
    							c5.333,4.832,14.072,10.921,19.89,14.26C191.853,117.272,197.476,118,205,118h17v-17.368c-11,0-28.709-4.319-35.995-9.479
    							C183.588,92.272,181.808,93.168,180.46,93.852z"></path>
    					    <path class="background" id="C4_Left" fill="#FFFFFF"
    					d="M269.892,96.085c-2.127-0.067-3.466-0.747-6.4-2.235c-1.348-0.684-3.103-1.579-5.521-2.699
    							c-7.283,5.16-25.971,9.48-35.971,9.48V118h17.189c7.524,0,13.147-0.728,19.626-4.447c5.668-3.253,14.351-9.377,19.712-14.21
    							C275.994,97.284,273.111,96.187,269.892,96.085z"></path>
    					    <text transform="matrix(1 0 0 1 218.5977 111.3413)"
    					font-family="'ArialMT'" font-size="6">C4</text>
    						<circle cx="177.495" cy="98.419" r="1.85"></circle>
    						<circle cx="266.378" cy="98.419" r="1.85"></circle>
    						<path class="background" id="C4_Left" fill="#FFFFFF"
    					d="M345.054,81.87c-1.255-1.203-2.444-2.352-3.507-3.514c-3.162,2.752-9.522,8.123-14.572,11.331
    							c-5.86,3.722-16.966,9.62-23.492,12.182c-1.182,2.444-2.112,4.809-2.35,6.896h57.047C357.87,94.153,350.777,87.356,345.054,81.87z"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M314.203,103.558
    							c-0.393,1.046-1.569,3.633-1.569,5.931"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M346.783,100.548
    							c0.61,1.439,2.049,3.882,2.049,8.941"></path>
    						<path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-miterlimit="10"
    					d="M356.9,98.063
    							c-1.221,2.748-5.714,6.454-8.068,7.239"></path>
    						<text transform="matrix(1 0 0 1 336.5713 106.5229)"
    					font-family="'ArialMT'" font-size="6">C4</text>
    						<circle cx="334.506" cy="95.409" r="1.85"></circle>
    					</g>
    					<g>
    						<path class="background" id="C3_Right" fill="#FFFFFF"
    					d="M207.273,77.687c-1.123,3.169-3.701,6.242-9.289,8.415c-4.619,1.796-8.149,3.309-10.917,4.566
    							c7.408,4.91,24.933,8.964,34.933,8.964V83C214,83,209.49,79.894,207.273,77.687z"></path>
    						<path class="background" id="C3_Left" fill="#FFFFFF"
    					d="M245.973,86.099c-5.587-2.172-8.145-5.245-9.27-8.413C234.486,79.893,230,83,222,83v16.632
    							c10,0,27.506-4.055,34.914-8.965C254.145,89.409,250.593,87.896,245.973,86.099z"></path>
    						<text transform="matrix(1 0 0 1 218.1406 91.7886)"
    					font-family="'ArialMT'" font-size="6">C3</text>
    						<circle cx="205.985" cy="91.42" r="1.85"></circle>
    						<path
    					d="M210.917,94.943c-3.246,0-9.234-0.354-9.54-0.372c-0.276-0.016-0.486-0.253-0.47-0.529c0.017-0.275,0.256-0.48,0.528-0.469
    							c0.085,0.005,7.981,0.469,10.564,0.352V90c0-0.276,0.224-0.5,0.5-0.5s0.5,0.224,0.5,0.5v4.836l-0.444,0.05
    							C212.195,94.926,211.621,94.943,210.917,94.943z"></path>
    						<circle cx="237.966" cy="91.42" r="1.85"></circle>
    						<path
    					d="M233.034,94.943c3.246,0,9.234-0.354,9.54-0.372c0.276-0.016,0.486-0.253,0.47-0.529c-0.017-0.275-0.231-0.48-0.504-0.469
    							c-0.085,0.005-7.54,0.469-10.54,0.352V90c0-0.276-0.224-0.5-0.5-0.5S231,89.724,231,90v4.836l0.42,0.05
    							C231.78,94.926,232.33,94.943,233.034,94.943z"></path>
    						<path class="background" id="C3_Left" fill="#FFFFFF"
    					d="M326.438,88.843c4.992-3.171,11.299-8.496,14.441-11.231c-2.18-2.557-3.004-8.583-2.68-13.698
    							c-3.496,2.438-9.053,6.353-11.666,8.32c-3.754,2.827-7.371,4.712-11.057,5.766c-1.336,0.381-2.782,0.567-4.421,0.567
    							c-0.981,0-1.839-0.068-2.465-0.118c-0.287-0.022-0.513-0.039-0.696-0.045c0.03,0.056,0.062,0.114,0.091,0.168
    							c0.977,1.806,2.452,4.537,2.452,7.054c0,3.174-2.176,7.209-4.479,11.482c-0.611,1.133-1.223,2.276-1.802,3.41
    							C310.689,97.796,321.034,92.274,326.438,88.843z"></path>
    						<text transform="matrix(1 0 0 1 325.6709 80.3335)"
    					font-family="'ArialMT'" font-size="6">C3</text>
    						<circle cx="316.406" cy="85.25" r="1.85"></circle>
    					</g>
    					    <g>
    					        <path class="background" id="C2_Right" fill="#FFFFFF"
    					d="M207.967,69.94c0.158,2.092,0.245,4.519-0.429,6.931C211.287,80.29,216,82,222,82v-7.184
    							C217,74.816,211.418,73.118,207.967,69.94z"></path>
    					        <path class="background" id="C2_Left" fill="#FFFFFF"
    					d="M236.01,69.941c-3.453,3.177-9.01,4.875-14.01,4.875V82c8,0,12.339-3.304,14.372-5.421
    							C235.783,74.264,235.857,71.948,236.01,69.941z"></path>
    					        <text transform="matrix(1 0 0 1 218.1406 80.2314)"
    					font-family="'ArialMT'" font-size="6">C2</text>
    					        <g>
    					            <path class="background" id="C2_Left" fill="#FFFFFF"
    					d="M307.313,77.239c0.009,0.028,0.032,0.077,0.049,0.115c0.146,0.025,0.285,0.043,0.399,0.043
    								c0.211,0,0.521,0.024,0.909,0.055c0.609,0.048,1.444,0.114,2.386,0.114c1.545,0,2.9-0.173,4.146-0.529
    								c3.566-1.019,7.076-2.851,10.73-5.603c0.104-0.078,8.058-5.831,12.373-8.814c0.296-2.809,0.96-5.199,1.953-6.357
    								c0.609-0.712,1.461-1.287,2.446-1.953c3.422-2.312,8.593-5.806,8.593-19.33c0-12.009-5.857-24.689-18.402-30.467
    								c-0.232,5.087-1.176,11.865-5.917,27.134c-1.131,3.64-2.167,7.013-3.13,10.148c-3.757,12.23-6.472,21.066-9.272,27.722
    								l-0.079,0.188l-0.188,0.079c-2.449,1.035-5.288,2.174-7.059,2.833v0.195c0,0.688,0.02,1.736,0.036,2.673
    								C307.299,76.204,307.311,76.857,307.313,77.239z"></path>
    					        </g>
    					        <text transform="matrix(1 0 0 1 330.6709 30.8281)"
    					font-family="'ArialMT'" font-size="6">C2</text>
    					        <circle cx="340.406" cy="51.408" r="1.85"></circle>
    					        <path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-linejoin="round" stroke-miterlimit="10"
    					d="M306.81,72.248
    							c2.866-1.051,8.771-3.487,10.301-4.251s6.976-2.867,6.976-13.569c0.478,0.764,1.053,1.243,2.39-0.191s4.013-7.836,4.013-11.754
    							s-1.625-9.651-6.976-6.211"></path>
    					        <path fill="none" stroke="#000000" stroke-width="0.5"
    					stroke-linecap="round" stroke-linejoin="round"
    					stroke-miterlimit="10"
    					d="
    							M324.661,46.405c0.178,0.681,0.444,1.748,1.155,1.748s1.926-2.489,1.926-5.896c0-2.696-1.098-3.318-1.541-3.318
    							s-1.985-0.267-2.548,3.496"></path>
    					    </g>
    					    <g id="Top_1_">
    						    <path fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-linejoin="round" stroke-miterlimit="10"
    					d="M66.985,259.314
    							    c-6.314,2.676-17.252,2.484-22.485-2.293c-5.233,4.777-16.171,4.969-22.485,2.293"></path>
    						    <polyline fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-linejoin="round" stroke-miterlimit="10"
    					points="
    							    46.547,218.45 44.5,220.498 44.5,220.498 42.453,218.45 	"></polyline>
    							<line fill="none" stroke="#000000" stroke-linecap="round"
    					stroke-linejoin="round" stroke-miterlimit="10" x1="44.5"
    					y1="220.498" x2="44.5" y2="257.021"></line>
    					    </g>
    				</svg>
    		</div>
    		<div class="left-column">
    			<table>
    				<thead>
    					<tr>
    						<th colspan="2" class="measurement-type">Sensory</th>
    						<th colspan="2" class="measurement-type">Motor</th>
    						<th colspan="2" rowspan="2" class="side-label">Left</th>
    					</tr>
    					<tr>
    						<th colspan="2" class="measurement-subtype">Key sensory<br>points
    						</th>
    						<th colspan="2" class="measurement-subtype">Key<br>muscles
    						</th>
    					</tr>
    					<tr>
    						<th class="measurement-technique">Light Touch (LT)</th>
    						<th class="measurement-technique">Pin Prick (PP)</th>
    						<th colspan="4">&nbsp</th>
    					</tr>
    				</thead>
    				<tfoot>
    					<tr>
    						<td class="total" id="LeftTouchTotal">&nbsp;</td>
    						<td class="total" id="LeftPrickTotal">&nbsp;</td>
    						<td class="total" id="LeftMotorTotal">&nbsp;</td>
    						<td colspan="3" class="total-label">Left totals</td>
    					</tr>
    					<tr>
    						<td class="maximum">(56)</td>
    						<td class="maximum">(56)</td>
    						<td class="maximum">(50)</td>
    						<td colspan="3" class="maximum-label">(Maximum)</td>
    					</tr>
    				</tfoot>
    				<tbody>
    					<tr>
    						<td><input id="C2LeftTouch" class="smart-cell sensory touch left"
    							title="C2 light touch left"></td>
    						<td><input id="C2LeftPrick" class="smart-cell sensory prick left"
    							title="C2 pin prick left"></td>
    						<td class="level-name">C2</td>
    						<td colspan="3" rowspan="3">&nbsp;</td>
    					</tr>
    					<tr>
    						<td><input id="C3LeftTouch" class="smart-cell sensory touch left"
    							title="C3 light touch left"></td>
    						<td><input id="C3LeftPrick" class="smart-cell sensory prick left"
    							title="C3 pin prick left"></td>
    						<td class="level-name">C3</td>
    					</tr>
    					<tr>
    						<td><input id="C4LeftTouch" class="smart-cell sensory touch left"
    							title="C4 light touch left"></td>
    						<td><input id="C4LeftPrick" class="smart-cell sensory prick left"
    							title="C4 pin prick left"></td>
    						<td class="level-name">C4</td>
    					</tr>
    					<tr>
    						<td><input id="C5LeftTouch" class="smart-cell sensory touch left"
    							title="C5 light touch left"></td>
    						<td><input id="C5LeftPrick" class="smart-cell sensory prick left"
    							title="C5 pin prick left"></td>
    						<td><input id="C5LeftMotor" class="smart-cell motor upper left"
    							title="C5 motor left"></td>
    						<td class="level-name">C5</td>
    						<td class="helper">Elbow flexors</td>
    						<td rowspan="5">
    							<div class="location">UEL</div>
    							<div class="location-description">(Upper Extremity Left)</div>
    						</td>
    					</tr>
    					<tr>
    						<td><input id="C6LeftTouch" class="smart-cell sensory touch left"
    							title="C6 light touch left"></td>
    						<td><input id="C6LeftPrick" class="smart-cell sensory prick left"
    							title="C6 pin prick left"></td>
    						<td><input id="C6LeftMotor" class="smart-cell motor upper left"
    							title="C6 motor left"></td>
    						<td class="level-name">C6</td>
    						<td class="helper">Wrist extensors</td>
    					</tr>
    					<tr>
    						<td><input id="C7LeftTouch" class="smart-cell sensory touch left"
    							title="C7 light touch left"></td>
    						<td><input id="C7LeftPrick" class="smart-cell sensory prick left"
    							title="C7 pin prick left"></td>
    						<td><input id="C7LeftMotor" class="smart-cell motor upper left"
    							title="C7 motor left"></td>
    						<td class="level-name">C7</td>
    						<td class="helper">Elbow extensors</td>
    					</tr>
    					<tr>
    						<td><input id="C8LeftTouch" class="smart-cell sensory touch left"
    							title="C8 light touch left"></td>
    						<td><input id="C8LeftPrick" class="smart-cell sensory prick left"
    							title="C8 pin prick left"></td>
    						<td><input id="C8LeftMotor" class="smart-cell motor upper left"
    							title="C8 motor left"></td>
    						<td class="level-name">C8</td>
    						<td class="helper">Finger flexors</td>
    					</tr>
    					<tr>
    						<td><input id="T1LeftTouch" class="smart-cell sensory touch left"
    							title="T1 light touch left"></td>
    						<td><input id="T1LeftPrick" class="smart-cell sensory prick left"
    							title="T1 pin prick left"></td>
    						<td><input id="T1LeftMotor" class="smart-cell motor upper left"
    							title="T1 motor left"></td>
    						<td class="level-name">T1</td>
    						<td class="helper">Finger abductors <span>(little finger)</span></td>
    					</tr>
    					<tr>
    						<td><input id="T2LeftTouch" class="smart-cell sensory touch left"
    							title="T2 light touch left"></td>
    						<td><input id="T2LeftPrick" class="smart-cell sensory prick left"
    							title="T2 pin prick left"></td>
    						<td class="level-name">T2</td>
    						<td colspan="3" rowspan="12">&nbsp;</td>
    					</tr>
    					<tr>
    						<td><input id="T3LeftTouch" class="smart-cell sensory touch left"
    							title="T3 light touch left"></td>
    						<td><input id="T3LeftPrick" class="smart-cell sensory prick left"
    							title="T3 pin prick left"></td>
    						<td class="level-name">T3</td>
    					</tr>
    					<tr>
    						<td><input id="T4LeftTouch" class="smart-cell sensory touch left"
    							title="T4 light touch left"></td>
    						<td><input id="T4LeftPrick" class="smart-cell sensory prick left"
    							title="T4 pin prick left"></td>
    						<td class="level-name">T4</td>
    					</tr>
    					<tr>
    						<td><input id="T5LeftTouch" class="smart-cell sensory touch left"
    							title="T5 light touch left"></td>
    						<td><input id="T5LeftPrick" class="smart-cell sensory prick left"
    							title="T5 pin prick left"></td>
    						<td class="level-name">T5</td>
    					</tr>
    					<tr>
    						<td><input id="T6LeftTouch" class="smart-cell sensory touch left"
    							title="T6 light touch left"></td>
    						<td><input id="T6LeftPrick" class="smart-cell sensory prick left"
    							title="T6 pin prick left"></td>
    						<td class="level-name">T6</td>
    					</tr>
    					<tr>
    						<td><input id="T7LeftTouch" class="smart-cell sensory touch left"
    							title="T7 light touch left"></td>
    						<td><input id="T7LeftPrick" class="smart-cell sensory prick left"
    							title="T7 pin prick left"></td>
    						<td class="level-name">T7</td>
    					</tr>
    					<tr>
    						<td><input id="T8LeftTouch" class="smart-cell sensory touch left"
    							title="T8 light touch left"></td>
    						<td><input id="T8LeftPrick" class="smart-cell sensory prick left"
    							title="T8 pin prick left"></td>
    						<td class="level-name">T8</td>
    					</tr>
    					<tr>
    						<td><input id="T9LeftTouch" class="smart-cell sensory touch left"
    							title="T9 light touch left"></td>
    						<td><input id="T9LeftPrick" class="smart-cell sensory prick left"
    							title="T9 pin prick left"></td>
    						<td class="level-name">T9</td>
    					</tr>
    					<tr>
    						<td><input id="T10LeftTouch" class="smart-cell sensory touch left"
    							title="T10 light touch left"></td>
    						<td><input id="T10LeftPrick" class="smart-cell sensory prick left"
    							title="T10 pin prick left"></td>
    						<td class="level-name">T10</td>
    					</tr>
    					<tr>
    						<td><input id="T11LeftTouch" class="smart-cell sensory touch left"
    							title="T11 light touch left"></td>
    						<td><input id="T11LeftPrick" class="smart-cell sensory prick left"
    							title="T11 pin prick left"></td>
    						<td class="level-name">T11</td>
    					</tr>
    					<tr>
    						<td><input id="T12LeftTouch" class="smart-cell sensory touch left"
    							title="T12 light touch left"></td>
    						<td><input id="T12LeftPrick" class="smart-cell sensory prick left"
    							title="T12 pin prick left"></td>
    						<td class="level-name">T12</td>
    					</tr>
    					<tr>
    						<td><input id="L1LeftTouch" class="smart-cell sensory touch left"
    							title="L1 light touch left"></td>
    						<td><input id="L1LeftPrick" class="smart-cell sensory prick left"
    							title="L1 pin prick left"></td>
    						<td class="level-name">L1</td>
    					</tr>
    					<tr>
    						<td><input id="L2LeftTouch" class="smart-cell sensory touch left"
    							title="L2 light touch left"></td>
    						<td><input id="L2LeftPrick" class="smart-cell sensory prick left"
    							title="L2 pin prick left"></td>
    						<td><input id="L2LeftMotor" class="smart-cell motor upper left"
    							title="L2 motor left"></td>
    						<td class="level-name">L2</td>
    						<td class="helper">Hip flexors</td>
    						<td rowspan="5">
    							<div class="location">LEL</div>
    							<div class="location-description">(Lower Extremity Left)</div>
    						</td>
    					</tr>
    					<tr>
    						<td><input id="L3LeftTouch" class="smart-cell sensory touch left"
    							title="L3 light touch left"></td>
    						<td><input id="L3LeftPrick" class="smart-cell sensory prick left"
    							title="L3 pin prick left"></td>
    						<td><input id="L3LeftMotor" class="smart-cell motor upper left"
    							title="L3 motor left"></td>
    						<td class="level-name">L3</td>
    						<td class="helper">Knee extensors</td>
    					</tr>
    					<tr>
    						<td><input id="L4LeftTouch" class="smart-cell sensory touch left"
    							title="L4 light touch left"></td>
    						<td><input id="L4LeftPrick" class="smart-cell sensory prick left"
    							title="L4 pin prick left"></td>
    						<td><input id="L4LeftMotor" class="smart-cell motor upper left"
    							title="L4 motor left"></td>
    						<td class="level-name">L4</td>
    						<td class="helper">Ankle dorsiflexors</td>
    					</tr>
    					<tr>
    						<td><input id="L5LeftTouch" class="smart-cell sensory touch left"
    							title="L5 light touch left"></td>
    						<td><input id="L5LeftPrick" class="smart-cell sensory prick left"
    							title="L5 pin prick left"></td>
    						<td><input id="L5LeftMotor" class="smart-cell motor upper left"
    							title="L5 motor left"></td>
    						<td class="level-name">L5</td>
    						<td class="helper">Long toe extensors</td>
    					</tr>
    					<tr>
    						<td><input id="S1LeftTouch" class="smart-cell sensory touch left"
    							title="S1 light touch left"></td>
    						<td><input id="S1LeftPrick" class="smart-cell sensory prick left"
    							title="S1 pin prick left"></td>
    						<td><input id="S1LeftMotor" class="smart-cell motor upper left"
    							title="S1 motor left"></td>
    						<td class="level-name">S1</td>
    						<td class="helper">Ankle plantar flexors</td>
    					</tr>
    					<tr>
    						<td><input id="S2LeftTouch" class="smart-cell sensory touch left"
    							title="S2 light touch left"></td>
    						<td><input id="S2LeftPrick" class="smart-cell sensory prick left"
    							title="S2 pin prick left"></td>
    						<td class="level-name">S2</td>
    						<td colspan="3" rowspan="2">&nbsp;</td>
    					</tr>
    					<tr>
    						<td><input id="S3LeftTouch" class="smart-cell sensory touch left"
    							title="S3 light touch left"></td>
    						<td><input id="S3LeftPrick" class="smart-cell sensory prick left"
    							title="S3 pin prick left"></td>
    						<td class="level-name">S3</td>
    					</tr>
    					<tr>
    						<td><input id="S4_5LeftTouch"
    							class="smart-cell sensory touch left"
    							title="S-45 light touch left"></td>
    						<td><input id="S4_5LeftPrick"
    							class="smart-cell sensory prick left" title="S-45 pin prick left"></td>
    						<td class="level-name">S4-5</td>
    						<td colspan="3"><select id="AnalSensation" name="AnalSensation"
    							id="AnalSensation">
    								<option></option>
    								<option value="Yes">Yes</option>
    								<option value="No">No</option>
    								<option value="NT">NT</option>
    						</select> <label for="AnalSensation">(DAP) Deep anal pressure</label>
    						</td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
		</div>
		<div id="subscores">
			<div id="motor-subscores">
				<div class="motor">
					<div class="title">Motor subscores</div>
					<ul>
						<li>
							<div class="item">
								<span>UER</span> <span class="total" id="RightUpperMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">
								<span style="text-transform: uppercase;">Max</span> (25)
							</div>
						</li>
						<li>
							<div class="item">
								<span>+ UEL</span>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="total" id="LeftUpperMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">(25)</div>
						</li>
						<li>
							<div class="item">
								<span>= UEMS Total</span>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="total" id="UpperMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">(50)</div>
						</li>
						<li>
							<div class="item">
								<span>LER</span> <span class="total" id="RightLowerMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">
								<span style="text-transform: uppercase;">Max</span> (25)
							</div>
						</li>
						<li>
							<div class="item">
								<span>+ LEL</span>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="total" id="LeftLowerMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">(25)</div>
						</li>
						<li>
							<div class="item">
								<span>= LEMS Total</span>
							</div>
						</li>
						<li>
							<div class="item">
								<span class="total" id="LowerMotorTotal">&nbsp;</span>
							</div>
							<div class="helper">(50)</div>
						</li>
					</ul>
				</div>
			</div>
			<div class="sensory">
				<div class="title">Sensory subscores</div>
				<ul>
					<li>
						<div class="item">
							<span>LTR</span> <span class="total" id="RightTouchTotalSubscore">&nbsp;</span>
						</div>
						<div class="helper">
							<span style="text-transform: uppercase;">Max</span> (56)
						</div>
					</li>
					<li>
						<div class="item">
							<span>+ LTL</span>
						</div>
					</li>
					<li>
						<div class="item">
							<span class="total" id="LeftTouchTotalSubscore">&nbsp;</span>
						</div>
						<div class="helper">(56)</div>
					</li>
					<li>
						<div class="item">
							<span>= LT Total</span>
						</div>
					</li>
					<li>
						<div class="item">
							<span class="total" id="TouchTotal">&nbsp;</span>
						</div>
						<div class="helper">(112)</div>
					</li>
					<li>
						<div class="item">
							<span>PPR</span> <span class="total" id="RightPrickTotalSubscore">&nbsp;</span>
						</div>
						<div class="helper">
							<span style="text-transform: uppercase;">Max</span> (56)
						</div>
					</li>
					<li>
						<div class="item">
							<span>+ PPL</span>
						</div>
					</li>
					<li>
						<div class="item">
							<span class="total" id="LeftPrickTotalSubscore">&nbsp;</span>
						</div>
						<div class="helper">(56)</div>
					</li>
					<li>
						<div class="item">
							<span>= PP Total</span>
						</div>
					</li>
					<li>
						<div class="item">
							<span class="total" id="PrickTotal">&nbsp;</span>
						</div>
						<div class="helper">(112)</div>
					</li>
				</ul>
			</div>
		</div>
		<div id="additional-questions">
			<div class="block">
				<div>
					<label class="question-label" for="bcr-status">BCR Status</label>
				</div>
				<input type="radio" value="0" class="bcr-status" name="bcr-status"><label>Present</label>
				<input type="radio" value="1" class="bcr-status" name="bcr-status"><label>Absent</label>
				<input type="radio" value="2" class="bcr-status" name="bcr-status"><label>Unknown</label>
			</div>
			<div class="block">
				<div>
					<label class="question-label" for="ce-syndrome">Cauda Equina
						Syndrome</label>
				</div>
				<input type="radio" value="0" class="ce-syndrome" name="ce-syndrome"><label>Yes</label>
				<input type="radio" value="1" class="ce-syndrome" name="ce-syndrome"><label>No</label>
				<input type="radio" value="2" class="ce-syndrome" name="ce-syndrome"><label>Unknown</label>
			</div>
			<div class="block">
				<div>
					<label class="question-label" for="neurological-deficit">Other
						Neurological Deficit</label>
				</div>
				<input type="radio" value="0" class="neurological-deficit"
					name="neurological-deficit"><label>Myelopathy</label> <input
					type="radio" value="1" class="neurological-deficit"
					name="neurological-deficit"><label>Periph. nerve injury NO cord
					injury</label> <input type="radio" value="2"
					class="neurological-deficit" name="neurological-deficit"><label>Periph.
					nerve injury with cord injury</label> <input type="radio" value="3"
					class="neurological-deficit" name="neurological-deficit"><label>None</label>
				<input type="radio" value="4" class="neurological-deficit"
					name="neurological-deficit"><label>Unknown</label>
			</div>
		</div>
		<div id="test-totals">
			<div id="test-totals-instructions" class="block">
				<div class="title">
					Neurological<br>levels
				</div>
				<div class="helper">
					Steps 1-6 for<br>classification
				</div>
			</div>
			<div class="block">
				<table>
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>R</th>
							<th>L</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th style="text-align: right;">1. Sensory</th>
							<td><div class="total" id="RightSensory" data-type="Total"
									data-value="">&nbsp;</div></td>
							<td><div class="total" id="LeftSensory" data-type="Total"
									data-value="">&nbsp;</div></td>
						</tr>
						<tr>
							<th style="text-align: right;">2. Motor</th>
							<td><div class="total" id="RightMotor" data-type="Total"
									data-value="">&nbsp;</div></td>
							<td><div class="total" id="LeftMotor" data-type="Total"
									data-value="">&nbsp;</div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="block">
				<table>
					<tbody>
						<tr>
							<th>3. Neurological<br>Level of Injury<br>(NLI)
							</th>
							<td><div class="total" style="width: 50px;"
									id="NeurologicalLevelOfInjury" data-type="Total" data-value="">&nbsp;</div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="block">
				<table>
					<tbody>
						<tr>
							<td style="text-align: right;">
								<div class="title">4. Complete or incomplete?</div>
								<div class="helper">Incomplete = Any sensory or motor funtion in
									S4-5</div>
							</td>
							<td><div class="total" style="width: 50px;" id="Completeness"
									data-type="Total" data-value="">&nbsp;</div></td>
						</tr>
						<tr>
							<th style="text-align: right;">5. Asia Impairment Scale (AIS)</th>
							<td><div class="total" style="width: 50px;"
									id="AsiaImpairmentScale" data-type="Total" data-value="">&nbsp;</div></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="block">
				<div class="helper">(In injuries with absent motor OR sensory
					function in S4-5 only)</div>
				<div class="zpp">
					<div style="text-align: center;">
						<div class="title margin-top">
							6. Zone of partial<br>preservation
						</div>
						<div class="helper">
							Most caudal level with any<br>innervation
						</div>
					</div>
					<div>
						<table>
							<thead>
								<tr>
									<th>&nbsp;</th>
									<th>R</th>
									<th>L</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th style="text-align: right;">Sensory</th>
									<td><div class="total" id="RightSensoryZpp" data-type="Total"
											data-value="">&nbsp;</div></td>
									<td><div class="total" id="LeftSensoryZpp" data-type="Total"
											data-value="">&nbsp;</div></td>
								</tr>
								<tr>
									<th style="text-align: right;">Motor</th>
									<td><div class="total" id="RightMotorZpp" data-type="Total"
											data-value="">&nbsp;</div></td>
									<td><div class="total" id="LeftMotorZpp" data-type="Total"
											data-value="">&nbsp;</div></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="block">
				<div class="title">Enter manual values below:</div>
				<textarea id="classificationsComments" type="text"></textarea>
			</div>
		</div>
	</div>
</body>

<script type="module">
    import {data, scores} from "<?php echo $module->getUrl("app.js")?>";

    $("#save-data-btn").click(function () { 
        if (!$("#redcap-record").val() || ($("#redcap-event").length > 0 && !$("#redcap-event").val())) { 
            alert("Please enter a record ID, and event, if required, before saving data.");
        }
        else {
            $("#alert-redcap-id b").text($("#redcap-record").val());
            $("#alert-redcap-event b").text($("#redcap-event").val());
            $(".alert").show() 
        }
    });

    $(".close").click(function () { $(".alert").hide() });

    $("#confirm-save-data-btn").click(function () {
        if (!$("#redcap-record").val() || ($("#redcap-event").length > 0 && !$("#redcap-event").val())) { 
            alert("Please enter a record ID, and event, if required, before saving data.");
        }
        else { 
    	   $.ajax({
                url: "<?php print $module->getUrl("saveToRedcap.php") ?>",
                type: "POST",
                data: {
                    redcap_record: $("#redcap-record").val(),
                    redcap_event: $("#redcap-event").val(),
                    data: data,
                    scores: scores,
                    redcap_csrf_token: "<?php print $module->getCSRFToken() ?>" // required by REDCap
                },
                success: function (data) {
                    let response = JSON.parse(data);
                    if (response.success) {
                       alert("Your data has been successfully saved!");
                    }
                    else {
                         alert("Returned with the following error:\n\n '" + response.error + "' Please send a screenshot of this to your REDCap administrator");
                    }
                },
                error: function (data, status, error) {
                    alert("Returned with status " + status + " - " + error + "Please send a screenshot of this to your REDCap administrator");
                }
            });
        }
    });

    $("#download").click(function () {
        html2canvas(document.getElementById('main-content')).then(function (canvas) {
                var imgdata = canvas.toDataURL("image/jpg");
                var doc = new jspdf.jsPDF({"orientation": "l", "unit": "px", "format": "letter"});
                doc.addImage(imgdata, "JPG", 80, 10, doc.internal.pageSize.getWidth() - 150, doc.internal.pageSize.getHeight() - 20);
                doc.save("ISNCSCI.pdf");
            });
    });

$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 1,
    minTime: '00:00',
    maxTime: '23:59',
    defaultTime: '00:00',
    startTime: '00:00',
    dynamic: false,
    dropdown: false,
    scrollbar: false
});


</script>
</html>
<?php
/*
 * Display REDCap footer.
 */
require_once APP_PATH_DOCROOT . 'ProjectGeneral/footer.php';