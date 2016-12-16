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
    $currency = $realty->getCurrency();

    if (empty($currency)) {
        $currency = 'EUR';
    }

    if ($marketingType['KAUF'] == true) {
        $purchase_price = $realty->getPurchasePrice();
        if (!empty($purchase_price)) {
            $price_text = money_format("%!i $currency", $purchase_price);
        }
    } else {
        $rent_price = $realty->getTotalRent();
        if (!empty($rent_price)) {
            $price_text = money_format("%!i $currency", $rent_price);
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
                <?php echo $surface_area . ' m&sup2;'; ?>
            </span>

        </li>

    <?php endif; ?>

    <?php if ($room_count = $realty->getRoomCount()) : ?>

        <li class="ji-info">

            <label class="ji-info__label">
                <?php _e('Rooms:', 'jiwp'); ?>
            </label>
            
            <span class="ji-info__value">
                <?php echo $room_count; ?>
            </span>

        </li>

    <?php endif; ?>

</ul>