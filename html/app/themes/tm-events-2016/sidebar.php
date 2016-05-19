<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tm-events-2016
 */
?>

<?php if ( function_exists( 'tm_events_has_venue' ) && tm_events_has_venue() ) : ?>
<article class="box separator--horizontal" itemscope itemtype="http://schema.org/Event">

	<?php // @TODO allow user to change details via admin ?>

  <h3 class="gamma heading--main">Awards Ceremony</h3>

	<?php tm_events_the_venue_image(); ?>

	<?php tm_events_the_venue_date(); ?>

	<?php tm_events_the_venue_location(); ?>

	<?php tm_events_the_venue_info(); ?>

</article>
<?php endif; ?>

<article class="box separator--horizontal">

  <h4 class="gamma heading--main">#BPBA2016</h4>

	<a class="twitter-timeline" href="https://twitter.com/search?q=%23BPBA2016%20exclude%3Aretweets" data-widget-id="728167826196848645" data-chrome="noheader">Tweets about #BPBA2016</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</article>
