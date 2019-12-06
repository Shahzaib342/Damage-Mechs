$(document).ready(function () {

    //submit form data in ajax and then create output/ranking section based on the response
    $('form').submit(function (event) {
        event.preventDefault();
        $.ajax({
            url: '/Controller.php',
            type: 'post',
            data: $('form#form-data').serialize(),
            dataType: 'json',
            success: function (data) {
                // ... show output and ranked based on highest number of true probability
                if (data.output.outputs.length < 1) {
                    $('.right-tile .content .content').empty().append('<span> No data </span>');
                } else {
                    singleLineArray = [];
                    maximumCorrectedInputs = data.output.maximumCorrectedInputs;
                    $.each(data.output.outputs, function (index, value) {
                        var Obj = {
                            "correctedInputs": value.correctedInputs,
                            "output": value.output,
                        };
                        singleLineArray.push(Obj);
                    });
                    //sort array based on the number of corrected Inputs
                    singleLineArray.sort(function (a, b) {
                        return a.correctedInputs > b.correctedInputs ? -1 : 1
                    });
                    var html = '';
                    //create and append output html to display on output section
                    $.each(singleLineArray, function (index, val) {
                        var percentage = (val.correctedInputs / maximumCorrectedInputs) * 100;
                        html += '<span>' + val.output + '</span>';
                        html += '<progress class="progress is-primary" value="' + percentage + '" max="100">' + percentage + '%</progress>';
                    });
                    $('.right-tile .content .content').empty().append(html);
                }
            }
        });
    });

    //create material & equipment type dropdowns
    var materialTypes = [
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
    ];

    var materialTypeOptions = '';
    $.each(materialTypes, function (index, value) {
        materialTypeOptions += '<option value="' + (index + 1) + '">' + value + ' </option>';
    });

    $('select#material-type').append(materialTypeOptions);

    var equipmentTypes = [
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
    ];

    var equipmentTypeOptions = '';
    $.each(equipmentTypes, function (index, value) {
        equipmentTypeOptions += '<option value="' + (index + 1) + '">' + value + ' </option>';
    });

    $('select#equipment-type').append(equipmentTypeOptions);
});
