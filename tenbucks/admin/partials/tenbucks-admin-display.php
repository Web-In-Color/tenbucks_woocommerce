<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.tenbucks.io
 * @since      1.0.0
 *
 * @package    Tenbucks
 * @subpackage Tenbucks/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h2 class="clear"><?php _e('Tenbucks', 'tenbucks'); ?></h2>
	<?php foreach ($this->notice as $notice) { ?>
		<div class="notice notice-<?php echo $notice['type']; ?>">
			<p><?php echo $notice['message']; ?></p>
		</div>
	<?php } ?>

	<?php if ($display_generation_btn) { ?>
		<div id="tenbucks-kgn" class="notice notice-info">
			<h4><?php _e('Tenbucks need API keys to interact with your shop. Click on below button to generate it automaticly.', 'tenbucks'); ?></h4>
			<p>
				<button type="button" class="button-primary tenbucks-action-btn" name="tb-generate"><?php _e('Generate keys', 'tenbucks'); ?></button>
				<button type="button" class="button tenbucks-action-btn" name="tb-hide_notice"><?php _e('Do not show again', 'tenbucks'); ?></button>
			</p>
		</div>
	<?php } ?>
	<?php if ($display_iframe) { ?>
	<iframe id="tenbucks-iframe" name="tenbucks-iframe" src="<?php echo $iframe_url; ?>" frameborder="0"></iframe>
	<hr />
	<p><a href="<?php echo $standalone_url; ?>" target="_blank"><?php _e('Use addons on our website', 'tenbucks'); ?></a>. <small>(<?php _e('No iframe', 'tenbucks'); ?>)</small></p>
	<?php } else { ?>
		<p><?php _e('Please correct above error(s) before use this plugin', 'tenbucks'); ?></p>
	<?php } ?>
</div>
