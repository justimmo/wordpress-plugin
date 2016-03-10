<?php foreach($regions as $region): ?>
        <li>
            <input type="checkbox" name="filter[region][]" value="<?php echo $region->id ?>" id="ji_region_<?php echo $region->id ?>" <?php echo isset($ji_obj_list->filter['region']) && in_array($region->id, $ji_obj_list->filter['region']) ? 'checked' : '' ?>>
            <label for="ji_region_<?php echo $region->id ?>"><?php echo $region->name ?></label>
        </li>
<?php endforeach; ?>
