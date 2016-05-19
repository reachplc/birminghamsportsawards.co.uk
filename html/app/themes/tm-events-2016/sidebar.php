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

  <h3 class="gamma heading--sub"><?php esc_html_e( 'Awards Ceremony', 'tm-events-2016' ); ?></h3>

	<?php tm_events_the_venue_image(); ?>

	<?php tm_events_the_venue_date(); ?>

	<?php tm_events_the_venue_location(); ?>

	<?php tm_events_the_venue_info(); ?>

</article>
<?php endif; ?>

<?php if ( function_exists( 'tm_events_has_twitter' ) && tm_events_has_twitter() ) : ?>
<article class="box separator--horizontal">

  <h4 class="gamma heading--sub"><?php tm_events_the_twitter_hashtag(); ?></h4>
	<a class="twitter-timeline" data-dnt="true" href="<?php tm_events_the_twitter_link(); ?>" data-widget-id="<?php tm_events_the_twitter_id(); ?>" data-chrome="noheader"><?php tm_events_the_twitter_hashtag(); ?></a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</article>
<?php endif; ?>
