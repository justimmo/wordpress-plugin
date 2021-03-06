<?php if ( ! empty( $realty ) ) : ?>
    <div class="ji-inquiry-messages"></div>

    <form action="" class="ji-inquiry-form">
        <input type="hidden" name="realty_id" value="<?php echo $realty->getId(); ?>">
        <p>
            <label for="contact_salutation"><?php _e( 'Salutation', 'jiwp' ); ?></label>
            <select name="contact_salutation" id="contact_salutation">
                <option value="">-</option>
                <option value="1"><?php _e( 'Mr.', 'jiwp' ); ?></option>
                <option value="2"><?php _e( 'Ms.', 'jiwp' ); ?></option>
            </select>
        </p>

        <p>
            <label for="contact_first_name"><?php _e( 'First Name', 'jiwp' ); ?> *</label>
            <input type="text" id="contact_first_name" name="contact_first_name" placeholder="<?php _e( 'First Name',
                'jiwp' ); ?>" required/>
        </p>

        <p>
            <label for="contact_last_name"><?php _e( 'Last Name', 'jiwp' ); ?> *</label>
            <input type="text" id="contact_last_name" name="contact_last_name" placeholder="<?php _e( 'Last Name',
                'jiwp' ); ?>" required/>
        </p>
        <p>
            <label for="contact_email"><?php _e( 'Email', 'jiwp' ); ?> *</label>
            <input type="email" id="contact_email" name="contact_email" placeholder="<?php _e( 'Email',
                'jiwp' ); ?>" required/>
        </p>
        <p>
            <label for="contact_phone"><?php _e( 'Phone', 'jiwp' ); ?></label>
            <input type="text" id="contact_phone" name="contact_phone" placeholder="<?php _e( 'Phone', 'jiwp' ); ?>"/>
        </p>
        <p>
            <label for="contact_street"><?php _e( 'Street', 'jiwp' ); ?></label>
            <input type="text" id="contact_street" name="contact_street" placeholder="<?php _e( 'Street',
                'jiwp' ); ?>"/>
        </p>
        <p>
            <label for="contact_zipcode"><?php _e( 'Zipcode', 'jiwp' ); ?></label>
            <input type="text" id="contact_zipcode" name="contact_zipcode" placeholder="<?php _e( 'Zipcode',
                'jiwp' ); ?>"/>
        </p>
        <p>
            <label for="contact_city"><?php _e( 'City', 'jiwp' ); ?></label>
            <input type="text" id="contact_city" name="contact_city" placeholder="<?php _e( 'City', 'jiwp' ); ?>"/>
        </p>
        <p>
            <label for="contact_message"><?php _e( 'Message', 'jiwp' ); ?></label>
            <textarea id="contact_message" name="contact_message" required><?php echo __( 'I am interested in this property: ',
                        'jiwp' ) . $realty->getPropertyNumber(); ?></textarea>
        </p>
        <p><?php _e( 'Fields marked with an * are mandatory.', 'jiwp' ); ?></p>
        <p>
            <button class="ji-realty__more-link"><?php _e( 'Request Info', 'jiwp' ); ?></button>
        </p>
    </form>
<?php endif; ?>
