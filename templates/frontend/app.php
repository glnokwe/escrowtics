<?php
/**
 * Main public template (The App)
 *
 * @since    1.0.0
 * @package  FneHousing
 */
 
$trans = array(
    'Payer'  => escrot_option('escrow_payer_label'),
	'Earner' => escrot_option('escrow_earner_label')
);

// Start output buffering to capture all echoed content
ob_start();
?>

<div class="escrot-main-panel" id="escrot-front-wrapper">
    <?php
        echo escrot_ajax_loader('working..');
    
        if(is_user_logged_in()){
            if(escrot_is_front_user()){ //Allow only Escrowtics users
                include ESCROT_PLUGIN_PATH."templates/frontend/user-profile.php";
            
                if(ESCROT_INTERACTION_MODE == "modal") { 
                    include_once ESCROT_PLUGIN_PATH."templates/frontend/front-modals.php"; 
                }   
            } else { 
                include ESCROT_PLUGIN_PATH."templates/frontend/user-login.php"; 
            }               
        } else { 
            include ESCROT_PLUGIN_PATH."templates/frontend/user-login.php"; 
        }
    ?>
</div>

<?php

// Get the buffered content
$content = ob_get_clean();

// Transform the content using strtr
$updatedContent = strtr($content, $trans);

// Output or save the transformed content
echo $updatedContent;

