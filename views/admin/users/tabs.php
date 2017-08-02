<?php
if (!empty($template_vars['tabs'])) {
	?>
	<ul class="nav nav-tabs">
	<?php
	foreach($template_vars['tabs'] as $tab) {
		$cls = strlen(trim($tab['class'])) > 0?' class="active" ':'';
		?>
		<li role="presentation" <?php echo $cls; ?>><a href="<?php echo $tab['url']; ?>"><?php echo $tab['label']; ?></a></li>
		<?php
	}
	?>
	</ul>
	<?php
}
?>