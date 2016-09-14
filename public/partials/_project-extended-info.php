<section class="ji-info-section">
    <ul class="ji-info-list">
        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e( 'Locality:', 'jiwp' ); ?>
            </label>
            <span class="ji-info__value">
                <?php echo $project->getLocality(); ?>
            </span>
        </li>
        <li class="ji-info">
            <label class="ji-info__label">
                <?php _e( 'Address:', 'jiwp' ); ?>
            </label>
            <span class="ji-info__value">
                <?php

                    $address_array = array();

                    $zipCode =  $project->getZipCode();

                    if ( !empty( $zipCode ) )
                    {
                        $address_array[] = $zipCode;
                    }

                    $place = $project->getPlace();

                    if ( !empty( $place ) )
                    {
                        $address_array[] = $place;
                    }

                    $street = $project->getStreet();

                    if ( !empty( $street ) )
                    {
                        $address_array[] = $street;
                    }

                    $houseNumber = $project->getHouseNumber();

                    if ( !empty( $houseNumber ) )
                    {
                        $address_array[] = $houseNumber;
                    }

                    echo implode( ', ', $address_array );

                ?>
            </span>
        </li>
    </ul>
</section>

<?php $contact_info = $project->getContact(); ?>
<?php if ( !empty( $contact_info ) ): ?>
    <section class="ji-info-section ji-info-section--contact">
        <ul class="ji-info-list">
            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e( 'Contact Name:', 'jiwp' ); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $contact_info->getFirstName() . ' ' . $contact_info->getLastName(); ?>
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e( 'Contact Phone:', 'jiwp' ); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $contact_info->getPhone(); ?>
                </span>
            </li>

            <li class="ji-info">
                <label class="ji-info__label">
                    <?php _e( 'Contact E-mail:', 'jiwp' ); ?>
                </label>
                <span class="ji-info__value">
                    <?php echo $contact_info->getEmail(); ?>
                </span>
            </li>
        </ul>
    </section>
<?php endif; ?>

<section class="ji-info-section ji-info-section--description">
    <?php echo $project->getDescription(); ?>
</section>

<section class="ji-info-section ji-info-section--other-info">
    <?php echo $project->getMiscellaneous(); ?>
</section>