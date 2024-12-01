<?php 
 /**
 * Escrow Search Results.
 * Show table formated results for escrow search.
 * @since      1.0.0
 * @package    Escrowtics
 */ 

        $output = '';
		
		$trans = [$text => '<b>'.$text.'</b>'];//Translate search phrase to Bold
	  
        $searches = $this->escrowSearchData($text);
	    $search_count = $this->escrowSearchCount($text);

        if ($search_count > 0) { 
		
            $output .=' 
			    <h5 class="text-light">'.__("Search Results for Phrase", "escrowtics").' <small>"'.$text.'"</small></h5>
                <table class="escrot-table-numbering table" id="escrot-escrow-search-results-tbl">
					<thead class="tbl-head">
						<tr>
							<th>'.__("No.", "escrowtics").'</th>
							<th>'.__("Payer", "escrowtics").'</th>
							<th>'.__("Earner", "escrowtics").'</th>
							<th>'.__("Created Date", "escrowtics").'</th>
							<th>'.__("<center>Action</center>", "escrowtics").'</th>
						</tr>
					</thead>	
						  
                    <tbody>';
							
						foreach ($searches as $search) {

						   $output .="
							<tr>
								<td style='font-weight: bold;'></td>
								<td>".strtr($search['payer'], $trans)."</td>
								<td>".strtr($search['earner'], $trans)."</td>
								<td>".strtr($search['creation_date'], $trans)."</td>
								<td class='text-right'>
								    <right>
										<a href='admin.php?page=escrowtics-view-escrow&escrow_id=".$search['escrow_id']."' class='btn btn-behance btn-icon-text escrot-btn-sm'> 
											<i class='fas fa-eye'></i> &nbsp;".__('View Transaction', 'escrowtics')."
										</a>
										<a href='#' id='".$search['escrow_id']."' class='btn btn-danger btn-icon-text escrot-btn-sm escrot-delete-btn' data-action='escrot_del_escrow'> 
											<i class='fas fa-trash'></i> &nbsp;".__('Delete', 'escrowtics')."
										</a>
									</right>
									</td> 
					       </tr>";	
						}							 
				   
 				        $output .='	
                  </tbody>
                </table>';
				
        } else{
		    $output.='<h4 class="text-light text-center mt-2">'.__("No results found for phrase", "escrowtics").' "'.$text.'"</h4>';
        }
		wp_send_json(["data" => $output, "search_text" => $text, "mode" => ESCROT_PLUGIN_INTERACTION_MODE]);