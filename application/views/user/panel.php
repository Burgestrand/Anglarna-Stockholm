<?php
    /**
     * An intelligent view. Includes the correct view depending on if the
     * user is logged in or not.
     */
    $auth = Auth::instance();
    $user = $auth->get_user();
    
    // No panel if not logged in
    if ( ! $auth->logged_in())
    {
        return;
    }
?>
<div class="section panel">
    <div class="wrap">
        <p class="status">
            Du är inloggad som <?php echo html::anchor('user', html::chars($user->username)) ?>
        </p>
        <p class="actions">
            <?php echo html::anchor('user/logout?referrer=' . rawurlencode(Request::instance()->controller), '[ Logga ut ]') ?>
        </p>
    </div>
</div>