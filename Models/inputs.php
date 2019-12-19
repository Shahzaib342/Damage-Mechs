<?php
include_once 'declarations.php';

//creat a list of inputs that received in post request
if (isset($_POST['token'])) {
    $data = $_POST;
    $group_main_service = explode(",", $data['group_main_service']);
    $system_design = explode(",", $data['system_design']);
    $system_stresses_and_loads = explode(",", $data['system_stresses_and_loads']);
    $inputs = '';

    if ($data['material-type'] != '') {
        $inputs .= '<label>Material Type: </label>';
        $inputs .= '<span>' . $materialTypes[$data['material-type'] - 1] . '</span></br>';
    }
    if ($data['equipment-type'] != '') {
        $inputs .= '<label>Equipment Type: </label>';
        $inputs .= '<span>' . $equipmentTypes[$data['equipment-type'] - 1] . '</span></br>';
    }
    if ($data['years-in-service'] != '') {
        $inputs .= '<label>Years in service: </label>';
        $inputs .= '<span>' . $data['years-in-service'] . '</span></br>';
    }
    if ($data['temperature-max-of-process-or-skin'] != '') {
        $inputs .= '<label>Temperature: </label>';
        $inputs .= '<span>' . $data['temperature-max-of-process-or-skin'] . '°F</span></br>';
    }
    if ($data['thickness'] != '') {
        $inputs .= '<label>Thickness: </label>';
        $inputs .= '<span>' . $data['thickness'] . '</span></br>';
    }
    if ($data['internal-pressure'] != '') {
        $inputs .= '<label>Pressure: </label>';
        $inputs .= '<span>' . $data['internal-pressure'] . '</span>';
    }
    $inputs .= '</br>';
    if (count($group_main_service) > 0 && $group_main_service[0] != '') {
        $inputs .= '<label>Process – Main Service OR Additive(s):  </label>';
        foreach ($group_main_service as $index => $value) {
            if (count($group_main_service) < $index)
                $inputs .= '<span>' . $value . ', </span>';
            else
                $inputs .= '<span>' . $value . '.</span>';
        }
        $inputs .= '</br>';
    }

    if (count($system_design) > 0 && $system_design[0] != '') {
        $inputs .= '<label>System Design:  </label>';
        foreach ($system_design as $index => $value) {
            if (count($system_design) < $index)
                $inputs .= '<span>' . $value . ', </span>';
            else
                $inputs .= '<span>' . $value . '.</span>';
        }
        $inputs .= '</br>';
    }

    if (count($system_stresses_and_loads) > 0 && $system_stresses_and_loads[0] != '') {
        $inputs .= '<label>System Stresses & Loads:  </label>';
        foreach ($system_stresses_and_loads as $index => $value) {
            if (count($system_stresses_and_loads) < $index)
                $inputs .= '<span>' . $value . ', </span>';
            else
                $inputs .= '<span>' . $value . '.</span>';
        }
    }
}