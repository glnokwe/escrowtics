<span class="navbar-brand">
	<a href="admin.php?page=escrowtics-dashboard"><i class="text-light fas fa-home"></i></a> 
	<b style="color: #a9afbbd1;">::</b>
	<a class="text-light" href="<?= $_SERVER['REQUEST_URI']; ?>" style="text-decoration: none; font-weight: bold">		
		<?php 
		$break_current_url = explode('=', $_SERVER['REQUEST_URI']);
		$slug = explode('-', $break_current_url[1]);
		  
		if(isset($_GET["user_id"]) || isset($_GET["escrow_id"])) {
			if(isset($_GET["user_id"]))  { 
				$user = get_user_by('ID', absint($_GET["user_id"]) ); 
				$breadcrp = $slug[1].'<b style="color: #a9afbbd1;">::</b>'.$user->first_name.' '.$user->last_name;
			}
			if(isset($_GET["escrow_id"])){ 
				$data = escrot_get_escrow_data( absint($_GET["escrow_id"]) ); 
				$breadcrp = 'View Escrow <b style="color: #a9afbbd1;">::</b> '.$data["payer"].' & '.$data["earner"];
			}				   
		} else {	  
		   if(count($slug)<3) {
			  $breadcrp = $slug[1]; 
		   } else {
			  $breadcrp = $slug[1].' '.$slug[2];
		   }
		}
		  echo ucwords($breadcrp); ?>
	</a>
</span>