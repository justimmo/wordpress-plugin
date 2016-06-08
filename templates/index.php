<?php get_header(); ?>
    <div id="jsHolder" style="display: none"></div>

    <script type="text/javascript">
        //<![CDATA[
        function submitForm(append) {
            $('maxPerPageForm' + append).submit();
        }
        //]]>
    </script>



    <div id="ji_listingsWrapper" class="<?php if (is_active_sidebar('jiapi')) : ?>ji_withSideBar<?php endif; ?> fusion-row">
        <div style="width: 100%;" id="content">
            <div class="post-content">
                <div style="border-color:#eae9e9;border-bottom-width: 0px;border-top-width: 0px;border-bottom-style: solid;border-top-style: solid;padding-bottom:20px;padding-top:20px;padding-left:;padding-right:;" class="fusion-fullwidth fullwidth-box fusion-fullwidth-1  fusion-parallax-none nonhundred-percent-fullwidth">

                    <div class="fusion-row">
                        <div style="margin-top:0px;margin-bottom:20px;" class="fusion-three-fourth fusion-layout-column fusion-spacing-yes">
                            <div class="fusion-column-wrapper">
                                <?php if (is_object($objekte) && count($objekte->immobilie) > 0): ?>
                                    <div class="ji_listingsHeader">
                                        <div class="ji_listingsCount"><?php echo $ji_obj_list->getTotalCount() ?> Objekte</div>
                                        <div> Sortieren nach:
                                            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>?orderby=sort_preis">Preis</a> |
                                            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>?orderby=sort_flaeche">Fläche</a> |
                                            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>?orderby=ort">Ort</a> |
                                            <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>?orderby=plz">PLZ</a>
                                        </div>
                                        <div class="clear"></div>
                                    </div>

                                    <table id="ji_listings">
                                        <?php $i = 1; ?>
                                        <?php foreach ($objekte->immobilie as $immobilie): ?>
                                            <tr class="ji_listing">
                                                <td>
                                                    <div class="ji_listingPreviewImage">
                                                        <?php if ($immobilie->erstes_bild): ?>
                                                            <div class="fusion-imageframe imageframe-none imageframe-12 hover-type-zoomin">
                                                                <a class="fusion-no-lightbox" title="" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie); ?>">
                                                                    <img alt="" class="img-responsive ji_realty_shortlist_pic" src="<?php echo $immobilie->erstes_bild ?>"/>
                                                                </a>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="fusion-imageframe imageframe-none imageframe-12 hover-type-zoomin">
                                                                <a class="fusion-no-lightbox" title="" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie); ?>">
                                                                    Kein Bild
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="ji_listingInfos">
                                                        <h2 class="bg_listTitle">
                                                            <a href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie) ?>"><?php echo trim($immobilie->titel) != '' ? $immobilie->titel : $immobilie->id; ?></a>
                                                        </h2>
                                                        <div class="ji_objectShortDescription">
                                                            <table>
                                                                <tr>
                                                                    <td width="110">PLZ / Ort:</td>
                                                                    <td><?php echo $immobilie->plz; ?> <?php echo $immobilie->ort; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Objektnr.:</td>
                                                                    <td><?php echo $immobilie->objektnummer; ?></td>
                                                                </tr>
                                                                <?php if ($immobilie->grundflaeche): ?>
                                                                    <tr>
                                                                        <td>Grundfläche:</td>
                                                                        <td>ca. <?php echo number_format((float)$immobilie->grundflaeche, 2, ',', '.'); ?> m²</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if ($immobilie->wohnflaeche): ?>
                                                                    <tr>
                                                                        <td>Wohnfläche:</td>
                                                                        <td>ca. <?php echo number_format((float)$immobilie->wohnflaeche, 2, ',', '.'); ?> m²</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if ($immobilie->grundstuecksflaeche): ?>
                                                                    <tr>
                                                                        <td>Grundstücksfläche:</td>
                                                                        <td>ca. <?php echo number_format((float)$immobilie->grundflaeche, 2, ',', '.'); ?> m²</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if ($immobilie->nutzflaeche): ?>
                                                                    <tr>
                                                                        <td>Nutzfläche:</td>
                                                                        <td>ca. <?php echo number_format((float)$immobilie->nutzflaeche, 2, ',', '.'); ?> m²</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if ($immobilie->zimmer) : ?>
                                                                    <tr>
                                                                        <td>Zimmer:</td>
                                                                        <td><?php echo $immobilie->zimmer; ?></td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if ((int)$immobilie->status_id == 5): ?>
                                                                    <?php if ($immobilie->kaufpreis) : ?>
                                                                        <?php if ((float)$immobilie->kaufpreis > 0): ?>
                                                                            <tr>
                                                                                <td>Kaufpreis:</td>
                                                                                <td><?php echo number_format((float)$immobilie->kaufpreis, 2, ',', '.'); ?> &euro;</td>
                                                                            </tr>
                                                                        <?php else: ?>
                                                                            <tr>
                                                                                <td colspan="2">Kaufpreis auf Anfrage</td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php if ($immobilie->gesamtmiete) : ?>
                                                                        <?php if ((float)$immobilie->gesamtmiete > 0): ?>
                                                                            <tr>
                                                                                <td>Gesamtmiete:</td>
                                                                                <td><?php echo number_format((float)$immobilie->gesamtmiete, 2, ',', '.'); ?> &euro;</td>
                                                                            </tr>
                                                                        <?php else: ?>
                                                                            <tr>
                                                                                <td colspan="2">Miete auf Anfrage</td>
                                                                            </tr>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <?php $i++; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>

                                    <div class="ji_listingsFooter">
                                        <?php include('_pager.php'); ?>
                                    </div>
                                <?php else: ?>
                                    <h2>Keine Ergebnisse</h2>
                                    <p>Wir konnten leider keine passenden Immobilien zu Ihren Suchkriterien finden.</p>
                                    <h3>Vorschläge:</h3>
                                    <ul>
                                        <li>Vergewissern Sie sich, dass die Objektnummer richtig geschrieben ist.</li>
                                        <li>Probieren Sie andere Suchkriterien.</li>
                                        <li>Probieren Sie allgemeinere Suchkriterien.</li>
                                    </ul>
                                <?php endif; ?>
                                <div class="fusion-clearfix"></div>
                            </div>
                        </div>

                        <?php if (is_active_sidebar('jiapi')) : ?>
                            <div style="margin-top:0; margin-bottom:20px;" class="fusion-one-fourth fusion-layout-column fusion-column-last fusion-spacing-yes">
                                <div class="fusion-column-wrapper">
                                    <?php dynamic_sidebar('jiapi'); ?>
                                    <div class="fusion-clearfix"></div>
                                </div>
                            </div>
                            <div class="fusion-clearfix"></div>
                        <?php else : ?>
                            <!-- Create some custom HTML or call the_widget().  It's up to you. -->
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>