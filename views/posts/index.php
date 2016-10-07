<div class="table">
    <div class="table-row head">
        <div class="table-cell">RSS Feed</div>
        <div class="table-cell">&nbsp;</div>
        <div class="table-cell">&nbsp;</div>
        <div class="table-cell">&nbsp;</div>
    </div>

    <?php if(!empty($feeds)){
        foreach($feeds as $feed){ ?>
            <div class="table-row">
                <div class="table-cell"><?php echo $feed->url ?></div>
                <div class="table-cell"><a href="?controller=posts&amp;action=view&id=<?php echo $feed->id ?>">view</a></div>
                <div class="table-cell"><a href="?controller=posts&amp;action=edit&id=<?php echo $feed->id?>">edit</a></div>
                <div class="table-cell"><a href="?controller=posts&amp;action=delete&id=<?php echo $feed->id ?>">delete</a></div>
            </div>
        <?php }}?>
</div>

<br>
<a href='?controller=posts&amp;action=add'>add rss feed</a>
