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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($realties_array as $index => $realty) : ?>
                    <tr data-href="<?php echo get_bloginfo('url') . '/realties/' . $realty->getId() ?>">
                        <td>
                            <a href="<?php echo get_bloginfo('url') . '/realties/' . $realty->getId() ?>">
                                <?php echo $index + 1; ?>
                            </a>
                        </td>
                        <td><?php echo $realty->getTier(); ?></td>
                        <td><?php echo $realty->getLivingArea(); ?></td>
                        <td><?php echo $realty->getRoomCount(); ?></td>
                        <td><?php echo $realty->getBalconyArea(); ?></td>
                        <td><?php echo $realty->getTerraceArea(); ?></td>
                        <td><?php echo $realty->getGardenArea(); ?></td>
                        <td>
                            <?php

                            $currency = $realty->getCurrency();

                            if (empty($currency)) {
                                $currency = 'EUR';
                            }

                            if ($marketingType['KAUF'] == true) {
                                echo money_format("%!i $currency", $realty->getPurchasePrice());
                            } else {
                                echo money_format("%!i $currency", $realty->getTotalRent());
                            }

                            ?>
                        </td>
                        <td><?php echo $realty->getStatus(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </section>

<?php endif; ?>