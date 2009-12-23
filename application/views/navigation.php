<ul class="nav">
    <?php foreach(array('search') as $link): ?> 
    <li><?php echo html::anchor($link, UTF8::ucfirst($link)) ?></li>
    <?php endforeach; ?> 
</ul>