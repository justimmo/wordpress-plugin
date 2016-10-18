<?php if (!empty($realty)) : ?>
<form action="" class="ji-inquiry-form">
    <input type="hidden" name="realty_id" value="<?php echo $realty->getId(); ?>">
    <p>
        <label for="contact_salutation"><?php _e('Salutation', 'jiwp'); ?></label>
        <select name="contact_salutation" id="contact_salutation">
            <option value="">-</option>
            <option value="1"><?php _e('Mr.', 'jiwp'); ?></option>
            <option value="2"><?php _e('Ms.', 'jiwp'); ?></option>
        </select>
    </p>
    <p>
        <label for="contact_title"><?php _e('Title', 'jiwp'); ?></label>
        <input type="text" id="contact_title" name="contact_title" placeholder="<?php _e('Title', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_first_name"><?php _e('First Name', 'jiwp'); ?></label>
        <input type="text" id="contact_first_name" name="contact_first_name" placeholder="<?php _e('First Name', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_last_name"><?php _e('Last Name', 'jiwp'); ?></label>
        <input type="text" id="contact_last_name" name="contact_last_name" placeholder="<?php _e('Last Name', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_email"><?php _e('Email', 'jiwp'); ?></label>
        <input type="text" id="contact_email" name="contact_email" placeholder="<?php _e('Email', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_phone"><?php _e('Phone', 'jiwp'); ?></label>
        <input type="text" id="contact_phone" name="contact_phone" placeholder="<?php _e('Phone', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_street"><?php _e('Street', 'jiwp'); ?></label>
        <input type="text" id="contact_street" name="contact_street" placeholder="<?php _e('Street', 'jiwp'); ?>"/>
    </p>
    <p>
        <label for="contact_zipcode_city"><?php _e('Zipcode / City', 'jiwp'); ?></label>
        <select name="contact_zipcode_city" id="contact_zipcode_city">
            <option value="">-</option>
            <?php foreach ($cities as $city_id => $city) : ?>
                <option value="<?php echo $city['zipCode'] . '|' . $city['place'] ; ?>">
                    <?php echo $city['zipCode'] . ' (' . $city['place'] . ')' ; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="contact_country"><?php _e('Country', 'jiwp'); ?></label>
        <select name="contact_country" id="contact_country">
            <option value="">-</option>
            <?php foreach ($countries as $country_id => $country) : ?>
                <option value="<?php echo $country['iso2']; ?>">
                    <?php echo $country['name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <button><?php _e('Send Inquiry', 'jiwp'); ?></button>
</form>
<?php endif; ?>