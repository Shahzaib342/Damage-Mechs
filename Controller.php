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

    /** 1 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], range(1, 9)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 800 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $output[] = [
            'output' => 'Galvanic Corrosion',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Slight - Moderate Graphitization [Mechanical and Metallurgical Failure Mechanism]"
	                   Inspection Methodology - Metallographic techniques.
	                   Damage Appearance / Morphology -Loss in creep strength.  Formation of microfissuring/microvoid formation resulting into subsurface'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 1.1 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], range(1, 9)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] <= 1100 && $data['years-in-service'] >= 5) {
        $output[] = [
            'output' => 'Galvanic Corrosion',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Sever Graphitization [Mechanical and Metallurgical Failure Mechanism]
	                   Inspection Methodology - Metallographic techniques.
	                   Damage Appearance / Morphology -Loss in creep strength.
	                   Formation of  microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking.
	                   Prevention - Proper Material Selection. Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended.
	                    IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
    }
    /** 2 Softening */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Slight - Moderate Softening (Spheroidization) [Mechanical and Metallurgical Failure Mechanism]
	                   Inspection Methodology - "Inspection Methodology - Metallographic techniques
	                   Damage Appearance / Morphology -  Pearlitic phase gradual transformation from partial to complete spheroidization
	                   Prevention - Proper IOW Monitoring. Minimizing long-term exposure to elevated temperatures. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 2.1  Softening */
    if (in_array((int)$data['material-type'], range(1, 19)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1300 && $data['temperature-max-of-process-or-skin'] < 1400) {
        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Slight - Moderate Softening (Spheroidization) [Mechanical and Metallurgical Failure Mechanism]
	                   Inspection Methodology - "Inspection Methodology - Metallographic techniques
	                   Damage Appearance / Morphology -  Pearlitic phase gradual transformation from partial to complete spheroidization
	                   Prevention - Proper IOW Monitoring. Minimizing long-term exposure to elevated temperatures. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 3 Temper Embrittlement */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = [
            'output' => 'Temper Embrittlement',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Temper Embrittlement [Mechanical and Metallurgical Failure Mechanism]
	                   Inspection Methodology - Charpy V-notch Impact test
	                   Damage Appearance / Morphology - Brittle fracture. Intergranular cracking in severe cases.
	                   Shift in the ductile-to-brittle transition temperature with negligible effects on the upper shelf energy.
	                   Prevention - Proper Material Design (PWHT, low level of Arsenics, Manganese, Silicon, Tin, Phosphorus in Metal & Weld electrode.
	                    IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 4 Strain Aging */
    if (in_array((int)$data['material-type'], [1, 2, 6]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 450) {
        $output[] = [
            'output' => 'Strain Aging',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism - Strain Aging
	                   Inspection Methodology - None
	                   Damage Appearance / Morphology - Brittle cracks leading to fracture
	                   Prevention - PWHT repaired welds, Change to newer Steel. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 5 885°F (475°C) Embrittlement */
    if (in_array((int)$data['material-type'], range(25, 34)) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= 600 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $output[] = [
            'output' => '5 885°F (475°C) Embrittlement',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism - 885°F (475°C) Embrittlement
	                   Inspection Method - Impact Testing. Bend Testing
	                   Damage Appearance / Morphology - Loss of toughness and Increased hardness
	                   Prevention - Use low ferrite or non-ferritic alloys. Avoid exposing to embrittling temperature range. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 6 Sigma Phase Embrittlement */
    if (in_array((int)$data['material-type'], range(25, 34)) && in_array((int)$data['equipment-type'], [10, 16, 36]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] < 1750) {
        $output[] = [
            'output' => 'Sigma Phase Embrittlement',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism - Sigma Phase Embrittlement
	                   Inspection Method - Metallographic examination and impact testing
	                   Damage Appearance / Morphology -Cracking, Welds & High Stress areas are more susceptible.
	                   Prevention - Proper Material Selection. Avoid exposing to the embrittling temperature range. PWHT.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 7 Brittle Fracture */
    $materials = range(1, 26);
    $materials = array_merge($materials, [19, 25]);
    if (in_array((int)$data['material-type'], $materials) && ((int)$data['equipment-type'] != 0) && $data['years-in-service'] >= 30) {
        $output[] = [
            'output' => 'Brittle Fracture ',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism - Brittle Fracture
	                   Inspection Method - Impact test.
	                   Damage Appearance / Morphology - Cracks (Straight, non-branching, and no ductility / plastic deformation) 
	                   Prevention -Proper Material Selection and Heat treatment,  Strict IOWs especially during Hydrotest & Startup/Shutdown'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($materials);

    /** 8 Creep & Stress Rupture */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= $creepTemperature[(int)$data['material-type']]) {
        $output[] = [
            'output' => 'Creep & Stress Rupture',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -Creep and Stress Rupture
	                   Inspection Method - NDE-Ultrasonic Testing, NDE-Radiographic Testing, NDE-Eddy Current Testing, NDE-Dimensional measurements,
	                   NDE-Replication, Electron metallography (Early stage / Validate Damage)
	                   Damage Appearance / Morphology - At Creep temperature threshold limits, deformation may be observed as well as Creep cracking.
	                   Creep voids, fissuring and cracks around the grain boundaries at later stages.
	                   Prevention - Proper Material Selection. Avoid exposing to temperature above Creep threshold. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 9 Thermal Fatigue */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && isset($data['thermal-cycle-over-heating'])) {
        $output[] = [
            'output' => 'Thermal Fatigue',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -Thermal Fatigue 
	                   Inspection Method - NDE-Visual Inspections, NDE-Magnetic Particle, NDE-Liquid Penetrant. NDE-Ultrasonic Testing.
	                   Damage Appearance / Morphology -Cracks usually initiate on the surface of the component and propagate transverse to the stress direction.
	                   Prevention -Design and operation to minimize thermal stresses and thermal cycling. IOW Monitoring. '
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 10 Short Term Overheating Stress Rupture */
    $equipmentType = range(1, 13);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['material-type'], $equipmentType) && isset($data['Intermittent'])) {
        $output[] = [
            'output' => 'Short Term Overheating Stress Rupture',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism - Short Term Overheating
	                   Inspection Method -NDE Visual examination, Real-time Instrument- Skin Thermocouple.
	                   Damage Appearance / Morphology -Localized deformation or bulging on the order of 3% to 10% or more and Stress Rupture.
	                   Prevention -Minimize localized temperature excursions. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($equipmentType);

    /** 11 Steam Blanketing */
    $materialType = range(1, 24);
    if (in_array((int)$data['material-type'], $materialType) && in_array((int)$data['equipment-type'], [1, 6, 10, 12, 13]) && isset($data['Intermittent'])) {
        $output[] = [
            'output' => 'Steam Blanketing',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Steam Blanketing
	                   Inspection Method -NDE Visual examination, Real-time Instrument- Skin Thermocouple or Infrared Scan Monitoring
	                   Damage Appearance / Morphology -Open burst with the fracture edges, bulging
                       drawn to a near knife-edge
	                   Prevention -Properly maintained to prevent flame impingement, Proper burner management system maintenance to minimize flame impingement.'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($materialType);

    /** 12 Dissimilar Metal Weld (DMW) Cracking */
    $materialType = range(1, 24);
    if (in_array((int)$data['material-type'], $materialType) && ((int)$data['equipment-type'] != 0) && isset($data['mismatch-ajoining-metals'])) {
        $output[] = [
            'output' => 'Dissimilar Metal Weld (DMW) Cracking',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -Thermal Shock . 
	                   Inspection Method - NDE-Liquid Penetrant. NDE-Magnetic Particle.
	                   Damage Appearance / Morphology -Cracks initiating from the surface and may also appear as craze cracks.
	                   Prevention -Proper Material Design. Proper Structural restraint design. IOW Monitoring to reduce process induced thermal variance'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($materialType);

    /** 13 Thermal Shock */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0)) {
        $output[] = [
            'output' => 'Thermal Shock',
            'correctedInputs' => 2,
            'Desc' => 'Damage Mechanism -Thermal Shock .
	                   Inspection Method - NDE-Liquid Penetrant. NDE-Magnetic Particle.
	                   Damage Appearance / Morphology -Cracks initiating from the surface and may also appear as craze cracks.
	                   Prevention -Proper Material Design. Proper Structural restraint design. IOW Monitoring to reduce process induced thermal variance'
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
    }

    /** 14 Erosion/Erosion Corrosion */
    if (!in_array((int)$data['material-type'], [41]) && ((int)$data['equipment-type'] != 0)) {
        $output[] = [
            'output' => 'Erosion/Erosion Corrosion',
            'correctedInputs' => 2,
            'Desc' => 'Damage Appearance / Morphology -  Localized loss in thickness in the form of pits, grooves, gullies, waves, rounded holes and valleys
	                   Prevention - Proper Material Design, Shape and Geometry of equipment'
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
    }

    /** 15 Cavitation */
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], [38, 39])) {
        $output[] = [
            'output' => 'Cavitation',
            'correctedInputs' => 2,
            'Desc' => 'Damage Mechanism - Cavitation
	                   Inspection Method -NDE-Visual Inspections,  NDE-Ultrasonic Testing. NDE-Radiographic Testing
	                   Damage Appearance / Morphology - Sharp-edged pits or  gouges in rotational components
	                   Prevention - Proper Material Design and Operating Condition'
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
    }

    /** 16 Mechanical Fatigue */
    $equipmentType = array_merge(range(10, 13), range(28, 33), [34, 38, 39]);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], $equipmentType) && ((isset($data['excessive-tensile-stress'])) || (isset($data['excessive-compressive-stress'])))) {
        $correctInputs = isset($data['excessive-tensile-stress']) ? (isset($data['excessive-compressive-stress']) ? 4 : 3) : isset($data['excessive-compressive-stress']) ? (isset($data['excessive-tensile-stress']) ? 4 : 3) : 3;
        $output[] = [
            'output' => 'Mechanical Fatigue ',
            'correctedInputs' => $correctInputs,
            'Desc' => 'Damage Mechanism -Mechanical Fatigue
	                   Inspection Method - NDE-Visual inspections, NDE-Liquid Penetrant. NDE-Magnetic Particle. NDE-Ultrasonic Testing. Vibration monitoring.
	                   Damage Appearance / Morphology -Clam shell type  fingerprint profile (concentric rings) on crack-line around Areas of
                       stress concentration.
	                   Prevention -Proper Material Design. Proper Structural restraint design. IOW Monitoring'
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
    }
    unset($equipmentType);
    unset($correctInputs);

    /** 17 Vibration-Induced Fatigue  */
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], array_merge(range(34, 39), [27])) && (isset($data['high-dynamic-loading']))) {
        $output[] = [
            'output' => 'Vibration-Induced Fatigue ',
            'correctedInputs' => 3,
            'Desc' => 'Damage Mechanism -  Vibration-Induced Fatigue
	                   Inspection Method - NDE-Visual inspections, Vibration monitoring.
	                   Damage Appearance / Morphology -Crack initiating at a point of high stress or discontinuity such as a thread or weld joint
	                   Prevention -Proper Process Design. Proper equipment structural Design and installation and the use of supports and vibration dampening equipment. IOW Monitoring'
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 18 Refractory Degradation */
    if ((int)$data['material-type'] != 0 && in_array((int)$data['equipment-type'], [4, 11, 32]) && isset($data['refractory-lined']) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 5 : 4) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3);
        $output[] = [
            'output' => 'Refractory Degradation ',
            'correctedInputs' => $correctInputs,
            'Desc' => 'Damage Mechanism -  Refractory Degradation
	                   Inspection Method - NDE-Visual inspections, Cold and hot Thermography Scans.
	                   Damage Appearance / Morphology -Excessive cracking, spalling or lift-off from the substrate, softening or general degradation from exposure to moisture, thinning, anchor exposure
	                   Prevention -Proper Material Design: refractory, anchors and fillers and their proper design and installation, IOW Monitoring'
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
    }
    unset($correctInputs);

    /** 19 Reheat Cracking */
    $materialType = array_merge(range(1, 16), range(27, 33));
    $materialType = array_merge($materialType, [9, 44]);
    if (in_array((int)$data['material-type'], $materialType) && in_array((int)$data['equipment-type'], [27]) && $data['temperature-max-of-process-or-skin'] > 750 && $data['thickness'] >= 1) {
        $output[] = [
            'output' => 'Reheat Cracking ',
            'correctedInputs' => 4,
            'Desc' => 'Damage Mechanism -  Reheat Cracking
	                   Inspection Method -NDE-Visual Inspections, NDE-Liquid Penetrant. NDE-Ultrasonic Testing. NDE-Magnetic Particle, NDE-Time of Flight Diffraction TOFD
	                   Damage Appearance / Morphology - Intergranular cracking (Surface breaking or embedded depending on stress and geometry type). Welds /HAZ are particularly susceptible.
	                   Prevention -Proper weld design.  Joint configurations in heavy wall sections should be designed to minimize restraint during welding and PWHT. Proper Welding preheat/interpass heat procedure.'
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
    }
    unset($materialType);

    /** 20 Gaseous Oxygen-Enhanced Ignition and Combustion */
    $materialType = array_merge(range(1, 16), range(27, 33));
    $materialType = array_merge($materialType, [19, 39, 41, 43]);
    if (in_array((int)$data['material-type'], $materialType) && (int)$data['equipment-type'] != 0 && isset($data['25-percent-Oxygen-process']) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 5 : 4) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3);
        $output[] = [
            'output' => 'Gaseous Oxygen-Enhanced Ignition and Combustion',
            'correctedInputs' => $correctInputs,
            'Desc' => 'Damage Mechanism -  Gaseous Oxygen-Enhanced Ignition and Combustion
	                   Inspection Method -NDE-Visual Inspections. Backlights can be used to check for hydrocarbon contamination.
	                   Damage Appearance / Morphology - Internal/ external fire damage. Component burn, such as a valve seat,  without kindling other materials and without any outward sign of fire damage
	                   Prevention -Proper Material Design. IOW Monitoring.'
        ];
        if ($maximumCorrectedInputs < $correctInputs)
            $maximumCorrectedInputs = $correctInputs;
    }
    unset($materialType);
    unset($correctInputs);

    $response['outputs'] = $output;
    $response['maximumCorrectedInputs'] = $maximumCorrectedInputs;
    return $response;
}

