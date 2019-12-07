<?php
//handle the form data and generate outputs on base of required conditions
$response = array();
$response['success'] = false;

if (isset($_POST['token'])) {
    $data = $_POST;
    $response['output'] = processOutput($data);
    $response['success'] = true;
    echo json_encode($response);
} else {
    echo 'go away';
}


function processOutput($data)
{
    //creep temperature in ferhenite
    $creepTemperature = array(650, 650, 700, 700, 700, 750, 750, 800, 800, 800, 800, 800, 825, 825, 800, 800, 800, 850, 825, 900, 1050, 1050, 1050, 1200, null, null, null, 950, 1000, 1000, 1000, 1000, 1000, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
    $output = array();
    $response = array();
    $maximumCorrectedInputs = 0;

    //add all conditions based on which you want to create output

    /** 1 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], range(1, 9)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 800 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss in creep strength', 'Formation of  microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking.'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper Material Selection.', 'Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended.', 'IOW Monitoring.'
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
    /** 1.1 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], range(1, 9)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] <= 1100 && $data['years-in-service'] >= 5) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss in creep strength', 'Formation of  microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking.'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper Material Selection.', 'Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Galvanic Corrosion',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
        unset($desc);
    }
    /** 2 Softening */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Pearlitic phase gradual transformation from partial to complete spheroidization'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper IOW Monitoring.', 'Minimizing long-term exposure to elevated temperatures.', 'IOW Monitoring.'
                ));

        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /** 2.1  Softening */
    if (in_array((int)$data['material-type'], range(1, 19)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1300 && $data['temperature-max-of-process-or-skin'] < 1400) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Pearlitic phase gradual transformation from partial to complete spheroidization'
                ), 'Inspection Method' =>
                array('Metallographic techniques.'
                ), 'Prevention' =>
                array('Proper IOW Monitoring.', 'Minimizing long-term exposure to elevated temperatures.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /** 3 Temper Embrittlement */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Brittle fracture.', 'Intergranular cracking in severe cases.', 'Shift in the ductile-to-brittle transition temperature with negligible effects on the upper shelf energy.'
                ), 'Inspection Method' =>
                array('Charpy V-notch Impact test'
                ), 'Prevention' =>
                array('Proper Material Design (PWHT, low level of Arsenics, Manganese, Silicon, Tin, Phosphorus in Metal & Weld electrode.', 'IOW Monitoring.'
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
    /** 4 Strain Aging */
    if (in_array((int)$data['material-type'], [1, 2, 6]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 450) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss of toughness and Increased hardness'
                ), 'Inspection Method' =>
                array('Impact Testing.', 'Bend Testing'
                ), 'Prevention' =>
                array('Use low ferrite or non-ferritic alloys.', 'Avoid exposing to embrittling temperature range.', 'IOW Monitoring.'
                ));
        $output[] = [
            'output' => 'Strain Aging',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    /** 5 885°F (475°C) Embrittlement */
    if (in_array((int)$data['material-type'], range(25, 34)) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= 600 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Loss of toughness and Increased hardness'
                ), 'Inspection Method' =>
                array('Impact Testing.', 'Bend Testing'
                ), 'Prevention' =>
                array('Use low ferrite or non-ferritic alloys.', 'Avoid exposing to embrittling temperature range.', 'IOW Monitoring.'
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
    if (in_array((int)$data['material-type'], range(25, 34)) && in_array((int)$data['equipment-type'], [10, 16, 36]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] < 1750) {
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
    $materials = range(1, 26);
    $materials = array_merge($materials, [19, 25]);
    if (in_array((int)$data['material-type'], $materials) && ((int)$data['equipment-type'] != 0) && $data['years-in-service'] >= 30) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks (Straight, non-branching, and no ductility / plastic deformation)'
                ), 'Inspection Method' =>
                array('Impact test.'
                ), 'Prevention' =>
                array('Proper Material Selection and Heat treatment,  Strict IOWs especially during Hydrotest & Startup/Shutdown'
                ));
        $output[] = [
            'output' => 'Brittle Fracture ',
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    unset($materials);

    /** 8 Creep & Stress Rupture */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= $creepTemperature[(int)$data['material-type']]) {
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
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && isset($data['thermal-cycle-over-heating'])) {
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
    $equipmentType = range(1, 13);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['material-type'], $equipmentType) && isset($data['Intermittent'])) {
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
            'correctedInputs' => 3,
            'Desc' => $desc
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
        unset($desc);
    }
    unset($equipmentType);

    /** 11 Steam Blanketing */
    $materialType = range(1, 24);
    if (in_array((int)$data['material-type'], $materialType) && in_array((int)$data['equipment-type'], [1, 6, 10, 12, 13]) && isset($data['Intermittent'])) {
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
    unset($materialType);

    /** 12 Dissimilar Metal Weld (DMW) Cracking */
    $materialType = range(1, 24);
    if (in_array((int)$data['material-type'], $materialType) && ((int)$data['equipment-type'] != 0) && isset($data['mismatch-ajoining-metals'])) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks.', ' Usually formed around the toe of the weld in the heat-affected zone'
                ), 'Inspection Method' =>
                array('NDE Visual examination', 'NDE-Liquid Penetrant', 'NDE-Ultrasonic Testing', ' NDE-Radiographic Testing'
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
    unset($materialType);

    /** 13 Thermal Shock */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0)) {
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
    if (!in_array((int)$data['material-type'], [41]) && ((int)$data['equipment-type'] != 0)) {
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
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], [38, 39])) {
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
    $equipmentType = array_merge(range(10, 13), range(28, 33), [34, 38, 39]);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], $equipmentType) && ((isset($data['excessive-tensile-stress'])) || (isset($data['excessive-compressive-stress'])))) {
        $correctInputs = isset($data['excessive-tensile-stress']) ? (isset($data['excessive-compressive-stress']) ? 4 : 3) : isset($data['excessive-compressive-stress']) ? (isset($data['excessive-tensile-stress']) ? 4 : 3) : 3;
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
    }
    unset($equipmentType);
    unset($correctInputs);

    /** 17 Vibration-Induced Fatigue  */
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], array_merge(range(34, 39), [27])) && (isset($data['high-dynamic-loading']))) {
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
    if ((int)$data['material-type'] != 0 && in_array((int)$data['equipment-type'], [4, 11, 32]) && isset($data['refractory-lined']) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 5 : 4) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3);
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
    }
    unset($correctInputs);

    /** 19 Reheat Cracking */
    $materialType = array_merge(range(1, 16), range(27, 33));
    $materialType = array_merge($materialType, [9, 44]);
    if (in_array((int)$data['material-type'], $materialType) && in_array((int)$data['equipment-type'], [27]) && $data['temperature-max-of-process-or-skin'] > 750 && $data['thickness'] >= 1) {
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
    unset($materialType);

    /** 20 Gaseous Oxygen-Enhanced Ignition and Combustion */
    $materialType = array_merge(range(1, 16), range(27, 33));
    $materialType = array_merge($materialType, [19, 39, 41, 43]);
    if (in_array((int)$data['material-type'], $materialType) && (int)$data['equipment-type'] != 0 && isset($data['25-percent-Oxygen-process']) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
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
    unset($materialType);
    unset($correctInputs);

    //if you have more conditions/rule you can add here using the same structure as used above


    //return result
    $response['outputs'] = $output;
    $response['maximumCorrectedInputs'] = $maximumCorrectedInputs;
    return $response;
}

