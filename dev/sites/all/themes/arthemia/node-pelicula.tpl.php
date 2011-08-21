<?php
// $Id: node.tpl.php,v 1.2 2009/06/11 01:10:04 nbz Exp $

/**
 * @file node.tpl.php
 *
 * Theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: Node body or teaser depending on $teaser flag.
 * - $picture: The authors picture of the node output from
 *   theme_user_picture().
 * - $date: Formatted creation date (use $created to reformat with
 *   format_date()).
 * - $links: Themed links like "Read more", "Add new comment", etc. output
 *   from theme_links().
 * - $name: Themed username of node author output from theme_user().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $submitted: themed submission information output from
 *   theme_node_submitted().
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $teaser: Flag for the teaser state.
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 */
?>
<div id="node-<?php print $node->nid; ?>" class="node<?php if ($sticky) { print ' sticky'; } ?><?php if (!$status) { print ' node-unpublished'; } ?> clear-block">

<?php print $picture ?>

<?php if (!$page): ?>
  <h1><a href="<?php print $node_url ?>" title="<?php print $title ?>"><?php print $title ?></a></h1>
<?php endif; ?>

  <?php if ($submitted): ?>
    <span class="submitted"><?php print $submitted ?></span>
  <?php endif; ?>
  
  <div id="trailers-video-box">
  <?php if($node->field_pelicula_trailer_oficial[0]['view']):?>
    <div id="pelicula-trailer-1" class="trailer-box" ><?php print $node->field_pelicula_trailer_oficial[0]['view'];?></div>
    
    <?php if( !empty($node->field_pelicula_trailers[0]['value']) ):?>
        <?php $i=1; ?>
        <?php foreach($node->field_pelicula_trailers as $trailer): ?>
            
            <div id="pelicula-trailer-<?php $i++; print $i; ?>" class="trailer-box hide" >
                <?php print $trailer['view'];?>
            </div>
        <?php endforeach;?>
    <?php endif;?>    
    
  <?endif?>
  </div>
  
  <div id="pelicula-sinopsis">
    <h2>Sinopsis:</h2>
    <?php print $node->content['body']['#value'];?>
  </div>
  <?php if( !empty($node->field_pelicula_trailers[0]['value']) ):?>
      <?php $i=1;?>
    <ul id="peliculas-gallery" class="trailers-list jcarousel-skin-tango">
    <?php foreach($node->field_pelicula_trailers as $trailer): ?>
        <li>
            <img data-movie-idx="<?php $i++; print $i;?>"
                 class="trailer-thumb"
                 src="<?php print $trailer['data']['thumbnail']['url'];?>"  
                 alt="image pelicula"  width="90" height="70"/>
            
        </li>
    <?php endforeach;?>
        <li>
            <img data-movie-idx="1"
                class="trailer-thumb" 
                src="<?php print $node->field_pelicula_trailer_oficial[0]['data']['thumbnail']['url'];?>"  
                alt="image pelicula"  width="90" height="70"/>
        </li>
    </ul>
  <?php endif;?>
    <div class="clear"></div>
  <div class="content">
    <?php //print $content ?>
  </div>

 
  <?php if ($terms && !$teaser): ?>
    <div class="taxonomy">Genero: 
    <div class="terms terms-inline"><?php print $terms ?></div>
    </div>
  <?php endif;?>

  <?php print $links; ?>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#peliculas-gallery').jcarousel({
        auto: 5,
        wrap: 'last',
    });
    
    $(".trailer-thumb").click(function(){
        var idx =  $(this).attr("data-movie-idx");
        $(".trailer-box").hide();
        $("#pelicula-trailer-" + idx).show();
    });
});
 
</script>

