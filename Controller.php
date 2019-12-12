<?php
//handle the form data and generate outputs on base of required conditions
$response = array();
$response['success'] = false;
//global material type and equipment type arrays
$materialTypes = array(
    'Vintage carbon Steels  (UTS = 414MPa (60 ksi))',
    'Vintage carbon Steels  (UTS >414MPa (60 ksi))',
    'Carbon Steel  Graphitized',
    'Carbon Steel (UTS = 414MPa (60 ksi))',
    'Carbon Steel (UTS > 414MPa (60 ksi))',
    'Carbon Steel Alloy C-1/2Mo',
    'Carbon Steel 1Cr-1/2Mo',
    'Carbon Steel Alloy 1-1/4Cr-1/2Mo Normalized & Tempered',
    'Carbon Steel Alloy 1-1/4Cr-1/2Mo  Annealed',
    'Carbon Steel Alloy 2-1/4Cr-1Mo Normalized & Tempered',
    'Carbon Steel Alloy 2-1/4Cr-1Mo Annealed',
    'Carbon Steel Alloy 2-1/4Cr-1Mo Quenched & Tempered',
    'Carbon Steel Alloy 2-1/4Cr-1Mo V',
    'Carbon Steel Alloy 3Cr-1Mo-V',
    'Carbon Steel Alloy 5Cr-1/2Mo',
    'Carbon Steel Alloy 7Cr-1/2Mo',
    'Carbon Steel Alloy 9Cr-1Mo',
    'Carbon Steel Alloy 9Cr-1Mo V',
    'High-strength low Alloy Steel Cr-Mo-V',
    'Carbon Steel Alloy 12 Cr',
    'Carbon Steel Alloy 800',
    'Carbon Steel Alloy 800H',
    'Carbon Steel Alloy 800HT',
    'Carbon Steel Alloy HK-40',
    '400 Series SS (e.g., 405, 409, 410, 410S, 430 and 446)',
    'Duplex stainless steels such as Alloys 2205, 2304 and 2507',
    '300 Series SS',
    'AISI Type 304 & 304H',
    'AISI Type 316 & 316H',
    'AISI Type 321',
    'AISI Type 321H',
    'AISI Type 347',
    'AISI Type 347H',
    'Cast Stainless Steel',
    'Alloy 400',
    'Lead and Lead based Alloys',
    'Zinc & Zinc based alloys',
    'XXXXXXX',
    'Titanium & Titanium based alloys',
    'Refractory Material',
    'Polymers',
    'Cast Iron',
    'Aluminium & Aluminium based alloy',
    'Nickel & Nickel based Alloys',
    'Copper & Copper based Alloys ((brass, bronze, tin, Alloy 400)',
    'A693 (TP630, TP631)',
    'A286 Stainless Steel'
);
$equipmentTypes = array(
    'Boiler: Convection tubes',
    'Boiler: Downcomers',
    'Boiler: Economizer',
    'Boiler: Firebox',
    'Boiler: Mud Drum',
    'Boiler: Radiant tubes',
    'Boiler: Risers',
    'Boiler: Steam Drums',
    'Boiler: Superheater',
    'Fired heater: Convection tubes',
    'Fired heater: Fire box /Shell',
    'Fired heater: Other tubes',
    'Fired heater: Radiant tube',
    'Air Cooled Heat Exchanger -  Header',
    'Air Cooled Heat Exchanger - Tube',
    'Shell Tube Heat Exchanger: Bundle',
    'Shell Tube Heat Exchanger: Channel',
    'Shell Tube Heat Exchanger: Shell',
    'Columns : Bottom',
    'Columns : Middle',
    'Columns : Top',
    'Columns : Trays',
    'Storage Tanks-Roof',
    'Storage Tanks-Shell',
    'Storage Tanks-Bottom',
    'Storage Tanks Sphere -Shell',
    'Piping / Pipeline',
    'Pressure Vessels- Deaerator- Shell',
    'Pressure Vessels- Accumulator-Shell',
    'Pressure Vessels-Drum-Shell',
    'Pressure Vessels- Filter -Shell',
    'Pressure Vessels- Reactor-Shell',
    'Pressure Vessels- Receiver -Shell',
    'Relief Devices',
    'Weld & HAZ - Shell / Wall',
    'Weld & HAZ -Tube / Tubesheet / Bundle',
    'Weld & HAZ Tray / Baffle',
    'Pumps & Turbines (ROT Equipment)',
    'Valves'
);

if (isset($_POST['token'])) {
    $data = $_POST;
    $response['output'] = processOutput($data, $materialTypes, $equipmentTypes);
    $response['success'] = true;
    echo json_encode($response);
} else {
    echo 'go away';
}


function processOutput($data, $materialTypes, $equipmentTypes)
{
    //creep temperature in ferhenite
    $creepTemperature = array(650, 650, 700, 700, 700, 750, 750, 800, 800, 800, 800, 800, 825, 825, 800, 800, 800, 850, 825, 900, 1050, 1050, 1050, 1200, null, null, null, 950, 1000, 1000, 1000, 1000, 1000, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
    $output = array();
    $response = array();
    $maximumCorrectedInputs = 0;

    //creat input based format to display at the format
    $outputFormat = '';
    if ($data['material-type'] != '')
        $outputFormat .= 'Material Type: ' . $materialTypes[$data['material-type'] - 1];
    if (isset($data['equipment-type']))
        $outputFormat .= ' :: Equipment Type: ' . $equipmentTypes[$data['equipment-type'] - 1];
    if ($data['years-in-service'] != '')
        $outputFormat .= ' :: Years in service: ' . $data['years-in-service'];
    if ($data['temperature-max-of-process-or-skin'] != '')
        $outputFormat .= ' :: Temperature: ' . $data['temperature-max-of-process-or-skin'] . '°F';
    if ($data['thickness'] != '')
        $outputFormat .= ' :: Thickness: ' . $data['thickness'];
    if ($data['internal-pressure'] != '')
        $outputFormat .= ' :: Pressure: ' . $data['internal-pressure'];

    $outputFormat .= ' :: ';

    if (isset($data['high-dynamic-loading']))
        $outputFormat .= 'Equipment Under excessive dynamic loads: ';
    if (isset($data['hydrogen-present']))
        $outputFormat .= 'Process contains Hydrogen: ';
    if (isset($data['amonia']))
        $outputFormat .= 'Process contains Ammonia: ';
    if (isset($data['PWHT']))
        $outputFormat .= 'Equipment Post weld Heat treated: ';
    if (isset($data['Ext-Coating']))
        $outputFormat .= 'Equipment coated with Anti-corrosion/rust: ';
    if (isset($data['insulation-or-fire-proofing']))
        $outputFormat .= 'Equipment Insulated: ';
    if (isset($data['refractory-lined']))
        $outputFormat .= 'Equipment refractory lined: ';
    if (isset($data['excessive-compressive-stress']))
        $outputFormat .= 'Equipment Under excessive compression stress: ';
    if (isset($data['Intermittent']))
        $outputFormat .= 'Equipment experiencing Intermittent overheating: ';
    if (isset($data['chloride-present']))
        $outputFormat .= 'Process contains Chlorides: ';
    if (isset($data['caustics-present']))
        $outputFormat .= ' Process contains Caustics: ';
    if (isset($data['sulphur-present']))
        $outputFormat .= 'Process contains sulfur: ';
    if (isset($data['25-percent-Oxygen-process']))
        $outputFormat .= 'Process is oxygen enriched (&gt;25%): ';
    if (isset($data['thermal-cycle-over-heating']))
        $outputFormat .= 'Equipment under excess Thermal cycle: ';
    if (isset($data['excessive-tensile-stress']))
        $outputFormat .= 'Equipment Under excess Tensile stress: ';
    if (isset($data['mismatch-ajoining-metals']))
        $outputFormat .= ': Equipment contains different connected welded materials';
    if (isset($data['mat-creep-range']))
        $outputFormat .= 'Mat creep range present: ';


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
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 25]) && in_array((int)$data['equipment-type'], [14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 40]) && $data['years-in-service'] >= 30 && ((isset($data['excessive-tensile-stress'])) || (isset($data['excessive-compressive-stress'])) || (isset($data['excessive-residual-stress'])))) {
        $desc = array(
            'Appearance or Morphology of Damage' =>
                array('Cracks (Straight, non-branching, and no ductility / plastic deformation)'
                ), 'Inspection Method' =>
                array('Impact test.'
                ), 'Prevention' =>
                array('Proper Material Selection and Heat treatment', 'Strict IOWs especially during Hydrotest & Startup/Shutdown'
                ));
        $correctInputs = isset($data['excessive-tensile-stress']) ? (isset($data['excessive-compressive-stress']) ? (isset($data['excessive-residual-stress']) ? 6 : 5) : (isset($data['excessive-residual-stress']) ? 5 : 4)) : 4;
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
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 38, 40, 41]) && isset($data['thermal-cycle-over-heating'])) {
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
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 35, 36, 37, 39, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 6, 10, 12, 13]) && isset($data['Intermittent']) && $data['temperature-max-of-process-or-skin'] >= 1000) {
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
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && ((int)$data['equipment-type'] != 0) && isset($data['mismatch-ajoining-metals'])) {
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
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 16, 17, 18, 28, 29, 30, 31, 32, 33, 34]) && isset($data['thermal-cycle-over-heating'])) {
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
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 27, 31, 32, 34, 38, 39]) && ((isset($data['excessive-tensile-stress'])) || (isset($data['excessive-compressive-stress'])))) {
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
        unset($correctInputs);
    }

    /** 17 Vibration-Induced Fatigue  */
    if (!in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 42, 43, 44, 45, 46, 47]) && in_array((int)$data['equipment-type'], [15, 16, 27, 34, 35, 36, 37, 38, 39]) && (isset($data['high-dynamic-loading']))) {
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
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 19, 27, 28, 29, 30, 31, 32, 33, 39, 41, 43]) && in_array((int)$data['equipment-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41]) && isset($data['25-percent-Oxygen-process'])) {
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
    /*  LOGIC 1-66 (1-47 updated)

// (1A) Graphitization
if Equipment Type=  (11,12,13,27,16,17,18,32) AND Material Type= (1,2,3,4,5,6,7) AND 1000>=Temp>=800,
"Damage Mechanism -  Slight - Moderate Graphitization [Mechanical and Metallurgical Failure Mechanism]"
"Inspection Methodology - Metallographic techniques."
"Damage Appearance / Morphology -Loss in creep strength.  Formation of microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking."
"Prevention - Proper Material Selection. Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended. IOW Monitoring."

//(1B) Graphitization
if Equipment Type= (11,12,13,27,16,17,18,32) AND Material Type= (1,2,3,4,5,6,7) AND 1100<=Temp>1000 AND Years in service>=5,
 "Damage Mechanism -  Sever Graphitization [Mechanical and Metallurgical Failure Mechanism]"
"Inspection Methodology - Metallographic techniques."
"Damage Appearance / Morphology -Loss in creep strength.  Formation of  microfissuring/microvoid formation resulting into subsurface cracking or surface connected cracking."
"Prevention - Proper Material Selection. Chromium containing low alloy steels for long-term operation above 800°F (427°C) is recommended. IOW Monitoring."

// (2A) Softening
if Equipment Type= (1,6,10,11,12,13,27,16,18,32) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18) AND 1300>Temp>850,
"Damage Mechanism -  Slight - Moderate Softening (Spheroidization) [Mechanical and Metallurgical Failure Mechanism]"
"Inspection Methodology - "Inspection Methodology - Metallographic techniques"
"Damage Appearance / Morphology -  Pearlitic phase gradual transformation from partial to complete spheroidization"
"Prevention - Proper IOW Monitoring. Minimizing long-term exposure to elevated temperatures. IOW Monitoring."

// (2B) Softening
if Equipment Type= (11,12,13,27,16,17,18,32) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18) AND 1400>=Temp>=1300,
"Damage Mechanism -  Sever Softening (Spheroidization) [Mechanical and Metallurgical Failure Mechanism]"
"Inspection Methodology - "Inspection Methodology - Metallographic techniques"
"Damage Appearance / Morphology -  Pearlitic phase gradual transformation from partial to complete spheroidization"
"Prevention - Proper IOW Monitoring. Minimizing long-term exposure to elevated temperatures. IOW Monitoring."

// (3) Temper Embrittlement
if Equipment Type= (10,11,12,13,16,17,18,32,33) AND Material Type= (1,2,6-14,19) AND  1100>=Temp>650,
"Damage Mechanism -  Temper Embrittlement [Mechanical and Metallurgical Failure Mechanism]"
"Inspection Methodology - Charpy V-notch Impact test
"Damage Appearance / Morphology - Brittle fracture. Intergranular cracking in severe cases. Shift in the ductile-to-brittle transition temperature with negligible effects on the upper shelf energy."
"Prevention - Proper Material Design (PWHT, low level of Arsenics, Manganese, Silicon, Tin, Phosphorus in Metal & Weld electrode. IOW Monitoring."

// (4) Strain Aging
if Equipment Type= (8,9,11,18,24,26, 28,29,30,31,32,33, 35) AND Material Type= (1,2,6) AND  Temp>=450 AND thickness>=1 AND PWHT=false;
"Damage Mechanism - Strain Aging"
"Inspection Methodology - None"
"Damage Appearance / Morphology - Brittle cracks leading to fracture"
"Prevention - PWHT repaired welds, Change to newer Steel. IOW Monitoring."

// (5) 885°F (475°C) Embrittlement
if Equipment Type= (16,22,35,36,37) AND Material Type= (25,26)  AND 1000>Temp>=600,
"Damage Mechanism - 885°F (475°C) Embrittlement"
"Inspection Method - Impact Testing. Bend Testing"
"Damage Appearance / Morphology - Loss of toughness and Increased hardness"
"Prevention - Use low ferrite or non-ferritic alloys. Avoid exposing to embrittling temperature range. IOW Monitoring."

// (6) Sigma Phase Embrittlement
if Equipment Type= (6,10,12,13,16,27,36,39) AND Material Type=  (25,26,27,28,29,30,31,32,33,34) AND 1700>=Temp>=1000
"Damage Mechanism - Sigma Phase Embrittlement "
"Inspection Method - Metallographic examination and impact testing"
"Damage Appearance / Morphology -Cracking, Welds & High Stress areas are more susceptible."
"Prevention - Proper Material Selection. Avoid exposing to the embrittling temperature range. PWHT."

//(7) Brittle Fracture
if Equipment Type= (14,15,16,17,18,19,20,21,22,24,25,26,27,28,29,30,31,32,33,40) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,19,25)  AND Years in service >=30 AND excess residual stress=true;
"Damage Mechanism - Brittle Fracture"
"Inspection Method - Impact test."
"Damage Appearance / Morphology - Cracks (Straight, non-branching, and no ductility / plastic deformation)
"Prevention -Proper Material Selection and Heat treatment,  Strict IOWs especially during Hydrotest & Startup/Shutdown"

//(8) Creep & Stress Rupture
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47)  AND Temp>=Creep Temp {check thee material creep temp if available or ignore},
"Damage Mechanism -Creep and Stress Rupture "
"Inspection Method - NDE-Ultrasonic Testing, NDE-Radiographic Testing, NDE-Eddy Current Testing, NDE-Dimensional measurements, NDE-Replication, Electron metallography (Early stage / Validate Damage)"
"Damage Appearance / Morphology - At Creep temperature threshold limits, deformation may be observed as well as Creep cracking.  Creep voids, fissuring and cracks around the grain boundaries at later stages."
"Prevention - Proper Material Selection. Avoid exposing to temperature above Creep threshold. IOW Monitoring."

// (9) Thermal Fatigue
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47)   AND Thermal Cycle=(True);
"Damage Mechanism -Thermal Fatigue "
"Inspection Method - NDE-Visual Inspections, NDE-Magnetic Particle, NDE-Liquid Penetrant. NDE-Ultrasonic Testing. "
"Damage Appearance / Morphology -Cracks usually initiate on the surface of the component and propagate transverse to the stress direction. "
"Prevention -Design and operation to minimize thermal stresses and thermal cycling. IOW Monitoring. "

// (10) Short Term Overheating– Stress Rupture
if Equipment Type= (1,6,10,12,13) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,39,43,44,45,46,47)  AND Intermittent Overheating=(True) AND temp>=1000
"Damage Mechanism - Short Term Overheating "
"Inspection Method -NDE Visual examination, Real-time Instrument- Skin Thermocouple."
"Damage Appearance / Morphology -Localized deformation or bulging on the order of 3% to 10% or more and Stress Rupture."
"Prevention -Minimize localized temperature excursions. IOW Monitoring."

// (11)  Steam Blanketing
if Equipment Type= (1,6,10,12,13) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,4,15,16,19)  AND Intermittent Overheating=(True);
"Damage Mechanism -  Steam Blanketing"
"Inspection Method -NDE Visual examination, Real-time Instrument- Skin Thermocouple or Infrared Scan Monitoring "
"Damage Appearance / Morphology -Open burst with the fracture edges, bulging drawn to a near knife-edge "
"Prevention -Properly maintained to prevent flame impingement, Proper burner management system maintenance to minimize flame impingement."

// (12) Dissimilar Metal Weld (DMW) Cracking
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,38,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47) AND Mismatch Adjoining  Metals=(True);
"Damage Mechanism -Dissimilar Metal Weld (DMW) Cracking "
"Inspection Method - NDE-Visual Inspections, NDE-Liquid Penetrant. NDE-Ultrasonic Testing. NDE-Radiographic Testing. NDE-PMI "
"Damage Appearance / Morphology - Cracks. Usually formed around the toe of the weld in the heat-affected zone"
"Prevention -Proper Material Design (geometry and correct welding procedure ) "

//(13) Thermal Shock
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,16,17,18, 28,29,30,31,32,33,34)  AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,35,36,37,39,42,43,44,45,46,47) AND temp>=1000 AND thermal cycle=true;
"Damage Mechanism -Thermal Shock ."
"Inspection Method - NDE-Liquid Penetrant. NDE-Magnetic Particle."
"Damage Appearance / Morphology -Cracks initiating from the surface and may also appear as “craze” cracks."
"Prevention -Proper Material Design. Proper Structural restraint design. IOW Monitoring to reduce process induced thermal variance"

//(14) Erosion/Erosion – Corrosion
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,42,43,44,45,46,47);
"Damage Mechanism - Erosion/Erosion – Corrosion"
"Inspection Method -NDE-Visual Inspections,  NDE-Ultrasonic Testing. NDE-Radiographic Testing,  Infrared Scan Monitoring for Refractory thickness monitoring"
"Damage Appearance / Morphology -  Localized loss in thickness in the form of pits, grooves, gullies, waves, rounded holes and valleys"
"Prevention - Proper Material Design, Shape and Geometry of equipment"

//(15) Cavitation
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47);
"Damage Mechanism - Cavitation"
"Inspection Method -NDE-Visual Inspections,  NDE-Ultrasonic Testing. NDE-Radiographic Testing "
"Damage Appearance / Morphology - Sharp-edged pits or  gouges in rotational components"
"Prevention - Proper Material Design and Operating Condition"

//(16) Mechanical Fatigue
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,27,31,32,34,38,39) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47) AND ( Excessive Tensile stress =TRUE or Excessive Compressive Stress=True);
"Damage Mechanism -Mechanical Fatigue"
"Inspection Method - NDE-Visual inspections, NDE-Liquid Penetrant. NDE-Magnetic Particle. NDE-Ultrasonic Testing. Vibration monitoring. "
"Damage Appearance / Morphology -Clam shell” type  fingerprint profile (concentric rings) on crack-line around Areas of stress concentration. "
"Prevention -Proper Material Design. Proper Structural restraint design. IOW Monitoring"

// (17) Vibration-Induced Fatigue
if Equipment Type= (15,16,27,34,35,36,37,38,39) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47) AND  High Dynamic loading=True;
"Damage Mechanism -  Vibration-Induced Fatigue "
"Inspection Method - NDE-Visual inspections, Vibration monitoring. "
"Damage Appearance / Morphology -Crack initiating at a point of high stress or discontinuity such as a thread or weld joint "
"Prevention -Proper Process Design. Proper equipment structural Design and installation and the use of supports and vibration dampening equipment. IOW Monitoring"

//(18) Refractory Degradation
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND (Material Type=  (40) OR Refractory lined=True)  AND (temp >=1200  OR Sulphur Present=True);
"Damage Mechanism -  Refractory Degradation "
"Inspection Method - NDE-Visual inspections, Cold and hot IR Thermography Scans."
"Damage Appearance / Morphology -Excessive cracking, spalling or lift-off from the substrate, softening or general degradation from exposure to moisture, thinning, anchor exposure "
"Prevention -Proper Material Design: refractory, anchors and fillers and their proper design and installation, IOW Monitoring"

//(19) Reheat Cracking
if Equipment Type= (27,28,29,30,31,32,33) AND Material Type=  (6,7,8,9,10,11,12,13,14,15,16,19,21,22,23,24,27,28,29,30,31,32,33,44,47 )  AND temp > 750 AND thickness>=1 );
"Damage Mechanism -  Reheat Cracking  "
"Inspection Method -NDE-Visual Inspections, NDE-Liquid Penetrant. NDE-Ultrasonic Testing. NDE-Magnetic Particle, NDE-Time of Flight Diffraction TOFD"
"Damage Appearance / Morphology - Intergranular cracking (Surface breaking or embedded depending on stress and geometry type). Welds /HAZ are particularly susceptible."
"Prevention -Proper weld design.  Joint configurations in heavy wall sections should be designed to minimize restraint during welding and PWHT. Proper Welding preheat/interpass heat procedure."

//(20) Gaseous Oxygen-Enhanced Ignition and Combustion
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33,39,41,43 ) AND >25% oxygen present=True ;
"Damage Mechanism -  Gaseous Oxygen-Enhanced Ignition and Combustion"
"Inspection Method -NDE-Visual Inspections. Backlights can be used to check for hydrocarbon contamination."
"Damage Appearance / Morphology - Internal/ external fire damage. Component burn, such as a valve seat,  without kindling other materials and without any outward sign of fire damage"
"Prevention -Proper Material Design. IOW Monitoring."

//(21) Galvanic Corrosion
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33,39,42,43) AND -Mismatch Ajoining  Metals=true ;
"Damage Mechanism -  Galvanic Corrosion"
"Inspection Method -NDE-Visual Inspections. NDE-Ultrasonic Testing. "
"Damage Appearance / Morphology - Generalized wall loss in thickness or crevice, groove or pitting corrosion."
"Prevention -Proper Material Design and Coating / electric insulating Devices."

//(22) Atmospheric Corrosion
if Equipment Type= (14,18,19,20,21,23,24,25,26,27,28,29,30,31,32,33,34,39) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,43,45) AND Ext Coating=False AND Temperature<250;
"Damage Mechanism -  Atmospheric Corrosion"
"Inspection Method -NDE-Visual Inspections. NDE-Ultrasonic Testing. "
"Damage Appearance / Morphology - General or localized wall loss, depending upon whether or not the moisture is trapped."
"Prevention -Proper Material Design. Anti corrosion / rust Coating."

//(23) Corrosion Under Insulation
if Equipment Type= (14,18,19,20,21,23,24,25,26,27,28,29,30,31,32,33,34,39) AND Insulation=True  AND { (Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19) AND ( 10 <= temperature<= 350) ) OR (Material Type=  (26-33,42) AND ( 140 <= temperature<= 400)) }
"Damage Mechanism -  Corrosion Under Insulation"
"Inspection Method -NDE-Visual Inspections (Strip Insulation). NDE-Ultrasonic Testing (Guided wave UT).  NDE Real-time Profile x-ray (for small bore piping). NDE-Neutron backscatter techniques for identifying wet insulation. Deep penetrating eddy-current inspection.  IR thermography looking for wet insulation and/or damaged and missing insulation under
the jacket. "
"Damage Appearance / Morphology - Localized pitting corrosion and/or wall loss in CS. Stress Corrosion Cracks in SS"
"Prevention -Proper Material Design. Anti corrosion / rust Coating. Maintaining the insulation/sealing/vapor barriers to prevent moisture ingress."

// (24) Cooling Water Corrosion
if Equipment Type= (16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,40) AND Material Type= (1-5,25-33,39,43,44,45,47) AND Water_service=true;
"Damage Mechanism -  Cooling Water Corrosion "
"Inspection Method -NDE-Visual Inspections. NDE-Ultrasonic Testing (Phased array). NDE- Radiography. NDE-Eddy-current inspection."
"Damage Appearance / Morphology - Generalized / Localized wall loss in thickness or crevice, groove or pitting corrosion. Stress corrosion cracking and fouling "
"Prevention -Proper Material Design. Operation and chemical treatment of cooling water systems; Monitoring of process  parameters that affect corrosion and fouling such as the pH, oxygen content, cycles of concentration, biocide residual, biological activity, cooling water outlet temperatures, hydrocarbon contamination and process leaks. "

//(25) Boiler Water Condensate Corrosion
if Equipment Type= (2,3,5,16,17,27,28,39) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33,45) AND Water_service=true;
"Damage Mechanism -  Boiler Water Condensate Corrosion  "
"Inspection Method -NDE-Visual Inspections. NDE-Magnetic Particle."
"Damage Appearance / Morphology - Cracks, Localized Pitting corrosion."
"Prevention -Proper Material Design. Oxygen scavenging treatments typically include catalyzed sodium sulfite or hydrazine depending on the system pressure level along with proper mechanical deaerator operation. Amine treatment to eliminate CO2 in condensate return systems. "

// (26) CO2 Corrosion
if Equipment Type= (2,3,5,16,20,21,22,27,28,39) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19) AND Co2 present=True AND Temperature<=300 AND Water_service=true;
"Damage Mechanism -  CO2 Corrosion "
"Inspection Method -NDE-Visual Inspections. NDE-Ultrasonic Testing . NDE- Radiography."
"Damage Appearance / Morphology -Localized thinning and/or pitting corrosion "
"Prevention -Proper Material Design SS. Corrosion inhibitors to the condensate systems. Vapor phase inhibitors may be required to protect against condensing vapors. Increasing condensate pH above 6."

//(27) Flue-Gas Dew-Point Corrosion
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,28,29,30,31,32,33) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33) AND { (Sulphur present=True AND Temperature<=280) OR (Chloride Present=True AND Temperature<=130) };
Damage Mechanism - Flue-Gas Dew-Point Corrosion.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography, NDE-Liquid Penetrant. NDE-Visual Inspections.
Damage Appearance / Morphology -Localized thinning and/or pitting corrosion in CS. Surface breaking cracks with crazed surface appearance in SS.
Prevention -Proper Material Design. Maintain the metallic surfaces temperature of the equipment backend above the sulfuric acid dewpoint corrosion temperature.

// (28) Microbiologically Induced Corrosion (MIC)
if Equipment Type= (16,17,18,23,24,25,26,27,28,29,30,31,32,33,34,38,39,40) AND Material Type=(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,25,27,28,29,30,31,32,33, 43,45,44,47) ;
Damage Mechanism -  Microbiologically Induced Corrosion (MIC).
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE-Visual Inspections.
Damage Appearance / Morphology -Localized pitting under deposits or tubercles shielding the organism.
Prevention -Proper Material Design. Process Water treatment, high enough flow. Anti corrosion coating. Monitoring of process  parameters that affect MIC such as cycles of concentration, biocide residual, biological activity, cooling water outlet temperatures, hydrocarbon contamination.

// (29) Soil Corrosion
if Equipment Type= (23,24,25,26,27) AND Material Type=  (1,2,3,4,5,38,42) AND Buried/Soil-Air/Cemented=True ;
Damage Mechanism -  Soil Corrosion.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE-Visual Inspections, Soil potential and resistivity.
Damage Appearance / Morphology -External thinning with localized losses due to pitting.
Prevention -Proper Material Design. Use of special backfill, Cathodic protection. Anti corrosion coating.

// (30) Caustic Corrosion
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,16,17,18,27,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33) AND Caustics Present=True;
Damage Mechanism -   Caustic Corrosion.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE-Visual Inspections.
Damage Appearance / Morphology -Localized metal loss which may appear as grooves or locally thinned areas.
Prevention -Proper Material Design. Reduce the amount of free caustic and Alkaline producing salts  in the system. Cleaning and maintenance of Burner Management System.

// (31)  Dealloying. process:Cooling water application,  boiler feed water
if Equipment Type= (16,27,38,39) AND Material Type=  (45,35,42).
Damage Mechanism -   Dealloying.
Inspection Method - NDE-Visual Inspections. Metallographic examination.
Damage Appearance / Morphology -Significant color change or a deep etched (corroded) appearance.
Prevention -Proper Material Design. Add balancing alloy for resistance.

// (32)  Graphitic Corrosion. process:Dilute acids, mine water,salt water, soft water, Fire Water. Boiler feed water
if Equipment Type= (27,) AND Material Type=  (42) AND temp<200 and (water-service=true OR acid-service=true);
Damage Mechanism -   Graphitic Corrosion.
Inspection Method - NDE-Acoustic techniques.
Damage Appearance / Morphology -Local or general wall loss and affected areas soft and easily gouged mechanically using hand tool.
Prevention -Proper Material Design. Internal and External coatings and/or cement linings. Cathodic protection. White Iron is not Susceptible.

// (33)  Oxidation.  process: ANY
if Equipment Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,27,28,29,30,31,32,33) AND Material Type (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,27,28,29,30,31,32,33,38,42,44,47 ) AND Temperature>=1000;
Damage Mechanism -   Oxidation.
Inspection Method - Real-time Instrument- Skin Thermocouple or Infrared Thermographic Scan Monitoring.
Damage Appearance / Morphology -General wall loss-  thinning.
Prevention -Proper Material Design. IOW Monitoring.

// (34)  Sulfidation.  process: Crude,coke,sulphur, fuel gas, feed gas
if Equipment Type= (1-13,16-18,27-33) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,27,28,29,30,31,32,33,38,42,44,45,47) AND Temperature>=500 AND Sulphur Present=TRUE;
Damage Mechanism -   Sulfidation.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. Real-time Instrument- Skin Thermocouple or Infrared Thermographic Scan Monitoring
Damage Appearance / Morphology -Uniform thinning but can also occur as localized corrosion or high velocity erosion-corrosion.
Prevention -Proper Material Design; High Chromium based alloys, Clad 300/400 SS, Alumunium Diffusion treatment.

// (35)  Carburization.  process: Coke, ethylene pyrolysis
if Equipment Type= (10,12,13) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,21,22,23,25,27,28,29,30,31,32,33,34,44,47) AND Temperature>=1100;
Damage Mechanism -   Carburization.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE- Magnetic Particle testing. Hardness Testing.  Eddy Current. Metallography.
Damage Appearance / Morphology -At advanced stage, cracking or through wall.  Loss of ductility and increase in Hardness and ferromagnetism.
Prevention -Proper Material Design. IOW Monitoring.

//(36)  Decarburization.  process:
if Equipment Type= (ANY) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19) AND Temperature>=1100 AND hydrogen present:Yes;
Damage Mechanism -   Decarburization.
Inspection Method - NDE- Magnetic Particle testing. Hardness Testing. Metallography. Replication (FMR).
Damage Appearance / Morphology -At advanced stage, cracking or through wall.  Loss of ductility and increase in Hardness and ferromagnetism.
Prevention -Proper Material Design. IOW Monitoring.

//(37)  Metal Dusting.  process:
if Equipment Type= (10,12) AND Material Type= (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,21,22,23,27,28,29,30,31,32,33,44,47) AND 900<=Temperature<=1500 AND (hydrogen present:Yes OR carbon present:yes)
Damage Mechanism -  Metal Dusting.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE- Visual Testing. Metal particles from dusting.
Damage Appearance / Morphology -Pits filled with a crumbly residue of metal oxides and carbides.
Prevention -Proper Material Design. Chemical injection (H2S)  and aluminium diffusion.

// (38)  Fuel Ash Corrosion.  process: Fired heater, gas turbine with contaminants
if Equipment Type= (1,4,6,10,11,12,13) AND Material Type=  (6,7,8,9,10,11,12,13,14,15,16,19,20) AND 700<=Temperature<=1130;
Damage Mechanism -  Fuel Ash Corrosion.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE- Visual Testing.
Damage Appearance / Morphology -Metal loss associated with slagging.
Prevention -Proper Material Design. Proper Burner Management maintenance program. Clean feed fuel source.

//(39A)  Nitriding.  process: team methane-reformers, steam gas cracking (olefin plants) and ammonia synthesis plants.
if Equipment Type= (ANY) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,25,27,28,29,30,31,32,33)  AND 600<=Temperature<900 AND (Nitrides Present=TRUE OR ammonia present=true OR cyanide=true);
Damage Mechanism -  Moderate Nitriding
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE- Visual Testing. NDE- Liquid Penetrant testing
Damage Appearance / Morphology -A change in surface color to a Dull, dark gray appearance.  Cracking at advnace stages. Preferential grain boundary nitriding may lead to microcracking and embrittlement. Stainless steels may form brittle layers that may crack and spall from thermal cycling or
applied stress.
Prevention -Proper Material Design. alloys with 30% to 80% nickel.

// (39B)  Nitriding.  process:
if Equipment Type= (ANY) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,25,27,28,29,30,31,32,33) AND Temperature>=900 AND (Nitrides Present=TRUE OR ammonia present=true OR cyanide=true);
Damage Mechanism -  Severe Nitriding.
Inspection Method - NDE-Ultrasonic Testing. NDE- Radiography. NDE- Visual Testing. NDE- Liquid Penetrant testing.
Damage Appearance / Morphology -A change in surface color to a Dull, dark gray appearance.  Cracking at advnace stages. Preferential grain boundary nitriding may lead to microcracking and embrittlement.  Stainless steels may form brittle layers that may crack and spall from thermal cycling or
applied stress.
Prevention -Proper Material Design. alloys with 30% to 80% nickel "

// (40)  Chloride Stress Corrosion Cracking (Cl-SCC). process:
if Equipment Type= (13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,40,41) AND Material Type=  (26,27,28,29,30,31,32,33)  AND chlorides present=True AND temp>=140 AND excess tensile stress=true;
Damage Mechanism -  Chloride Stress Corrosion Cracking (Cl-SCC)
Inspection Method - NDE-Ultrasonic Testing.  NDE- Liquid Penetrant testing. NDE- Eddy Current
Damage Appearance / Morphology -Cracks can popagate from process side or externally for Corrosion Under insulation
Prevention -Proper Material Design. Hydrotest Medium with zero/low chloride content + immediate dry-out. CUI Coating. Remove residual stresses through Material Stress Relief &/OR PWHT

// (41)   Corrosion Fatigue . process:
if Equipment Type= (1,2,3,4,5,6,7,8,9,28,38) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,27,28,29,30,31,32,33,34,35,36,37,38,39,42,43,44,45,46,47) AND Cyclic loading=True;
Damage Mechanism -   Corrosion Fatigue.
Inspection Method - NDE-Ultrasonic Testing.  NDE- Visual Testing. NDE- Magnetic Particle.
Damage Appearance / Morphology -Transgranular brittle cracks propagation of multiple parallel cracks.
Prevention -Proper Material design. Material stress-relieving heat treatment (e.g. PWHT).  Anti Corrosion Coating.

// (42)  Caustic Stress Corrosion Cracking (Caustic Embrittlement) . process:
if Equipment Type= (1,6,27,41) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,27,28,29,30,31,32,33) AND Caustic Present=True,  AND PWHT=False AND Temperature>=150 AND (Excessive Tensile stress=True OR Excessive Compressive Stress=True OR  Cyclic loading=True);
Damage Mechanism -   Caustic Stress Corrosion Cracking (Caustic Embrittlement).
Inspection Method - NDE-Ultrasonic Testing UT/SWUT.  NDE- Visual Testing. NDE- Magnetic Particle. NDE- Eddy Current. Acoustic Emmision Testing for crack monitoring.
Damage Appearance / Morphology -Weblike cracks propagating parallel to the weld & adjacent base metal. Cracks in the weld deposit or HAZ initiate from local stress raisers. Typically transgranular cracks in SS.
Prevention -Proper Material design. Material stress-relieving heat treatment (e.g. PWHT).

// (43)  Ammonia Stress Corrosion Cracking. Process:
if Equipment Type= (16,41,24,25,26,27,15,35,36,37,38) AND Material Type=  (1,2,3,4,5,45) AND Ammonia Present=True;
Damage Mechanism -   Ammonia Stress Corrosion Cracking .
Inspection Method - NDE-Ultrasonic Testing UT/SWUT- TOFD.  NDE- Visual Testing. NDE- Magnetic Particle. NDE- Eddy Current. Acoustic Emmision Testing for crack monitoring.
Damage Appearance / Morphology -Cracking can be either transgranular or intergranular depending on the environment and stress level. In base metal, or in/around welds/HAZ for non-PWWT Carbon steel.
Prevention -Proper Material design (<70 ksi tensile strength). Proper welding + PWHT. Hardness Check for welds <=225 BHN. For CS, Add small quantity of Water  (+0.3% H20 stream). Monitor pH of Ammonia in Water. Prevent Air / oxygen ingress.

//(44)   Liquid Metal Embrittlement / Cracking (LME/LMC)
if Equipment Type= (4,11,18,24,26,28,29,30,32,33,34,35,38) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,27,28,29,30,31,32,33,35,39,43,44,45,47) AND  (Molten zinc=true, OR Molten mercury=true, OR  Molten cadmium=true, OR  Molten lead=true, OR molten copper=true, OR tin=true OR fire/flame present=true) ;
Damage Mechanism -   Liquid Metal Embrittlement (LME/LMC).
Inspection Method -  NDE- Magnetic Particle. NDE- Eddy Current.  NDE-Liquid Penetrant testing. Metallography.
Damage Appearance / Morphology -Brittle Cracking can be either transgranular or intergranular
Prevention -LME/LMC can only be prevented by protecting metal substrates from coming into contact with the low melting metal.

// (45)    Hydrogen Embrittlement (HE)
if Equipment Type= (1,2,3,4,5,6,7,8,9,11,18,24,26,27,28,29,30,31,32,33,35,36,37,38) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19,21,22,23,24,25,35,44,47) AND 60<Temp<=300 AND (Hydrogen present=True OR cathodic protection=true);
Damage Mechanism -    Hydrogen Embrittlement (HE).
Inspection Method -  NDE- Magnetic Particle. NDE- Eddy Current.  NDE-Liquid Penetrant testing. NDE-Ultrasonic examination.
Damage Appearance / Morphology -Sub-surface, or Surface cracking.
Prevention -Proper material and welding design. Low hydrogen elctrodes. PWHT- stress Relief

// (46)   Ethanol Stress Corrosion Cracking (SCC)
if Equipment Type= (14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33) AND Material Type=  (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,19); tensile stress excesssive=true AND ethanol present=True;
 Inspection Method -  NDE- Magnetic Particle. NDE-Liquid Penetrant testing. NDE-Ultrasonic examination.
 Damage Appearance / Morphology -Cracks that are parallel to the weld or transverse to the weld.
 Prevention -Proper material and welding design. PWHT- stress Relief.

//(47)   Sulfate Stress Corrosion Cracking. Process: Cooling Water
if Equipment Type= (16) AND Material Type=  (45)  AND AND sulfate present=True and Years in service>=10  AND water-service=true;
Damage Mechanism -  Sulfate Stress Corrosion Cracking
Inspection Method -  NDE- Visual Testing. NDE- Eddy Current. NDE-Liquid Penetrant testing.
Damage Appearance / Morphology -Surface Cracks. single or highly branched transgranular.
Prevention -Proper material and welding design. Periodic cleaning.

END OF ADDITIONAL LOGIC*/

    $response['outputs'] = $output;
    $response['outputFomat'] = $outputFormat;
    $response['maximumCorrectedInputs'] = $maximumCorrectedInputs;
    return $response;
}