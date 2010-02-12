<p class="meta">
    <?php echo html::chars($post->author) ?>:
    <span class="date"><?php echo $post->created; ?></span>
</p>
<p>
    <?php echo html::chars($post->message) ?>
</p>