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
        <p>
            Du är inloggad som <a><?php echo html::chars($user->username) ?></a>
            
            <span class="actions">
            <?php echo html::anchor('user/logout', '[ Logga ut ]')?>
            </span>
        </p>
    </div>
</div>