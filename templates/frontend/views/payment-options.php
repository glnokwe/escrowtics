<?php 
 	if(isset($_GET['endpoint'])){
	    $process = ( $_GET['endpoint'] == "deposit_payment_options"? 'deposit' : 'withdraw' );
	} else { 
		exit(); 
	}
	
	$payments = array(
					
					'Bitcoin' => array( 'image'     =>  'bitcoin-pay.png', 
										'modal_id'  =>  'escrot-bitcoin-'.$process.'-form-modal', 
										'dialog_id' =>  'escrot-bitcoin-'.$process.'-form-dialog',
										'is_on'     =>  escrot_option('enable_bitcoin_payment')
									),
					'Paypal' => array( 'image'     => 'paypal.png', 
									   'modal_id'  => 'escrot-paypal-'.$process.'-form-modal', 
									   'dialog_id' => 'escrot-paypal-'.$process.'-form-dialog',
									   'is_on'     =>  escrot_option('enable_paypal_payment')
									),
					'Manual' => array( 'image'     => 'manual_pay.png', 
									   'modal_id'  => 'escrot-manual-'.$process.'-form-modal', 
									   'dialog_id' => 'escrot-manual-'.$process.'-form-dialog',
									   'is_on'     =>  true
									)				
						
					);
	
?>
<div id="escrot-payment-options">
    <h2 class="pb-5 pricing-title text-center">Select <?= ucwords($process); ?> Gateway</h2>
    <div class="pricing pricing-palden">
		
		<?php foreach($payments as $title => $option){ if($option['is_on']) { ?>
		
			<div class="m-2 pricing-item features-item ja-animate" data-animation="move-from-bottom" data-delay="item-0" style="min-height: 350px;">
				<div class="pricing-deco">
					<svg class="pricing-deco-img" enable-background="new 0 0 300 100" height="100px" id="Layer_1" preserveAspectRatio="none" version="1.1" viewBox="0 0 300 100" width="300px" x="0px" xml:space="preserve" y="0px">
						<path class="deco-layer deco-layer--1" d="M30.913,43.944c0,0,42.911-34.464,87.51-14.191c77.31,35.14,113.304-1.952,146.638-4.729c48.654-4.056,69.94,16.218,69.94,16.218v54.396H30.913V43.944z" fill="#FFFFFF" opacity="0.6"></path>
						<path class="deco-layer deco-layer--2" d="M-35.667,44.628c0,0,42.91-34.463,87.51-14.191c77.31,35.141,113.304-1.952,146.639-4.729c48.653-4.055,69.939,16.218,69.939,16.218v54.396H-35.667V44.628z" fill="#FFFFFF" opacity="0.6"></path>
						<path class="deco-layer deco-layer--3" d="M43.415,98.342c0,0,48.283-68.927,109.133-68.927c65.886,0,97.983,67.914,97.983,67.914v3.716H42.401L43.415,98.342z" fill="#FFFFFF" opacity="0.7"></path>
						<path class="deco-layer deco-layer--4" d="M-34.667,62.998c0,0,56-45.667,120.316-27.839C167.484,57.842,197,41.332,232.286,30.428c53.07-16.399,104.047,36.903,104.047,36.903l1.333,36.667l-372-2.954L-34.667,62.998z" fill="#FFFFFF"></path>
					</svg>
					<h3 class="pricing-title"><?= $title; ?></h3>
					<?= escrot_image(ESCROT_PLUGIN_URL.'assets/img/'.$option['image'], 100, 'escrot-rounded'); ?>
				</div>
				
				<button class="pricing-action" id="escrot-bitcoin-pay" <?= ESCROT_INTERACTION_MODE == "modal"? 'data-toggle="modal" data-target="#'.$option['modal_id'].'"' : 'data-toggle="collapse" data-target="#'.$option['dialog_id'].'"'; ?> > Select </button>
			</div>
			
		<?php } } ?>
			
    </div>
</div>