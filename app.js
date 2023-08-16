import {ISNCSCI} from "./node_modules/isncsci/esm/ISNCSCI.min.js";
	
// Object representing all of the form data
export const data = {
	"visit": null,
	"examDate": null,
	"examTime": null,
	"examinerName": null,
	"examinerType": null,
	"examinerTypeOther": null,
	"deepAnalPressure": null,
	"voluntaryAnalContraction": null,
	"left": {
	    "lightTouch": {
	      "C2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T6": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T9": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T10": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T11": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T12": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S4_5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    },
	    "motor": {
	      "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    },
	    "pinPrick": {
	      "C2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T6": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T9": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T10": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T11": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T12": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S4_5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    }
	  },
	"right": {
	    "lightTouch": {
	      "C2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T6": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T9": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T10": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T11": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T12": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S4_5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    },
	    "motor": {
	      "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    },
	    "pinPrick": {
	      "C2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C6": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "C8": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T6": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "T7": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T8": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T9": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T10": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T11": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "T12": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "L1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L4": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "L5": {value: null, considerNormal: null, impairment: null, impairmentOther: null},
	      "S1": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S2": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S3": {value: null, considerNormal: null, impairment: null, impairmentOther: null}, "S4_5": {value: null, considerNormal: null, impairment: null, impairmentOther: null}
	    }
	  },
	"lowestNonKeyMuscleWithMotorFunction": {
		"right": null,
		"left": null
	},
	"bcrStatus": null,
	"ceSyndrome": null,
	"neurologicalDeficit": null,
	"comments": null,
	"classificationsComments": null
};

// Variable representing the scores, after calculation
export const scores = {
	// totals
	"RightMotorTotal": null,
	"RightTouchTotal": null,
	"RightPrickTotal": null,
	"RightUpperMotorTotal": null,
	"RightLowerMotorTotal": null,
	"RightTouchTotalSubscore": null,
	"RightPrickTotalSubscore": null,
	
	"LeftMotorTotal": null,
	"LeftTouchTotal": null,
	"LeftPrickTotal": null,
	"LeftUpperMotorTotal": null,
	"LeftLowerMotorTotal": null,
	"LeftTouchTotalSubscore": null,
	"LeftPrickTotalSubscore": null,
	
	"UpperMotorTotal": null,
	"LowerMotorTotal": null,
	"TouchTotal": null,
	"PrickTotal": null,
	
	// classifications
	"RightSensory": null,
	"RightMotor": null,
	"RightSensoryZpp": null,
	"RightMotorZpp": null,
	
	"LeftSensory": null,
	"LeftMotor": null,
	"LeftSensoryZpp": null,
	"LeftMotorZpp": null,
	
	"NeurologicalLevelOfInjury": null,
	"Completeness": null,
	"AsiaImpairmentScale": null
}
const score_ranges = {
	// classifications
	"RightSensory": null,
	"RightMotor": null,
	"RightSensoryZpp": null,
	"RightMotorZpp": null,

	"LeftSensory": null,
	"LeftMotor": null,
	"LeftSensoryZpp": null,
	"LeftMotorZpp": null,

	"NeurologicalLevelOfInjury": null,
	"Completeness": null,
	"AsiaImpairmentScale": null
}


let selectedCell = null; // Variable representing which cell is currently selected in the form
let disablePropagation = false; // Variable representing whether downward propagation has been disabled or not

function getCellVars() {
	
	if (selectedCell) {
		let position = "";
		let subCategory = "";
		let suffix = "";
		
		if ($("#" + selectedCell).hasClass("right"))
			position = "right";
		else
			position = "left";

		if ($("#" + selectedCell).hasClass("prick")) {
			subCategory = "pinPrick";
			suffix = "Prick";
		}
		else if ($("#" + selectedCell).hasClass("touch")) {
			subCategory = "lightTouch";
			suffix = "Touch";
		}
		else {
			subCategory = "motor";
			suffix = "Motor";
		}

		let substrEnd = selectedCell.indexOf(position.charAt(0).toUpperCase() + position.slice(1) + suffix);
		let cell = selectedCell.substring(0, substrEnd);
		
		return {
			"position": position,
			"subCategory": subCategory,
			"cell": cell
		}
	}
	
	return null;
}

/*
	Set given property of the currently selected cell, with the given value.
*/
function setCellValue(propName, value) {

	let cellVars = getCellVars();
	if (cellVars) {
		data[cellVars.position][cellVars.subCategory][cellVars.cell][propName] = value;
	}
}

/*
	Set all cells that come after currently selected cell to have the same values.
*/
function setPropagatedCellValues() {
	let cellVars = getCellVars();
	if (!disablePropagation && cellVars) {
		
		let keys = Object.keys(data[cellVars.position][cellVars.subCategory]);
		let selectedCellIndex = keys.indexOf(cellVars.cell);
		let currCellIndex = "";
		
		let value = data[cellVars.position][cellVars.subCategory][cellVars.cell]["value"];
		let considerNormal = data[cellVars.position][cellVars.subCategory][cellVars.cell]["considerNormal"];
		let impairment = data[cellVars.position][cellVars.subCategory][cellVars.cell]["impairment"];
		let impairmentOther = data[cellVars.position][cellVars.subCategory][cellVars.cell]["impairmentOther"];
		
		for (const cell in data[cellVars.position][cellVars.subCategory]) {
			currCellIndex = keys.indexOf(cell);
			if (currCellIndex > selectedCellIndex) {
				data[cellVars.position][cellVars.subCategory][cell]["value"] = value;
				data[cellVars.position][cellVars.subCategory][cell]["considerNormal"] = considerNormal;
				data[cellVars.position][cellVars.subCategory][cell]["impairment"] = impairment;
				data[cellVars.position][cellVars.subCategory][cell]["impairmentOther"] = impairmentOther;
			}
		}
	}
}

/*
	To display the controller in its appropriate state according to the type of selected cell.
*/
function updateController() {
	
	const allControls = ["0", "0*", "1", "1*", "2", "2*", "3", "3*", "4", "4*", "5", "5*", "NT", "NT*"];
	
	const states = {
		"lightTouch": ["0", "0*", "1", "1*", "2", "NT", "NT*"],
		"pinPrick": ["0", "0*", "1", "1*", "2", "NT", "NT*"],
		"motor": ["0", "0*", "1", "1*", "2", "2*", "3", "3*", "4", "4*", "5", "5*", "NT", "NT*"]
	};
	
	let cellVars = getCellVars();
	if (cellVars) {
		let currState = states[cellVars.subCategory];
		allControls.forEach(function (element) {
			if ($.inArray(element, currState) != -1) {
				$(".combo-item > span[data-value='" + element + "']").removeClass("disabled");
			}
			else {
				$(".combo-item > span[data-value='" + element + "']").addClass("disabled");
			}
		})
	}
	else {
		allControls.forEach(function (element) {
			$(".combo-item > span[data-value='" + element + "']").addClass("disabled");
		})
	}
}

/*
	When a flagged value is clicked in the controller, then display flagged form items.
	When flagged form items are displayed, also populate them with corresponding values from the data object,
	if they're not null.
*/
function renderFlaggedItems() {
	const HighlightControls = ["0*", "1*", "2*", "3*", "4*", "5*", "NT*"];
	let cellVars = getCellVars();
	if (cellVars) {
		let currValue = data[cellVars.position][cellVars.subCategory][cellVars.cell]["value"];
		if ($.inArray(currValue, HighlightControls) != -1) {
			updateFlaggedItems(cellVars)
			showHeaderComments()
		} else {
			updateFlaggedItems(cellVars)
			hideHeaderComments()
		}
	} else {
		hideHeaderComments();
	}
}

/*
* Helpers for renderFlaggedItems
* */

function hideHeaderComments() {
	$("#ConsiderationForNotSciLabel").attr("style", "display:none");
	$("#ConsiderationForImpairmentNotDueToSci").attr("style", "display:none");
	$("#ReasonNotSciContainer").attr("style", "display:none");
	$("#ReasonNotSciCommentContainer").attr("style", "display:none");
}
function showHeaderComments() {
	$("#ConsiderationForNotSciLabel").show();
	$("#ConsiderationForImpairmentNotDueToSci").show();
	$("#ReasonNotSciContainer").show();
	$("#ReasonNotSciCommentContainer").show();
}

/* Populate the corresponding values from data object
	- considerNormal, impairment, impairmentOther
 */

function updateFlaggedItems(cellVars) {
	let considerNormal = data[cellVars.position][cellVars.subCategory][cellVars.cell]["considerNormal"];
	let impairment = data[cellVars.position][cellVars.subCategory][cellVars.cell]["impairment"];
	let impairmentOther = data[cellVars.position][cellVars.subCategory][cellVars.cell]["impairmentOther"];
	$("#ConsiderationForImpairmentNotDueToSci").val(considerNormal);
	$("#ReasonForImpairmentNotDueToSci").val(impairment);
	$("#CommentsReasonForImpairmentNotDueToSci").val(impairmentOther);
}


/*	
	Displays the values of every cell in the data object
*/
function updateForm() {
	
	for (const position in data) {
		switch (position) {
			case "left":
			case "right":
				for (const subcategory in data[position]) {
					for (const cell in data[position][subcategory]) {
						let suffix = "";
						switch (subcategory) {
							case "lightTouch":
								suffix = "Touch";
							break;
							case "pinPrick":
								suffix = "Prick";
							break;
							case "motor":
								suffix = "Motor"
							break;
						}
						
						let id = cell + position.charAt(0).toUpperCase() + position.slice(1) + suffix;
						let selector = "#" + id;
							
						let value = data[position][subcategory][cell]["value"];
						$(selector).val(value);
						
						// If flagged value then highlight the cell
						if (value && value.includes("*"))
							$(selector).addClass("flagged-cell");
						else
							$(selector).removeClass("flagged-cell");

						
						// Highlight propagation start
						if (!value)
							$(selector).removeClass("manually-entered-cell");
						else if (id == selectedCell)
							$(selector).addClass("manually-entered-cell");
						else if (!disablePropagation){
							// Remove highlight if in selectedCell's' propagation path
							let cellVars = getCellVars();
							if (cellVars && position == cellVars.position && subcategory == cellVars.subCategory) {
								let keys = Object.keys(data[cellVars.position][cellVars.subCategory]);
								let selectedCellIndex = keys.indexOf(cellVars.cell);
								let currCellIndex = keys.indexOf(cell);
								if (currCellIndex > selectedCellIndex) {
									$(selector).removeClass("manually-entered-cell");
								}
							}	
						}
					}
				}
			break;
		}
	}
}


/*
	Displays the scores in the form, after the scores variable has been populated
*/
function updateScores() {
	for (const id in scores) {
		let val = scores[id];
		if (val) {
			const array = val.split(',');
			if (array.length > 1) {
				score_ranges[id] = showRange(array);
				$("#" + id).text("ND");
				$("#" + id).css('color', '#f15a24');
			} else {
				$("#" + id).text(val);
				$("#" + id).css('color', 'black');
			}
		}
		else {
			$("#" + id).text("");
			$("#" + id).css('color', 'black');
		}
	}
	console.log(score_ranges)
}

/*
	Helpers for UpdateScores
*/

function parseToRange(array) {
	array.sort();
	console.log(array);
	const ranges = (array[0]).toString() + "-" + (array[array.length - 1]).toString();
	return ranges;
}

function showRange(array) {
	if (array.includes("INT")) {
		array.splice(array.indexOf("INT"),1)
		let ranges = parseToRange(array);
		return ranges + ",INT"
	} else {
		let ranges = parseToRange(array);
		return ranges;
	}

}


/*
	Validate that all the required fields of the form have been filled. 
	
	All fields in the data object must have a value. If a value is flagged then
	considerNormal, impairment, and impairmentOther must be filled, otherwise they can be empty.
	
	The following are not required for validation:
	- lowestNonKeyMuscleWithMotorFunction and its sub-fields
	- comments
	
	return boolean
*/
function validate() {
	if (data["deepAnalPressure"] === null || data["voluntaryAnalContraction"] === null ||
		data["deepAnalPressure"] === "" || data["voluntaryAnalContraction"] === "") {
		console.log("Empty values in deepAnalPressure & voluntaryAnalContraction fields")
		return false;
	} else if (iterativeValidate(data["left"]) && iterativeValidate(data["right"])) {
		console.log("all the entries are valid, ready to calculate.");
		return true;
	} else {
		return false;
	}
}

/*
* Helpers for validate()
*/

function iterativeValidate(contents) {
	const HighlightControls = ["0*", "1*", "2*", "3*", "4*", "5*", "NT*"];
	for (const subCategory in contents) {
		for (const cell in contents[subCategory]) {
			if ($.inArray(contents[subCategory][cell]["value"], HighlightControls) != -1) {
				if (contents[subCategory][cell]["value"] === null ||
					contents[subCategory][cell]["considerNormal"] === null ||
					contents[subCategory][cell]["considerNormal"] === "") {
					console.log("the flagged cell: " + subCategory + cell +
						" has empty comments from the header");
					return false;
				}
			} else {
				if (contents[subCategory][cell]["value"] === null) {
					console.log("the non-flagged cell: " + subCategory + cell +
						" is empty");
					return false;
				}
			}
		}
	}
	return true;
}


/*
	Resets the form to its default state.
	
	- Reset all values in the data and scores objects to null
	- Clear the all values in the UI. (see updateForm() && updateScores())
	- Clear selectedCell:
		- Remove selected-cell class from selectedCell
		- Set selectedCell to null
	- Reset Controller (see updateController())
*/
function clear() {
	iterativeClearObject(data);
	updateForm();
	
	iterativeClearObject(scores);
	updateScores();
	
	clearSelectedCell();
	clearDropdowns();
	clearComments();
	
	$("#DisablePropagationBox").removeAttr('checked');
	$("#save-data-section").hide();
	$(".alert").hide();
	
	// Reset visit info and additional radio fields
	let selectors = [".visit", "#exam-date", "#exam-time", "#examiner-name", ".examiner-position", ".bcr-status", ".ce-syndrome", ".neurological-deficit"];
	for (var i = 0; i < selectors.length; i++) {
		$(selectors[i]).val(null).prop('checked', false);;
	}
}

/*
* Helpers for clear()
* */

function iterativeClearObject(contents) {

	for (const key in contents) {
		if (typeof contents[key] === 'object' ) {
			iterativeClearObject(contents[key]);
		} else {
			contents[key] = null;
		}
	}
}

function clearSelectedCell() {
	if (selectedCell) {
			$("#" + selectedCell).removeClass("selected-cell");
		}
		selectedCell = null;
		updateController();
		renderFlaggedItems();
}

function clearDropdowns() {
	let allDropdowns = ["#ConsiderationForImpairmentNotDueToSci", "#ReasonForImpairmentNotDueToSci",
		"#RightLowestNonKeyMuscleWithMotorFunction", "#LeftLowestNonKeyMuscleWithMotorFunction",
		"#AnalContraction", "#AnalSensation", "#redcap-record", "#redcap-event"];
	for (const dropdown of allDropdowns) {
		$(dropdown).val(null);
	}
}


function clearComments() {
	let allComments= ["#CommentsReasonForImpairmentNotDueToSci", "#Comments", "#classificationsComments"];
	for (const textbox of allComments) {
		$(textbox).val(null);
	}
}

/*
	Calculate the scores for the form, assuming validation has been run.
*/
function calculate() {
	let exam = {
		"deepAnalPressure": data["deepAnalPressure"],
		"voluntaryAnalContraction": data["voluntaryAnalContraction"]
	}
	
	for (const position in data) {
		
		if (position == "left" || position == "right") {
			exam[position] = {};
			for (const subcategory in data[position]) {
				exam[position][subcategory] = {};
				for (const cell in data[position][subcategory]) {
					// have to change value if considered normal
					if (data[position][subcategory][cell]["considerNormal"] == 1) {
						exam[position][subcategory][cell] = data[position][subcategory][cell]["value"] + "*";
					}
					else {
						exam[position][subcategory][cell] = data[position][subcategory][cell]["value"];
					}
				}
			}
		}
		
		if (position == "lowestNonKeyMuscleWithMotorFunction") {
			if (exam["left"] && data[position]["left"]) {
				exam["left"][position] = data[position]["left"];
			}
			
			if (exam["right"] && data[position]["right"]) {
				exam["right"][position] = data[position]["right"];
			}
		}
	}
	
	let result = new ISNCSCI(exam);
	
	/*
		Populate scores object
	*/
	
	// Totals
	scores["RightTouchTotal"] = result["totals"]["right"]["lightTouch"];
	scores["RightMotorTotal"] = result["totals"]["right"]["motor"];
	scores["RightPrickTotal"] = result["totals"]["right"]["pinPrick"];
	scores["RightUpperMotorTotal"] = result["totals"]["right"]["upperExtremity"];
	scores["RightLowerMotorTotal"] = result["totals"]["right"]["lowerExtremity"];
	scores["RightTouchTotalSubscore"] = result["totals"]["right"]["lightTouch"];
	scores["RightPrickTotalSubscore"] = result["totals"]["right"]["pinPrick"];
	
	scores["LeftTouchTotal"] = result["totals"]["left"]["lightTouch"];
	scores["LeftMotorTotal"] = result["totals"]["left"]["motor"];
	scores["LeftPrickTotal"] = result["totals"]["left"]["pinPrick"];
	scores["LeftUpperMotorTotal"] = result["totals"]["left"]["upperExtremity"];
	scores["LeftLowerMotorTotal"] = result["totals"]["left"]["lowerExtremity"];
	scores["LeftTouchTotalSubscore"] = result["totals"]["left"]["lightTouch"];
	scores["LeftPrickTotalSubscore"] = result["totals"]["left"]["pinPrick"];
	
	scores["UpperMotorTotal"] = result["totals"]["upperExtremity"];
	scores["LowerMotorTotal"] = result["totals"]["lowerExtremity"];
	scores["TouchTotal"] = result["totals"]["lightTouch"];
	scores["PrickTotal"] = result["totals"]["pinPrick"];
	
	// Classifications
	scores["RightSensory"] = result["classification"]["neurologicalLevels"]["sensoryRight"];
	scores["RightMotor"] = result["classification"]["neurologicalLevels"]["motorRight"];
	scores["RightSensoryZpp"] = result["classification"]["zoneOfPartialPreservations"]["sensoryRight"];
	scores["RightMotorZpp"] = result["classification"]["zoneOfPartialPreservations"]["motorRight"];
	
	scores["LeftSensory"] = result["classification"]["neurologicalLevels"]["sensoryLeft"];
	scores["LeftMotor"] = result["classification"]["neurologicalLevels"]["motorLeft"];
	scores["LeftSensoryZpp"] = result["classification"]["zoneOfPartialPreservations"]["sensoryLeft"];
	scores["LeftMotorZpp"] = result["classification"]["zoneOfPartialPreservations"]["motorLeft"];
	
	scores["NeurologicalLevelOfInjury"] = result["classification"]["neurologicalLevelOfInjury"];
	scores["Completeness"] = result["classification"]["injuryComplete"];
	scores["AsiaImpairmentScale"] = result["classification"]["ASIAImpairmentScale"];
	
	console.log(exam);
	console.log(result);
}




/*
	Move currently selected cell 1 right or left.
	
	Left: If possible, move to the previous cell on the left. Else do nothing.
	Right: If possible, move to the next cell on the right. Else do nothing.
*/
function moveHorizontally(direction) {
	let newCell = null;
	switch(direction) {
		case "right":
			newCell = $("#" + selectedCell).parent("td").next().find(".smart-cell");
		break;
		case "left":
			newCell = $("#" + selectedCell).parent("td").prev().find(".smart-cell");
		break;
	}
	
	if (newCell.length > 0) {
		$("#" + selectedCell).removeClass("selected-cell");
		newCell.addClass("selected-cell");
		selectedCell = newCell.attr("id");
		$("#" + selectedCell).focus();
	}
}

/*
	Move currently selected cell 1 cell up or down.
	
	Up: If possible, move to the next cell directly above selectedCell. Else do nothing.
	Down: If possible, move to the next cell directly below selectedCell. Else do nothing.
*/
function moveVertically(direction) {
	let newCells = null;
	let newCell = null;
	
	let endPos = $("#" + selectedCell).attr("class").indexOf("manually-entered-cell selected-cell") != -1 ? 
						$("#" + selectedCell).attr("class").indexOf("manually-entered-cell selected-cell") :
						$("#" + selectedCell).attr("class").indexOf("selected-cell");
						
	let classList = trim($("#" + selectedCell).attr("class").substring(0, endPos));
	
	switch(direction) {
		case "up":
			newCells = $("#" + selectedCell).parent("td").parent("tr").prevAll().find("td > input[class*='" + classList + "']");
			if (newCells.length > 0)
				newCell = $(newCells.get(newCells.length-1));
		break;
		case "down":
			newCells = $("#" + selectedCell).parent("td").parent("tr").nextAll().find("td > input[class*='" + classList + "']");
			if (newCells.length > 0)
				newCell = $(newCells.get(0));
		break;
	}
			
	if (newCell && newCell.length > 0) {
		$("#" + selectedCell).removeClass("selected-cell");
		newCell.addClass("selected-cell");
		selectedCell = newCell.attr("id");
		$("#" + selectedCell).focus();
	}
}


$(document).keydown(function (e) {
	
	if (selectedCell) {
		switch(e.which) {
			/*
			Tab
			
			If possible, move to the next cell on the right. 
			Else if there's a row available move to the leftmost cell in the next row.
			Else do nothing.
			*/
			case 9 : // Tab
				let rowCells = $("#" + selectedCell).parent("tr").children(".smart-cell");
				let cellIndex = rowCells.index($("#" + selectedCell));
				if (cellIndex < rowCells.length-1) {
					moveHorizontally("right");
				}
				else {
					let nextRowNumCells = $("#" + selectedCell).parent("tr").next().find(".smart-cell").length;
					if (nextRowNumCells > 0) {
						if (cellIndex > nextRowNumCells-1) { // selectedCell is motor cell, first below cell is sensory
							moveHorizontally("left");
							moveVertically("down");
							moveHorizontally("left");
						}
						else if (cellIndex < nextRowNumCells-1) { // selectedCell is sensory cell, first below cell is motor
							moveVertically("down");
							moveHorizontally("left");
							moveHorizontally("left");
						}
						else { // selectedCell is of the same type as the first below cell
							moveVertically("down");
							moveHorizontally("left");
							
							if (nextRowNumCells == 3) { // Move one more space if selectedCell is motor
								moveHorizontally("left");
							}
						}
					}
				}
			break;
	        case 37: // left
				moveHorizontally("left");
	        break;
	        case 39: // right
				moveHorizontally("right");
	        break;
	        case 38: // up
				moveVertically("up");
	        break;
	        case 40: // down
				moveVertically("down");
	        break;
	        default: return; // exit this handler for other keys
	    }
		updateController();
		renderFlaggedItems();
	    e.preventDefault(); // prevent the default action (scroll / move caret)
	}
});

$('#main-content').mousedown(function (event) {
	let id = null;
	if ($(event.target).hasClass("smart-cell")) {
		id = $(event.target).attr("id");
	}
	
	// highlight currently selected cell
	if (id) {
		$("#" + selectedCell).removeClass("selected-cell");
		$("#" + id).addClass("selected-cell");
	}
	else if (selectedCell) {
		$("#" + selectedCell).removeClass("selected-cell");
	}
	
	selectedCell = id;
	updateController();
	renderFlaggedItems();
});

$(".combo-item > span").click(function () { 
	if (!$(this).hasClass("disabled")) {
		let value = $(this).attr("data-value");
		setCellValue("value", value);

		if ($(this).hasClass("flag")) {
			renderFlaggedItems();
		}
		else {
			renderFlaggedItems();
			setCellValue("considerNormal", null);
			setCellValue("impairment", null);
			setCellValue("impairmentOther", null);
		}
		
		setPropagatedCellValues();
		updateForm();
		
		// Only move to the next cell if the selected value is not flagged.
		if (!value.includes("*")) {
			moveVertically("down");
		}
	}
});

$(".smart-cell").on("input", function() {
	
	let validMotorValues = ["0", "1", "2", "3", "4", "5", "N", "NT", "0*", "1*", "2*", "3*", "4*", "5*", "NT*"];
	let validSensoryValues = ["0", "1", "2", "N", "NT", "0*", "1*", "2*", "NT*"]
	let cellVars = getCellVars();
	let value = $(this).val();
	
	if ((cellVars.subCategory == "motor" && validMotorValues.includes(value)) || 
		(cellVars.subCategory != "motor" && validSensoryValues.includes(value))) {
		
		if (value == "N") {
			value = "NT";
		}
		
		setCellValue("value", value);

		if ($(this).hasClass("flag")) {
			renderFlaggedItems();
		}
		else {
			renderFlaggedItems();
			setCellValue("considerNormal", null);
			setCellValue("impairment", null);
			setCellValue("impairmentOther", null);
		}
		
		setPropagatedCellValues();
		updateForm();
		
		// Only move to the next cell if the selected value is not flagged.
		if (!value.includes("*")) {
			moveVertically("down");
		}
	}
	else if (value) {
		alert("You're entering an incorrect value for your selected cell!");
		$("#" + selectedCell).val(null);
	}
})

$("#ConsiderationForImpairmentNotDueToSci").change(function () { 
	let value = $(this).val();
	setCellValue("considerNormal", value);
	setPropagatedCellValues();
	updateForm();
});

$("#ReasonForImpairmentNotDueToSci").change(function () { 
	let value = $(this).val();
	setCellValue("impairment", value);
	setPropagatedCellValues();
	updateForm();
});

$("#CommentsReasonForImpairmentNotDueToSci").on('input', function () {
	let value = $(this).val();
	setCellValue("impairmentOther", value);
	setPropagatedCellValues();
	updateForm();
});

$("#RightLowestNonKeyMuscleWithMotorFunction").change(function () { 
	data["lowestNonKeyMuscleWithMotorFunction"]["right"] = $(this).val(); 
});

$("#LeftLowestNonKeyMuscleWithMotorFunction").change(function () { 
	data["lowestNonKeyMuscleWithMotorFunction"]["left"] = $(this).val(); 
});

$("#AnalContraction").change(function () { data["voluntaryAnalContraction"] = $(this).val();});

$("#AnalSensation").change(function () { data["deepAnalPressure"] = $(this).val();});

$("#Comments").on('input', function () { data["comments"] = $(this).val();});

$("#DisablePropagationBox").change(function () { 
	if ($(this).is(":checked")) {
		disablePropagation = true;
	}
	else {
		disablePropagation = false;
	}
});

document.getElementById("test-totals").onmouseover = function() {

}

$('.total').mouseover(function() {
	let currElementID = this.id;
	let range = score_ranges[currElementID];
	if (range != null) {
		this.title = range;
		console.log("currElement: " + currElementID + " range = " + this.title);
		$(this).tooltip({trigger: "hover", animation: true});
	}
});


$('#clearContent').click(function () { clear(); });

$("#calculator").click(function () { 
	
	if (validate()) {
		calculate(); 
		updateScores();
		$("#save-data-section").show();
		window.scrollTo(0, document.body.scrollHeight);
	}
	else {
		alert("Could not calculate, the form is incomplete.");
		$("#save-data-section").hide();
	}
});

$(".examiner-position").change(function () {
	if ($(this).val() == 8) {
		$("#other-examiner-text").show();
	}
	else {
		$("#other-examiner-text").hide();
	}
})

$(".visit").change(function () { data["visit"] = $(this).val(); });

$("#exam-date").change(function () { data["examDate"] = $(this).val(); });

$("#exam-time").change(function () { data["examTime"] = $(this).val(); });

$("#examiner-name").change(function () { data["examinerName"] = $(this).val(); });

$(".examiner-position").change(function () { data["examinerPosition"] = $(this).val(); });

$("#other-examiner-text").change(function () { data["examinerPositionOther"] = $(this).val(); });

$(".bcr-status").change(function () { data["bcrStatus"] = $(this).val(); });

$(".ce-syndrome").change(function () { data["ceSyndrome"] = $(this).val(); });

$(".neurological-deficit").change(function () { data["neurologicalDeficit"] = $(this).val(); });

$("#classificationsComments").change(function () { data["classificationsComments"] = $(this).val(); });

$("document").ready(function () {
	renderFlaggedItems();
});
