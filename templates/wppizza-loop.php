<?php
if ( ! defined( 'ABSPATH' ) ) exit;/*Exit if accessed directly*/
 /****************************************************************************************
 *
 *
 *	WPPizza - Category Loop Template
 *	IF YOU MUST EDIT THIS, READ THE COMMENTS
 *
 *
 ****************************************************************************************/
	/*************************************************************
		[TIDYUP in 2.11.2 using includes to get plugin options
		, get/set vars and run query in loop and loop responsive
	*************************************************************/
	/**get / add plugin options 1x max**/
	require_once(WPPIZZA_PATH.'inc/frontend.require.once.options.inc.php');/*returns plugin options, filterable via wppizza_loop_top**/
	/**get / set vars and run query **/
	require(WPPIZZA_PATH.'inc/frontend.require.loop-query.inc.php');/*query arguments filterable via wppizza_filter_loop */
?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_outside_start', $the_query, $options,  $termSlug, $categoryId);
?>
<?php
/********************************************
 *
 *	[OUTPUT HEADER]
 *	[edit or even delete if you want]
 *	[alternatively - and better - set "noheader" in shortcode, "Suppress Category Header" in widget
 *	or just suppress all headers above looped items  in wppizza settings->layout]
 *
 ********************************************/
?>
<?php if(!is_single() && !isset($noheader) && $termDetails && $the_query->found_posts>0){ /*exclude header if set or is single or <=0 posts */?>
	<header id="<?php echo $post_type ?>-header-<?php echo $termSlug ?>-<?php echo $categoryId ?>" class="<?php echo $headerclasses ?>">
		<h1 class="<?php echo $headerclassesh1 ?>"><?php echo $termDetails->name ?></h1>
		<?php if ( $termDetails->description!='' ) :?>
		<div class="entry-meta <?php echo $post_type ?>-header-meta"><?php echo $termDetails->description; ?></div>
		<?php endif; ?>
	</header>
<?php } ?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_outside_before', $the_query, $options, $termSlug, $categoryId);
?>
<?php
/********************************************
*
*
*	[OUTPUT LOOP - edit if you want/must]
*	WARNING: be careful not to change or delete any classes or id's (especially in the prices section), as the ajax functionality when adding items to cart depends on them
*	Furthermore, the used CSS has - obviously - been setup with those in mind.
*	You should be able to add additional classes though (use the filters if you can). Make sure you test things.
*
*
 ********************************************/
	/* Start the Loop */
	$articlecount=0;//counter
	while ( $the_query->have_posts() ) : $the_query->the_post();
	$articlecount++;
	/**changed / added in 2.5***/
	/**changed to not run function multiple times unnecessarily -> replaced all other get_the_ID() further down**/
	$postId=get_the_ID();
	/***new in 2.5.6 ->prettyPhoto (store get_the_title() in var so we can use it multiple times without running function more than once **/
	$postTitle=get_the_title();
	/**get permalink*****/
	$permalink = get_permalink( $postId );
	/**filter to add category id to permalink so we can identify which category it came from if we have "group by category" enabled;**/
	$permalink = apply_filters('wppizza_filter_loop_permalink', $postId, $permalink, $termDetails, $categoryId);
	/*get meta data for this post**/
	$meta=get_post_meta($postId, $post_type, true );
	/**added in 2.5 to enable messing around with output below if required***/
	$meta = apply_filters('wppizza_filter_loop_meta', $meta, $postId);
	/**article classes*****/
	$articleclasses = array(''.$post_type.'-article','entry-content',''.$post_type.'-article-'.$termSlug.'-'.$categoryId);
	if($articlecount==1){$articleclasses[]=''.$post_type.'-article-first';}/*add - first*/
	if($articlecount==$the_query->found_posts && $the_query->found_posts>1){$articleclasses[]=''.$post_type.'-article-last';}/*add - last if more than one*/
	$articleclasses=apply_filters('wppizza_filter_article_class', $articleclasses, $postId, $articlecount, $meta);/*enable filtering*/
	/***********************************************************
	*
	*	if you want to display categories for example , uncomment
	*	the following and put it in the loop where required
	*
	************************************************************/
//		$postterms = get_the_terms($postId, WPPIZZA_TAXONOMY);
//		/*example what to do with it. edit as required***/
//		$categoryNames='';
//		if ($postterms && ! is_wp_error($postterms)){
//			$term_category=array();
//			foreach ($postterms as $term) {
//				$term_category[]= $term->name;
//			}
//			$categoryNames = implode(" / ",$term_category);
//		}
//		/*now output $categoryNames somewhere***/


	$numberOfSizes=count($options['sizes'][$meta['sizes']]);
	/**if selected in admin, make click on title add to cart or
	show alert when there are more than one size**/
	$clickTriggerClass='';
	$clickTriggerId='';
	if(isset($clickTrigger)){
	 	/*trigger add to cart**/
	 	if($numberOfSizes==1){
			$clickTriggerClass=' '.$post_type.'-trigger-click';
			$clickTriggerId=' id="'.$post_type.'-article-'.$postId.'-'.$meta['sizes'].'-0"';
	 	}
	 	/*more than one size available, show alert**/
	 	if($numberOfSizes>1){$clickTriggerClass=' '.$post_type.'-trigger-choose';}
	}
?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_before_article', $postId,  $options, $termSlug, $categoryId);
?>
	<article id="post-<?php echo $postId ?>" <?php post_class($articleclasses); ?>>
<?php
/*********************************************
	[single items entry content]
	[lets attempt to keep single items (if used)
	somewhat consistant. depends on theme though]
**********************************************/
if(is_single()){
	print"<div class='entry-content'>";
}
?>
<?php
/*********************************************
			[thumbnails]
**********************************************/
?>
		<?php if(has_post_thumbnail()) {?>
			<div class="<?php echo $post_type ?>-article-img">
			<?php
			/**new in 2.5.6 ->prettyPhoto if enabled**/
			if($options['layout']['prettyPhoto']){
				$full_image_data = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full' );
				print'<a href="'.$full_image_data[0].'" rel="wppizzaPrettyPhoto" title="'.$postTitle.'">';
			}
			?>
			<?php the_post_thumbnail( 'thumbnail', array('class' => ''.$post_type.'-article-img-thumb', 'title'=>$postTitle)); ?>
			<?php
			/**new in 2.5.6 ->prettyPhoto if enabled**/
			if($options['layout']['prettyPhoto']){
				print"</a>";
			}
			?>
			</div>
		<?php
			}else{
				if($options['layout']['placeholder_img']){//display placeholder
		?>
			<div class="<?php echo $post_type ?>-article-img">
				<div class="<?php echo $post_type ?>-article-img-placeholder"></div>
			</div>
		<?php } } ?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_thumbnails', $postId,  $options, $termSlug, $categoryId);
?>
<?php
/*********************************************
		[prices]
**********************************************/
	if(!isset($hidePrices)){
?>
		<div id="<?php echo $post_type ?>-article-tiers-<?php echo $postId ?>" class="<?php echo $post_type ?>-article-tiers">

	   	<?php if(!isset($hideCurrencySymbol) && isset($currencyLeft)){?>
	   		<span class='<?php echo $post_type ?>-article-price-currency <?php echo $post_type ?>-article-currency-left'><?php echo $currency ?></span>
	   	<?php } ?>


	   	<?php foreach($options['sizes'][$meta['sizes']] as $k=>$v){?>
	   		<span id='<?php echo $post_type."-".$postId."-".$meta['sizes']."-".$k ?>' class='<?php echo $post_type ?>-article-price <?php echo $priceClass ?>' <?php echo $priceTitle ?>>
	    		<span><?php if($options['layout']['show_currency_with_price']==1){echo $currency." ";} ?><?php echo wppizza_output_format_price($meta['prices'][$k],$optionsDecimals)?><?php if($options['layout']['show_currency_with_price']==2){echo " ".$currency;} ?></span>
	    		<?php if(!isset($hidePricetier) || count($options['sizes'][$meta['sizes']])>1){ ?>
	    		<div class='<?php echo $post_type ?>-article-price-lbl<?php echo $hideCartIcon?>'><?php echo $v['lbl']?></div>
	   			<?php } ?>
	   		</span>
	   	<?php } ?>

	   	<?php if(!isset($hideCurrencySymbol) && !isset($currencyLeft)){?>
	   		<span class='<?php echo $post_type ?>-article-price-currency'><?php echo $currency ?></span>
	   	<?php } ?>

		</div>
<?php 	} ?>

<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_prices', $postId,  $options, $termSlug, $categoryId);
?>
<?php
/*********************************************
		[title, additives info and description]
**********************************************/
?>
		<div class="<?php echo $post_type ?>-article-info">
		<h2<?php echo $clickTriggerId ?> class="<?php echo $post_type ?>-article-title<?php echo $clickTriggerClass ?>">
			<?php echo $postTitle ?>
			<?php if(count($meta['additives'])>0){?>
				<sup class='<?php echo $post_type ?>-article-additives' title='<?php echo $txt['contains_additives']['lbl'] ?>'>
	    		<?php foreach($meta['additives'] as $k=>$v){ $additivesOnPage=true; ?>
	    			<span id="wppizza-loop-additive-<?php echo $postId ?>-<?php echo $k ?>" title="<?php echo $v ?>" class="wppizza-loop-additive wppizza-loop-additive-<?php echo $k ?>">(<?php echo $k ?>)</span>
	    		<?php } ?>
				</sup>
			<?php } ?>
		</h2>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_title', $postId,  $options, $termSlug, $categoryId);
?>
		<?php the_content();?>
		</div>

<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_content', $postId, $options,  $termSlug, $categoryId);
?>
<?php
/*********************************************
		[single items entry content end]
**********************************************/
if(is_single()){
	print"</div>";
}
?>
<?php
/*********************************************
		[article end]
**********************************************/
?>
	</article>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_article', $postId,  $options, $termSlug, $categoryId);
?>
<?php
/*************************************************
	[comments box - if single item view and enabled of course]
**************************************************/
if(is_single()){
	comments_template( '', true );
}
?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_inside_after_comments', $postId,  $options, $termSlug, $categoryId);
?>
<?php endwhile;	?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_outside_after', $the_query,  $options, $termSlug, $categoryId);
?>
<?php
/********************************************
 *
 *	[if any of the items have additives, display idents here]
 *	[if showadditives is distinctly set force/hide display]
 *
 ********************************************/
if(!isset($showadditives) || $showadditives!=0){
if(isset($additivesOnPage) || (isset($showadditives) && $showadditives==1)){
?>
	<div class='<?php echo $post_type ?>-contains-additives'>
	<?php foreach($options['additives'] as $k=>$v){?>
		<span id="wppizza-additive-<?php echo $k ?>" class="wppizza-additive wppizza-additive-<?php echo $k ?>"><sup>(<?php echo $k ?>)</sup><?php echo $v ?></span>
	<?php } ?>
	</div>
<?php }} ?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_outside_after_additives', $the_query, $options,  $termSlug, $categoryId);
?>
<?php
/*************************************************
	[pagination - no need to display empty divs]
**************************************************/
if(!is_single() && $the_query->max_num_pages>1){
?>
<div class="navigation">
  <div class="alignleft"><?php previous_posts_link(''.$txt['previous']['lbl'].'') ?></div>
  <div class="alignright"><?php next_posts_link(''.$txt['next']['lbl'].'',$the_query->max_num_pages) ?></div>
</div>
<?php } ?>
<?php
	/*ADDED IN VERSION 2.8.5*/
	do_action('wppizza_loop_outside_end', $the_query,  $options, $termSlug, $categoryId);
?>