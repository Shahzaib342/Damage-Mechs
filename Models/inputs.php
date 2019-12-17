<?php
include_once 'declarations.php';

//creat a list of inputs that received in post request
if (isset($_POST['token'])) {
    $data = $_POST;
    $group_main_service = explode(",", $data['group_main_service']);
    $system_design = explode(",", $data['system_design']);
    $system_stresses_and_loads = explode(",", $data['system_stresses_and_loads']);
    $inputs = '<span class="title">Inputs</span>';

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

    if (count($group_main_service) > 0) {
        $inputs .= '</br><label>Process – Main Service OR Additive(s):  </label>';
        foreach ($group_main_service as $value) {
            $inputs .= '<span>' . $value . ', </span>';
        }
    }

    if (count($system_design) > 0) {
        $inputs .= '</br><label>System Design:  </label>';
        foreach ($system_design as $value) {
            $inputs .= '<span>' . $value . ', </span>';
        }
    }

    if (count($system_stresses_and_loads) > 0) {
        $inputs .= '</br><label>System Stresses & Loads:  </label>';
        foreach ($system_stresses_and_loads as $value) {
            $inputs .= '<span>' . $value . ', </span>';
        }
    }
}