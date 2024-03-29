$(document).ready(function () {

    app = {};

    //submit form data in ajax and then create output/ranking section based on the response
    $('form').submit(function (event) {
        event.preventDefault();

        var group_main_service = [];
        var system_design = [];
        var system_stresses_and_loads = [];
        $(".select.process-main-service-or-additive span.dropdown-selected").each(function (index) {
            group_main_service.push(
                $(this).find('i').attr('data-id')
            );
        });
        $(".system-design span.dropdown-selected").each(function (index) {
            system_design.push(
                $(this).find('i').attr('data-id')
            );
        });
        $(".system-stresses-and-loads span.dropdown-selected").each(function (index) {
            system_stresses_and_loads.push(
                $(this).find('i').attr('data-id')
            );
        });
        var data = $('form#form-data').serializeArray();
        data.push({name: 'group_main_service', value: group_main_service});
        data.push({name: 'system_design', value: system_design});
        data.push({name: 'system_stresses_and_loads', value: system_stresses_and_loads});
        $.ajax({
            url: 'Controller.php',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function (data) {
                // ... show output and ranked based on highest number of true probability
                if (data.output.outputs.length < 1) {
                    $('.right-tile .content .content .output-section').empty().append('<span> NA </span>');
                    return false;
                } else {
                    singleLineArray = [];
                    maximumCorrectedInputs = data.output.maximumCorrectedInputs;
                    $.each(data.output.outputs, function (index, value) {
                        var Obj = {
                            "correctedInputs": value.correctedInputs,
                            "output": value.output,
                            'Desc': value.Desc
                        };
                        singleLineArray.push(Obj);
                    });
                    //sort array based on the number of corrected Inputs
                    singleLineArray.sort(function (a, b) {
                        return a.correctedInputs > b.correctedInputs ? -1 : 1
                    });
                    $('.inputs-section').empty().append(data.inputs);
                    var html = '';
                    //create and append output html to display on output section
                    $.each(singleLineArray, function (index, val) {
                        var percentage = (val.correctedInputs / maximumCorrectedInputs) * 100;
                        html += '<button type="button" class="collapsible"><i class="fa fa-angle-down"></i> ';
                        html += val.output + '</button>';
                        html += '<progress class="progress is-primary" value="' + percentage + '" max="100">' + percentage + '%</progress>';
                        html += '<div class="content">';
                        html += '<ul style="list-style: none">';
                        $.each(val.Desc, function (k, v) {
                            html += '<li>';
                            html += '<span class="output-titles">' + k + '</span>';
                            html += '<ul>';
                            $.each(v, function (i, j) {
                                html += '<li>' + j + '</li>';
                            });
                            html += '</ul></li>';
                        });
                        html += '</ul></div>';
                    });
                    $('.right-tile .content .content .output-section').empty().append(html);
                    app.addCollapsibleEvent();
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
        'A286 Stainless Steel',
        'Alloy C276',
        'Alloy 20'
    ];

    $('.process-main-service-or-additive').dropdown({});
    $('.system-design').dropdown({});
    $('.system-stresses-and-loads').dropdown({});


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
        'Valves',
        'Towers - Cooling Water',
        'Injection Points'
    ];

    var equipmentTypeOptions = '';
    $.each(equipmentTypes, function (index, value) {
        equipmentTypeOptions += '<option value="' + (index + 1) + '">' + value + ' </option>';
    });

    $('select#equipment-type').append(equipmentTypeOptions);

    //event for collapsible output sections
    app.addCollapsibleEvent = function () {
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function () {
                this.classList.toggle("active");
                $(this).find('svg').toggleClass('fa-angle-down').toggleClass('fa-angle-up');
                var content = this.nextElementSibling;
                content = content.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    };

    //allow only positive and greater than 0 number for Thickness field
    $('input[name="thickness"]').on('focusout', function () {
        $('span.error').remove();
        if (isNaN($(this).val()) || $(this).val() <= 0) {
            $(this).val('');
            $('input[name="thickness"]').after('<span class="error" style="color:red">value must be greater than 0</span>');
        } else {
            $('span.error').remove();
        }
    });

    //allow only positive number for years in service field
    $('input[name="years-in-service"]').on('focusout', function () {
        $('span.service-years-error').remove();
        if (isNaN($(this).val()) || $(this).val() < 0) {
            $(this).val('');
            $('input[name="years-in-service"]').after('<span class="service-years-error" style="color:red">value must be a positive number</span>');
        } else {
            $('span.service-years-error').remove();
        }
    });

    //allow only positive number for Internal pressure field
    $('input[name="internal-pressure"]').on('focusout', function () {
        $('span.internal-pressure-error').remove();
        if (isNaN($(this).val()) || $(this).val() < 0) {
            $(this).val('');
            $('input[name="internal-pressure"]').after('<span class="internal-pressure-error" style="color:red">value must be a positive number</span>');
        } else {
            $('span.internal-pressure-error').remove();
        }
    });
});

