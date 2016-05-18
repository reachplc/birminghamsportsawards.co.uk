<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-events-2016
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<article class="box separator--horizontal" itemscope itemtype="http://schema.org/Event">

	<?php // @TODO allow user to change details via admin ?>

  <h3 class="gamma heading--main">Awards Ceremony</h3>

  <img class="image image__responsive" src="<?php echo get_template_directory_uri(); ?>/gui/venue_icc-birmingham.jpg" alt="">

  <h4 itemprop="startDate" content="2016-10-26T16:30">Wednesday, 26&nbsp;October&nbsp;2016</h4>
  <p itemprop="location" itemscope itemtype="http://schema.org/Place">
  <strong itemprop="name">The&nbsp;ICC, Birmingham</strong>,<br><span itemprop="streetAddress">Broad&nbsp;St</span>,
	<span itemprop="addressLocality">Birmingham</span>. <span itemprop="postalCode">B1&nbsp;2EA</span></p>
	<p>Prosecco reception from <span itemprop="doorTime" content="18:30">6:30pm</span>.</p>

</article>


<article class="box separator--horizontal">

  <h4 class="gamma heading--main">#BPBA2016</h4>

	<a class="twitter-timeline" href="https://twitter.com/search?q=%23BPBA2016%20exclude%3Aretweets" data-widget-id="728167826196848645" data-chrome="noheader">Tweets about #BPBA2016</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</article>
