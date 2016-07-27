<?php if ( $realties->haveToPaginate() ): ?>

	<?php

		$current_page = $realties->getPage();
		$max_page = $realties->getLastPage();

	?>

	<nav class="ji-pagination">
		<ul>

			<?php for ( $i = 1; $i <= $max_page; $i++ ): ?>

				<?php if ( $current_page == $i ): ?>

					<span><?php echo $i; ?></span>

				<?php else: ?>

					<a href="<?php echo $pager_url . 'page=' . $i; ?>"><?php echo $i; ?></a>

				<?php endif; ?>

			<?php endfor; ?>
			
		</ul>
	</nav>

<?php endif; ?>