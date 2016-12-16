<section class="ji-info-section ji-info-section--address">
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