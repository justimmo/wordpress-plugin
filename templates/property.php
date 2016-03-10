<?php get_header(); ?>

    <script type="text/javascript">
        //<![CDATA[
        function displayImage(path) {
            document.getElementById('detailImage').innerHTML = '<img src="' + path + '" alt="' + path + '">';
        }
        //]]>
    </script>

    <div id="bg_AllContent">
        <div style="border-color:#eae9e9; border-bottom-width: 0px; border-top-width: 0px;border-bottom-style: solid;border-top-style: solid;padding-bottom:20px;padding-top:20px;padding-left:px;padding-right:px;" class="fusion-fullwidth fullwidth-box fusion-fullwidth-1  fusion-parallax-none nonhundred-percent-fullwidth">
            <div id="bg_objectDetailMetaNav">
                <a class="fusion-button button-flat button-round button-large button-default" href="<?php echo $ji_api_wp_plugin->getIndexUrl() ?>">Zurück zur Übersicht</a>
                <a class="fusion-button button-flat button-round button-large button-default" href="<?php echo $ji_api_wp_plugin->getExposeUrl($immobilie->verwaltung_techn->objektnr_intern); ?>">EXPOSÉ</a>
                <div class="clear"></div>
            </div>

            <h2><?php echo $immobilie->freitexte->objekttitel; ?></h2>

            <div class="fusion-row">
                <div style="margin-top:0px;margin-bottom:20px;" class="fusion-two-third fusion-layout-column fusion-spacing-yes">
                    <div class="fusion-column-wrapper">

                        <?php if ($request_form_error): ?>
                            <div class="alert alert-danger">
                                Es ist ein Fehler bei der Objektanfrage aufgetreten!<br>
                                <?php echo nl2br($request_form_error); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($request_form_success): ?>
                            <div class="alert alert-success">
                                Objektanfrage wurde versendet!
                            </div>
                        <?php endif; ?>


                        <div id="bg_objectDetailContent">

                            <h3 class="bg_address">
                                <?php echo $immobilie->geo->plz; ?>
                                <?php echo $immobilie->geo->ort; ?><?php if ($immobilie->geo->regionaler_zusatz): ?>
                                    , <?php echo $immobilie->geo->regionaler_zusatz; ?>
                                <?php endif; ?>
                            </h3>

                            <div class="bg_content">
                                <?php if (count($immobilie->anhaenge->anhang)): ?>
                                    <div id="detailImage">
                                        <a href="<?php echo $immobilie->anhaenge->anhang[0]->daten->pfad; ?>" rel="prettyPhoto[gallery1]" target="_blank">
                                            <img alt="<?php echo $immobilie->freitexte->objekttitel; ?>" src="<?php echo $immobilie->anhaenge->anhang[0]->daten->pfad; ?>"/>
                                        </a>
                                    </div>

                                    <div id="objekt_vorschaubilder">
                                        <?php $i = 0; ?>
                                        <?php foreach ($immobilie->anhaenge->anhang as $anhang): ?>
                                            <?php $i++ ?>
                                            <a href="<?php echo $anhang->daten->pfad; ?>" rel="prettyPhoto[gallery1]" target="_blank">
                                                <img alt="<?php echo $immobilie->freitexte->objekttitel; ?>" class="bg_smallImageDetail" src="<?php echo $anhang->daten->small; ?>" alt="immobilie"/>
                                            </a>
                                        <?php endforeach; ?>
                                        <div class="clear"></div>

                                    </div>
                                <?php endif ?>

                                <div id="bg_objektBeschreibung">
                                    <h2>Beschreibung</h2>
                                    <?php echo $immobilie->freitexte->objektbeschreibung; ?>
                                </div>
                                <?php if ($immobilie->freitexte->lage): ?>
                                    <div id="bg_objektLage">
                                        <h2>Lage</h2>
                                        <?php echo $immobilie->freitexte->lage; ?>
                                    </div>
                                <?php endif ?>

                                <?php if (count($immobilie->dokumente->dokument)): ?>
                                    <div id="bg_objektDokumente">
                                        <h2>Dokumente</h2>
                                        <?php $i = 0; ?>
                                        <?php foreach ($immobilie->dokumente->dokument as $anhang): ?>
                                            <?php $i++ ?>
                                            <a href="<?php echo $anhang->pfad ?>" target="_blank">
                                                <?php echo $anhang->titel ?>
                                            </a>
                                            <br/>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="bg_clear"></div>
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="fusion-clearfix"></div>
                    </div>
                </div>
                <div style="margin-top:0;margin-bottom:20px;" class="fusion-one-third one_third fusion-layout-column fusion-column-last fusion-spacing-yes">
                    <div class="fusion-column-wrapper">

                        <div id="bg_objectDetailInformation" class="JiApiWpSearchBarWidget">
                            <h2>Objektnummer <?php echo $immobilie->verwaltung_techn->objektnr_extern; ?></h2>
                            <ul>
                                <li>
                                    <?php if ($immobilie->objektkategorie->objektart->children()->getName()): ?>
                                        <strong>Objektart:</strong>
                                        <?php
                                        switch ($immobilie->objektkategorie->objektart->children()->getName()) {
                                            case 'haus':
                                                echo 'Haus';
                                                break;
                                            case 'grundstueck':
                                                echo 'Grundstück';
                                                break;
                                            case 'buero_praxen':
                                                echo 'Büro';
                                                break;
                                            case 'einzelhandel':
                                                echo 'Einzelhandel';
                                                break;
                                            case 'gastgewerbe':
                                                echo 'Gastgewerbe';
                                                break;
                                            case 'hallen_lager_prod':
                                                echo 'Industrie/Gewerbe';
                                                break;
                                            case 'land_und_forstwirtschaft':
                                                echo 'Land/Forstwirtschaft';
                                                break;
                                            case 'freizeitimmobilie_gewerblich':
                                                echo 'Freizeitimmobilie';
                                                break;
                                            case 'zinshaus_renditeobjekt':
                                                echo 'Zinshaus/Renditeobjekt';
                                                break;
                                            case 'sonstige':
                                                echo 'Sonstiges';
                                                break;
                                            default:
                                                echo 'Wohnung';
                                                break;
                                        }
                                        ?>
                                    <?php endif; ?>
                                </li>
                                <li>
                                    <?php if (count($immobilie->objektkategorie->nutzungsart) > 0): ?>
                                        <strong>Nutzungsart: </strong>
                                        <?php if ($immobilie->objektkategorie->nutzungsart['WOHNEN'] == 1) {
                                            echo 'Wohnen';
                                        } ?>
                                        <?php if ($immobilie->objektkategorie->nutzungsart['GEWERBE'] == 1) {
                                            echo 'Gewerbe';
                                        } ?>
                                        <?php if ($immobilie->objektkategorie->nutzungsart['ANLAGE'] == 1) {
                                            echo 'Anlage';
                                        } ?>
                                    <?php endif; ?>
                                </li>
                            </ul>

                            <h2>Preisinformation</h2>
                            <ul>
                                <?php if (isset($immobilie->objektkategorie->vermarktungsart["KAUF"]) && ($immobilie->objektkategorie->vermarktungsart["KAUF"] == 1 || $immobilie->objektkategorie->vermarktungsart["KAUF"] == "true")): ?>
                                    <?php if (isset($immobilie->preise->kaufpreis)): ?>
                                        <li>
                                            <strong>Kaufpreis:</strong> <?php echo number_format((float)$immobilie->preise->kaufpreis, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endif; ?>
                                    <?php foreach ($immobilie->xpath('.//preise/user_defined_simplefield[@feldname="monatlichekostenbrutto"]') as $monatliche_kosten): ?>
                                        <li>
                                            <strong>Monatliche
                                                Kosten:</strong> <?php echo number_format((float)$monatliche_kosten, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php if (isset($immobilie->preise->kaltmiete) && $immobilie->preise->kaltmiete > 0): ?>
                                        <li>
                                            <strong>Gesamtmiete:</strong> <?php echo number_format((float)$immobilie->preise->kaltmiete, 2, ',', '.') ?> &euro;<br/>
                                            (ohne Heizkosten inkl. USt.)
                                        </li>
                                    <?php endif; ?>

                                    <?php if (isset($immobilie->preise->nettokaltmiete) && $immobilie->preise->nettokaltmiete > 0): ?>
                                        <li>
                                            <strong>Miete:</strong> <?php echo number_format((float)$immobilie->preise->nettokaltmiete, 2, ',', '.') ?> &euro;
                                        </li>
                                    <?php endif; ?>
                                    <?php if (isset($immobilie->preise->nebenkosten)): ?>
                                        <li>
                                            <strong>Betriebskosten:</strong> <?php echo number_format((float)$immobilie->preise->nebenkosten, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endif; ?>
                                    <?php foreach ($immobilie->xpath('.//preise/user_defined_anyfield/sonstige_kosten') as $sonstige_kosten): ?>
                                        <li>
                                            <strong>Sonstige
                                                Kosten:</strong> <?php echo number_format((float)$sonstige_kosten, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endforeach; ?>
                                    <?php foreach ($immobilie->xpath('.//preise/user_defined_anyfield/mwst_gesamt') as $mwst_gesamt): ?>
                                        <li>
                                            <strong>USt:</strong> <?php echo number_format((float)$mwst_gesamt, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endforeach; ?>
                                    <?php if (isset($immobilie->preise->warmmiete)): ?>
                                        <li>
                                            <strong>Gesamtbelastung:</strong> <?php echo number_format((float)$immobilie->preise->warmmiete, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endif; ?>
                                    <?php if (isset($immobilie->preise->kaution)): ?>
                                        <li>
                                            <strong>Kaution:</strong> <?php echo number_format((float)$immobilie->preise->kaution, 2, ',', '.'); ?> &euro;
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if (isset($immobilie->preise->aussen_courtage)): ?>
                                    <li>
                                        <strong>Provision:</strong> <?php echo $immobilie->preise->aussen_courtage; ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                            <div class="clear"></div>

                            <h2>Eckdaten</h2>
                            <ul>
                                <?php if ($immobilie->zustand_angaben->baujahr): ?>
                                    <li><strong>Baujahr:</strong> <?php echo $immobilie->zustand_angaben->baujahr; ?>
                                    </li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->anzahl_zimmer): ?>
                                    <li><strong>Zimmer:</strong> <?php echo $immobilie->flaechen->anzahl_zimmer; ?></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->wohnflaeche): ?>
                                    <li>
                                        <strong>Wohnfl&auml;che:</strong> <?php echo number_format((float)$immobilie->flaechen->wohnflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->nutzflaeche): ?>
                                    <li>
                                        <strong>Nutzfl&auml;che:</strong> <?php echo number_format((float)$immobilie->flaechen->nutzflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->gesamtflaeche): ?>
                                    <li>
                                        <strong>Gesamtfl&auml;che:</strong> <?php echo number_format((float)$immobilie->flaechen->gesamtflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->grundstuecksflaeche): ?>
                                    <li>
                                        <strong>Grundst&uuml;cksfl&auml;che:</strong> <?php echo number_format((float)$immobilie->flaechen->grundstuecksflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->anzahl_badezimmer): ?>
                                    <li>
                                        <strong>B&auml;der:</strong> <?php echo $immobilie->flaechen->anzahl_badezimmer; ?>
                                    </li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->anzahl_sep_wc): ?>
                                    <li><strong>WC:</strong> <?php echo $immobilie->flaechen->anzahl_sep_wc; ?></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->anzahl_balkon_terrassen): ?>
                                    <li>
                                        <strong>Balkon/Terrassen:</strong> <?php echo $immobilie->flaechen->anzahl_balkon_terrassen; ?>
                                        , <?php echo number_format((float)$immobilie->flaechen->balkon_terrasse_flaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->gartenflaeche): ?>
                                    <li>
                                        <strong>Garten:</strong> <?php echo number_format((float)$immobilie->flaechen->gartenflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>
                                <?php if ($immobilie->flaechen->kellerflaeche): ?>
                                    <li>
                                        <strong>Keller:</strong> <?php echo number_format((float)$immobilie->flaechen->kellerflaeche, 2, ',', '.'); ?>
                                        m<sup>2</sup></li>
                                <?php endif; ?>

                                <?php $epass_hwbwert = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_hwbwert"]'); ?>
                                <?php if (count($epass_hwbwert)): ?>
                                    <li>
                                        <strong>HWB:</strong>
                                        <?php $epass_hwbklasse = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_hwbklasse"]'); ?>
                                        <?php $epass_hwbklasse_farbe = array('A++' => '#00ADEF', 'A+' => '#0084B5', 'A' => '#00954D', 'B' => '#0CB14B', 'C' => '#99CA3C', 'D' => '#EDE824', 'E' => '#F0B41C', 'F' => '#DF7527', 'G' => '#E33226'); ?>
                                        <?php if (count($epass_hwbklasse) && isset($epass_hwbklasse_farbe[(string)$epass_hwbklasse[0]])): ?>
                                            <span style="color: #ffffff; background-color:<?php echo $epass_hwbklasse_farbe[(string)$epass_hwbklasse[0]]; ?>">&nbsp;<?php echo (string)$epass_hwbklasse[0]; ?>
                                                &nbsp;</span>
                                        <?php endif; ?>
                                        <?php echo number_format((float)$epass_hwbwert[0], 2, ',', '.') ?> kWh/m²a
                                    </li>
                                <?php endif; ?>

                                <?php $epass_fgeewert = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_fgeewert"]'); ?>
                                <?php if (count($epass_fgeewert)): ?>
                                    <li>
                                        <strong>FGEE:</strong>
                                        <?php $epass_fgeeklasse = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_fgeeklasse"]'); ?>
                                        <?php $epass_fgeeklasse_farbe = array('A++' => '#00ADEF', 'A+' => '#0084B5', 'A' => '#00954D', 'B' => '#0CB14B', 'C' => '#99CA3C', 'D' => '#EDE824', 'E' => '#F0B41C', 'F' => '#DF7527', 'G' => '#E33226'); ?>
                                        <?php if (count($epass_fgeeklasse) && isset($epass_fgeeklasse_farbe[(string)$epass_fgeeklasse[0]])): ?>
                                            <span style="color: #ffffff; background-color:<?php echo $epass_fgeeklasse_farbe[(string)$epass_fgeeklasse[0]]; ?>">&nbsp;<?php echo (string)$epass_fgeeklasse[0]; ?>
                                                &nbsp;</span>
                                        <?php endif; ?>
                                        <?php echo number_format((float)$epass_fgeewert[0], 2, ',', '.') ?>
                                    </li>
                                <?php endif; ?>
                            </ul>

                            <?php if (strlen(trim($immobilie->freitexte->ausstatt_beschr)) > 2): ?>
                                <div id="bg_objectDetailInterior">
                                    <h2>Ausstattung</h2>

                                    <p><?php echo $immobilie->freitexte->ausstatt_beschr; ?></p>

                                    <div class="clear"></div>

                                </div>
                                <div class="bg_clear"></div>
                            <?php endif; ?>

                            <div class="bg_objectContactPerson">
                                <h2>Ihr Ansprechpartner</h2>

                                <p>
                                    <?php if ($immobilie->kontaktperson->bild): ?>
                                        <img style="float: left; margin-right: 10px;" src="<?php echo $immobilie->kontaktperson->bild->small; ?>"/>
                                    <?php endif; ?>
                                    <?php echo $immobilie->kontaktperson->titel . ' ' . $immobilie->kontaktperson->vorname . ' ' . $immobilie->kontaktperson->name; ?>
                                    <br/>
                                    <a href="mailto:<?php echo $immobilie->kontaktperson->email_direkt; ?>">E-Mail
                                        an <?php echo $immobilie->kontaktperson->vorname . ' ' . $immobilie->kontaktperson->name; ?></a><br/>
                                    <?php if ($immobilie->kontaktperson->tel_zentrale && $immobilie->kontaktperson->tel_zentrale != 0): ?>
                                        Telefon: <?php echo $immobilie->kontaktperson->tel_zentrale; ?><br/>
                                    <?php endif; ?>
                                    <?php if ($immobilie->kontaktperson->tel_handy && $immobilie->kontaktperson->tel_handy != 0): ?>
                                        Mobil: <?php echo $immobilie->kontaktperson->tel_handy; ?><br/>
                                    <?php endif; ?>
                                    <?php if ($immobilie->kontaktperson->tel_fax && $immobilie->kontaktperson->tel_fax != 0): ?>
                                        Fax: <?php echo $immobilie->kontaktperson->tel_fax; ?>
                                    <?php endif; ?>
                                </p>
                                <div style="clear: both;"></div>
                                <br />
                                <h2>Nehmen Sie Kontakt auf</h2>
                                <form class="bg_property_request" action="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->verwaltung_techn->objektnr_intern) ?>" method="post">
                                    <label>Name:</label>
                                    <input type="text" name="request[name]" value="<?php isset($request_form['name']) and print $request_form['name']; ?>" class="request[name]"/>
                                    <label>E-Mail:</label>
                                    <input type="text" name="request[email]" value="<?php isset($request_form['email']) and print $request_form['email']; ?>" class="request[email]"/>
                                    <label>Nachricht:</label>
                                    <textarea name="request[text]" class="request[email]"/><?php isset($request_form['text']) and print $request_form['text']; ?></textarea>
                                    <?php if (function_exists('cptch_display_captcha_custom')): ?>
                                        <label>Sicherheitsabfrage:</label><br/>
                                        <input type='hidden' name='cntctfrm_contact_action' value='true'/>
                                        <?php echo cptch_display_captcha_custom(); ?>
                                    <?php endif; ?>
                                    <?php if ($request_form_error): ?>
                                        <div class="alert alert-danger"><?php echo nl2br($request_form_error); ?></div>
                                    <?php endif; ?>
                                    <br><br>
                                    <input type="submit" class="fusion-button button-flat button-round button-large button-default"/>
                                </form>

                            </div>
                        </div>
                        <div class="fusion-clearfix"></div>
                    </div>
                </div>
                <div class="fusion-clearfix"></div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>