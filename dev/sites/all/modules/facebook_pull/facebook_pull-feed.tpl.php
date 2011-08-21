<ul class="facebook-feed">
<?php foreach ($items as $item): ?>
  <li class="item">
    <span class="facebook-feed-picture"><img src="http://graph.facebook.com/<?php echo $item->from->id; ?>/picture" /></span>
    <span class="facebook-feed-from"><a href="http://facebook.com/profile.php?id=<?php echo $item->from->id; ?>"><?php echo $item->from->name; ?></a></span>
    <span class="facebook-feed-message"><?php echo check_plain($item->message); ?></span>
    <span class="facebook-feed-time"><?php echo t('!time ago.', array('!time' => format_interval(time() - strtotime($item->created_time)))); ?></span>
  </li>
<?php endforeach; ?>
</ul>
