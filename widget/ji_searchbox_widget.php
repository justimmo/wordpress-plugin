<div id="bg_sideBar">
    <div id="immobilien_schnellsuche">
    
            <form action="/immobilien-ji" method="post">
            <input type="hidden" value="filter" name="reset">
            <h3>Objektnummer</h3>
            <div class="bg_formRow">
                <div class="bg_formInput">
                    <input type="text" class="numberDE bg_textfield" size="10" value="<?php isset($ji_obj_list->filter['objektnummer']) and print $ji_obj_list->filter['objektnummer']; ?>" id="object_own_id" name="filter[objektnummer]">
                    <input type="submit" class="bg_button" value="Suchen">
                </div>
            </div>
        </form><br />
    
        <form action="/immobilien-ji" method="post">
            <input type="hidden" value="filter" name="reset">
            <h3>Immobilien Schnellsuche</h3>
            <div class="bg_formRow">
                <div id="bg_formInputMiete">
                    <input type="checkbox" value="1" id="filters_miete" name="filter[miete]" <?php isset($ji_obj_list->filter['miete']) and print 'checked="checked"'; ?>>
                    &nbsp;
                    <label style="width:auto;display:inline;float:none;margin-top:0" for="filters_miete">Miete</label>
                </div>
                <div id="bg_formInputKauf">
                    <input type="checkbox" value="1" id="filters_kauf" name="filter[kauf]" <?php isset($ji_obj_list->filter['kauf']) and print 'checked="checked"'; ?>>
                    &nbsp;
                    <label style="width:auto;display:inline;float:none;margin-top:0" for="filters_kauf">Kauf</label>
                </div>
            </div>
            <?php /*
                        <div class="bg_formRow">
                            <strong>
                                <a onclick="new Effect.toggle('objektarten_checkboxen', 'appear', {duration:0.25});; return false;" href="#">Objektart auswŠhlen</a>
                            </strong>
                            <div style="display:none;" id="objektarten_checkboxen">
                                <ul>
                                    <li id="1"><input type="checkbox" value="1" id="filters_objektart_id_1" name="filters[objektart_id][1]"> <label for="filters_objektart_id_1">Zimmer</label></li>
                                    <li id="2"><input type="checkbox" value="2" id="filters_objektart_id_2" name="filters[objektart_id][2]"> <label for="filters_objektart_id_2">Wohnung</label></li>
                                    <li id="3"><input type="checkbox" value="3" id="filters_objektart_id_3" name="filters[objektart_id][3]"> <label for="filters_objektart_id_3">Haus</label></li>
                                    <li id="4"><input type="checkbox" value="4" id="filters_objektart_id_4" name="filters[objektart_id][4]"> <label for="filters_objektart_id_4">GrundstŸck</label></li>
                                    <li id="5"><input type="checkbox" value="5" id="filters_objektart_id_5" name="filters[objektart_id][5]"> <label for="filters_objektart_id_5">BŸro / Praxis</label></li>
                                    <li id="6"><input type="checkbox" value="6" id="filters_objektart_id_6" name="filters[objektart_id][6]"> <label for="filters_objektart_id_6">Einzelhandel</label></li>
                                    <li id="7"><input type="checkbox" value="7" id="filters_objektart_id_7" name="filters[objektart_id][7]"> <label for="filters_objektart_id_7">Gastgewerbe</label></li>
                                    <li id="8"><input type="checkbox" value="8" id="filters_objektart_id_8" name="filters[objektart_id][8]"> <label for="filters_objektart_id_8">Halle / Lager / Produktion</label></li>
                                    <li id="9"><input type="checkbox" value="9" id="filters_objektart_id_9" name="filters[objektart_id][9]"> <label for="filters_objektart_id_9">Land und Forstwirtschaft</label></li>
                                    <li id="10"><input type="checkbox" value="10" id="filters_objektart_id_10" name="filters[objektart_id][10]"> <label for="filters_objektart_id_10">Sonstige</label></li>
                                    <li id="11"><input type="checkbox" value="11" id="filters_objektart_id_11" name="filters[objektart_id][11]"> <label for="filters_objektart_id_11">Freizeitimmobilie gewerblich</label></li>
                                    <li id="12"><input type="checkbox" value="12" id="filters_objektart_id_12" name="filters[objektart_id][12]"> <label for="filters_objektart_id_12">Zinshaus Renditeobjekt</label></li>
                                    <li id="15"><input type="checkbox" value="15" id="filters_objektart_id_15" name="filters[objektart_id][15]"> <label for="filters_objektart_id_15">BautrŠger</label></li>
                                    <li id="18"><input type="checkbox" value="18" id="filters_objektart_id_18" name="filters[objektart_id][18]"> <label for="filters_objektart_id_18">Betriebsobjekte</label></li>
                                    <li id="19"><input type="checkbox" value="19" id="filters_objektart_id_19" name="filters[objektart_id][19]"> <label for="filters_objektart_id_19">Anlageobjekte</label></li>
                                    <li id="22"><input type="checkbox" value="22" id="filters_objektart_id_22" name="filters[objektart_id][22]"> <label for="filters_objektart_id_22">Sonderobjekte</label></li>
                                    <li id="23"><input type="checkbox" value="23" id="filters_objektart_id_23" name="filters[objektart_id][23]"> <label for="filters_objektart_id_23">Ferienimmobilie</label></li>
                                </ul>
                            </div>
                        </div>
                        */ ?>
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
                <label for="zimmer">Zimmer:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['zimmer_von']) and print $ji_obj_list->filter['zimmer_von']; ?>" id="filters_zimmer_von" name="filter[zimmer_von]">
                    bis
                    <input type="text" class="bg_textfield bg_smallTextfield" value="<?php isset($ji_obj_list->filter['zimmer_bis']) and print $ji_obj_list->filter['zimmer_bis']; ?>" id="filters_zimmer_bis" name="filter[zimmer_bis]">
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
                <label for="plz">Plz:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_fluidTextfield" maxlength="10" value="<?php isset($ji_obj_list->filter['plz_von']) and print $ji_obj_list->filter['plz_von']; ?>" id="filters_plz_von" name="filter[plz_von]">
                </div>
                <div class="clear"></div>
            </div>
            <div class="bg_formRow">
                <label for="filters_ort">Ort:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_fluidTextfield ac_input" autocomplete="off" value="<?php isset($ji_obj_list->filter['ort']) and print $ji_obj_list->filter['ort']; ?>" id="filters_ort" name="filter[ort]">
                </div>
                <div class="clear"></div>
            </div>
            <div class="bg_formRow">
                <label for="stichwort">Suchbegriff:</label>
                <div class="bg_formInput">
                    <input type="text" class="bg_textfield bg_fluidTextfield" value="<?php isset($ji_obj_list->filter['stichwort']) and print $ji_obj_list->filter['stichwort']; ?>" id="filters_stichwort" name="filter[stichwort]">
                </div>
            </div>
            <input type="submit" class="bg_button" value="Suchen">
            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>/?reset=filter" class="bg_rightLink">Suche l&ouml;schen</a>
            </li>
        </form>
        <div class="clear"></div>
    </div>
</div>
