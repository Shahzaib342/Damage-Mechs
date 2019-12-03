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
                                <div class="control">
                                    <div class="select">
                                        <select id="material-type" name="material-type">
                                            <option>Select Material Type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-half">
                                <div class="control">
                                    <div class="select">
                                        <select id="equipment-type" name="equipment-type">
                                            <option>Select Equipment Type</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="PWHT" name="PWHT">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Thickness(Inches)"
                                               name="thickness">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Years in service"
                                               name="years-in-service">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Ext-Coating" name="Ext-Coating">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Insulation / Fire Proofing"
                                               name="insulation-or-fire-proofing">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Refractory lined"
                                               name="refractory-lined">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Internal Pressure"
                                               name="internal-pressure">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Temperature (Max of Process/Skin)"
                                               name="temperature-max-of-process-or-skin">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="High Dynamic loading"
                                               name="high-dynamic-loading">
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Mat_Creep_range"
                                               name="mat-creep-range">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns switch-toggles">
                            <div class="column is-half">
                                <div class="field">
                                    <div class="control">
                                        <input class="input" type="text" placeholder="Mismatch Ajoining  Metals"
                                               name="mismatch-ajoining-metals">
                                    </div>
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
