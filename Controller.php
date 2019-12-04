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
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 1.1 Galvanic Corrosion */
    if (in_array((int)$data['material-type'], range(1, 9)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] <= 1100 && $data['years-in-service'] >= 5) {
        $output[] = [
            'output' => 'Galvanic Corrosion',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 4)
            $maximumCorrectedInputs = 4;
    }
    /** 2 Softening */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 2.1  Softening */
    if (in_array((int)$data['material-type'], range(1, 19)) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1300 && $data['temperature-max-of-process-or-skin'] < 1400) {
        $output[] = [
            'output' => 'Softening',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 3 Temper Embrittlement */
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = [
            'output' => 'Temper Embrittlement',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 4 Strain Aging */
    if (in_array((int)$data['material-type'], [1, 2, 6]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 450) {
        $output[] = [
            'output' => 'Strain Aging',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 5 885°F (475°C) Embrittlement */
    if (in_array((int)$data['material-type'], range(25, 34)) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= 600 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $output[] = [
            'output' => '5 885°F (475°C) Embrittlement',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 6 Sigma Phase Embrittlement */
    if (in_array((int)$data['material-type'], range(25, 34)) && in_array((int)$data['equipment-type'], [10, 16, 36]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] < 1750) {
        $output[] = [
            'output' => 'Sigma Phase Embrittlement',
            'correctedInputs' => 3
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
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($materials);

    /** 8 Creep & Stress Rupture */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && $data['temperature-max-of-process-or-skin'] >= $creepTemperature[(int)$data['material-type']]) {
        $output[] = [
            'output' => 'Creep & Stress Rupture',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    /** 9 Thermal Fatigue */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0) && isset($data['thermal-cycle-over-heating'])) {
        $output[] = [
            'output' => 'Thermal Fatigue',
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 10 Short Term Overheating Stress Rupture */
    $equipmentType = range(1, 13);
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['material-type'], $equipmentType) && isset($data['Intermittent'])) {
        $output[] = [
            'output' => 'Short Term Overheating Stress Rupture',
            'correctedInputs' => 3
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
            'correctedInputs' => 3
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
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }
    unset($materialType);

    /** 13 Thermal Shock */
    if (!in_array((int)$data['material-type'], [40, 41]) && ((int)$data['equipment-type'] != 0)) {
        $output[] = [
            'output' => 'Thermal Shock',
            'correctedInputs' => 2
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
    }

    /** 14 Erosion/Erosion Corrosion */
    if (!in_array((int)$data['material-type'], [41]) && ((int)$data['equipment-type'] != 0)) {
        $output[] = [
            'output' => 'Erosion/Erosion Corrosion',
            'correctedInputs' => 2
        ];
        if ($maximumCorrectedInputs < 2)
            $maximumCorrectedInputs = 2;
    }

    /** 15 Cavitation */
    if (!in_array((int)$data['material-type'], [40, 41]) && in_array((int)$data['equipment-type'], [38, 39])) {
        $output[] = [
            'output' => 'Cavitation',
            'correctedInputs' => 2
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
            'correctedInputs' => $correctInputs
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
            'correctedInputs' => 3
        ];
        if ($maximumCorrectedInputs < 3)
            $maximumCorrectedInputs = 3;
    }

    /** 18 Refractory Degradation */
    if ((int)$data['material-type'] != 0 && in_array((int)$data['equipment-type'], [4, 11, 32]) && isset($data['refractory-lined']) && ((isset($data['sulphur-present'])) || $data['temperature-max-of-process-or-skin'] >= 1200)) {
        $correctInputs = isset($data['sulphur-present']) ? ($data['temperature-max-of-process-or-skin'] >= 1200 ? 5 : 4) : ($data['temperature-max-of-process-or-skin'] >= 1200 ? 4 : 3);
        $output[] = [
            'output' => 'Refractory Degradation ',
            'correctedInputs' => $correctInputs
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
            'correctedInputs' => 4
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
            'correctedInputs' => $correctInputs
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

