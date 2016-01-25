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

	<?php if ($display_iframe) { ?>
	<iframe id="tenbucks-iframe" name="tenbucks-iframe" src="<?php echo $iframe_url; ?>" frameborder="0"></iframe>
	<hr />
	<p><a href="<?php echo $standalone_url; ?>" target="_blank"><?php _e('Use addons on our website', 'wic-bridge'); ?></a>. <small>(<?php _e('No iframe', 'wic-bridge'); ?>)</small></p>
	<?php } else { ?>
		<p><?php _e('Please correct above error(s) before use this plugin', 'wic-bridge'); ?></p>
	<?php } ?>
</div>
