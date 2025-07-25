<?php
/**
 * The template used to display the campaign submission form.
 *
 * Override this template by copying it to yourtheme/charitable/charitable-ambassadors/shortcodes/submit-campaign.php
 *
 * @author 	Studio 164a
 * @since 	1.0.0
 * @version 1.0.0
 */

$form 	= $view_args[ 'form' ];
$fields = $form->get_current_page_fields();
$donor	= new Charitable_User( get_current_user_id() );

$fields['campaign_fields']['fields']['post_title']['type'] = 'textarea';

foreach ( $fields as $key => &$field ) {
	foreach ( $field['fields'] as $key2 => &$fieldset_field ) 
	{
		// we don't want to use their labels
		unset($fieldset_field['label']);

		if( isset($_REQUEST[$key2]) ) {
			$fieldset_field['value'] = $_REQUEST[$key2];
		}
	}
}

$campaign_id = get_query_var( 'campaign_id', false );
$campaign = null;
if($campaign_id) {
	$campaign = HopeCampaign::get($campaign_id);
}

if( @$fields['campaign_fields']['fields']['charitable_parent_id']['value'] ) {
	$parent_campaign = HopeCampaign::get($fields['campaign_fields']['fields']['charitable_parent_id']['value']);
}
else if( $campaign && $campaign->post_parent ) {
	$parent_campaign = HopeCampaign::get($campaign->post_parent);
}

// verify that a fundraiser type is being set
$allowed_fundraiser_types = [CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT, CAMPAIGN_EARMARKED_FOR_HOPE_LOAN, CAMPAIGN_NON_EARMARKED_DONATION];
if( !in_array(@$fields['campaign_fields']['fields']['fundraiser_type']['value'], $allowed_fundraiser_types) )
{
	wp_redirect(site_url('/start-a-fundraiser/?error=unknown_fundraiser'));
	die();
}

$fundraiser_type = @$fields['campaign_fields']['fields']['fundraiser_type']['value'];

// verify that hope loan earmarks have the correct charitable_parent_id and earmark_identifier set
if( $fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_LOAN )
{
	$earmarked_post = get_post($fields['campaign_fields']['fields']['earmark_identifier']['value']);

	if( $parent_campaign->ID != HopeCampaign::$HOPELOAN_CAMPAIGN_ID ) 
	{
		wp_redirect(site_url('/start-a-fundraiser/?error=bad_hopeloan_parent_campaign_id'));
		die();
	}

	if( !$earmarked_post ) 
	{
		wp_redirect(site_url('/start-a-fundraiser/?error=bad_earmarked_post'));
		die();
	}
}

// verify that hope project earmarks have a charitable_parent_id set and that it is not a child project
if( $fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT )
{
	if( @$parent_campaign->post()->post_type != 'campaign' ) 
	{
		wp_redirect(site_url('/start-a-fundraiser/?error=bad_parent_campaign'));
		die();
	}

	if( $parent_campaign->isChildCampaign() ) 
	{
		wp_redirect(site_url('/start-a-fundraiser/?error=parent_campaign_is_child'));
		die();
	}
}

// verify that hope donation (non earmarks) have the correct charitable_parent_id set
if( $fundraiser_type == CAMPAIGN_NON_EARMARKED_DONATION )
{
	if( $parent_campaign->ID != HopeCampaign::$DONATION_CAMPAIGN_ID ) 
	{
		wp_redirect(site_url('/start-a-fundraiser/?error=bad_donation_parent_campaign_id'));
		die();
	}
}

if( $campaign )
{
	if( $campaign->daysLeft() <= 0 ) {
		die("<h2 style='margin-top:50px'>This campaign has ended and is no longer editable.</h2><p><a class='green-button' href='" . site_url('my-fundraisers/') . "'>Go Back</a></p>");
	}

	if( $campaign->isComplete() ) {
		die("<h2 style='margin-top:50px'>This campaign has completed its fundraising goal and is no longer editable.</h2><p><a class='green-button' href='" . site_url('my-fundraisers/') . "'>Go Back</a></p>");
	}
}

if ( ! $form->current_user_can_edit_campaign() ) : ?>

	<p><?php _e( 'You do not have permission to edit this campaign.', 'charitable-ambassadors' ) ?></p>

<?php 

else :

	/**
	 * @hook 	charitable_campaign_submission_before
	 */
	do_action('charitable_campaign_submission_before');

	?>

	<!--
	<?php if( $parent_campaign ): ?>
		<h2 id="top-title">Please verify the Fundraiser Info and your Personal Info below:</h2>
	<?php else: ?>
		<h2 id="top-title">Please edit the Fundraiser Info and your Personal Info below:</h2>
	<?php endif; ?>
	-->

	<div class="container-full graddy">
		<div id="account-bar"><a href="<?=site_url('my-account/')?>">Account Information</a></div>

		<form method="post" id="charitable-campaign-submission-form" class="charitable-form" enctype="multipart/form-data">

			<div class="charitable-form-fields cf">
				<?php
					$form->view()->render_honeypot();
					$form->view()->render_hidden_fields();
				?>
			</div>

			<?php if( $parent_campaign ): ?>
				<input type="hidden" name="parent_id" value="<?=$parent_campaign->ID?>" />
			<?php endif; ?>

			<?php $form->render_field($fields['campaign_fields']['fields']['fundraiser_type'], 'fundraiser_type', $form, 0); ?>
			<?php $form->render_field($fields['campaign_fields']['fields']['earmark_identifier'], 'earmark_identifier', $form, 0); ?>

			<div id="charitable_field_post_title-row" class="container">
				<div class="row">
					<div class="col-sm-3 col-sm-offset-1">	
						<?php $form->render_field($fields['campaign_fields']['fields']['post_title'], 'post_title', $form, 0); ?>
					</div>
					<div class="col-sm-7 campaign-public">
						<?php if($campaign && $campaign->post_status == "publish"): ?>
							<p>This campaign is public and can be seen on our website <input type="checkbox" checked="checked" disabled="disabled" /></p>	
						<?php else: ?>
							<p>This campaign can not be seen on our website and is not yet public <input type="checkbox" disabled="disabled" /></p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="container">
				<div class="row">

					<!-- left side -->
					<div class="col-md-4" id="funding-info">

						<div class="funding-amt-group col-sm-6 col-md-12">
							<div class="funded-amt">$<?=$campaign?$campaign->amountDonated():'0'?></div>
							<div class="empty-funded-bar"></div>
							<div class="row">
								<div class="col-sm-5 funded-pct"><?=$campaign?round($campaign->percentCompleted()*100):'0'?>% Funded</div>
								<div class="col-sm-7 donation-goal"><?php $form->render_field($fields['campaign_fields']['fields']['goal'], 'goal', $form, 1); ?></div>
							</div>
						</div>

						<div class="funding-time-group col-sm-6 col-md-12">
							<div class="days-left">
								<p><span class="fa fa-calendar">&nbsp;</span> <span class="num-days"><?=$campaign?$campaign->runTimeInDays():'?'?></span> DAYS LEFT TO DONATE</p>
							</div>
						</div>
					</div>

					<!-- right side -->
					<div class="col-md-8" id="description">

						<?php if( $fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_PROJECT ): ?>
							<div class="charitable-form-header">You are Fundraising for Hope Project: <a target="_blank" href="<?=get_permalink($parent_campaign->ID)?>"><?= $parent_campaign->post_title ?></a></div>
						<?php endif; ?>

						<?php if( $fundraiser_type == CAMPAIGN_EARMARKED_FOR_HOPE_LOAN ): ?>
							<div class="charitable-form-header">You are Fundraising for Hope Loan: <a target="_blank" href="<?=get_permalink($earmarked_post->ID)?>"><?= $earmarked_post->post_title ?></a></div>
						<?php endif; ?>

						<p>Please tell us why people should donate to your fundraiser:</p>

						<p class="desc_p">Short Description:</p>
						<?php $form->render_field($fields['campaign_fields']['fields']['description'], 'description', $form, 2); ?>

						<p class="desc_p">Long Description:</p>
						<?php $form->render_field($fields['campaign_fields']['fields']['post_content'], 'post_content', $form, 2); ?>
					</div>
				</div>
			</div>
			
			<?php 
			
			do_action( 'charitable_form_before_fields', $form ) ?>
			
			<?php
			do_action( 'charitable_form_after_fields', $form );
			
			?>
			<div class="row charitable-form-field charitable-submit-field">
				<?php echo $form->get_submit_buttons() ?>		

				<div>
					<ul class="errors">
					</ul>
				</div>
			</div>

			<?php if($campaign): ?>
				<input type="hidden" id="start_date" name="start_date" value="<?=$campaign->post_date?>" />
				<input type="hidden" id="end_date" name="end_date" value="<?=$campaign->charity->end_date?>" />
			<?php endif; ?>

		</form>
	</div>
	<?php

	/**
	 * @hook 	charitable_campaign_submission_after
	 */
	do_action('charitable_campaign_submission_after');

endif;