<div id="bg_sideBar">
    <div id="immobilien_schnellsuche">
    
            <form action="<?php echo $ji_api_wp_plugin->getIndexUrl() ?>" method="post">
            <input type="hidden" value="filter" name="reset">
            <h3>Objektnummer</h3>
            <div class="bg_formRow">
                <div class="bg_formInput">
                    <input type="text" class="numberDE bg_textfield" size="10" value="<?php isset($ji_obj_list->filter['objektnummer']) and print $ji_obj_list->filter['objektnummer']; ?>" id="object_own_id" name="filter[objektnummer]">
                    <input type="submit" class="fusion-button button-flat button-round button-small button-default button-20" value="Suchen">
                </div>
            </div>
        </form><br />
    
        <form action="<?php echo $ji_api_wp_plugin->getIndexUrl() ?>" method="post">
            <input type="hidden" value="filter" name="reset">
            <h3>Immobilien Schnellsuche</h3>
            <div class="bg_formRow">
                    <li>
                        <input type="checkbox" value="1" id="filters_miete" name="filter[miete]" <?php isset($ji_obj_list->filter['miete']) && $ji_obj_list->filter['miete'] and print 'checked="checked"'; ?>>
                        <label for="filters_miete">Miete</label>
                    </li>
                    <li>
                        <input type="checkbox" value="1" id="filters_kauf" name="filter[kauf]" <?php isset($ji_obj_list->filter['kauf']) && $ji_obj_list->filter['kauf'] and print 'checked="checked"'; ?>>
                        <label for="filters_kauf">Kauf</label>
                    </li>
                    <li>
                        <input type="checkbox" value="anlage" id="filters_investment" name="filter[nutzungsart]" <?php isset($ji_obj_list->filter['nutzungsart']) && $ji_obj_list->filter['nutzungsart'] == "anlage" and print 'checked="checked"'; ?>>
                        <label for="filters_investment">Investment</label>
                    </li>
            </div>
            <div class="bg_formRow">
                <label class="control-label">Objektart:</label>
                <select name="filter[objektart_id][]" size="1">
                    <option value=""></option>
                    <?php foreach($objektarten as $i => $objektart): ?>
                        <option value="<?php echo $i ?>" <?php echo isset($ji_obj_list->filter['objektart_id']) && in_array($i, $ji_obj_list->filter['objektart_id']) ? 'selected=selected' : '' ?>><?php echo $objektart ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="bg_formRow">
                <label for="preis">Preis:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['preis_von']) and print $ji_obj_list->filter['preis_von']; ?>" id="filters_preis_von" name="filter[preis_von]">
                    bis
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['preis_bis']) and print $ji_obj_list->filter['preis_bis']; ?>" id="filters_preis_bis" name="filter[preis_bis]">
                    &euro;<br>
                </div>
            </div>
            <div class="bg_formRow">
                <label for="zimmer">Fl&auml;che:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['wohnflaeche_von']) and print $ji_obj_list->filter['wohnflaeche_von']; ?>" id="filters_wohnflaeche_von" name="filter[wohnflaeche_von]">
                    bis
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['wohnflaeche_bis']) and print $ji_obj_list->filter['wohnflaeche_bis']; ?>" id="filters_wohnflaeche_bis" name="filter[wohnflaeche_bis]">
                    m&sup2; </div>
            </div>
            <div class="bg_formRow">
                <label for="zimmer">Zimmer:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['zimmer_von']) and print $ji_obj_list->filter['zimmer_von']; ?>" id="filters_zimmer_von" name="filter[zimmer_von]">
                    bis
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['zimmer_bis']) and print $ji_obj_list->filter['zimmer_bis']; ?>" id="filters_zimmer_bis" name="filter[zimmer_bis]">
                </div>
            </div>
            <div class="bg_formRow">
                <label>Ort:</label>
                <div class="bg_formInput">
                    <select id="ji_searchbar_states" name="filter[bundesland_id]">
                        <option value=""></option>
                        <option value="AT" <?php echo isset($ji_obj_list->filter['bundesland_id']) && $ji_obj_list->filter['bundesland_id'] == 'AT' ? 'selected=selected': '' ?>>Österreich</option>
                        <?php foreach($ji_api_wp_plugin->getClient()->getBundeslaender()->bundesland as $bundesland): ?>
                            <option value="<?php echo $bundesland->id ?>" <?php echo isset($ji_obj_list->filter['bundesland_id']) && $ji_obj_list->filter['bundesland_id'] == $bundesland->id ? 'selected=selected': '' ?>>&nbsp;&nbsp;<?php echo $bundesland->name ?></option>
                        <?php endforeach; ?>
                        <option value="FOREIGN" <?php echo isset($ji_obj_list->filter['bundesland_id']) && $ji_obj_list->filter['bundesland_id'] == 'FOREIGN' ? 'selected=selected': '' ?>>Ausland</option>
                    </select>
                </div>
                <div class="clear"></div>
            </div>

            <div class="bg_formRow">
                <label>Region:</label>
                <div class="bg_formInput" id="ji_searchbar_regions">
                    <?php include JI_API_WP_PLUGIN_DIR . '/widget/_searchbar_regions.php' ?>
                </div>
                <div class="clear"></div>
            </div>

            <div id="bg_formRow">
                    <li>
                        <input type="checkbox" value="1" id="filters_garten" name="filter[garten]" <?php isset($ji_obj_list->filter['garten']) and print 'checked="checked"'; ?>>
                        &nbsp;
                        <label for="filters_garten">Garten</label>
                    </li>
                    <li>
                        <input type="checkbox" value="1" id="filters_garage" name="filter[garage]" <?php isset($ji_obj_list->filter['garage']) and print 'checked="checked"'; ?>>
                        &nbsp;
                        <label for="filters_garage">Garage</label>
                    </li>
                    <li>
                        <input type="checkbox" value="1" id="filters_balkon" name="filter[balkon]" <?php isset($ji_obj_list->filter['balkon']) and print 'checked="checked"'; ?>>
                        &nbsp;
                        <label for="filters_balkon">Balkon/Terrasse</label>
                    </li>
            </div>


            <input type="submit" class="fusion-button button-flat button-round button-small button-default button-20" value="Suchen">
            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&reset=filter" class="bg_rightLink">Suche l&ouml;schen</a>
            </li>
        </form>
        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript" >
    jQuery("#ji_searchbar_states").change(function() {
        var data = {
      			'action': 'ji_api_widget_render_regions',
      			'data': jQuery(this).val()
      		};

        jQuery.post(justimmoApi.ajaxurl, data, function(response) {
                jQuery("#ji_searchbar_regions").html(response);
      		});
    })
</script>

