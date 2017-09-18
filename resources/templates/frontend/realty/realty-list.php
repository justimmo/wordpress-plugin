<?php

use Justimmo\Wordpress\Helper\NumberFormatter;

?>
<section class="ji-realties-container">
    <?php /** @var Justimmo\Pager\ListPager $pager */ ?>
    <?php if (count($pager)) : ?>
        <ul class="ji-realty-list <?php echo $realty_list_class; ?>">
            <?php foreach ($pager as $realty) : ?>
                <li class="ji-realty-list__item">
                    <article class="ji-realty ji-realty--list-item">
                        <header class="ji-realty__header">
                            <?php /** @var \Justimmo\Model\Attachment[] $photos_array */
                            /** @var \Justimmo\Model\Realty $realty */
                            $photos_array = $realty->getPictures(); ?>

                            <?php if (count($photos_array)) : ?>
                                <?php

                                try {
                                    $img_src = $photos_array[0]->getUrl('medium');
                                } catch (Exception $e) {
                                    $img_src = $photos_array[0]->getUrl();
                                }

                                ?>

                                <a href="<?php echo Justimmo\Wordpress\Routing::getRealtyUrl($realty); ?>">
                                    <img src="<?php echo $img_src; ?>" class="ji-realty__featured-img" alt=''/>
                                </a>
                            <?php endif; ?>

                            <h1 class="ji-realty__title">
                                <a href="<?php echo Justimmo\Wordpress\Routing::getRealtyUrl($realty); ?>">
                                    <?php $realty_title = $realty->getTitle(); ?>
                                    <?php if (!empty($realty_title)) : ?>
                                        <?php echo $realty->getTitle(); ?>
                                    <?php else : ?>
                                        <?php

                                        echo $realty->getRealtyTypeName()
                                            . ' '
                                            . __('in', 'jiwp')
                                            . ' '
                                            . $realty->getCountry()
                                            . ' / '
                                            . $realty->getFederalState();

                                        ?>
                                    <?php endif; ?>
                                </a>
                            </h1>

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
                                        $price_text = NumberFormatter::formatCurrency(
                                            $realty->getPurchasePrice(),
                                            $currency,
                                            0
                                        );
                                    }
                                } else {
                                    if (!empty($realty->getTotalRent())) {
                                        $price_text = NumberFormatter::formatCurrency(
                                            $realty->getTotalRent(),
                                            $currency,
                                            0
                                        );
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

                                <?php $surface_area = $realty->getSurfaceArea(); ?>
                                <?php if (!empty($surface_area)) : ?>
                                    <li class="ji-info">
                                        <label class="ji-info__label">
                                            <?php _e('Surface Area:', 'jiwp'); ?>
                                        </label>
                                        <span class="ji-info__value">
                                            <?php echo NumberFormatter::format($surface_area) . ' m&sup2;'; ?>
                                        </span>
                                    </li>
                                <?php endif; ?>

                                <?php $room_count = $realty->getRoomCount(); ?>
                                <?php if (!empty($room_count)) : ?>
                                    <li class="ji-info">
                                        <label class="ji-info__label">
                                            <?php _e('Rooms:', 'jiwp'); ?>
                                        </label>
                                        <span class="ji-info__value">
                                            <?php echo NumberFormatter::format($room_count); ?>
                                        </span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </header>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php include(Justimmo\Wordpress\Templating::getPath('_pagination.php')); ?>
    <?php else : ?>
        <h3 class="ji-no-realties"><?php _e('No realties found', 'jiwp'); ?></h3>
    <?php endif; ?>
</section>