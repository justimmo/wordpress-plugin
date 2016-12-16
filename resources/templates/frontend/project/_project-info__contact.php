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