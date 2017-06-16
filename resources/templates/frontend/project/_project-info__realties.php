<?php $realties_array = $project->getRealties(); ?>

<?php if (count($realties_array)) : ?>

    <section class="ji-realty-list ji-realty-list--project">

        <h1 class="ji-realty-list__title"><?php echo _e('Project Realties:', 'jiwp'); ?></h1>

        <table class="project-realties">
            <thead>
                <tr>
                    <th><?php echo _e('Nb.', 'jiwp'); ?></th>
                    <th><?php echo _e('Floor', 'jiwp'); ?></th>
                    <th><?php echo _e('Living Area', 'jiwp'); ?></th>
                    <th><?php echo _e('Room Count', 'jiwp'); ?></th>
                    <th><?php echo _e('Balcony Surface', 'jiwp'); ?></th>
                    <th><?php echo _e('Terrace Surface', 'jiwp'); ?></th>
                    <th><?php echo _e('Garden Surface', 'jiwp'); ?></th>
                    
                    <?php $marketingType = $realties_array[0]->getMarketingType(); ?>

                    <?php if ($marketingType['KAUF'] == true) : ?>
                        <th><?php echo _e('Purchase Price', 'jiwp'); ?></th>
                    <?php else : ?>
                        <th><?php echo _e('Rent', 'jiwp'); ?></th>
                    <?php endif; ?>

                    <th><?php echo _e('Status', 'jiwp'); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($realties_array as $index => $realty) : ?>
                    <tr data-href="<?php echo Justimmo\Wordpress\Routing::getRealtyUrl($realty); ?>">
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo $realty->getTier(); ?></td>
                        <td><?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($realty->getLivingArea()); ?></td>
                        <td><?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($realty->getRoomCount()); ?></td>
                        <td><?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($realty->getBalconyArea()); ?></td>
                        <td><?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($realty->getTerraceArea()); ?></td>
                        <td><?php echo Justimmo\Wordpress\Helper\NumberFormatter::format($realty->getGardenArea()); ?></td>
                        <td>
                            <?php
                            $currency = empty($realty->getCurrency()) ? 'EUR' : $realty->getCurrency();

                            if ($marketingType['KAUF'] == true) {
                                echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getPurchasePrice(), $currency, 0);
                            } else {
                                echo Justimmo\Wordpress\Helper\NumberFormatter::formatCurrency($realty->getTotalRent(), $currency, 0);
                            }

                            ?>
                        </td>
                        <td><?php echo $realty->getStatus(); ?></td>
                        <td>
                            <a href="<?php echo Justimmo\Wordpress\Routing::getRealtyUrl($realty); ?>">
                                <?php _e('VIEW', 'jiwp'); ?>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </section>

<?php endif; ?>
