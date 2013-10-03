<?php get_header(); ?>

<script type="text/javascript">
	var myScroll = false;
	var tmyscrollresize = function(){
		var cur_cont_height = jQuery('.customScrollBox').height();
		var cur_viewport_height = jQuery(window).height()*0.8;
		if(myScroll){
			if(cur_cont_height >= cur_viewport_height){
				jQuery('#mcs_container').height(cur_viewport_height);
				myScroll.refresh();
			}else{
				jQuery('#mcs_container').height(cur_cont_height);
				myScroll.scrollTo(0, 0, 10);
				myScroll.destroy();
				myScroll = false;
			}
		}else{
			if(cur_cont_height >= cur_viewport_height){
				jQuery('#mcs_container').height(cur_viewport_height);
				myScroll = new iScroll('mcs_container', { zoom: true, vScroll: true, onBeforeScrollStart: function(e){var target = e.target;while (target.nodeType != 1) target = target.parentNode;if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA'){/*e.preventDefault();*/ }} });
			}
		}
	}
	jQuery(document).ready(function() {
		var cur_cont_height = jQuery('#mcs_container').height();
		var cur_viewport_height = jQuery(window).height()*0.8;
		var cur_cont_height2 = jQuery('.customScrollBox').height();
		if(cur_cont_height >= cur_viewport_height){
			//alert(cur_cont_height);
			jQuery('#mcs_container').height(cur_viewport_height);
			//jQuery('#mcs_container .customScrollBox').height(cur_cont_height2+50);
			//jQuery('#mcs_container .customScrollBox').css({'-moz-transform': 'translate(0px, '+cur_cont_height+'px) scale(1)'});
				//jQuery('#mcs_container').css({'opacity':'0'});
			setTimeout(function () {
				myScroll = new iScroll('mcs_container', { zoom: true, vScroll: true, onBeforeScrollStart: function(e){var target = e.target;while (target.nodeType != 1) target = target.parentNode;if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA'){/*e.preventDefault();*/ }} });
				jQuery(window).resize(tmyscrollresize);
			}, 100);
		}else{
			jQuery(window).resize(tmyscrollresize);
		}
	});
</script>

<div id="content">
<div id="mcs_container">
<div class="customScrollBox">
<div class="container">
<div class="content">
	<div class="container_12">
		<div class="grid_12">

<div <?php if (is_active_sidebar('jiapi')) : ?>class="bg_content"<?php endif; ?>>
    <div class="clear"></div>
    <div id="jsHolder" style="display: none"></div>
    <div id="listDiv">
        <script type="text/javascript">
            //<![CDATA[
            function submitForm(append) {
                $('maxPerPageForm' + append).submit();
            }
            //]]>
        </script>

        <?php if (is_object($objekte) && count($objekte->immobilie) > 0): ?>
        <div class="bg_objectSearchList">
            <div class="bg_objectSearchListHeader">
                <div style="float:left;">
                    <h1 class="bg_numberObject"><?php echo $ji_obj_list->getTotalCount() ?> Objekte </h1>
                </div>
                <div style="float:right;">
                    Sortieren nach:
                    <a href="?orderby=ort">Ort</a> |
                    <a href="?orderby=kaufpreis">Kaufpreis</a> |
                    <a href="?orderby=gesamtmiete">Miete</a> |
                    <a href="?orderby=wohnflaeche">Fläche</a> |
                    <a href="?orderby=zimmer">Zimmer</a> |
                    <a href="?orderby=plz">PLZ</a>
                </div>

                <div class="clear"></div>
            </div>

            <div class="clear"></div>
            <?php $i = 1; ?>
            <?php foreach ($objekte->immobilie as $immobilie): ?>
            <div class="bg_objectSearchListEntry">

                <div class="bg_smallImage">
                    <?php if ($immobilie->erstes_bild) : ?>
                    <a title="" href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                        <img src="<?php echo $immobilie->erstes_bild ?>"/>
                    </a>
                    <?php endif; ?>

                </div>


                <div id="bg_compactInfos">
                    <div>
                        <h2 class="bg_listTitle">
                            <a href="<?php echo $ji_api_wp_plugin->getPropertyUrl($immobilie->id); ?>">
                                <?php echo trim($immobilie->titel) != '' ? $immobilie->titel : $immobilie->id; ?>
                            </a>
                        </h2>


                        <div class="bg_objectSearchListMeta">
                            <table width="100%">
                                <tr>
                                    <td width="110">Plz / Ort:</td>
                                    <td><?php echo $immobilie->plz; ?> <?php echo $immobilie->ort; ?></td>
                                </tr>
                                <tr>
                                    <td>Objektnr.:</td>
                                    <td><?php echo $immobilie->objektnummer; ?></td>
                                </tr>


                                <?php if ($immobilie->wohnflaeche): ?>
                                <tr>
                                    <td>Wohnfläche:</td>
                                    <td>ca. <?php echo number_format((float)$immobilie->wohnflaeche, 2, ',', '.'); ?> m²</td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($immobilie->grundstuecksflaeche): ?>
                                   <tr>
                                         <td>Grundstücksfläche:</td>
                                          <td><?php echo number_format((float)$immobilie->grundflaeche, 2, ',', '.'); ?> m²</td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($immobilie->nutzflaeche): ?>
                                <tr>
                                    <td>Nutzfläche:</td>
                                    <td><?php echo number_format((float)$immobilie->nutzflaeche, 2, ',', '.'); ?> m²</td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($immobilie->zimmer) : ?>
                                <tr>
                                    <td>Zimmer:</td>
                                    <td><?php echo $immobilie->zimmer; ?></td>
                                </tr>
                                <?php endif; ?>

                                <?php if ($immobilie->kaufpreis) : ?>
                                <?php if ((float)$immobilie->kaufpreis > 0): ?>
                                    <tr>
                                    <td>Kaufpreis:</td>
                                    <td><?php echo number_format((float)$immobilie->kaufpreis, 2, ',', '.'); ?> &euro;</td>
                                    </tr>
                                    <?php else: ?>
                                    <tr>
                                    <td colspan="2">Kaufpreis auf Anfrage</td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if ($immobilie->gesamtmiete) : ?>
                                <?php if ((float)$immobilie->gesamtmiete > 0): ?>
                                    <tr>
                                    <td>Gesamtmiete:</td>
                                    <td><?php echo number_format((float)$immobilie->gesamtmiete, 2, ',', '.'); ?> &euro;</td>
                                    </tr>
                                    <?php else: ?>
                                    <tr>
                                    <td colspan="2">Miete auf Anfrage</td>
                                    </tr>
                                    <?php endif; ?>
                                <?php endif; ?>


                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="clear"></div>
            <?php $i++; ?>
            <?php endforeach; ?>

            <div class="bg_objectSearchListFooter">
                <?php include('_pager.php'); ?>
            </div>
        </div>
        <?php else: ?>
        <h2>Keine Ergebnisse</h2>
        <?php endif; ?>
    </div>
</div>

<?php if (is_active_sidebar('jiapi')) : ?>
<?php dynamic_sidebar('jiapi'); ?>
<?php else : ?>
<!-- Create some custom HTML or call the_widget().  It's up to you. -->
<?php endif; ?>

		</div><!-- /.grid_12 -->
	</div><!-- /.container -->
</div>
</div>
</div>
</div>
</div><!-- /#content -->

<?php get_footer(); ?>
