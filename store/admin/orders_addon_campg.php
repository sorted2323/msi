<?php
      /* 
         Created by:		Spencer Lai
         Purpose:		Display Transaction Details for Moneris eSELECTplus Transactions
         Last Modified:		August 17, 2007
      */
      
            $baseTable = "(select moneris_order_id, gateway_url, osc_session, ref_num, f4l4, " .
                            "iso_code, resp_code, auth_code, trans_date, trans_time, " .
                            "trans_type, message, card_type, txn_num, avs_code, " .
                            "cvd_code, crypt_type, veres, pares " .
                            "from moneris_can_orders " .
                            "where osc_order_id = '" . tep_db_input($oID) . "'" .
                            ") as baseTable " ;
            
            $txnTable = "(select moneris_order_id, trans_type, txn_num " .
                           "from moneris_can_orders " .
                           "where trans_type='01' " .
                           "and osc_order_id = '" . tep_db_input($oID) . "'" .
                           ") as txnTable " ;
                           
            $strSQL = "select baseTable.moneris_order_id, baseTable.gateway_url, baseTable.osc_session, baseTable.ref_num, baseTable.f4l4, " .
                         "baseTable.resp_code, baseTable.iso_code, baseTable.auth_code, baseTable.trans_date, " .
                         "baseTable.trans_time, baseTable.trans_type, baseTable.message, " .
                         "baseTable.card_type, baseTable.txn_num, baseTable.avs_code, baseTable.cvd_code, " .
                         "baseTable.crypt_type, baseTable.veres, baseTable.pares, txnTable.txn_num orig_txn_num " . 
                         "from " . $baseTable . " " .
                         "cross join " . $txnTable . " " .
                         "where " .
                         "(baseTable.trans_type = '01' " .
                         "and baseTable.moneris_order_id = txnTable.moneris_order_id) " .
                         "or (baseTable.trans_type <> txnTable.trans_type) " .
                         "and (baseTable.moneris_order_id = txnTable.moneris_order_id) " ;
                         
            $moneris_order_query = tep_db_query($strSQL);

            if (tep_db_num_rows($moneris_order_query)) { 
            ?>   
            <tr>
              <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
            </tr>
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                  <td class="main" valign="top"><b>Transaction Details:</b></td>
      	    <td class="main"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      	      <?php 

      	        while ($moneris_order_detail = tep_db_fetch_array($moneris_order_query)) { 
      	              switch (strtoupper($moneris_order_detail['card_type'])) {
	      	        case 'V':
	      	          $card_type = 'Visa';
	      	          break;
	      	        case 'M':
	      	          $card_type = 'MasterCard';
	      	          break;
	      	        case 'AX':
	      	          $card_type = 'American Express';
	      	          break;
	      	        case 'SE':
	      	          $card_type = 'Sears Card';
	      	          break;
	      	        case 'C':
	      	          $card_type = 'JCB';
	      	          break;
	      	        case 'DC':
	      	          $card_type = 'Diners Card';
	      	          break;
	      	        case 'NO':
	      	          $card_type = 'Novus/Discover';
	      	          break;
	      	        default:
	      	          $card_type = 'UNKNOWN';
	      	          break;
	              }
      	              $order_link = "<a href='https://" . $moneris_order_detail['gateway_url'] . "/mpg/reports/order_history/index.php" .
      	                            "?order_no=" . $moneris_order_detail['moneris_order_id'] .
      	                            "&orig_txn_no=" . $moneris_order_detail['orig_txn_num'] . "' target='_mpg'>" . 
      	                            $moneris_order_detail['moneris_order_id'] .
      	                            "</a>";
	              $message = $moneris_order_detail['message'];
	              $message = str_replace("''", "'", $message);
      	      ?>
                    <tr>
                      <td class="smalltext" valign="top"><b>Moneris Order ID:</b></td>
                      <td class="smalltext"><?php echo $order_link ?></td>
                      <td class="smalltext"><b>Transaction Type:</b></td>
      	      	      <td class="smalltext"><?php echo (($moneris_order_detail['trans_type'] == '01') ? 'PreAuth' : 'Capture'); ?></td>
      	      	      
                    </tr>
                    <tr>
      	              <td class="smalltext"><b>Transaction Date:</b></td>
      	              <td class="smalltext"><?php echo $moneris_order_detail['trans_date']; ?></td>
      	              <td class="smalltext"><b>Transaction Time:</b></td>
      	              <td class="smalltext"><?php echo $moneris_order_detail['trans_time']; ?></td>
                    </tr>              
                    <tr>
                      <td class="smalltext"><b>Card Number:</b></td>
                      <td class="smalltext"><?php echo $moneris_order_detail['f4l4']; ?></td>  
      	      	      <td class="smalltext" valign="top"><b>Card Type:</b></td>
                      <td class="smalltext"><?php echo $card_type; ?></td>
                    </tr>
                    <tr>
                      <td class="smalltext"><b>ISO Code:</b></td>
      	      	      <td class="smalltext"><?php echo $moneris_order_detail['iso_code']; ?></td>                  
                      <td class="smalltext"><b>Response Code:</b></td>
                      <td class="smalltext"><?php echo $moneris_order_detail['resp_code']; ?></td>
                    </tr>                            
                    <tr>
                      <td class="smalltext"><b>AVS Result:</b></td>
                      <td class="smalltext"><?php echo (($moneris_order_detail['avs_code'] != '') ? $moneris_order_detail['avs_code'] : 'Did Not Perform'); ?></td>
                      <td class="smalltext"><b>CVD Result:</b></td>
                      <td class="smalltext"><?php echo (($moneris_order_detail['cvd_code'] != '') ? $moneris_order_detail['cvd_code'] : 'Did Not Perform'); ?></td>
                    </tr>
                    <tr>
                      <td class="smalltext"><b>VERes:</b></td>
                      <td class="smalltext"><?php echo (($moneris_order_detail['veres'] != '') ? $moneris_order_detail['veres'] : 'Did Not Perform'); ?></td>
                      <td class="smalltext"><b>PARes:</b></td>
                      <td class="smalltext"><?php echo (($moneris_order_detail['pares'] != '') ? $moneris_order_detail['pares'] : 'Did Not Perform'); ?></td>
                    </tr>                     
                    <tr>
                      <td class="smalltext"><b>Reference Number:</b></td>
                      <td class="smalltext"><?php echo $moneris_order_detail['ref_num']; ?></td>
                      <td class="smalltext"><b>Auth Code:</b></td>
      	      	      <td class="smalltext"><?php echo $moneris_order_detail['auth_code']; ?></td>                  
                    </tr>
                    <tr>
                      <td class="smalltext"><b>Message:</b></td>
                      <td class="smalltext"><?php echo $message; ?></td>
                      <td class="smalltext"><b>Crypt Type:</b></td>
                      <td class="smalltext"><?php echo $moneris_order_detail['crypt_type']; ?></td>
                    </tr>
                   
                    <tr>
                      <td class="smalltext" colspan="4"><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
                    </tr>
                  <?php
                  }
                  ?>
                  </table></td>
                </tr>
              </table></td>
            </tr>
      <?php
            } //end if
?> 