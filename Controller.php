<?php

include_once 'Models/declarations.php';
include_once 'Models/inputs.php';
//handle the form data and generate outputs on base of required conditions
$response = array();
$response['success'] = false;

if (isset($_POST['token'])) {
    $data = $_POST;
    $group_main_service = explode(",", $data['group_main_service']);
    $system_design = explode(",", $data['system_design']);
    $system_stresses_and_loads = explode(",", $data['system_stresses_and_loads']);
    $response['output'] = processOutput($data, $group_main_service, $system_design, $system_stresses_and_loads);
    $response['inputs'] = $inputs;
    $response['success'] = true;
    echo json_encode($response);
} else {
    echo 'go away';
}

function isValueExist(array $arr, $value)
{
    foreach ($arr as $val) {
        if ($val == $value) {
            return true;
        }
    }
    return false;
}


function processOutput($data, $group_main_service, $system_design, $system_stresses_and_loads)
{
    //creep temperature in ferhenite
    $creepTemperature = array(650, 650, 700, 700, 700, 750, 750, 800, 800, 800, 800, 800, 825, 825, 800, 800, 800, 850, 825, 900, 1050, 1050, 1050, 1200, null, null, null, 950, 1000, 1000, 1000, 1000, 1000, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
    $output = array();
    $response = array();
    $maximumCorrectedInputs = 0;

    //add all conditions based on which you want to create output

    /* 1.1 Slight-Moderate Graphitization */
    if (in_array((int)$data['material-type'], range(1, 7)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 800 && $data['temperature-max-of-process-or-skin'] <= 1000) {

        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss in creep strength', 'Microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking.'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper Material Selection. Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Slight-Moderate Graphitization',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 1.2 Severe Graphitization */
    if (in_array((int)$data['material-type'], range(1, 7)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] > 1000 && $data['temperature-max-of-process-or-skin'] <= 1100 && $data['years-in-service'] >= 5) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss in creep strength', 'Microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking.'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper Material Selection. Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Severe Graphitization',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 2.1 Slight-Moderate Softening */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]) && in_array((int)$data['equipment-type'], [1, 6, 10, 11, 12, 13, 27, 16, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 850 && $data['temperature-max-of-process-or-skin'] < 1300) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Pearlitic phase gradual transformation from partial to complete spheroidization'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper IOW Monitoring.', 'Minimizing long-term exposure to elevated temperatures.'
                ));

        $output[] = [
            'output' => 'Slight-Moderate Softening',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 2.2  Severe Softening */
    if (in_array((int)$data['material-type'], range(1, 18)) && in_array((int)$data['equipment-type'], [1, 6, 10, 11, 12, 13, 27, 16, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1300 && $data['temperature-max-of-process-or-skin'] <= 1400) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Pearlitic phase gradual transformation from partial to complete spheroidization'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper IOW Monitoring.', 'Minimizing long-term exposure to elevated temperatures.'
                ));
        $output[] = [
            'output' => 'Severe Softening',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 3 Temper Embrittlement */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [10, 11, 12, 13, 16, 17, 18, 32, 33]) && $data['temperature-max-of-process-or-skin'] > 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Brittle fracture.', 'Intergranular cracking in severe cases.', 'Shift in the ductile-to-brittle transition temperature with negligible effects on the upper shelf energy.'
                ), 'Inspection Method' =>
                array('Charpy V-notch Impact test'
                ), 'Prevention' =>
                array('Proper Material Design.(PWHT, low level of Arsenics, Manganese, Silicon, Tin, Phosphorus in Metal & Weld electrode.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Temper Embrittlement',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 4 Strain Aging */
    if (in_array((int)$data['material-type'], [1, 2, 6]) && in_array((int)$data['equipment-type'], [8, 9, 11, 12, 13, 16, 17, 18, 24, 26, 28, 29, 30, 31, 32, 33, 35]) && $data['temperature-max-of-process-or-skin'] >= 450 && $data['thickness'] >= 1) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss of toughness and Increased hardness'
                ), 'Inspection Method' =>
                array('NA'
                ), 'Prevention' =>
                array('PWHT repaired welds.', 'Change to Newer Steel.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Strain Aging',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 5 885°F (475°C) Embrittlement */
    if (in_array((int)$data['material-type'], [25, 26]) && in_array((int)$data['equipment-type'], [16, 22, 35, 36, 37]) && $data['temperature-max-of-process-or-skin'] >= 600 && $data['temperature-max-of-process-or-skin'] <= 1000) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss of toughness and Increased hardness'
                ), 'Inspection Method' =>
                array('Impact Testing.', 'Bend Testing'
                ), 'Prevention' =>
                array('Proper Material Selection: Low ferrite or non-ferritic alloys.', 'Avoid exposing to embrittling temperature range.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => '5 885°F (475°C) Embrittlement',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /** 6 Sigma Phase Embrittlement */
    if (in_array((int)$data['material-type'], range(22, 34)) && in_array((int)$data['equipment-type'], [6, 10, 12, 13, 15, 16, 27, 36, 39]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] <= 1700) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracking, Welds & High Stress areas are more susceptible.'
                ), 'Inspection Method' =>
                array('Metallographic examination and impact testing'
                ), 'Prevention' =>
                array('Proper Material Selection.', 'Avoid exposing to the embrittling temperature range.', 'PWHT'
                ));
        $output[] = [
            'output' => 'Sigma Phase Embrittlement',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /** 7 Brittle Fracture */
    /*check OR logic format is correct  and number of "corrected input is correct (4 or 6)" */
    /* numbers [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41]*/
    /* numbers [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47]*/
    /* logic operator format && isset($data['thermal-cycle-over-heating']) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25]) && in_array((int)$data['equipment-type'], [14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 40]) && $data['years-in-service'] >= 30 && ((isValueExist($system_stresses_and_loads, 'tensile-induced-stress')) || (isValueExist($system_stresses_and_loads, 'compressive-induced-stress')) || (isset($data['excessive-residual-stress'])))) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks (Straight, non-branching, and no ductility / plastic deformation)'
                ), 'Inspection Method' =>
                array('Impact test.'
                ), 'Prevention' =>
                array('Proper Material Selection and Heat treatment', 'Strict IOWs especially during Hydrotest & Startup/Shutdown'
                ));
        $correctInputs = isValueExist($system_stresses_and_loads, 'tensile-induced-stress') ? (isValueExist($system_stresses_and_loads, 'compressive-induced-stress') ? (isset($data['excessive-residual-stress']) ? 6 : 5) : (isset($data['excessive-residual-stress']) ? 5 : 4)) : 4;
        $output[] = [
            'output' => 'Brittle Fracture ',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /** 8 Creep & Stress Rupture */
    /*what does the logic do when creep temp is not available? does it ignore this logic or just makes it true?
    Ans : ignore this logic
     */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= $creepTemperature[(int)$data['material-type']]) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array(' At Creep temperature threshold limits, deformation may be observed as well as Creep cracking.', 'Creep voids, fissuring and cracks around the grain boundaries at later stages.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing', 'NDE-Radiographic Testing', 'NDE-Eddy Current Testing', 'NDE-Dimensional measurements', 'NDE-Replication', 'Electron metallography (Early stage / Validate Damage)'
                ), 'Prevention' =>
                array('Proper Material Selection.', 'Avoid exposing to temperature above Creep threshold.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Creep & Stress Rupture',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /** 9 Thermal Fatigue */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 38, 40, 41]) && isValueExist($system_stresses_and_loads, 'thermal-cycle')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks usually initiate on the surface of the component and propagate transverse to the stress direction.'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Magnetic Particle', 'NDE-Liquid Penetrant', 'NDE-Ultrasonic Testing'
                ), 'Prevention' =>
                array('Design and operation to minimize thermal stresses and thermal cycling.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Thermal Fatigue',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /** 10 Short Term Overheating Stress Rupture */
    /* look at your former code, and review the new format. I changed it for consistency.
    check "corrected input is correct as per your structure"
    $equipmentType = range(1, 13);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['material-type'], $equipmentType) && isset($data['Intermittent'])) */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 39, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 6, 10, 12, 13]) && isValueExist($system_stresses_and_loads, 'intermittent-overheating') && $data['temperature-max-of-process-or-skin'] >= 1000) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized deformation or bulging on the order of 3% to 10% or more and Stress Rupture.'
                ), 'Inspection Method' =>
                array('NDE Visual examination', 'Real-time Instrument- Skin Thermocouple.'
                ), 'Prevention' =>
                array('Minimize localized temperature excursions.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Short Term Overheating Stress Rupture',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }

    /** 11 Steam Blanketing */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], [1, 6, 10, 12, 13])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Open burst with the fracture edges', 'bulging drawn to a near knife-edge'
                ), 'Inspection Method' =>
                array('NDE Visual examination', 'Real-time Instrument', 'Skin Thermocouple or Infrared Scan Monitoring'
                ), 'Prevention' =>
                array('Properly maintained to prevent flame impingement', 'Proper burner management system maintenance to minimize flame impingement.'
                ));
        $output[] = [
            'output' => 'Steam Blanketing',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /** 12 Dissimilar Metal Weld (DMW) Cracking */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && ((int)$data['equipment-type'] != 0) && isValueExist($system_design, 'mismatch-adjoining-metals-in-equipment')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks.', ' Usually formed around the toe of the weld in the heat-affected zone'
                ), 'Inspection Method' =>
                array('NDE Visual examination', 'NDE-Liquid Penetrant', 'NDE-Ultrasonic Testing', ' NDE-Radiographic Testing', 'NDE- Positive Material Identification'
                ), 'Prevention' =>
                array('Proper Material Design (geometry and correct welding procedure )'
                ));
        $output[] = [
            'output' => 'Dissimilar Metal Weld (DMW) Cracking',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /** 13 Thermal Shock */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18, 28, 29, 30, 31, 32, 33, 34]) && isValueExist($system_stresses_and_loads, 'thermal-cycle')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks initiating from the surface and may also appear as craze cracks.'
                ), 'Inspection Method' =>
                array('NDE-Liquid Penetrant.', 'NDE-Magnetic Particle.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Proper Structural restraint design.', 'IOW Monitoring to reduce process induced thermal variance'
                ));
        $output[] = [
            'output' => 'Thermal Shock',
            'correctedInputs' => 2,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
        unset($desc);
    }
    /** 14 Erosion/Erosion Corrosion */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 42, 43, 44, 45, 46, 47]) && ((int)$data['equipment-type'] != 0)) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized loss in thickness in the form of pitsLocalized loss in thickness in the form of pits', 'grooves' . 'gullies', 'waves', 'rounded holes and valleys'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Ultrasonic Testing.', 'NDE-Radiographic Testing', 'Infrared Scan Monitoring for Refractory thickness monitoring'
                ), 'Prevention' =>
                array('Proper Material Design', 'Shape and Geometry of equipment'
                ));
        $output[] = [
            'output' => 'Erosion/Erosion Corrosion',
            'correctedInputs' => 2,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
        unset($desc);
    }

    /** 15 Cavitation */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [38, 39])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Sharp-edged pits or  gouges in rotational components'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Ultrasonic Testing.', 'NDE-Radiographic Testing'
                ), 'Prevention' =>
                array('Proper Material Design and Operating Condition'
                ));
        $output[] = [
            'output' => 'Cavitation',
            'correctedInputs' => 2,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
        unset($desc);
    }
    /** 16 Mechanical Fatigue */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 27, 31, 32, 34, 38, 39]) && ((isValueExist($system_stresses_and_loads, 'tensile-induced-stress')) || (isValueExist($system_stresses_and_loads, 'compressive-induced-stress')))) {
        $correctInputs = isValueExist($system_stresses_and_loads, 'tensile-induced-stress') ? (isValueExist($system_stresses_and_loads, 'compressive-induced-stress') ? 4 : 3) : isValueExist($system_stresses_and_loads, 'compressive-induced-stress') ? (isValueExist($system_stresses_and_loads, 'tensile-induced-stress') ? 4 : 3) : 3;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Clam shell type fingerprint profile (concentric rings) on crack-line around Areas of stress concentration.'
                ), 'Inspection Method' =>
                array('NDE-Visual inspections', 'NDE-Liquid Penetrant', 'NDE-Magnetic Particle', 'NDE-Ultrasonic Testing', 'Vibration monitoring.'
                ), 'Prevention' =>
                array('Proper Material Design', 'Proper Structural restraint design.', ' IOW Monitoring'
                ));
        $output[] = [
            'output' => 'Mechanical Fatigue ',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }

    /** 17 Vibration-Induced Fatigue  */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [15, 16, 27, 34, 35, 36, 37, 38, 39]) && (isValueExist($system_stresses_and_loads, 'dynamic-induced-loading'))) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Crack initiating at a point of high stress or discontinuity such as a thread or weld joint '
                ), 'Inspection Method' =>
                array('NDE-Visual inspections', 'Vibration monitoring.'
                ), 'Prevention' =>
                array('Proper Process Design.', 'Proper equipment structural Design and installation and the use of supports and vibration dampening equipment.', ' IOW Monitoring'
                ));
        $output[] = [
            'output' => 'Vibration-Induced Fatigue ',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /** 18 Refractory Degradation */
    if (in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) && in_array((int)$data['material-type'], [40]) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 3 : 2);
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Excessive cracking', 'spalling or lift-off from the substrate', ' softening or general degradation from exposure to moisture', 'thinning', 'anchor exposure'
                ), 'Inspection Method' =>
                array('NDE-Visual inspections', 'Cold and hot Thermography Scans'
                ), 'Prevention' =>
                array('Proper Material Design: refractory, anchors and fillers and their proper design and installation', 'IOW Monitoring'
                ));
        $output[] = [
            'output' => 'Refractory Degradation ',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /** 19 Reheat Cracking */
    if (in_array((int)$data['material-type'], [6, 7, 8, 9, 10, 11, 12, 3, 14, 15, 16, 19, 21, 22, 23, 24, 27, 28, 29, 30, 31, 32, 33, 44, 47]) && in_array((int)$data['equipment-type'], [27, 28, 29, 30, 31, 32, 33]) && $data['temperature-max-of-process-or-skin'] > 750 && $data['thickness'] >= 1) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Intergranular cracking (Surface breaking or embedded depending on stress and geometry type). Welds /HAZ are particularly susceptible.'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Liquid Penetrant', ' NDE-Ultrasonic Testing', ' NDE-Magnetic Particle', 'NDE-Time of Flight Diffraction TOFD'
                ), 'Prevention' =>
                array('Proper weld design.', 'Joint configurations in heavy wall sections should be designed to minimize restraint during welding and PWHT.', ' Proper Welding preheat/interpass heat procedure.'
                ));
        $output[] = [
            'output' => 'Reheat Cracking ',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }

    /* 20 Gaseous Oxygen-Enhanced Ignition and Combustion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 39, 41, 43]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) && isValueExist($group_main_service, '25-percent-Oxygen-process')) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 5 : 4) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3);
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Internal/ external fire damage', 'Component burn, such as a valve seat,  without kindling other materials and without any outward sign of fire damage'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'Backlights can be used to check for hydrocarbon contamination.'
                ), 'Prevention' =>
                array('Proper Material Design', ' IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Gaseous Oxygen-Enhanced Ignition and Combustion',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
    }

    /* 21 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 39, 41, 43]) && in_array((int)$data['equipment-type'], range(1, 41)) && isValueExist($system_design, 'mismatch-adjoining-metals-in-equipment')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Generalized wall loss in thickness or crevice', 'groove or pitting corrosion'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Ultrasonic Testing'
                ), 'Prevention' =>
                array('Proper Material Design and Coating / electric insulating Devices.'
                ));
        $output[] = [
            'output' => 'Galvanic Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 22 Atmospheric Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 43, 45]) && in_array((int)$data['equipment-type'], [14, 18, 19, 20, 21, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 39]) && isValueExist($system_design, 'ext-coating-anti-corrosion') && $data['temperature-max-of-process-or-skin'] < 250) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General or localized wall loss', 'depending upon whether or not the moisture is trapped.'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections', 'NDE-Ultrasonic Testing'
                ), 'Prevention' =>
                array('Proper Material Design.', 'Anti corrosion / rust Coating.'
                ));
        $output[] = [
            'output' => 'Atmospheric Corrosion',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 23 Corrosion Under Insulation */
    if (in_array((int)$data['equipment-type'], [14, 18, 19, 20, 21, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 39]) && isValueExist($system_design, 'insulated-fire-proofed-equipment') && ((in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && $data['temperature-max-of-process-or-skin'] <= 350 && $data['temperature-max-of-process-or-skin'] >= 10)
            || (in_array((int)$data['material-type'], [26, 27, 28, 29, 30, 31, 32, 33, 42]) && $data['temperature-max-of-process-or-skin'] <= 400 && $data['temperature-max-of-process-or-skin'] >= 140)

        )) {
        $correctedInputs = 2;
        if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]))
            $correctedInputs++;
        if (in_array((int)$data['material-type'], [26, 27, 28, 29, 30, 31, 32, 33, 42]))
            $correctedInputs++;
        if ($data['temperature-max-of-process-or-skin'] <= 350 && $data['temperature-max-of-process-or-skin'] >= 10)
            $correctedInputs++;
        if ($data['temperature-max-of-process-or-skin'] <= 400 && $data['temperature-max-of-process-or-skin'] >= 140)
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized pitting corrosion and/or wall loss in CS.', ' Stress Corrosion Cracks in SS'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections (Strip Insulation).', 'NDE-Ultrasonic Testing (Guided wave UT). ', ' NDE Real-time Profile x-ray (for small bore piping).', ' NDE-Neutron backscatter techniques for identifying wet insulation.', ' Deep penetrating eddy-current inspection. ', ' IR thermography looking for wet insulation and/or damaged and missing insulation under
the jacket.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Anti corrosion / rust Coating.', ' Maintaining the insulation/sealing/vapor barriers to prevent moisture ingress.'
                ));
        $output[] = [
            'output' => 'Corrosion Under Insulation',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 24 Cooling Water Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 25, 26, 27, 28, 29, 30, 31, 32, 33, 39, 43, 44, 45, 47]) && in_array((int)$data['equipment-type'], [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 40]) && isValueExist($group_main_service, 'water')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Generalized / Localized wall loss in thickness or crevice', 'groove or pitting corrosion.', 'Stress corrosion cracking and fouling'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections.', ' NDE-Ultrasonic Testing (Phased array).', ' NDE- Radiography. ', 'NDE-Eddy-current inspection.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Operation and chemical treatment of cooling water systems;', ' Monitoring of process  parameters that affect corrosion and fouling such as the pH', 'oxygen content', 'cycles of concentration', 'biocide residual', 'biological activity', 'cooling water outlet temperatures,', ' hydrocarbon contamination and process leaks. '
                ));
        $output[] = [
            'output' => 'Cooling Water Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /* 25 Boiler Water Condensate Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 45]) && in_array((int)$data['equipment-type'], [2, 3, 5, 16, 17, 27, 28, 39]) && isValueExist($group_main_service, 'water')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks', 'Localized Pitting corrosion.'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections. ', 'NDE-Magnetic Particle.'
                ), 'Prevention' =>
                array('Proper Material Design. ', 'Oxygen scavenging treatments typically include catalyzed sodium sulfite or hydrazine depending on the system pressure level along with proper mechanical deaerator operation. ', 'Amine treatment to eliminate CO2 in condensate return systems.'
                ));
        $output[] = [
            'output' => 'Boiler Water Condensate Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 26 CO2 Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], [2, 3, 5, 16, 20, 21, 22, 27, 28, 39]) && isValueExist($group_main_service, 'water') && isValueExist($group_main_service, 'carbon') &&
        $data['temperature-max-of-process-or-skin'] <= 300
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized thinning and/or pitting corrosion'
                ), 'Inspection Method' =>
                array('DE-Visual Inspections.', ' NDE-Ultrasonic Testing .', ' NDE- Radiography.'
                ), 'Prevention' =>
                array('Proper Material Design SS.', ' Corrosion inhibitors to the condensate systems.', ' Vapor phase inhibitors may be required to protect against condensing vapors.', ' Increasing condensate pH above 6.'
                ));
        $output[] = [
            'output' => 'CO2 Corrosion',
            'correctedInputs' => 5,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 5)
            $maximumCorrectedInputs = 5;
        unset($desc);
    }
    /* 27 Flue-Gas Dew-Point Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 28, 29, 30, 31, 32, 33]) && ((isset($data['sulphur-present']) && $data['temperature-max-of-process-or-skin'] <= 280) OR (isValueExist($group_main_service, 'chlorides') && $data['temperature-max-of-process-or-skin'] <= 130))
    ) {
        $correctedInputs = 2;
        if ($data['temperature-max-of-process-or-skin'] <= 280)
            $correctedInputs++;
        if (isset($data['sulphur-present']))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'chlorides'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized thinning and/or pitting corrosion in CS.', ' Surface breaking cracks with crazed surface appearance in SS.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography', ' NDE-Liquid Penetrant.', ' NDE-Visual Inspections.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Maintain the metallic surfaces temperature of the equipment backend above the sulfuric acid dewpoint corrosion temperature.'
                ));
        $output[] = [
            'output' => 'Flue-Gas Dew-Point Corrosion',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 28 Microbiologically Induced Corrosion (MIC) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25, 27, 28, 29, 30, 31, 32, 33, 43, 45, 44, 47]) && in_array((int)$data['equipment-type'], [16, 17, 18, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 38, 39, 40])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized pitting under deposits or tubercles shielding the organism.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography.', ' NDE-Visual Inspections.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Process Water treatment', 'high enough flow', ' Anti corrosion coating', 'Monitoring of process  parameters that affect MIC such as cycles of concentration', ' biocide residual', ' biological activity', ' cooling water outlet temperatures', 'hydrocarbon contamination.'
                ));
        $output[] = [
            'output' => 'Microbiologically Induced Corrosion (MIC)',
            'correctedInputs' => 2,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
        unset($desc);
    }
    /* 29 Soil Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 38, 42]) && in_array((int)$data['equipment-type'], [23, 24, 25, 26, 27]) && isValueExist($system_design, 'buried-soil-air-cemented-equipment')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('External thinning with localized losses due to pitting.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography.', ' NDE-Visual Inspections', ' Soil potential and resistivity.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Use of special backfill', ' Cathodic protection', ' Anti corrosion coating.'
                ));
        $output[] = [
            'output' => 'Soil Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 30 Caustic Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18, 27, 41]) && isValueExist($group_main_service, 'caustics')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized metal loss which may appear as grooves or locally thinned areas.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography', ' NDE-Visual Inspections.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Reduce the amount of free caustic and Alkaline producing salts  in the system. Cleaning and maintenance of Burner Management System.'
                ));
        $output[] = [
            'output' => 'Caustic Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 31 Dealloying. process:Cooling water application,  boiler feed water */
    if (in_array((int)$data['material-type'], [45, 35, 42]) && in_array((int)$data['equipment-type'], [16, 27, 38, 39])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Significant color change or a deep etched (corroded) appearance.'
                ), 'Inspection Method' =>
                array('NDE-Visual Inspections.', ' Metallographic examination.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Add balancing alloy for resistance.'
                ));
        $output[] = [
            'output' => 'Dealloying. process:Cooling water application,  boiler feed water',
            'correctedInputs' => 2,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
        unset($desc);
    }
    /* 32 Graphitic Corrosion. process:Dilute acids, mine water,salt water, soft water, Fire Water. Boiler feed water */
    if (in_array((int)$data['material-type'], [42]) && in_array((int)$data['equipment-type'], [27]) && $data['temperature-max-of-process-or-skin'] < 200 &&
        (isValueExist($group_main_service, 'water') || (isValueExist($group_main_service, 'acid-service')))) {
        $correctedInputs = isValueExist($group_main_service, 'water') ? (isValueExist($group_main_service, 'acid-service') ? 5 : 4) : (isValueExist($group_main_service, 'acid-service') ? 4 : 3);
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Local or general wall loss and affected areas soft and easily gouged mechanically using hand tool'
                ), 'Inspection Method' =>
                array('NDE-Acoustic techniques'
                ), 'Prevention' =>
                array('Proper Material Design.', ' Internal and External coatings and/or cement linings. ', 'Cathodic protection.', ' White Iron is not Susceptible.'
                ));
        $output[] = [
            'output' => 'Graphitic Corrosion. process:Dilute acids, mine water,salt water, soft water, Fire Water. Boiler feed water',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 33 Oxidation.  process: ANY */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 27, 28, 29, 30, 31, 32, 33, 38, 42, 44, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 27, 28, 29, 30, 31, 32, 33]) && $data['temperature-max-of-process-or-skin'] >= 1000) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General wall loss', 'thinning'
                ), 'Inspection Method' =>
                array('Real-time Instrument', 'Skin Thermocouple or Infrared Thermographic Scan Monitoring.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' IOW Monitoring'
                ));
        $output[] = [
            'output' => 'Oxidation.  process: ANY',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 34 Sulfidation.  process: Crude,coke,sulphur, fuel gas, feed gas */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 27, 28, 29, 30, 31, 32, 33, 38, 42, 44, 45, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18, 27, 28, 29, 30, 31, 32, 33]) && $data['temperature-max-of-process-or-skin'] >= 500 && isset($data['sulphur-present'])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Uniform thinning but can also occur as localized corrosion or high velocity erosion-corrosion.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing', ' NDE- Radiography', ' Real-time Instrument', ' Skin Thermocouple or Infrared Thermographic Scan Monitoring'
                ), 'Prevention' =>
                array('Proper Material Design', 'High Chromium based alloys', ' Clad 300/400 SS', ' Alumunium Diffusion treatment.'
                ));
        $output[] = [
            'output' => 'Sulfidation.  process: Crude,coke,sulphur, fuel gas, feed gas',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 35 Carburization.  process: Coke, ethylene pyrolysis */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 21, 22, 23, 25, 27, 28, 29, 30, 31, 32, 33, 34, 44, 47]) && in_array((int)$data['equipment-type'], [10, 12, 13]) && $data['temperature-max-of-process-or-skin'] >= 1100) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('At advanced stage, cracking or through wall.', '  Loss of ductility and increase in Hardness and ferromagnetism.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing', 'NDE- Radiography', 'NDE- Magnetic Particle testing', ' Hardness Testing.', '  Eddy Current. Metallography.'
                ), 'Prevention' =>
                array('Proper Material Design.', ' IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Carburization.  process: Coke, ethylene pyrolysis',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 36 Decarburization.  process: */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], range(1, 39)) && $data['temperature-max-of-process-or-skin'] >= 1100 && isValueExist($group_main_service, 'hydrogen')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('At advanced stage', ' cracking or through wall', 'Loss of ductility and increase in Hardness and ferromagnetism.'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle testing.', ' Hardness Testing.', ' Metallography.', ' Replication (FMR).'
                ), 'Prevention' =>
                array('Proper Material Design', ' IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Decarburization process',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 37 Metal Dusting.  process: */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 21, 22, 23, 27, 28, 29, 30, 31, 32, 33, 44, 47]) && in_array((int)$data['equipment-type'], [10, 12]) && $data['temperature-max-of-process-or-skin'] >= 900 && $data['temperature-max-of-process-or-skin'] <= 1500 && (isValueExist($group_main_service, 'hydrogen') || isset($data['carbon-present']))) {
        $correctedInputs = isValueExist($group_main_service, 'hydrogen') ? (isset($data['carbon-present']) ? 5 : 4) : (isset($data['carbon-present']) ? 4 : 3);
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Pits filled with a crumbly residue of metal oxides and carbides.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing', ' NDE- Radiography', ' NDE- Visual Testing', ' Metal particles from dusting.'
                ), 'Prevention' =>
                array('Proper Material Design', ' Chemical injection (H2S)  and aluminium diffusion.'
                ));
        $output[] = [
            'output' => 'Metal Dusting process',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 38 Fuel Ash Corrosion.  process: Fired heater, gas turbine with contaminants */
    if (in_array((int)$data['material-type'], [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 20]) && in_array((int)$data['equipment-type'], [1, 4, 6, 10, 11, 12, 13]) && $data['temperature-max-of-process-or-skin'] >= 700 && $data['temperature-max-of-process-or-skin'] <= 1130) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Metal loss associated with slagging.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography.', ' NDE- Visual Testing.'
                ), 'Prevention' =>
                array('Proper Material Design', ' Proper Burner Management maintenance program.', ' Clean feed fuel source.'
                ));
        $output[] = [
            'output' => 'Fuel Ash Corrosion.  process: Fired heater, gas turbine with contaminants',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 39A Nitriding.  process: team methane-reformers, steam gas cracking (olefin plants) and ammonia synthesis plants */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], range(1, 39)) && $data['temperature-max-of-process-or-skin'] >= 600 && $data['temperature-max-of-process-or-skin'] <= 900 && (isValueExist($group_main_service, 'ammonia') || isValueExist($group_main_service, 'nitrides') || isValueExist($group_main_service, 'cyanides'))) {
        $correctedInputs = 3;
        if (isValueExist($group_main_service, 'ammonia'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'nitrides'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'cyanides'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('A change in surface color to a Dull', ' dark gray appearance.', 'Cracking at advnace stages', 'Preferential grain boundary nitriding may lead to microcracking and embrittlement', 'Stainless steels may form brittle layers that may crack and spall from thermal cycling or
applied stress.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography', ' NDE- Visual Testing.', 'NDE- Liquid Penetrant testing'
                ), 'Prevention' =>
                array('Proper Material Design.', ' alloys with 30% to 80% nickel'
                ));
        $output[] = [
            'output' => 'Nitriding.  process: team methane-reformers, steam gas cracking (olefin plants) and ammonia synthesis plants',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 39B Nitriding.  process:*/
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], range(1, 39)) && $data['temperature-max-of-process-or-skin'] >= 900 && (isValueExist($group_main_service, 'ammonia') || isValueExist($group_main_service, 'nitrides') || isValueExist($group_main_service, 'cyanides'))) {
        $correctedInputs = 3;
        if (isValueExist($group_main_service, 'ammonia'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'nitrides'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'cyanides'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('A change in surface color to a Dull', ' dark gray appearance.', 'Cracking at advnace stages', 'Preferential grain boundary nitriding may lead to microcracking and embrittlement', 'Stainless steels may form brittle layers that may crack and spall from thermal cycling or
applied stress.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', ' NDE- Radiography', ' NDE- Visual Testing.', 'NDE- Liquid Penetrant testing'
                ), 'Prevention' =>
                array('Proper Material Design.', ' alloys with 30% to 80% nickel'
                ));
        $output[] = [
            'output' => 'Nitriding process',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 40 Chloride Stress Corrosion Cracking (Cl-SCC). process:*/
    if (in_array((int)$data['material-type'], [26, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 40, 41]) && $data['temperature-max-of-process-or-skin'] >= 140 && isValueExist($group_main_service, 'chlorides') && isValueExist($system_stresses_and_loads, 'tensile-induced-stress')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks can popagate from process side or externally for Corrosion Under insulation'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing.', 'NDE- Liquid Penetrant testing.', 'NDE- Eddy Current'
                ), 'Prevention' =>
                array('Proper Material Design', 'Hydrotest Medium with zero/low chloride content + immediate dry-out.', ' CUI Coating. ', 'Remove residual stresses through Material Stress Relief &/OR PWHT'
                ));
        $output[] = [
            'output' => 'Chloride Stress Corrosion Cracking (Cl-SCC). process:',
            'correctedInputs' => 5,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 5)
            $maximumCorrectedInputs = 5;
        unset($desc);
    }
    /* 41 Corrosion Fatigue . process:*/
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 27, 28, 29,
            30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 28, 38]) && isValueExist($system_stresses_and_loads, 'cyclic-induced-loading')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Transgranular brittle cracks propagation of multiple parallel cracks.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing', 'NDE- Visual Testing.', 'NDE- Magnetic Particle.'
                ), 'Prevention' =>
                array('Proper Material design', 'Material stress-relieving heat treatment (e.g. PWHT)', ' Anti Corrosion Coating.'
                ));
        $output[] = [
            'output' => 'Corrosion Fatigue process',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 42 Caustic Stress Corrosion Cracking (Caustic Embrittlement) . process:*/
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 6, 27, 41]) &&
        isValueExist($group_main_service, 'caustics') && !isValueExist($system_design, 'PWHT-equipment') && $data['temperature-max-of-process-or-skin'] >= 150 && (isValueExist($system_stresses_and_loads, 'tensile-induced-stress') || isValueExist($system_stresses_and_loads, 'compressive-induced-stress') || isValueExist($system_stresses_and_loads, 'cyclic-induced-loading'))) {
        $correctInputs = 5;
        if (isValueExist($system_stresses_and_loads, 'tensile-induced-stress'))
            $correctInputs++;
        if (isValueExist($system_stresses_and_loads, 'compressive-induced-stress'))
            $correctInputs++;
        if (isValueExist($system_stresses_and_loads, 'cyclic-induced-loading'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Weblike cracks propagating parallel to the weld & adjacent base metal.', 'Cracks in the weld deposit or HAZ initiate from local stress raisers.', 'Typically transgranular cracks in SS.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing UT/SWUT.', 'NDE- Visual Testing', 'NDE- Magnetic Particle.', 'NDE- Eddy Current.', 'Acoustic Emmision Testing for crack monitoring.'
                ), 'Prevention' =>
                array('Proper Material design.', 'Material stress-relieving heat treatment (e.g. PWHT).'
                ));
        $output[] = [
            'output' => 'Caustic Stress Corrosion Cracking (Caustic Embrittlement) process',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 43 Ammonia Stress Corrosion Cracking. Process:*/
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 45]) && in_array((int)$data['equipment-type'], [16, 41, 24, 25, 26, 27, 15, 35, 36, 37, 38]) &&
        isValueExist($group_main_service, 'ammonia')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracking can be either transgranular or intergranular depending on the environment and stress level.', 'In base metal, or in/around welds/HAZ for non-PWWT Carbon steel.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Testing UT/SWUT- TOFD', 'NDE- Visual Testing.', 'NDE- Magnetic Particle', 'NDE- Eddy Current.', 'Acoustic Emmision Testing for crack monitoring.'
                ), 'Prevention' =>
                array('Proper Material design (<70 ksi tensile strength).', 'Proper welding + PWHT.', 'Hardness Check for welds <=225 BHN.', 'For CS, Add small quantity of Water  (+0.3% H20 stream).', 'Monitor pH of Ammonia in Water. ', 'Prevent Air / oxygen ingress.'
                ));
        $output[] = [
            'output' => 'Ammonia Stress Corrosion Cracking Process',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 44 Liquid Metal Embrittlement / Cracking (LME/LMC)*/
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 27, 28, 29, 30, 31, 32, 33, 35, 39, 43, 44, 45, 47]) && in_array((int)$data['equipment-type'], [4, 11, 18, 24, 26, 28, 29, 30, 32, 33, 34, 35, 38]) &&
        (isValueExist($system_design, 'molten-zinc-on-equipment') || isValueExist($system_design, 'molten-mercury-on-equipment') || isValueExist($system_design, 'molten-cadmium-on-equipment') || isValueExist($system_design, 'molten-lead-on-equipment') || isValueExist($system_design, 'molten-copper-on-equipment') ||
            isValueExist($system_design, 'tin') || isValueExist($system_design, 'fire-flame-affected-equipment'))) {
        $correctInputs = 2;
        if (isValueExist($system_design, 'molten-zinc-on-equipment'))
            $correctInputs++;
        if (isValueExist($system_design, 'molten-mercury-on-equipment'))
            $correctInputs++;
        if (isValueExist($system_design, 'molten-cadmium-on-equipment'))
            $correctInputs++;
        if (isValueExist($system_design, 'molten-lead-on-equipment'))
            $correctInputs++;
        if (isValueExist($system_design, 'molten-copper-on-equipment'))
            $correctInputs++;
        if (isValueExist($system_design, 'tin'))
            $correctInputs++;
        if (isValueExist($system_design, 'fire-flame-affected-equipment'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Brittle Cracking can be either transgranular or intergranular'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle.', 'NDE- Eddy Current.', 'NDE-Liquid Penetrant testing.', 'Metallography.'
                ), 'Prevention' =>
                array('LME/LMC can only be prevented by protecting metal substrates from coming into contact with the low melting metal.'
                ));
        $output[] = [
            'output' => 'Liquid Metal Embrittlement / Cracking (LME/LMC)',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 45 Hydrogen Embrittlement (HE) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 21, 22, 23, 24, 25, 35, 44, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 18, 24, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 38]) &&
        $data['temperature-max-of-process-or-skin'] > 60 && $data['temperature-max-of-process-or-skin'] <= 300 && (isValueExist($group_main_service, 'hydrogen') || isValueExist($system_design, 'cathodic-protected-equipment'))) {
        $correctInputs = 3;
        if (isValueExist($system_design, 'cathodic-protected-equipment'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'hydrogen'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Sub-surface', 'Surface cracking.'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle.', 'NDE- Eddy Current.', 'NDE-Liquid Penetrant testing.', 'NDE-Ultrasonic examination.'
                ), 'Prevention' =>
                array('Proper material and welding design.', 'Low hydrogen elctrodes. ', 'PWHT- stress Relief'
                ));
        $output[] = [
            'output' => 'Hydrogen Embrittlement (HE)',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 46 Ethanol Stress Corrosion Cracking (SCC) (HE) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], [14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33]) &&
        isValueExist($system_stresses_and_loads, 'tensile-induced-stress') && isValueExist($group_main_service, 'ethanol')) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks that are parallel to the weld or transverse to the weld.'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle', 'NDE-Liquid Penetrant testing', 'NDE-Ultrasonic examination.'
                ), 'Prevention' =>
                array('Proper material and welding design. ', 'PWHT- stress Relief.'
                ));
        $output[] = [
            'output' => 'Ethanol Stress Corrosion Cracking (SCC)',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 47 Sulfate Stress Corrosion Cracking. Process: Cooling Water */
    if (in_array((int)$data['material-type'], [45]) && in_array((int)$data['equipment-type'], [16]) &&
        isValueExist($group_main_service, 'sulfate') && isValueExist($group_main_service, 'water') && $data['years-in-service'] >= 10) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Surface Cracks', 'single or highly branched transgranular.'
                ), 'Inspection Method' =>
                array('NDE- Visual Testing', 'NDE- Eddy Current.', 'NDE-Liquid Penetrant testing.'
                ), 'Prevention' =>
                array('Proper material and welding design.', 'Periodic cleaning.'
                ));
        $output[] = [
            'output' => 'Sulfate Stress Corrosion Cracking. Process: Cooling Water',
            'correctedInputs' => 5,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 5)
            $maximumCorrectedInputs = 5;
        unset($desc);
    }
    /* 48A Moderate Amine Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], [19, 20, 21, 22, 27, 29, 30, 33]) &&
        $data['temperature-max-of-process-or-skin'] < 220 && isValueExist($group_main_service, 'amine') || (isValueExist($group_main_service, 'carbon') || isValueExist($group_main_service, 'h2s')
            || isValueExist($group_main_service, 'other-chemical-contaminants')
        )) {
        $correctInputs = 0;
        if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]))
            $correctInputs++;
        if (in_array((int)$data['equipment-type'], [19, 20, 21, 22, 27, 29, 30, 33]))
            $correctInputs++;
        if ($data['temperature-max-of-process-or-skin'] < 220)
            $correctInputs++;
        if (isValueExist($group_main_service, 'amine'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'carbon'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'other-chemical-contaminants'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or localized wall loss (thinning) corrosion or localized under-deposit attack (Increases with Concentration & Temp)'
                ), 'Inspection Method' =>
                array('NDE- Visual Inspection', 'NDE-UT Inspection.'
                ), 'Prevention' =>
                array('Proper operation of the amine system.', 'Chemical injection of Corrosion inhibitors.', 'Proper Material design; SS (300 series) is highly resistant.'
                ));
        $output[] = [
            'output' => 'Moderate Amine Corrosion',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 48B Severe Amine Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]) && in_array((int)$data['equipment-type'], [19, 20, 21, 22, 27, 29, 30, 33]) &&
        $data['temperature-max-of-process-or-skin'] >= 220 && isValueExist($group_main_service, 'amine') || (isValueExist($group_main_service, 'carbon') || isValueExist($group_main_service, 'h2s')
            || isValueExist($group_main_service, 'other-chemical-contaminants')
        )) {
        $correctInputs = 0;
        if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19]))
            $correctInputs++;
        if (in_array((int)$data['equipment-type'], [19, 20, 21, 22, 27, 29, 30, 33]))
            $correctInputs++;
        if ($data['temperature-max-of-process-or-skin'] >= 220)
            $correctInputs++;
        if (isValueExist($group_main_service, 'amine'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'carbon'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'other-chemical-contaminants'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or localized wall loss (thinning) corrosion or localized under-deposit attack (Increases with Concentration & Temp)'
                ), 'Inspection Method' =>
                array('NDE- Visual Inspection', 'NDE-UT Inspection.'
                ), 'Prevention' =>
                array('Proper operation of the amine system.', 'Chemical injection of Corrosion inhibitors.', 'Proper Material design; SS (300 series) is highly resistant.'
                ));
        $output[] = [
            'output' => 'Severe Amine Corrosion',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 49A Ammonium Bisulfide Corrosion (Alkaline Sour Water) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 21, 22, 23, 24, 26, 27, 28, 29, 30, 31, 32, 33, 43, 44, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] >= 120 && $data['temperature-max-of-process-or-skin'] <= 150 &&
        (isValueExist($group_main_service, 'nh4hs') || isValueExist($group_main_service, 'h2s'))
    ) {
        $correctInputs = 3;
        if (isValueExist($group_main_service, 'nh4hs'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or localized wall loss (thinning) or localized under-deposit corrosion'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection', 'NDE- Radiography', 'NDE- Eddy Current Inspection.', 'IRIS Infrared Inspection scans.'
                ), 'Prevention' =>
                array('Proper Material design', 'Water flushing.'
                ));
        $output[] = [
            'output' => 'Ammonium Bisulfide Corrosion (Alkaline Sour Water)',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 49B Aggressive Ammonium Bisulfide Corrosion (Alkaline Sour Water) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 21, 22, 23, 24, 26, 27, 28, 29, 30, 31, 32, 33, 43, 44, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 150 &&
        (isValueExist($group_main_service, 'nh4hs') || isValueExist($group_main_service, 'h2s')) && isValueExist($group_main_service, 'cyanides')
    ) {
        $correctInputs = 4;
        if (isValueExist($group_main_service, 'nh4hs'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or localized wall loss (thinning) or localized under-deposit corrosion'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection', 'NDE- Radiography', 'NDE- Eddy Current Inspection.', 'IRIS Infrared Inspection scans.'
                ), 'Prevention' =>
                array('Proper Material design', 'Water flushing.'
                ));
        $output[] = [
            'output' => 'Aggressive Ammonium Bisulfide Corrosion (Alkaline Sour Water)',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 50 Ammonium Chloride Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        (isValueExist($group_main_service, 'ammonium-chloride') || isValueExist($group_main_service, 'amine'))
    ) {
        $correctInputs = 2;
        if (isValueExist($group_main_service, 'ammonium-chloride'))
            $correctInputs++;
        if (isValueExist($group_main_service, 'amine'))
            $correctInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or localized corrosion', 'often pitting', 'Damage Increases with Concentration & Temp.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection.', 'Process PH and composition analysis.	'
                ), 'Prevention' =>
                array(' Proper Material design', 'Alloys that are more pitting resistant will have improved resistance to ammonium chloride salts.'
                ));
        $output[] = [
            'output' => 'Ammonium Chloride Corrosion',
            'correctedInputs' => $correctInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
        unset($desc);
        unset($correctInputs);
    }
    /* 51 Hydrochloric Acid (HCl) Corrosion */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'hydrochloric-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or  localized wall loss (thinning) corrosion or localized under-deposit attack', 'Pitting attack and possible cracking (CSCC) of SS (300/400 series)', 'Damage Increases with  
Concentration & Temp.	'
                ), 'Inspection Method' =>
                array('NDE- Radiography inspection', 'Process PH and composition analysis.'
                ), 'Prevention' =>
                array(' Process controls of acid constituents and carryover / excursions.', 'Water flushing.', 'Chemical injection of Corrosion inhibitors.'
                ));
        $output[] = [
            'output' => 'Hydrochloric Acid (HCl) Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 52 High Temp H2/H2S Corrosion  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [17, 18, 19, 20, 21, 22, 27, 28, 29, 30, 31, 32, 33]) &&
        $data['temperature-max-of-process-or-skin'] > 500 && (isValueExist($group_main_service, 'h2s') || isValueExist($group_main_service, 'h2s-containing-hydrocarbons'))
    ) {
        $correctedInputs = 3;
        if (isValueExist($group_main_service, 'h2s-containing-hydrocarbons'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General wall loss (thinning) corrosion.', '(Increases with Concentration & Temp)'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection', 'NDE- Radiography inspection.', 'DE-Visual Inspection'
                ), 'Prevention' =>
                array(' Proper Material design: High chromium content alloy or 300 Series SS.', 'SS-304L,', '316L,', '321 and 347 are highly resistant.'
                ));
        $output[] = [
            'output' => 'High Temp H2/H2S Corrosion ',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 53 Hydrofluoric (HF) Acid Corrosion  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 150 && isValueExist($group_main_service, 'hf-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General or severe Localized thinning. ', ' Significant fouling.', ' Cracking due to hydrogen stress cracking', 'blistering and/or HIC/SOHIC. ', 'Damage Increases with Concentration & Temp.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection', 'NDE- Radiography inspection.'
                ), 'Prevention' =>
                array(' Proper Material design.', ' Minimize water', 'oxygen', 'sulfur and other contaminants in the feed.'
                ));
        $output[] = [
            'output' => 'Hydrofluoric (HF) Acid Corrosion',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 54A Slight-Moderate Naphthenic Acid Corrosion (NAC)	  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 425 && $data['temperature-max-of-process-or-skin'] <= 750 && isValueExist($group_main_service, 'naphthenic-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized corrosion', ' pitting corrosion', 'flow induced grooving. (Increases with Concentration & Temp)	'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection', 'Hydrogen probes.'
                ), 'Prevention' =>
                array(' Proper Materials and feed composition.', 'High Molybdenum alloys.'
                ));
        $output[] = [
            'output' => 'Slight-Moderate Naphthenic Acid Corrosion (NAC)',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 54B Sever Naphthenic Acid Corrosion (NAC)	  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 750 && isValueExist($group_main_service, 'naphthenic-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Localized corrosion', ' pitting corrosion', 'flow induced grooving. (Increases with Concentration & Temp)	'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection', 'Hydrogen probes.'
                ), 'Prevention' =>
                array(' Proper Materials and feed composition.', 'High Molybdenum alloys.'
                ));
        $output[] = [
            'output' => 'Sever Naphthenic Acid Corrosion (NAC)	',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 55A Moderate Phenol (Carbolic Acid) Corrosion	  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 48]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] == 250 && isValueExist($group_main_service, 'phenol')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/localized corrosion', '(Increases with Concentration & Temp)	'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection.', 'ER corrosion probes.'
                ), 'Prevention' =>
                array('Proper Material design.', 'Maintain temperature 30 degrees above the dew point.'
                ));
        $output[] = [
            'output' => 'Moderate Phenol (Carbolic Acid) Corrosion',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 55B Severe Phenol (Carbolic Acid) Corrosion	  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 48]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 450 && isValueExist($group_main_service, 'phenol')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/localized corrosion', '(Increases with Concentration & Temp)	'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection.', 'ER corrosion probes.'
                ), 'Prevention' =>
                array('Proper Material design.', 'Maintain temperature 30 degrees above the dew point.'
                ));
        $output[] = [
            'output' => 'Severe Phenol (Carbolic Acid) Corrosion',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 56 Phosphoric Acid Corrosion	  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 49]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 120 && isValueExist($group_main_service, 'phosphoric-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General or localized thinning of carbon steel.', '(Increases with Concentration & Temp)'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection.', 'ER corrosion probes.'
                ), 'Prevention' =>
                array('Proper Material design.'
                ));
        $output[] = [
            'output' => 'Phosphoric Acid Corrosion',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 57 Sour Water Corrosion (Acidic)		  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 1, 5, 16, 19]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'acidic-sour-water')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and/or  localized wall loss (thinning) corrosion or localized under-deposit attack', 'Pitting attack and possible cracking (CSCC) of SS (300/400 series).', ' (Increases with Concentration &  
Temp)	'
                ), 'Inspection Method' =>
                array(' NDE-Ultrasonic Inspection', 'NDE- Radiography inspection.'
                ), 'Prevention' =>
                array('Proper Material design', 'Minimize water', 'oxygen', 'sulfur and other contaminants in the feed.'
                ));
        $output[] = [
            'output' => 'Sour Water Corrosion (Acidic)	',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 58 Sulfuric Acid Corrosion  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 29, 42]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'sulfuric-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and localized corrosion', 'Grooving in low flow/stagnant fluid areas.', ' HAZ are particularly susceptible.'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection.', 'ER corrosion probes.'
                ), 'Prevention' =>
                array('Chemical injection of Corrosion inhibitors (caustics).', 'Proper Material design (Alloy 20, Alloy 904L and Alloy C-276).', 'Proper operation and IOW (flow rate)'
                ));
        $output[] = [
            'output' => 'Sulfuric Acid Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 59 Aqueous Organic Acid Corrosion  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'organic-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('General and localized corrosion(Thinning).', 'Smooth Groove profile (Increases with Concentration & Temp).'
                ), 'Inspection Method' =>
                array('NDE-Ultrasonic Inspection', 'NDE- Radiography inspection.'
                ), 'Prevention' =>
                array('Chemical injection of Corrosion inhibitors', 'Proper Material design (Corrosion resistant alloys).'
                ));
        $output[] = [
            'output' => 'Aqueous Organic Acid Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /* 60 Polyphonic Acid Stress Corrosion Cracking (PASCC)  */
    if (in_array((int)$data['material-type'], [21, 22, 23, 27, 28, 29, 30, 31, 32, 33]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] >= 750 && $data['temperature-max-of-process-or-skin'] <= 1500 &&
        (isValueExist($group_main_service, 'sulfuric-acid') || isValueExist($group_main_service, 'sulfide')) && (isValueExist($system_stresses_and_loads, 'residual-induced-stress') ||
            isValueExist($system_stresses_and_loads, 'applied-induced-stress'))
    ) {
        $correctedInputs = 3;
        if (isValueExist($group_main_service, 'sulfuric-acid'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'sulfide'))
            $correctedInputs++;
        if (isValueExist($system_stresses_and_loads, 'residual-induced-stress'))
            $correctedInputs++;
        if (isValueExist($system_stresses_and_loads, 'applied-induced-stress'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracking (Intergranular)', 'Usually around the Weld HAZ'
                ), 'Inspection Method' =>
                array('NDE- Liquid Penetrant.'
                ), 'Prevention' =>
                array('Proper Material design', 'PWHT all carbon steel welds'
                ));
        $output[] = [
            'output' => 'Polyphonic Acid Stress Corrosion Cracking (PASCC)',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }
    /* 61 Amine Stress Corrosion Cracking  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        !isValueExist($system_design, 'PWHT-equipment') && isValueExist($group_main_service, 'amine') && isValueExist($group_main_service, 'DEA/MDEA-service/present')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Surface breaking- Cracking. (Usually parallel to Weld and  HAZ)'
                ), 'Inspection Method' =>
                array('NDE- Liquid Penetrant', 'NDE-Ultrasonic Inspection. '
                ), 'Prevention' =>
                array('Proper Material design', 'PWHT all carbon steel welds'
                ));
        $output[] = [
            'output' => 'Amine Stress Corrosion Cracking',
            'correctedInputs' => 5,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 5)
            $maximumCorrectedInputs = 5;
        unset($desc);
    }
    /* 62 Wet H2S Damage (Blistering/HIC/SOHIC/SSC)  */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 300 && isValueExist($group_main_service, 'wet-h2s')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Hydrogen blisters may appear as Bulges on the ID', 'inside the wall thickness  or on the OD surface of the steel', ' HIC', 'SOHIC and SSC are cracks propagating usually around the Weld and weld HAZ and may be layered'
                ), 'Inspection Method' =>
                array('NDE-Visual inspection', 'NDE-Ultrasonic Inspection.', 'NDE- Radiography inspection. ', 'NDE- Eddy Current Inspection. '
                ), 'Prevention' =>
                array('Proper Material and welding design. Preheat', 'PWHT and hardness control using stress relief (Max 200HB )', 'Protective coating' . 'Maintain strict IOWs.'
                ));
        $output[] = [
            'output' => 'Wet H2S Damage (Blistering/HIC/SOHIC/SSC)',
            'correctedInputs' => 4,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /* 63 Hydrogen Stress Cracking - HF */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'hf-acid')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Surface breaking and cracks in any form around welds and HAZ'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle', 'Hardness testing.'
                ), 'Prevention' =>
                array('Proper Material and welding design', 'PWHT and hardness control using stress relief heat treatments procedures.'
                ));
        $output[] = [
            'output' => 'Hydrogen Stress Cracking - HF',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /* 64 Carbonate Stress Corrosion Cracking (ACSCC). */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'aqueous-carbonate')
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Surface breaking and cracks in any form around welds and HAZ'
                ), 'Inspection Method' =>
                array('NDE- Magnetic Particle', 'Hardness testing.'
                ), 'Prevention' =>
                array('Proper Material and welding design', 'Application of a post-fabrication stress-relieving heat treatment', 'Periodic cleaning with water'
                ));
        $output[] = [
            'output' => 'Carbonate Stress Corrosion Cracking (ACSCC)',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }

    /* 65 High Temperature Hydrogen Attack (HTHA) */
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18, 19, 20, 21, 22, 23, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        isValueExist($group_main_service, 'hydrogen') && $data['years-in-service'] > 10 && $data['internal-pressure'] > 700 && $data['temperature-max-of-process-or-skin'] > 550
    ) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('surface  and Internal decarburization of Steel', 'methane formation and result in bubbles/cavities microfissures and fissures that may combine to form cracks.'
                ), 'Inspection Method' =>
                array('Ultrasonic techniques using a combination of velocity ratio.', ' Metallography techniques'
                ), 'Prevention' =>
                array('Proper Material and welding design.', 'Use alloy steels with chromium and molybdenum', 'Maintain strict IOWs.'
                ));
        $output[] = [
            'output' => 'High Temperature Hydrogen Attack (HTHA)',
            'correctedInputs' => 6,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 6)
            $maximumCorrectedInputs = 6;
        unset($desc);
    }

    /* 66 Titanium Hydriding */
    if (in_array((int)$data['material-type'], [39]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) &&
        $data['temperature-max-of-process-or-skin'] > 165 && (isValueExist($group_main_service, 'h2s') && $data['temperature-max-of-process-or-skin'] > 165) ||
        isValueExist($group_main_service, 'amine') || isValueExist($group_main_service, 'acidic-sour-water') || isValueExist($system_design, 'mismatch-adjoining-metals-in-equipment') ||
        (isValueExist($group_main_service, 'hydrogen') && $data['temperature-max-of-process-or-skin'] > 350)
    ) {
        $correctedInputs = 0;
        if (in_array((int)$data['material-type'], [39]))
            $correctedInputs++;
        if (in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]))
            $correctedInputs++;
        if ($data['temperature-max-of-process-or-skin'] > 165)
            $correctedInputs++;
        if (isValueExist($group_main_service, 'h2s'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'amine'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'acidic-sour-water'))
            $correctedInputs++;
        if (isValueExist($system_design, 'mismatch-adjoining-metals-in-equipment'))
            $correctedInputs++;
        if (isValueExist($group_main_service, 'hydrogen'))
            $correctedInputs++;
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Embrittlement of metal which may lead to cracking.'
                ), 'Inspection Method' =>
                array('Metallurgical techniques or mechanical Hardness testing.', ' NDE-Eddy Current.'
                ), 'Prevention' =>
                array('Proper Material and welding design.', 'Use alloy steels with chromium and molybdenum', 'Maintain strict IOWs.'
                ));
        $output[] = [
            'output' => 'Titanium Hydriding',
            'correctedInputs' => $correctedInputs,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < $correctedInputs)
            $maximumCorrectedInputs = $correctedInputs;
        unset($desc);
        unset($correctedInputs);
    }

    $response['outputs'] = $output;
    $response['maximumCorrectedInputs'] = $maximumCorrectedInputs;
    return $response;
}