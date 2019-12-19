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
                                            <select id="material-type" name="material-type" required>
                                                <option value="">Select Material Type</option>
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
                                            <select id="equipment-type" name="equipment-type" required>
                                                <option value="">Select Equipment Type</option>
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
                                               name="years-in-service" required>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Thickness(Inches)</label>
                                    <div class="control">
                                        <input class="input" type="text" required placeholder="Thickness(Inches)"
                                               name="thickness" required>
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
                                               name="internal-pressure" required>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="field">
                                    <label class="label">Temperature (Max of Process/Skin) in fahrenheit</label>
                                    <div class="control">
                                        <input class="input" type="number"
                                               placeholder="Temperature (Max of Process/Skin) in fahrenheit"
                                               name="temperature-max-of-process-or-skin" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns dropdown-columns multi-select-dropdowns">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">Process – Main Service OR Additive(s)</label>
                                    <div class="control">
                                        <div class="select process-main-service-or-additive">
                                            <select name="process-main-service-or-additive" style="display: none"
                                                    multiple placeholder="Please select">
                                                <option value="DEA/MDEA-service/present">Diethanolamine (DEA/MDEA) service/present</option>
                                                <option value="25-percent-Oxygen-process"> > 25% oxygen In process</option>
                                                <option value="acid-service">Acid service (General)</option>
                                                <option value="acidic-sour-water">Acidic sour water</option>
                                                <option value="amine"> Amine</option>
                                                <option value="ammonia">Ammonia</option>
                                                <option value="ammonium-chloride">Ammonium Chloride</option>
                                                <option value="aqueous-carbonate"> Aqueous carbonate</option>
                                                <option value="carbon">Carbon (CO, CO2)</option>
                                                <option value="caustics">Caustics</option>
                                                <option value="chlorides"> Chlorides</option>
                                                <option value="cyanides">Cyanides</option>
                                                <option value="ethanol">Ethanol</option>
                                                <option value="h2s-containing-hydrocarbons">H2S containing hydrocarbons</option>
                                                <option value="h2s">H2S</option>
                                                <option value="hf-acid">HF Acid</option>
                                                <option value="hydrochloric-acid">Hydrochloric Acid</option>
                                                <option value="hydrogen">Hydrogen</option>
                                                <option value="naphthenic-acid">Naphthenic Acid</option>
                                                <option value="nh4hs">NH4HS</option>
                                                <option value="nitrides">Nitrides</option>
                                                <option value="organic-acid">Organic Acids</option>
                                                <option value="other-chemical-contaminants">Other chemical contaminants</option>
                                                <option value="phenol">Phenol</option>
                                                <option value="phosphoric-acid">Phosphoric Acid</option>
                                                <option value="sulfate">Sulfate</option>
                                                <option value="sulfide">Sulfide</option>
                                                <option value="sulfuric-acid">Sulfuric Acid</option>
                                                <option value="water">Water</option>
                                                <option value="wet-h2s">Wet H2S</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">System Design</label>
                                    <div class="control">
                                        <div class="select system-design">
                                            <select name="system-design" style="display: none" multiple placeholder="Please select">
                                                <option value="buried-soil-air-cemented-equipment">Buried/soil/air/cemented Equipment</option>
                                                <option value="cathodic-protected-equipment"> Cathodic Protected Equipment</option>
                                                <option value="ext-coating-anti-corrosion">Ext-Coating (Anti-corrosion)</option>
                                                <option value="fire-flame-affected-equipment">Fire/Flame affected Equipment</option>
                                                <option value="insulated-fire-proofed-equipment"> Insulated / Fire Proofed Equipment</option>
                                                <option value="mismatch-adjoining-metals-in-equipment">Mismatch Adjoining Metals in Equipment</option>
                                                <option value="molten-cadmium-on-equipment">Molten cadmium on Equipment</option>
                                                <option value="molten-copper-on-equipment">Molten copper on Equipment</option>
                                                <option value="molten-lead-on-equipment">Molten lead on Equipment</option>
                                                <option value="molten-mercury-on-equipment">Molten mercury on Equipment</option>
                                                <option value="molten-zinc-on-equipment"> Molten zinc on Equipment</option>
                                                <option value="PWHT-equipment">PWHT Equipment</option>
                                                <option value="tin">Tin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="columns dropdown-columns multi-select-dropdowns">
                            <div class="column is-half">
                                <div class="field">
                                    <label class="label">System Stresses & Loads</label>
                                    <div class="control">
                                        <div class="select system-stresses-and-loads">
                                            <select name="select system-stresses-and-loads" style="display: none"
                                                    multiple placeholder="Please select">
                                                <option value="applied-induced-stress">Applied Induced stress</option>
                                                <option value="cyclic-induced-loading"> Cyclic Induced loading</option>
                                                <option value="compressive-induced-stress">Compressive Induced stress</option>
                                                <option value="tensile-induced-stress">Tensile Induced stress</option>
                                                <option value="dynamic-induced-loading"> Dynamic induced loadingt</option>
                                                <option value="intermittent-overheating">Intermittent Overheating</option>
                                                <option value="residual-induced-stress">Residual Induced stress</option>
                                                <option value="thermal-cycle">Thermal cycle</option>
                                            </select>
                                        </div>
                                    </div>
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
