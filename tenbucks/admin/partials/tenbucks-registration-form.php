<div class="wrap">
	<h2 class="clear"><?php _e('Tenbucks', 'tenbucks'); ?></h2>
	<div id="notices" data-wait="<?php esc_attr_e(__('Please wait...', 'tenbucks')); ?>"></div>
    <form id="tenbucks_register_form" name="tenbucks_register_form" method="post">
        <fieldset>
            <legend><?php _e('Registration', 'tenbucks'); ?></legend>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row form-required">
                            <label for="email">* <?php _e('User email:', 'tenbucks'); ?></label>
                        </th>
                        <td>
                            <input name="email" id="email" value="<?php esc_attr_e(get_bloginfo('admin_email')); ?>" class="regular-text code" type="email" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row form-required">
                            <label for="email_confirmation">* <?php _e('Confirmation:', 'tenbucks'); ?></label>
                        </th>
                        <td>
                            <input name="email_confirmation" id="email_confirmation" value="<?php esc_attr_e(get_bloginfo('admin_email')); ?>" class="regular-text code" type="email" required>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="sponsor"><?php _e('Sponsor email:', 'tenbucks'); ?></label>
                        </th>
                        <td>
                            <input name="sponsor" id="sponsor" placeholder="<?php _e('Your sponsor email. Leave blank for none.', 'tenbucks'); ?>" class="regular-text code" type="email">
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <input name="submit" id="submit" class="button button-primary" value="<?php _e('Submit'); ?>" type="submit">
            </p>
        </fieldset>
    </form>
</div>
