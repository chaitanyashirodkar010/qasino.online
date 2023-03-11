<?php
global $post;
$bonus_allowed_html = array(
	'a' => array(
		'href' => true,
		'title' => true,
		'target' => true,
		'rel' => true
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
	'span' => array(
		'class' => true
	),
	'div' => array(
		'class' => true
	),
	'p' => array()
);
$bonus_short_desc = wp_kses( get_post_meta( get_the_ID(), 'bonus_short_desc', true ), $bonus_allowed_html );
$bonus_external_link = esc_url( get_post_meta( get_the_ID(), 'bonus_external_link', true ) );
$bonus_button_title = esc_html( get_post_meta( get_the_ID(), 'bonus_button_title', true ) );
$bonus_button_notice = wp_kses( get_post_meta( get_the_ID(), 'bonus_button_notice', true ), $bonus_allowed_html );
$bonus_code = esc_html( get_post_meta( get_the_ID(), 'bonus_code', true ) );
$bonus_valid_date = esc_html( get_post_meta( get_the_ID(), 'bonus_valid_date', true ) );
$bonus_dark_style = esc_attr( get_post_meta( get_the_ID(), 'bonus_dark_style', true ) );

$offer_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'offer_detailed_tc', true ), $bonus_allowed_html );
$offer_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_offer_popup_title', true ) );

if ($bonus_button_title) {
	$button_title = $bonus_button_title;
} else {
	if ( get_option( 'bonuses_get_bonus_title') ) {
		$button_title = esc_html( get_option( 'bonuses_get_bonus_title') );
	} else {
		$button_title = esc_html__( 'Get Bonus', 'mercury' );
	}
}

if ($offer_popup_title) {
	$custom_popup_title = $offer_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
}

if ($bonus_external_link) {
	$external_link_url = $bonus_external_link;
} else {
	$external_link_url = get_the_permalink();
}

$terms = get_the_terms( $post->ID, 'bonus-category' );

?>
<li class="bonus-code row w-100 align-items-center">
    <div class="bg-white position-relative" style="border-top-right-radius:10px;">
        <div class="bonus-details-section pt-3">
            <div class="bonus_for">
                <p>Recommended</p>
            </div>
            <div class="d-inline-flex user_claimed">
                <img class="menu-icon me-2 lazyload" alt="user" title="user"
                    src="data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjAiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48Y2lyY2xlIGN4PSIxMiIgY3k9IjgiIHI9IjQiIGZpbGw9IiNmZjkwMzYiIGNsYXNzPSJmaWxsLTAwMDAwMCI+PC9jaXJjbGU+PHBhdGggZD0iTTEyIDE0Yy02LjEgMC04IDQtOCA0djJoMTZ2LTJzLTEuOS00LTgtNHoiIGZpbGw9IiNmZjkwMzYiIGNsYXNzPSJmaWxsLTAwMDAwMCI+PC9wYXRoPjwvc3ZnPg=="
                    width="20" height="20" style=""> Users Claimed 207
            </div>
            <div class="d-inline-flex user_claimed">
                <img class="me-2" loading="lazy" alt="" title=""
                    src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDIzLjAuMywgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9Ikljb25zIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIKCSB2aWV3Qm94PSIwIDAgMzIgMzIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDMyIDMyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxwYXRoIHN0eWxlPSJmaWxsOiNhZGFiYWEiIGQ9Ik0xNiwyQzguMywyLDIsOC4zLDIsMTZzNi4zLDE0LDE0LDE0czE0LTYuMywxNC0xNFMyMy43LDIsMTYsMnogTTIzLDE3aC03Yy0wLjYsMC0xLTAuNC0xLTFWN2MwLTAuNiwwLjQtMSwxLTFzMSwwLjQsMSwxdjgKCWg2YzAuNiwwLDEsMC40LDEsMVMyMy42LDE3LDIzLDE3eiIvPgo8L3N2Zz4K">
                <?php echo get_the_modified_date() ?>
            </div>
            <div class="bonus_name">
                <a href="<?php the_permalink(); ?>"
                    title="<?php the_title_attribute(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
            </div>
            <div class="bonus_applicable">
                <p>Bonus available for <?php echo wp_kses( $bonus_button_notice, $bonus_allowed_html ); ?>
                </p>
            </div>
            <?php if ($bonus_code) { ?>
            <div class="bonus_code d-inline-flex align-items-center"><strong>Bonus Code: </strong>
                <p class="ms-2"><a rel="nofollow" class="copy-click" data-tooltip-text="Click to copy"
                        data-tooltip-text-copied="✔ Copied">

                        <?php echo esc_html( $bonus_code ); ?>



                    </a></p>
            </div>
            <?php } ?>
            <div class="bonus_info">
                <div class="max_bonus">
                    <p><?php if ($bonus_max) { ?><?php echo esc_html( $bonus_max ); ?><?php } ?></p>
                </div>
                <div class="min_deposit">
                    <p>Min-Deposit: </p>
                    $<?php if ($min_deposit) { ?><?php echo esc_html( $min_deposit ); ?><?php } ?>
                </div>
                <div class="wagering_requirement">
                    <p>Wagering Requirement: </p>
                    <?php if ($wagering_requirement) { ?><?php echo esc_html( $wagering_requirement ); ?><?php } ?>x
                    (Deposit + Bonus)
                </div>
            </div>
            <div class="expiring_date"><strong>Expiring Date: </strong>
                <p><?php echo esc_html( date_i18n('M d, Y',strtotime($bonus_valid_date))); ?></p>
            </div>
        </div>
        <div class="bonus_button d-flex justify-content-end">

            <div class="default_button orange_button me-3"><a href="<?php echo esc_url( $external_link_url ); ?>"
                    title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank"
                    rel="nofollow" <?php } ?>><?php echo esc_html( $button_title ); ?></a></div>
            <div class="default_button grey_button"><a href="<?php the_permalink(); ?>">More
                    Details</a></div>
        </div>
    </div>
</li>