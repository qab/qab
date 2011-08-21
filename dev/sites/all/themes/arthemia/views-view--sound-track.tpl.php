<?php
// $Id: views-view.tpl.php,v 1.13.2.2 2010/03/25 20:25:28 merlinofchaos Exp $
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>

<div class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>
<br/>
  <?php if ($rows): ?>
    <div class="view-content">
        
      <div id="soundtrak-title-box">
      <?php if( count($view->result)):?>
        
        <?php $i=0; foreach($view->result as $soundTrack):?>
            <h2 id="soundtrack-title-<?php $i++; print $i;?>" class="soundtrak-title<?php if($i>1) print ' hide';?>"> 
                <?php print $soundTrack->node_title?>
            </h2>
        <?php endforeach;?>
      <?php endif;?>
     </div>
     
     <div id="soundtrak-movie-box">
      <?php if( count($view->result)):?>
        
        <?php $i=0; foreach($view->result as $soundTrack):?>

            <div id="soundtrack-movie-<?php $i++; print $i;?>" class="soundtrak-movie<?php if($i>1) print ' hide';?>"> 
                <object width="425" height="350">
                    <param name="movie" value="http://www.youtube-nocookie.com/v/<?php print $soundTrack->node_data_field_soundtrack_pelicula_field_soundtrack_video_v?>?version=3&amp;hl=en_US"></param>
                    <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
                    <embed src="http://www.youtube-nocookie.com/v/<?php print $soundTrack->node_data_field_soundtrack_pelicula_field_soundtrack_video_v?>?version=3&amp;hl=en_US" 
                        type="application/x-shockwave-flash" width="425" height="350" allowscriptaccess="always" allowfullscreen="true"></embed>
               </object>

            </div>
        <?php endforeach;?>
      <?php endif;?>
     </div>
     
     <div id="soundtrak-body-box">
      <?php if( count($view->result)):?>
        
        <?php $i=0; foreach($view->result as $soundTrack):?>
            <p id="soundtrack-body-<?php $i++; print $i;?>" class="soundtrak-body<?php if($i>1) print ' hide';?>"> 
                <?php print $soundTrack->node_revisions_body?>;
            </p>
        <?php endforeach;?>
      <?php endif;?>
     </div>
     

     
    <div id="soundtrak-thumbs-box">
      <?php if( count($view->result)):?>
        <ul id="soundtrack-gallery">
        <?php $i=0; foreach($view->result as $soundTrack):?>
            <li> 
               <?php $obj = unserialize($soundTrack->node_data_field_soundtrack_pelicula_field_soundtrack_video_d);?> 
               <img data-movie-idx="<?php $i++; print $i;?>"  src="/<?php print $obj['emthumb']['filepath'];?>" alt="test" width="90" height="70"class="soundtrack-thumb" />
            </li>
        <?php endforeach;?>
        </ul>
      <?php endif;?>
     </div>
     
     
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div> <?php /* class view */ ?>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#soundtrack-gallery').jcarousel({
        auto: 5,
        wrap: 'last',
    });

    $(".soundtrack-thumb").click(function(){
        var idx =  $(this).attr("data-movie-idx");
        $(".soundtrak-movie").hide();
        $(".soundtrak-body").hide();
        $("#soundtrack-movie-" + idx).show();
        $("#soundtrack-body-" + idx).show();
    });
});
 
</script>
