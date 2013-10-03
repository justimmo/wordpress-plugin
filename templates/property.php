<?php get_header(); ?>

<script type="text/javascript">
    //<![CDATA[
    function displayImage(path) {
        document.getElementById('detailImage').innerHTML = '<img src="' + path + '" alt="' + path + '">';
    }
    //]]>
</script>

<script type="text/javascript">
	var myScroll = false;
	var tmyscrollresize = function(){
		var cur_cont_height = jQuery('.customScrollBox').height();
		var cur_viewport_height = jQuery(window).height()*0.8;
		if(myScroll){
			if(cur_cont_height >= cur_viewport_height){
				jQuery('#mcs_container').height(cur_viewport_height);
				myScroll.refresh();
			}else{
				jQuery('#mcs_container').height(cur_cont_height);
				myScroll.scrollTo(0, 0, 10);
				myScroll.destroy();
				myScroll = false;
			}
		}else{
			if(cur_cont_height >= cur_viewport_height){
				jQuery('#mcs_container').height(cur_viewport_height);
				myScroll = new iScroll('mcs_container', { zoom: true, vScroll: true, onBeforeScrollStart: function(e){var target = e.target;while (target.nodeType != 1) target = target.parentNode;if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA'){/*e.preventDefault();*/ }} });
			}
		}
	}
	jQuery(document).ready(function() {
		var cur_cont_height = jQuery('#mcs_container').height();
		var cur_viewport_height = jQuery(window).height()*0.8;
		var cur_cont_height2 = jQuery('.customScrollBox').height();
		if(cur_cont_height >= cur_viewport_height){
			//alert(cur_cont_height);
			jQuery('#mcs_container').height(cur_viewport_height);
			//jQuery('#mcs_container .customScrollBox').height(cur_cont_height2+50);
			//jQuery('#mcs_container .customScrollBox').css({'-moz-transform': 'translate(0px, '+cur_cont_height+'px) scale(1)'});
				//jQuery('#mcs_container').css({'opacity':'0'});
			setTimeout(function () {
				myScroll = new iScroll('mcs_container', { zoom: true, vScroll: true, onBeforeScrollStart: function(e){var target = e.target;while (target.nodeType != 1) target = target.parentNode;if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA'){/*e.preventDefault();*/ }} });
				jQuery(window).resize(tmyscrollresize);
			}, 100);
		}else{
			jQuery(window).resize(tmyscrollresize);
		}
	});
</script>

<div id="content">
<div id="mcs_container">
<div class="customScrollBox">
<div class="container">
<div class="content">
	<div class="container_12">
		<div class="grid_12">

<div id="bg_AllContent">
    <div id="bg_objectDetailMetaNav">
        <ul>
            <li>
                <a href="/immobilien-ji/">zurück zur Übersicht</a>
            </li>
            <li>
                <a href="<?php echo $ji_api_wp_plugin->getExposeUrl($immobilie->verwaltung_techn->objektnr_intern); ?>">EXPOSÉ</a>
            </li>
        </ul>
    </div>

    <div id="bg_objectDetailContent">

                <h1><?php echo $immobilie->freitexte->objekttitel; ?></h1>

                <h3 class="bg_address">
                    <?php echo $immobilie->geo->plz; ?>
                    <?php echo $immobilie->geo->ort; ?><?php if ($immobilie->freitexte->lage): ?>
                    , <?php echo $immobilie->freitexte->lage; ?><?php endif; ?>
                </h3>

                <div class="bg_content">
                    <?php if (count($immobilie->anhaenge->anhang)): ?>
                    <div id="detailImage">
                        <a href="<?php echo $immobilie->anhaenge->anhang[0]->daten->pfad; ?>" rel="fancybox" target="_blank">
                            <img src="<?php echo $immobilie->anhaenge->anhang[0]->daten->pfad; ?>"/>
                        </a>
                    </div>

                    <div id="objekt_vorschaubilder">
                        <?php $i = 0; ?>
                        <?php foreach ($immobilie->anhaenge->anhang as $anhang): ?>
                        <?php $i++ ?>
                        <a href="<?php echo $anhang->daten->pfad; ?>" rel="fancybox" target="_blank">
                            <img class="bg_smallImageDetail" src="<?php echo $anhang->daten->small; ?>" alt="immobilie"/>
                        </a>
                        <?php endforeach; ?>
                        <div class="clear"></div>

                    </div>
                    <?php endif ?>

                    <div id="bg_objektBeschreibung">
                        <?php echo $immobilie->freitexte->objektbeschreibung; ?>
                    </div>

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

                <div id="bg_objectDetailInformation" class="JiApiWpSearchBarWidget">
                    <h2>Eckdaten Objektnummer <?php echo $immobilie->verwaltung_techn->objektnr_extern; ?></h2>
                    <ul>
                        <li>
                            <?php if ($immobilie->objektkategorie->objektart->children()->getName()): ?>
                            <strong>Objektart:</strong>
                            <?php
                            switch ($immobilie->objektkategorie->objektart->children()->getName())
                            {
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
                            <?php if ($immobilie->objektkategorie->nutzungsart['WOHNEN'] == 1)
                            {
                                echo 'Wohnen';
                            } ?>
                            <?php if ($immobilie->objektkategorie->nutzungsart['GEWERBE'] == 1)
                            {
                                echo 'Gewerbe';
                            } ?>
                            <?php if ($immobilie->objektkategorie->nutzungsart['ANLAGE'] == 1)
                            {
                                echo 'Anlage';
                            } ?>
                            <?php endif; ?>
                        </li>
                    </ul>

                    <h2>Preisinformation</h2>
                    <ul>
                        <?php if (isset($immobilie->preise->kaufpreis)): ?>
                        <li>
                            <strong>Kaufpreis:</strong> <?php echo number_format((float)$immobilie->preise->kaufpreis, 2, ',', '.'); ?> &euro;
                        </li>
                        <?php endif; ?>
                        <?php if (isset($immobilie->preise->nettokaltmiete) && $immobilie->preise->nettokaltmiete > 0): ?>
                        <li>
                            <strong>Nettomiete:</strong> <?php echo number_format((float)$immobilie->preise->nettokaltmiete, 2, ',', '.') ?> &euro;
                        </li>
                        <?php elseif (isset($immobilie->preise->kaltmiete)): ?>
                        <li>
                            <strong>Nettomiete:</strong> <?php echo number_format((float)$immobilie->preise->kaltmiete, 2, ',', '.') ?> &euro;
                        </li>
                        <?php endif; ?>
                        <?php if (isset($immobilie->preise->nebenkosten)): ?>
                        <li>
                            <strong>Betriebskosten:</strong> <?php echo number_format((float)$immobilie->preise->nebenkosten, 2, ',', '.'); ?> &euro;
                        </li>
                        <?php endif; ?>
                        <?php if (isset($immobilie->preise->warmmiete)): ?>
                        <li><strong>Gesamtmiete: (inkl. USt. &
                            BK):</strong> <?php echo number_format((float)$immobilie->preise->warmmiete, 2, ',', '.'); ?> &euro;
                        </li>
                        <?php endif; ?>
                        <?php if (isset($immobilie->preise->kaution)): ?>
                        <li>
                            <strong>Kaution:</strong> <?php echo number_format((float)$immobilie->preise->kaution, 2, ',', '.'); ?> &euro;
                        </li>
                        <?php endif; ?>
                        <?php if (isset($immobilie->preise->aussen_courtage)): ?>
                        <li><strong>Provision:</strong> <?php echo $immobilie->preise->aussen_courtage; ?></li>
                        <?php endif; ?>
                    </ul>
                    <div class="clear"></div>

                    <h2>Details</h2>
                    <ul>
                        <?php if ($immobilie->zustand_angaben->baujahr): ?>
                        <li><strong>Baujahr:</strong> <?php echo $immobilie->zustand_angaben->baujahr; ?></li>
                        <?php endif; ?>
                        <?php if ($immobilie->flaechen->anzahl_zimmer): ?>
                        <li><strong>Zimmer:</strong> <?php echo $immobilie->flaechen->anzahl_zimmer; ?></li>
                        <?php endif; ?>
                        <?php if ($immobilie->flaechen->wohnflaeche): ?>
                        <li>
                            <strong>Wohnfl&auml;che:</strong> ca. <?php echo number_format((float)$immobilie->flaechen->wohnflaeche, 2, ',', '.'); ?>
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
                        <li><strong>B&auml;der:</strong> <?php echo $immobilie->flaechen->anzahl_badezimmer; ?></li>
                        <?php endif; ?>
                        <?php if ($immobilie->flaechen->anzahl_sep_wc): ?>
                        <li><strong>WC:</strong> <?php echo $immobilie->flaechen->anzahl_sep_wc; ?></li>
                        <?php endif; ?>
                        <?php if ($immobilie->flaechen->anzahl_balkon_terrassen): ?>
                        <li><strong>Balkon/Terrassen:</strong> <?php echo $immobilie->flaechen->anzahl_balkon_terrassen; ?>
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
                        <?php if(count($epass_hwbwert)): ?>
                            <li>
                                <strong>HWB:</strong>
                                <?php $epass_hwbklasse = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_hwbklasse"]'); ?>
                                <?php $epass_hwbklasse_farbe = array('A++' => '#00ADEF', 'A+' => '#0084B5', 'A' => '#00954D', 'B' => '#0CB14B', 'C' => '#99CA3C', 'D'=> '#EDE824', 'E' => '#F0B41C', 'F' => '#DF7527' ,'G' => '#E33226'); ?>
                                <?php if(count($epass_hwbklasse) && isset($epass_hwbklasse_farbe[(string)$epass_hwbklasse[0]])): ?>
                                    <span style="color: #ffffff; background-color:<?php echo $epass_hwbklasse_farbe[(string)$epass_hwbklasse[0]]; ?>">&nbsp;<?php echo (string)$epass_hwbklasse[0]; ?>&nbsp;</span>
                                <?php endif; ?>
                                <?php echo number_format((float) $epass_hwbwert[0], 2, ',', '.') ?> kWh/m²a
                            </li>
                        <?php endif; ?>

                        <?php $epass_fgeewert = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_fgeewert"]'); ?>
                        <?php if(count($epass_fgeewert)): ?>
                            <li>
                                <strong>FGEE:</strong>
                                <?php $epass_fgeeklasse = $immobilie->xpath('.//zustand_angaben/user_defined_simplefield[@feldname="epass_fgeeklasse"]'); ?>
                                <?php $epass_fgeeklasse_farbe = array('A++' => '#00ADEF', 'A+' => '#0084B5', 'A' => '#00954D', 'B' => '#0CB14B', 'C' => '#99CA3C', 'D'=> '#EDE824', 'E' => '#F0B41C', 'F' => '#DF7527' ,'G' => '#E33226'); ?>
                                <?php if(count($epass_fgeeklasse) && isset($epass_fgeeklasse_farbe[(string)$epass_fgeeklasse[0]])): ?>
                                    <span style="color: #ffffff; background-color:<?php echo $epass_fgeeklasse_farbe[(string)$epass_fgeeklasse[0]]; ?>">&nbsp;<?php echo (string)$epass_fgeeklasse[0]; ?>&nbsp;</span>
                                <?php endif; ?>
                                <?php echo number_format((float) $epass_fgeewert[0], 2, ',', '.') ?>
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
                            <?php echo $immobilie->kontaktperson->vorname . ' ' . $immobilie->kontaktperson->name; ?><br/>
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
                    </div>
                </div>

    </div>
    <div class="clear"></div>
</div>

		</div><!-- /.grid_12 -->
	</div><!-- /.container -->
</div>
</div>
</div>
</div>
</div><!-- /#content -->

<?php get_footer(); ?>
