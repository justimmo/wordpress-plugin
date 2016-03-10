<?php $i = 0 ?>
<?php foreach ($objekte->immobilie as $immobilie): ?>
    <?php $i++ ?>
    <div class="ji_immoCard fusion-one-fourth fusion-layout-column fusion-spacing-yes <?php echo ($i % 4 == 0) ? 'fusion-column-last' : '' ?>" style="margin-top:0; margin-bottom:3%;">
        <div class="fusion-column-wrapper">
            <div class="ji_realty_shortlist">
                <?php if ($immobilie->erstes_bild) : ?>
                    <div class="imageframe-align-center">
                        <span class="fusion-imageframe imageframe-none imageframe-12 hover-type-zoomin">
                            <a title="" class="fusion-no-lightbox" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                                <img class="img-responsive ji_realty_shortlist_pic" src="<?php //echo $immobilie->erstes_bild; ?><?php echo preg_replace('/(https:\/\/[^\/]*\/[^\/]*\/[^\/]*)\/[^\/]*\/(.*)/', '$1/s800x600bc/$2', $immobilie->erstes_bild); ?>"/>
                            </a>
                        </span>
                    </div>
                <?php endif; ?>
                <div class="ji_immoCard_content">
                    <h2>
                        <a href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                            <?php echo trim($immobilie->titel) != '' ? $immobilie->titel : $immobilie->id; ?>
                        </a>
                    </h2>

                    <?php if ($immobilie->plz) : ?>
                        <p>
                            <?php echo $immobilie->plz; ?> <?php echo $immobilie->ort; ?>
                        </p>
                    <?php endif; ?>

                    <p>
                        <?php if ($immobilie->wohnflaeche): ?>
                            ca. <?php echo number_format((float)$immobilie->wohnflaeche, 2, ',', '.'); ?> m<sup>2</sup> <span>Wohnfl&auml;che</span>
                        <?php elseif ($immobilie->grundstuecksflaeche): ?>
                            ca. <?php echo number_format((float)$immobilie->grundstuecksflaeche, 2, ',', '.'); ?> m<sup>2</sup> <span>Grundst&uuml;cksfl&auml;che</span>
                        <?php elseif ($immobilie->nutzflaeche): ?>
                            <?php echo number_format((float)$immobilie->nutzflaeche, 2, ',', '.'); ?> m<sup>2</sup> <span>Nutzfl&auml;che</span>
                        <?php elseif ($immobilie->gesamtflaeche): ?>
                            <?php echo number_format((float)$immobilie->gesamtflaeche, 2, ',', '.'); ?> m<sup>2</sup> <span>Gesamtfl&auml;che</span>
                        <?php endif; ?>
                    </p>

                    <?php if ($immobilie->kaufpreis) : ?>
                        <p>
                            <?php if ((float)$immobilie->kaufpreis > 0): ?>
                                Kaufpreis: <?php echo number_format((float)$immobilie->kaufpreis, 2, ',', '.'); ?> &euro;
                            <?php else: ?>
                                Kaufpreis auf Anfrage
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($immobilie->gesamtmiete) : ?>
                        <p>
                            <?php if ((float)$immobilie->gesamtmiete > 0): ?>
                                Gesamtmiete: <?php echo number_format((float)$immobilie->gesamtmiete, 2, ',', '.'); ?> &euro;
                            <?php else: ?>
                                Miete auf Anfrage
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <a title="" class="fusion-button button-flat button-round button-large" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                        Mehr Infos
                    </a>
                </div>
            </div>
            <div class="fusion-clearfix"></div>
        </div>
    </div>
<?php endforeach; ?>