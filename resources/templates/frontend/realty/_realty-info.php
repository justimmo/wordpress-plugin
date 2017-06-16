<?php /** @var Justimmo\Model\Realty $realty */ ?>

<ul class="ji-info-list">

    <li class="ji-info">

        <label class="ji-info__label">
            <?php _e('Realty Type:', 'jiwp'); ?>
        </label>
        
        <span class="ji-info__value">
            <?php echo $realty->getRealtyTypeName(); ?>
        </span>

    </li>

    <li class="ji-info">

        <label class="ji-info__label">
            <?php _e('For:', 'jiwp'); ?>
        </label>
        
        <span class="ji-info__value">
            <?php

            $marketingType = $realty->getMarketingType();

            if ($marketingType['KAUF'] == true) {
                _e('Purchase', 'jiwp');
            } else {
                _e('Rent', 'jiwp');
            }

            ?>
        </span>

    </li>

    <?php

    $price_text = '';
    $currency = empty($realty->getCurrency()) ? 'EUR' : $realty->getCurrency();

    if ($marketingType['KAUF'] == true) {
        if (!empty($realty->getPurchasePrice())) {
            $price_text = Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getPurchasePrice(), $currency, 0);
        }
    } else {
        if (!empty($realty->getTotalRent())) {
            $price_text = Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getTotalRent(), $currency, 0);
        }
    }
    ?>

    <?php if (!empty($price_text)) : ?>

        <li class="ji-info">

            <label class="ji-info__label">
                <?php _e('Price:', 'jiwp'); ?>
            </label>
            
            <span class="ji-info__value">
                <?php echo $price_text; ?>
            </span>
        </li>

    <?php endif; ?>

    <?php if ($surface_area = $realty->getSurfaceArea()) : ?>

        <li class="ji-info">

            <label class="ji-info__label">
                <?php _e('Surface Area:', 'jiwp'); ?>
            </label>
            
            <span class="ji-info__value">
                <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($surface_area) . ' m&sup2;'; ?>
            </span>

        </li>

    <?php endif; ?>

    <?php if ($room_count = $realty->getRoomCount()) : ?>

        <li class="ji-info">

            <label class="ji-info__label">
                <?php _e('Rooms:', 'jiwp'); ?>
            </label>
            
            <span class="ji-info__value">
                <?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($room_count); ?>
            </span>

        </li>

    <?php endif; ?>

</ul>
