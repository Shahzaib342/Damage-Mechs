<form type="post" action="#" id="form-data">
    <input type="hidden" value="<?php echo(rand(10, 100)); ?>" name="token">
    <div class="tile is-ancestor left-tile">
        <div class="tile is-vertical is-8">
            <div class="tile is-parent">
                <article class="tile is-child notification">
                    <p class="subtitle">EQUIPMENT - PROCESS DESCRIPTION</p>
                    <div class="content">
                        <!-- Content -->
                        <div class="columns dropdown-columns">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Material Type</label>
                                    <div class="control">
                                        <div class="select">
                                            <select id="material-type" name="material-type">
                                                <option value="0">Select Material Type</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Equipment Type</label>
                                    <div class="control">
                                        <div class="select">
                                            <select id="equipment-type" name="equipment-type">
                                                <option value="0">Select Equipment Type</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Years in service</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Years in service"
                                               name="years-in-service">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Thickness(Inches)</label>
                                    <div class="control">
                                        <input class="input" type="text" required placeholder="Thickness(Inches)"
                                               name="thickness">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Internal Pressure</label>
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Internal Pressure"
                                               name="internal-pressure">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Temperature (Max of Process/Skin) in fahrenheit</label>
                                    <div class="control">
                                        <input class="input" type="number"
                                               placeholder="Temperature (Max of Process/Skin) in fahrenheit"
                                               name="temperature-max-of-process-or-skin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">High Dynamic loading</label>
                                    <label class="switch">
                                        <input type="checkbox" name="high-dynamic-loading">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label"> Mat_Creep_range</label>
                                    <label class="switch">
                                        <input type="checkbox" name="mat-creep-range">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Hydrogen present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="hydrogen-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Amonia</label>
                                    <label class="switch">
                                        <input type="checkbox" name="amonia">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">PWHT</label>
                                    <label class="switch">
                                        <input type="checkbox" name="PWHT">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label"> Ext-Coating</label>
                                    <label class="switch">
                                        <input type="checkbox" name="Ext-Coating">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Insulation / Fire Proofing</label>
                                    <label class="switch">
                                        <input type="checkbox" name="insulation-or-fire-proofing">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Refractory lined</label>
                                    <label class="switch">
                                        <input type="checkbox" name="refractory-lined">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Excessive Compressive stress</label>
                                    <label class="switch">
                                        <input type="checkbox" name="excessive-compressive-stress">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label"> Intermittent</label>
                                    <label class="switch">
                                        <input type="checkbox" name="Intermittent">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Chloride Present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="chloride-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Caustics present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="caustics-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Sulphur present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="sulphur-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label"> > 25% oxygen process</label>
                                    <label class="switch">
                                        <input type="checkbox" name="25-percent-Oxygen-process">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Thermal cycle Overheating</label>
                                    <label class="switch">
                                        <input type="checkbox" name="thermal-cycle-over-heating">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Excessive Tensile stress</label>
                                    <label class="switch">
                                        <input type="checkbox" name="excessive-tensile-stress">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Mismatch Ajoining Metals</label>
                                    <label class="switch">
                                        <input type="checkbox" name="mismatch-ajoining-metals">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Water service</label>
                                    <label class="switch">
                                        <input type="checkbox" name="water_service">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Carbon present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="carbon_present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Burried/soil/air/cemented</label>
                                    <label class="switch">
                                        <input type="checkbox" name="burried-soil-air-cemented">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Acid service</label>
                                    <label class="switch">
                                        <input type="checkbox" name="acid-service">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Nitrides present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="nitrides-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Cyanide</label>
                                    <label class="switch">
                                        <input type="checkbox" name="cyanide">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Cyclic loading</label>
                                    <label class="switch">
                                        <input type="checkbox" name="cyclic-loading">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Molten zinc</label>
                                    <label class="switch">
                                        <input type="checkbox" name="molten-zinc">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Molten mercury</label>
                                    <label class="switch">
                                        <input type="checkbox" name="molten-mercury">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Molten cadmium</label>
                                    <label class="switch">
                                        <input type="checkbox" name="molten-cadmium">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Molten lead</label>
                                    <label class="switch">
                                        <input type="checkbox" name="molten-lead">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Molten copper</label>
                                    <label class="switch">
                                        <input type="checkbox" name="molten-copper">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Tin</label>
                                    <label class="switch">
                                        <input type="checkbox" name="tin">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">fire/flame present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="fire/flame-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Cathodic</label>
                                    <label class="switch">
                                        <input type="checkbox" name="cathodic">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Ethanol present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="ethanol-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="column is-one-quarter">
                                <div class="field">
                                    <label class="label">Sulfate present</label>
                                    <label class="switch">
                                        <input type="checkbox" name="sulfate-present">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>
<!--                            <div class="column is-one-quarter">-->
<!--                                <div class="field">-->
<!--                                    <label class="label">fire/flame present</label>-->
<!--                                    <label class="switch">-->
<!--                                        <input type="checkbox" name="fire/flame-present">-->
<!--                                        <span class="slider round"></span>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="column is-one-quarter">-->
<!--                                <div class="field">-->
<!--                                    <label class="label">Cathodic</label>-->
<!--                                    <label class="switch">-->
<!--                                        <input type="checkbox" name="cathodic">-->
<!--                                        <span class="slider round"></span>-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link">Submit</button>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
</form>
