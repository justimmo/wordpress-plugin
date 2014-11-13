<?php foreach ($objekte->immobilie as $immobilie): ?>
    <div class="ji_realty_shortlist">
        <?php if ($immobilie->erstes_bild) : ?>
        <a title="" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
            <img class="ji_realty_shortlist_pic" src="<?php echo $immobilie->erstes_bild ?>"/>
        </a>
        <?php endif; ?>

        <p class="ji_realty_shortlist_title">
            <a href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                <?php echo trim($immobilie->titel) != '' ? $immobilie->titel : $immobilie->id; ?>
            </a>
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

        <p>
        <?php if ($immobilie->wohnflaeche): ?>
            <span>Wohnfl&auml;che:</span> <?php echo number_format((float)$immobilie->wohnflaeche, 2, ',', '.'); ?>
            m<sup>2</sup>
        <?php elseif ($immobilie->grundstuecksflaeche): ?>
            <span>Grundst&uuml;cksfl&auml;che:</span> <?php echo number_format((float)$immobilie->grundstuecksflaeche, 2, ',', '.'); ?>
            m<sup>2</sup>
        <?php elseif ($immobilie->nutzflaeche): ?>
            <span>Nutzfl&auml;che:</span> <?php echo number_format((float)$immobilie->nutzflaeche, 2, ',', '.'); ?>
            m<sup>2</sup>
        <?php elseif ($immobilie->gesamtflaeche): ?>
            <span>Gesamtfl&auml;che:</span> <?php echo number_format((float)$immobilie->gesamtflaeche, 2, ',', '.'); ?>
            m<sup>2</sup>
        <?php endif; ?>
        </p>
    </div>
<?php endforeach; ?>
