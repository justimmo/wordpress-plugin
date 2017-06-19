<?php if ( $pager->haveToPaginate() ): ?>
	<?php
		$current_page = $pager->getPage();
		$max_page = $pager->getLastPage();
	?>
	<nav class="ji-pagination">
		<ul>
			<?php for ( $i = 1; $i <= $max_page; $i++ ): ?>
				<?php if ( $current_page == $i ): ?>
					<span><?php echo $i; ?></span>
				<?php else: ?>
					<a href="<?php echo add_query_arg( 'page', $i ) ?>"><?php echo $i; ?></a>
				<?php endif; ?>
			<?php endfor; ?>
		</ul>
	</nav>
<?php endif; ?>
