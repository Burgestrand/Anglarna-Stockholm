<div class="box">
    <h2><?php echo html::chars($title) ?></h2>
    <?php if ( ! empty($images)): ?> 
    <ol class="gallery images">
        <?php foreach ($images as $image): ?> 
        <li>
            <a href="<?php echo $image->path ?>"><img src="<?php echo $image->thumb ?>" height="80" alt="<?php echo $image->alt ?>"></a>
        </li>
        <?php endforeach; ?> 
    </ol>
    <?php endif; ?> 
    <div class="clear"></div>
</div>