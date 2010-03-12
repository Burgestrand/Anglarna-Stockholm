<div class="box">
    <h1>Mediagalleriet</h1>
    <p>
        Här samlar vi bilder från både matcher och änglamöten. Sitter du
        och trycker på lite bilder? Skicka dem till oss på <?php echo
        html::mailto('stockholm@anglarna.se') ?>!
    </p>
    <?php if ( ! empty($galleries)): ?>
    <ol class="gallery galleries">
        <?php foreach ($galleries as $gallery): ?>
        <li><a href="<?php echo url::site(Route::get('gallery')->uri(array('galleri' => $gallery->path))) ?>"><?php echo html::chars($gallery->path) ?> (<?php echo $gallery->images ?> bilder)</a></li>
        <?php endforeach; ?>
    </ol>
    <?php endif; ?>
</div>