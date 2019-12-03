<?php
//handle the form data and generate outputs on base of required conditions
$response = array();
$response['success'] = false;

if (isset($_POST['token'])) {
    $data = $_POST;
    $response['output'] = processOutput($data);
    $response['toggles'] = getTogglesData($data);
    $response['success'] = true;
    echo json_encode($response);
} else {
    echo 'go away';
}


function processOutput($data)
{
    $output = array();
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9]) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 800 && $data['temperature-max-of-process-or-skin'] < 1000) {
        $output[] = 'Galvanic Corrosion';
    }
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9]) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1000 && $data['temperature-max-of-process-or-skin'] <= 1100 && $data['years-in-service'] >= 5) {
        $output[] = 'Galvanic Corrosion';
    }
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = 'Softening';
    }
    if (in_array((int)$data['material-type'], [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 27, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 1300 && $data['temperature-max-of-process-or-skin'] < 1400) {
        $output[] = 'Softening';
    }
    if (in_array((int)$data['material-type'], [1, 2, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 650 && $data['temperature-max-of-process-or-skin'] <= 1100) {
        $output[] = 'Temper Embrittlement';
    }
    if (in_array((int)$data['material-type'], [1, 2, 6]) && in_array((int)$data['equipment-type'], [11, 12, 13, 16, 17, 18, 32]) && $data['temperature-max-of-process-or-skin'] >= 450) {
        $output[] = 'Strain Aging';
    }

    return $output;
}

function getTogglesData($data)
{

    $toggleCount = 0;
    $toggles = array(
        'Hydrogen Present' => isset($data['hydrogen-present']),
        'Amonia' => isset($data['amonia']),
        'Excessive Compressive Stress' => isset($data['excessive-compressive-stress']),
        'Intermittent' => isset($data['Intermittent']),
        'Chloride present' => isset($data['chloride-present']),
        'Caustics  Present' => isset($data['caustics-present']),
        'Sulphur Present' => isset($data['sulphur-present']),
        'greater than 25 percent Oxygen process' => isset($data['25-percent-Oxygen-process']),
        'Thermal Cycle Over Heating' => isset($data['thermal-cycle-over-heating']),
        'Excessive Tensile Stress' => isset($data['excessive-tensile-stress'])
    );

    foreach ($toggles as $toggle) {
        if ($toggle == true)
            $toggleCount++;
    }

    $toggles['toggleCount'] = $toggleCount;
    return $toggles;
}

?>
