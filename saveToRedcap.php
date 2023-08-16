<?php 

    $record_id = $_POST["redcap_record"];
    $redcap_event_name = $_POST["redcap_event"];
    
    $data = $_POST["data"];
    $scores = $_POST["scores"];
    
    $record_data = [REDCap::getRecordIdField() => $record_id];
    
    if (!empty($redcap_event_name)) {
        $record_data["redcap_event_name"] = $redcap_event_name;
    }
    
    // Parse Visit Info
    $record_data["exam_date"] = $data["examDate"];
    $record_data["exam_time"] = $data["examTime"];
    $record_data["examiner_name"] = $data["examinerName"];
    $record_data["examiner_position"] = $data["examinerPosition"];
    $record_data["examiner_position_other"] = $data["examinerPositionOther"];
    
    // Parse Data
    $record_data["deep_anal_pressure"] = $data["deepAnalPressure"];
    $record_data["voluntary_anal_contraction"] = $data["voluntaryAnalContraction"];
    $record_data["lowest_non_key_muscle_with_motor_function_right"] = $data["lowestNonKeyMuscleWithMotorFunction"]["right"];
    $record_data["lowest_non_key_muscle_with_motor_function_left"] = $data["lowestNonKeyMuscleWithMotorFunction"]["left"];
    $record_data["comments"] = $data["comments"];
    $record_data["bcr_status"] = $data["bcrStatus"];
    $record_data["ce_syndrome"] = $data["ceSyndrome"];
    $record_data["neurological_deficit"] = $data["neurologicalDeficit"];
    
    $cell_data["left"] = $data["left"];
    $cell_data["right"] = $data["right"];
    
    foreach($cell_data as $position => $body_parts) {
        foreach($body_parts as $part => $cells) {
            foreach($cells as $cell => $values) {
                foreach($values as $field_name => $value) {
                    switch($part) {
                        case "lightTouch":
                            $redcap_part = "light_touch";
                            break;
                        case "pinPrick":
                            $redcap_part = "pinprick";
                            break;
                        default:
                            $redcap_part = $part;
                            break;
                    }
                    
                    $redcap_field_name = "{$position}_{$redcap_part}_" . strtolower($cell) . "_" . strtolower($field_name);
                    
                    if ($field_name == "value" && strpos($value, "*") !== false) {
                        $record_data[$redcap_field_name] = "ab-" . strtolower(substr($value, 0, strpos($value, "*")));
                    }
                    else {
                        $record_data[$redcap_field_name] = strtolower($value);
                    }
                }
            }
        }
    }
    
    // Parse totals
    $record_data["motor_right"] = $scores["RightMotorTotal"];
    $record_data["light_touch_right"] = $scores["RightTouchTotal"];
    $record_data["pin_prick_right"] = $scores["RightPrickTotal"];
    $record_data["upper_extremity_right"] = $scores["RightUpperMotorTotal"];
    $record_data["lower_extremity_right"] = $scores["RightLowerMotorTotal"];
    
    $record_data["motor_left"] = $scores["LeftMotorTotal"];
    $record_data["light_touch_left"] = $scores["LeftTouchTotal"];
    $record_data["pin_prick_left"] = $scores["LeftPrickTotal"];
    $record_data["upper_extremity_left"] = $scores["LeftUpperMotorTotal"];
    $record_data["lower_extremity_left"] = $scores["LeftLowerMotorTotal"];
    
    $record_data["upper_extremity_total"] = $scores["UpperMotorTotal"];
    $record_data["lower_extremity_total"] = $scores["LowerMotorTotal"];
    $record_data["light_touch_total"] = $scores["TouchTotal"];
    $record_data["pin_prick_total"] = $scores["PrickTotal"];
    
    // Parse Classifications
    $record_data["neurological_levels_sensory_right"] = $scores["RightSensory"];
    $record_data["neurological_levels_motor_right"] = $scores["RightMotor"];
    $record_data["zone_of_partial_preservations_sensory_right"] = $scores["RightSensoryZpp"];
    $record_data["zone_of_partial_preservations_motor_right"] = $scores["RightMotorZpp"];
    
    $record_data["neurological_levels_sensory_left"] = $scores["LeftSensory"];
    $record_data["neurological_levels_motor_left"] = $scores["LeftMotor"];
    $record_data["zone_of_partial_preservations_sensory_left"] = $scores["LeftSensoryZpp"];
    $record_data["zone_of_partial_preservations_motor_left"] = $scores["LeftMotorZpp"];
    
    $record_data["neurological_level_of_injury"] = $scores["NeurologicalLevelOfInjury"];
    $record_data["injury_complete"] = $scores["Completeness"];
    $record_data["asia_impairment_scale"] = $scores["AsiaImpairmentScale"];
    $record_data["classifications_comments"] = $data["classificationsComments"];
    
    $record_data["isncsci_exam_complete"] = 2;
        
    $save_result = REDCap::saveData(array(
        "project_id" => $module->getProjectId(),
        "dataFormat" => "json",
        "data" => json_encode([$record_data]),
        "overwriteBehavior" => "overwrite"
    ));
    
    if (!empty($save_result["errors"])) {
        print json_encode(["success" => false, "error" => "REDCap experienced the following errors when saving data:\n" . json_encode($save_result["errors"])]);
    }
    else {
        print json_encode(["success" => true]);
    }