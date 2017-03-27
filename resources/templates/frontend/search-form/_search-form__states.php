<div class="ji-states-container">

    <?php if (!empty($states)) : ?>

        <select class="ji-input ji-input--select js-get-cities" name="filter[state]">

            <option value=""></option>

            <?php foreach ($states as $state_id => $state) : ?>

                <option value="<?php echo $state_id; ?>"
                    <?php echo isset($_GET[ 'filter' ][ 'state' ]) && $state_id == $_GET[ 'filter' ][ 'state' ] ? 'selected=selected' : '' ?>>

                    <?php echo $state['name']; ?>

                </option>

            <?php endforeach; ?>

        </select>

    <?php else : ?>

        <?php if (empty($_POST[ 'country' ])) : ?>

            <span class="ji-search-form__no-data-msg">
                <?php _e('Please select a country first', 'jiwp'); ?>
            </span>

        <?php else : ?>
            
            <span class="ji-search-form__no-data-msg">
                <?php _e('No states found for selected country', 'jiwp'); ?>
            </span>

        <?php endif; ?>

    <?php endif; ?>

</div>