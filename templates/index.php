<?php get_header(); ?>

<div <?php if (is_active_sidebar('jiapi')) : ?>class="bg_content"<?php endif; ?>>
    <div class="clear"></div>
    <div id="jsHolder" style="display: none"></div>
    <div id="listDiv">
        <script type="text/javascript">
            //<![CDATA[
            function submitForm(append) {
                $('maxPerPageForm' + append).submit();
            }
            //]]>
        </script>

        <?php if (is_object($objekte) && count($objekte->immobilie) > 0): ?>

            <div class="bg_objectSearchListHeader">
                <p class="bg_numberObject"><?php echo $ji_obj_list->getTotalCount() ?> Objekte </p>
                <div style="float:left;">
                    Sortieren nach:
                    <a href="<?php echo esc_url( get_permalink().'&orderby=sort_preis' ); ?>">Preis</a> |
                    <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&orderby=sort_flaeche">Fläche</a> |
                    <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&orderby=ort">Ort</a> |
                    <a href="<?php echo $ji_api_wp_plugin->getIndexUrl(); ?>&orderby=plz">PLZ</a>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>

            <div class="bg_objectSearchList">

                <?php $i = 1; ?>
                <?php foreach ($objekte->immobilie as $immobilie): ?>
                    <div class="bg_objectSearchListEntry">

                        <div class="bg_smallImage">
                            <?php if ($immobilie->erstes_bild) : ?>
                                <div class="fusion-imageframe imageframe-none imageframe-12 hover-type-zoomin">
                                    <a class="fusion-no-lightbox" title="" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                                        <img class="img-responsive ji_realty_shortlist_pic" src="<?php echo $immobilie->erstes_bild ?>"/>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="bg_compactInfos">

                            <h2 class="bg_listTitle">
                                <a href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                                    <?php echo trim($immobilie->titel) != '' ? $immobilie->titel : $immobilie->id; ?>
                                </a>
                            </h2>

                            <div class="bg_objectSearchListMeta">
                                <table width="100%">
                                    <tr>
                                        <td width="110">PLZ / Ort:</td>
                                        <td><?php echo $immobilie->plz; ?><?php echo $immobilie->ort; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Objektnr.:</td>
                                        <td><?php echo $immobilie->objektnummer; ?></td>
                                    </tr>


                                    <?php if ($immobilie->wohnflaeche): ?>
                                        <tr>
                                            <td>Wohnfläche:</td>
                                            <td><?php echo number_format((float)$immobilie->wohnflaeche, 2, ',', '.'); ?>
                                                m²
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($immobilie->grundstuecksflaeche): ?>
                                        <tr>
                                            <td>Grundstücksfläche:</td>
                                            <td><?php echo number_format((float)$immobilie->grundflaeche, 2, ',', '.'); ?>
                                                m²
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($immobilie->nutzflaeche): ?>
                                        <tr>
                                            <td>Nutzfläche:</td>
                                            <td><?php echo number_format((float)$immobilie->nutzflaeche, 2, ',', '.'); ?>
                                                m²
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php if ($immobilie->zimmer) : ?>
                                        <tr>
                                            <td>Zimmer:</td>
                                            <td><?php echo $immobilie->zimmer; ?></td>
                                        </tr>
                                    <?php endif; ?>

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
                                </table>
                            </div>

                        </div>

                        <div class="clear"></div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>

            </div>
            <div class="bg_objectSearchListFooter">
                <?php include('_pager.php'); ?>
            </div>
        <?php else: ?>
            <h2>Keine Ergebnisse</h2>
        <?php endif; ?>
    </div>
</div>

<?php if (is_active_sidebar('jiapi')) : ?>
    <?php dynamic_sidebar('jiapi'); ?>
<?php else : ?>
    <!-- Create some custom HTML or call the_widget().  It's up to you. -->
<?php endif; ?>
<div class="clear"></div>
<?php get_footer(); ?>
