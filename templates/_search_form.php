<div class="">
    <form action="<?php echo $ji_api_wp_plugin->getIndexUrl() ?>" method="post">
        <div class="form-group">
            <input type="hidden" value="filter" name="reset">

            <label class="control-label">Objektnummer</label>
            <input type="text" class="numberDE bg_textfield" size="10" value="" id="object_own_id" name="filter[objektnummer]">

            <input type="submit" class="fusion-button button-flat button-round button-large button-default" value="Suchen">
        </div>
    </form>
    <hr>
    <form action="<?php echo $ji_api_wp_plugin->getIndexUrl() ?>" method="post">
        <input type="hidden" value="filter" name="reset">
        <div class="form-group">
            <label class="control-label">Erwerb:</label>
            <ul>
                <li>
                    <input type="checkbox" value="1" id="filters_miete" name="filter[miete]">
                    <label for="filters_miete">Miete</label>
                </li>

                <li>
                    <input type="checkbox" value="anlage" id="filters_investment" name="filter[nutzungsart]">
                    <label for="filters_investment">Investment</label>
                </li>

                <li>
                    <input type="checkbox" value="1" id="filters_kauf" name="filter[kauf]">
                    <label for="filters_kauf">Kauf</label>
                </li>
            </ul>
        </div>
        <div class="form-group">
            <label class="control-label">Objektart:</label>
            <select name="filter[objektart_id][]" size="1">
                <option value=""></option>
                <?php foreach($objektarten as $i => $objektart): ?>
                    <option value="<?php echo $i ?>"><?php echo $objektart ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Ort:</label>
            <select id="ji_searchbar_states" name="filter[bundesland_id]">
                <option value=""></option>
                <option value="AT">Österreich</option>
                <?php foreach($ji_api_wp_plugin->getClient()->getBundeslaender()->bundesland as $bundesland): ?>
                    <option value="<?php echo $bundesland->id ?>">&nbsp;&nbsp;<?php echo $bundesland->name ?></option>
                <?php endforeach; ?>
                <option value="FOREIGN">Ausland</option>
            </select>
        </div>
        <div class="form-group">
            <?php /*
            <label class="control-label">Zimmer:</label>
            <div class="toggle-btn-grp-zimmer">
                <div><input type="checkbox" name="zimmer" data-zimmer="1"/><label onclick="" class="toggle-btn">1</label></div>
                <div><input type="checkbox" name="zimmer" data-zimmer="2"/><label onclick="" class="toggle-btn">2</label></div>
                <div><input type="checkbox" name="zimmer" data-zimmer="3"/><label onclick="" class="toggle-btn">3</label></div>
                <div><input type="checkbox" name="zimmer" data-zimmer="4"/><label onclick="" class="toggle-btn">4</label></div>
                <div><input type="checkbox" name="zimmer" data-zimmer=""/><label onclick="" class="toggle-btn">+</label></div>
            </div>

            <input type="hidden" value="" name="filter[zimmer_von]">
            <input type="hidden" value="" name="filter[zimmer_bis]">

            */ ?>

            <input type="submit" class="fusion-button button-flat button-round button-large button-default" value="Suchen">
        </div>
    </form>
</div>
<?php /*
<script type="application/javascript">
    $(".toggle-btn-grp-zimmer input[type=checkbox]").change(function() {
        if($(this).is(':checked')) {
            $(".toggle-btn-grp-zimmer input[type=checkbox]").attr('checked', false);
            $(this).attr('checked', true);
            $("input[name=filter\\[zimmer_von\\]]").val($(this).data('zimmer'));
            $("input[name=filter\\[zimmer_bis\\]]").val($(this).data('zimmer'));
        } else {
            $(".toggle-btn-grp-zimmer input[type=checkbox]").attr('checked', false);
            $("input[name=filter\\[zimmer_von\\]]").val("");
            $("input[name=filter\\[zimmer_bis\\]]").val("");
        }
    })
</script>
*/ ?>
