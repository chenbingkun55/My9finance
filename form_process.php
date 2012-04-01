<?PHP 				
	session_start();
	require_once("config.inc.php");
	require_once(INCLUDE_PATH.'finance.inc.php');


		if ($_POST['login'])  $form_name = str_replace(" ","",$_POST['login']);
		if ($_POST['addmantype']) $form_name = str_replace(" ","",$_POST['addmantype']);
		if ($_POST['alterinmantype']) $form_name = str_replace(" ","",$_POST['alterinmantype']);
		if ($_POST['alteroutmantype']) $form_name = str_replace(" ","",$_POST['alteroutmantype']);
		if ($_POST['deleteinmantype']) $form_name = str_replace(" ","",$_POST['deleteinmantype']);
		if ($_POST['deleteoutmantype']) $form_name = str_replace(" ","",$_POST['deleteoutmantype']);
		if ($_POST['addinsubtype']) $form_name = str_replace(" ","",$_POST['addinsubtype']);
		if ($_POST['addoutsubtype']) $form_name = str_replace(" ","",$_POST['addoutsubtype']);
		if ($_POST['alterinsubtype']) $form_name = str_replace(" ","",$_POST['alterinsubtype']);
		if ($_POST['alteroutsubtype']) $form_name = str_replace(" ","",$_POST['alteroutsubtype']);
		if ($_POST['deleteinsubtype']) $form_name = str_replace(" ","",$_POST['deleteinsubtype']);
		if ($_POST['deleteoutsubtype']) $form_name = str_replace(" ","",$_POST['deleteoutsubtype']);
		if ($_POST['addaddress']) $form_name = str_replace(" ","",$_POST['addaddress']);
		if ($_POST['deleteaddress']) $form_name = str_replace(" ","",$_POST['deleteaddress']);
		if ($_POST['addoutcorde']) $form_name = str_replace(" ","",$_POST['addoutcorde']);
		if ($_POST['alteroutcorde']) $form_name = str_replace(" ","",$_POST['alteroutcorde']);
		if ($_POST['deleteoutcorde']) $form_name = str_replace(" ","",$_POST['deleteoutcorde']);
		if ($_POST['addincorde']) $form_name = str_replace(" ","",$_POST['addincorde']);
		if ($_POST['alterincorde']) $form_name = str_replace(" ","",$_POST['alterincorde']);
		if ($_POST['deleteincorde']) $form_name = str_replace(" ","",$_POST['deleteincorde']);
		if ($_POST['adduser']) $form_name = str_replace(" ","",$_POST['adduser']);
		if ($_POST['alteruser']) $form_name = str_replace(" ","",$_POST['alteruser']);
		if ($_POST['deleteuser']) $form_name = str_replace(" ","",$_POST['deleteuser']);
		if ($_POST['addgroup']) $form_name = str_replace(" ","",$_POST['addgroup']);
		if ($_POST['altergroup']) $form_name = str_replace(" ","",$_POST['altergroup']);
		if ($_POST['deletegroup']) $form_name = str_replace(" ","",$_POST['deletegroup']);
		if ($_POST['addtogroup']) $form_name = str_replace(" ","",$_POST['addtogroup']);
		if ($_POST['new_member']) $form_name = str_replace(" ","",$_POST['new_member']);
		if ($_POST['delete_member']) $form_name = str_replace(" ","",$_POST['delete_member']);
		if ($_POST['addlog']) $form_name = str_replace(" ","",$_POST['addlog']);
		if ($_POST['alterlog']) $form_name = str_replace(" ","",$_POST['alterlog']);
		if ($_POST['deletelog']) $form_name = str_replace(" ","",$_POST['deletelog']);
		if ($_POST['taxis_front']) $form_name = str_replace(" ","",$_POST['taxis_front']);
		if ($_POST['taxis_after']) $form_name = str_replace(" ","",$_POST['taxis_after']);


		switch ($form_name) {
			case  "LOGIN": 
				$username = $_POST['username'];
				$password = $_POST['password'];
				$_SESSION['__error_logid'] = "0";

				
				/* 判断登录用户 */
				$_SESSION['__useralive'] = $Finance->login($username,  $password);	
				$_SESSION['__username'] = $Finance->convertUserID($_SESSION['__useralive'][0]);
				$Finance->refurbishUserSession($_SESSION['__useralive'][0]);
				if( $_SESSION['__username'] == $username )
				{ 
					if ( $Finance->getUserResideGroup())
					{
						$_SESSION['__group_id'] = $Finance->getUserResideGroup();
					} else {
						$_SESSION['__group_id'] = "0";
					}

					if(empty( $_SESSION['__useralive'][1]))
					{
						$_SESSION['__error_logid'] = "5001";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
					} else {
						$_SESSION['__username']  = $_SESSION['__useralive'][1];
						$_SESSION['__error_logid'] = "5000";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
					}
				} else {
					if($_SESSION['__useralive'] == "useralive")
					{
						$_SESSION['__error_logid'] = "2";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
					} else {
						$_SESSION['__error_logid'] = "1";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
					}
				}
				break;

			case $_ADD_LOG_RESOLVE: 
				$log_id = $_POST['log_id'];
				$content = $_POST['content'];

				$result = $Finance->insertLogResolve($log_id,$content);
				if ($result)
				{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
				} else {
					$_SESSION['__error_logid'] = "3";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
				}
				break;

		case "ADDINMANTYPE":
					$store_max = $Finance->getMaxManStore("_in_mantype");
					$store = $store_max['0']['0'] + 1;

					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;
					$addmantypename = $_POST['addmantypename'];

					$_SESSION['__gettype'] = "ADDINMANTYPE";

					if( $Finance->insertInManType($_SESSION['__useralive'][0],$store,$is_display,$addmantypename)) 
					{
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					} else {
							$_SESSION['__error_logid'] = "5054";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
				break;

		case "ALTERINMANTYPE":
					$_SESSION['__gettype'] = "ALTERINMANTYPE";
					$_SESSION['__gettype_id'] = $_POST["in_mantype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;

					
					if ( $_POST["alteractive"] == 1 )
					{			
						if ($Finance->updateManType("_in_mantype",$is_display,$_POST["altermantypename"],$_SESSION['__gettype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							$_SESSION['__gettype'] = "ADDINMANTYPE";
						} else {
							$_SESSION['__error_logid'] = "5000";
							$_SESSION['__gettype'] = "ADDINMANTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
						
					} else {
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;

		case "DELETEINMANTYPE":
					$_SESSION['__gettype'] = "ADDINMANTYPE";
					$_SESSION['__gettype_id'] = $_POST["in_mantype_id"];
					
					if ($Finance->deleteManType("_in_mantype",$_SESSION['__gettype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}

					break;

		case "ADDINSUBTYPE":

					$store_max = $Finance->getMaxSubStore("_in_subtype",$_POST["in_mantype_id"]);
					$store = $store_max['0']['0'] + 1;

					$_SESSION['__gettype_id'] = $_POST["in_mantype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;
					$addsubtypename = $_POST['addsubtypename'];
					$_SESSION['__gettype'] = "ADDINSUBTYPE";

					if ( $_POST["alteractive"] == 1 )
					{
						if ($Finance->insertSubType("_in_subtype",$_SESSION['__gettype_id'],$store,$is_display,$addsubtypename))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
					} else {
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;



		case "ALTERINSUBTYPE":
					$_SESSION['__gettype_id'] = $_POST["in_mantype_id"];
					$_SESSION['__getsubtype_id'] = $_POST["in_subtype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;

					if ( $_POST["alteractive"] == 1 )
					{

						if ($Finance->updateSubType("_in_subtype",$_SESSION['__getsubtype_id'],$is_display,$_POST["altersubtypename"]))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							$_SESSION['__gettype'] = "ADDINSUBTYPE";
						} else {
							$_SESSION['__error_logid'] = "5000";
							$_SESSION['__gettype'] = "ADDINSUBTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
					} else {
						$_SESSION['__gettype'] = "ALTERINSUBTYPE";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;

		case "DELETEINSUBTYPE":
					$_SESSION['__gettype'] = "ADDINSUBTYPE";
					$_SESSION['__gettsubype_id'] = $_POST["in_subtype_id"];
					
					if ($Finance->deleteSubType("_in_subtype",$_SESSION['__gettsubype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}

					break;

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


			case "ADDOUTMANTYPE":

					$store_max = $Finance->getMaxManStore("_out_mantype");
					$store = $store_max['0']['0'] + 1;

					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;
					$addmantypename = $_POST['addmantypename'];

					$_SESSION['__gettype'] = "ADDOUTMANTYPE";

					if( $Finance->insertOutManType($_SESSION['__useralive'][0],$store,$is_display,$addmantypename)) 
					{
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					} else {
							$_SESSION['__error_logid'] = "5054";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
				break;

		case "ALTEROUTMANTYPE":
					$_SESSION['__gettype'] = "ALTEROUTMANTYPE";
					$_SESSION['__gettype_id'] = $_POST["out_mantype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;

					
					if ( $_POST["alteractive"] == 1 )
					{	
						if ($Finance->updateManType("_out_mantype",$is_display,$_POST["altermantypename"],$_SESSION['__gettype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							$_SESSION['__gettype'] = "ADDOUTMANTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						} else {
							$_SESSION['__error_logid'] = "5000";
							$_SESSION['__gettype'] = "ADDOUTMANTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
						
					} else {
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;

		case "DELETEOUTMANTYPE":
					$_SESSION['__gettype'] = "ADDOUTMANTYPE";
					$_SESSION['__gettype_id'] = $_POST["out_mantype_id"];
					
					if ($Finance->deleteManType("_out_mantype",$_SESSION['__gettype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}

					break;

		case "ADDOUTSUBTYPE":
					$store_max = $Finance->getMaxSubStore("_out_subtype",$_POST["out_mantype_id"]);
					$store = $store_max['0']['0'] + 1;

					$_SESSION['__gettype_id'] = $_POST["out_mantype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;
					$addsubtypename = $_POST['addsubtypename'];
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";

					if ( $_POST["alteractive"] == 1 )
					{
						if ($Finance->insertSubType("_out_subtype",$_SESSION['__gettype_id'],$store,$is_display,$addsubtypename))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
					} else {
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;



		case "ALTEROUTSUBTYPE":
					$_SESSION['__gettype_id'] = $_POST["out_mantype_id"];
					$_SESSION['__getsubtype_id'] = $_POST["out_subtype_id"];
					$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;

					if ( $_POST["alteractive"] == 1 )
					{

						if ($Finance->updateSubType("_out_subtype",$_SESSION['__getsubtype_id'],$is_display,$_POST["altersubtypename"]))
						{				
							$_SESSION['__error_logid'] = "1";
							$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}
					} else {
						$_SESSION['__gettype'] = "ALTEROUTSUBTYPE";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
					}
					break;

		case "DELETEOUTSUBTYPE":
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
					$_SESSION['__gettsubype_id'] = $_POST["out_subtype_id"];
					
					if ($Finance->deleteSubType("_out_subtype",$_SESSION['__gettsubype_id']))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
						}

					break;

		case "TAXISMANFRONT":

			if($Finance->TaxisManFront($_POST['taxis_table'],$_POST['store'])) 
			{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			} else {
					$_SESSION['__error_logid'] = "5054";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			}
						
			switch ($_POST['taxis_table']) {
				case "_out_mantype": 
					$_SESSION['__gettype'] = "ADDOUTMANTYPE";
					break;
				case "_in_mantype":
					$_SESSION['__gettype'] = "ADDINMANTYPE";
					break;
				case "_out_subtype": 
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
					break;
				case "_in_subtype": 
					$_SESSION['__gettype'] = "ADDINSUBTYPE";
					break;
				case "_address": 
					$_SESSION['__gettype'] = "ADDADDRESS";
					break;
				default:
				echo "执行了默认操作";
				break;
			}
		break;

		case "TAXISMANAFTER":
			
			if($Finance->TaxisManAfter($_POST['taxis_table'],$_POST['store'])) 
			{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			} else {
					$_SESSION['__error_logid'] = "5054";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			}
			switch ($_POST['taxis_table']) {
				case "_out_mantype": 
					$_SESSION['__gettype'] = "ADDOUTMANTYPE";
					break;
				case "_in_mantype":
					$_SESSION['__gettype'] = "ADDINMANTYPE";
					break;
				case "_out_subtype": 
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
					break;
				case "_in_subtype": 
					$_SESSION['__gettype'] = "ADDINSUBTYPE";
					break;
				case "_address": 
					$_SESSION['__gettype'] = "ADDADDRESS";
					break;
				default:
				echo "执行了默认操作";
				break;
			}

		break;

		case "TAXISSUBFRONT":

			if($Finance->TaxisSubFront($_POST['taxis_table'],$_POST['mantype_id'],$_POST['store'])) 
			{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			} else {
					$_SESSION['__error_logid'] = "5054";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			}
						
			switch ($_POST['taxis_table']) {
				case "_out_mantype": 
					$_SESSION['__gettype'] = "ADDOUTMANTYPE";
					break;
				case "_in_mantype":
					$_SESSION['__gettype'] = "ADDINMANTYPE";
					break;
				case "_out_subtype": 
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
					break;
				case "_in_subtype": 
					$_SESSION['__gettype'] = "ADDINSUBTYPE";
					break;
				case "_address": 
					$_SESSION['__gettype'] = "ADDADDRESS";
					break;
				default:
				echo "执行了默认操作";
				break;
			}
		break;

		case "TAXISSUBAFTER":
			
			if($Finance->TaxisSubAfter($_POST['taxis_table'],$_POST['mantype_id'],$_POST['store'])) 
			{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			} else {
					$_SESSION['__error_logid'] = "5054";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_type.php\">";
			}
			switch ($_POST['taxis_table']) {
				case "_out_mantype": 
					$_SESSION['__gettype'] = "ADDOUTMANTYPE";
					break;
				case "_in_mantype":
					$_SESSION['__gettype'] = "ADDINMANTYPE";
					break;
				case "_out_subtype": 
					$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
					break;
				case "_in_subtype": 
					$_SESSION['__gettype'] = "ADDINSUBTYPE";
					break;
				case "_address": 
					$_SESSION['__gettype'] = "ADDADDRESS";
					break;
				default:
				echo "执行了默认操作";
				break;
			}

		break;
		

		case "ADDADDRESS": 
				$addr_name = $_POST['addr_name'];
				$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;

				$store_max = $Finance->getMaxAddrStore();
				$store =  $store_max['0']['0'] + 1;
				
				$result = $Finance->insertAddress($store,$is_display,$addr_name);
				if ($result)
				{
					$_SESSION['__error_logid'] = "5000";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				} else {
					$_SESSION['__error_logid'] = "3";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				}
			break;
			
		case "ALTERADDRESS":
					$_SESSION['__gettype'] = "ADDADDRESS";
					$_SESSION['__gettype_id'] = $_POST["address_id"];

					if ( $_POST["alteractive"] == 1 )
					{				
						$_POST['is_display'] == "on" ? $is_display = "1" : $is_display = "0" ;
						$addr_name = $_POST["addr_name"];

						if ($Finance->updateAddress($_SESSION['__gettype_id'],$addr_name,$is_display))
						{				
							$_SESSION['__error_logid'] = "1";							
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
						}
					} else {
						$_SESSION['__gettype'] = "ALTERADDRESS";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
					}

					break;

		case "DELETEADDRESS":
					$address_id = $_POST["address_id"];
					
					if ($Finance->deleteAddress($address_id))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
						}

					break;

			case "TAXISADDRFRONT":

				if($Finance->TaxisAddrFront($_POST['taxis_table'],$_POST['store'])) 
				{
						$_SESSION['__error_logid'] = "5000";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				} else {
						$_SESSION['__error_logid'] = "5054";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				}
							
				switch ($_POST['taxis_table']) {
					case "_out_mantype": 
						$_SESSION['__gettype'] = "ADDOUTMANTYPE";
						break;
					case "_in_mantype":
						$_SESSION['__gettype'] = "ADDINMANTYPE";
						break;
					case "_out_subtype": 
						$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
						break;
					case "_in_subtype": 
						$_SESSION['__gettype'] = "ADDINSUBTYPE";
						break;
					case "_address": 
						$_SESSION['__gettype'] = "ADDADDRESS";
						break;
					default:
					echo "执行了默认操作";
					break;
				}
			break;

			case "TAXISADDRAFTER":
				
				if($Finance->TaxisAddrAfter($_POST['taxis_table'],$_POST['store'])) 
				{
						$_SESSION['__error_logid'] = "5000";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				} else {
						$_SESSION['__error_logid'] = "5054";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_addr.php\">";
				}
				switch ($_POST['taxis_table']) {
					case "_out_mantype": 
						$_SESSION['__gettype'] = "ADDOUTMANTYPE";
						break;
					case "_in_mantype":
						$_SESSION['__gettype'] = "ADDINMANTYPE";
						break;
					case "_out_subtype": 
						$_SESSION['__gettype'] = "ADDOUTSUBTYPE";
						break;
					case "_in_subtype": 
						$_SESSION['__gettype'] = "ADDINSUBTYPE";
						break;
					case "_address": 
						$_SESSION['__gettype'] = "ADDADDRESS";
						break;
					default:
					echo "执行了默认操作";
					break;
				}

			break;



			case "ADDOUTCORDE":
					$money = $_POST["numlist_1000"].$_POST["numlist_100"].$_POST["numlist_10"].$_POST["numlist_1"].".".$_POST["numlist_01"].$_POST["numlist_001"];
					$out_mantype_id = $_POST["out_mantype_id"];
					$out_subtype_id = $_POST["out_subtype_id"];
					$address_id = $_POST["address_id"];
					$notes = $_POST["notes"];


				$_SESSION['__gettype'] = "ADDOUTCORDE";
				if ($Finance->insertInOutRecord("_out_corde",$money,$out_mantype_id,$out_subtype_id,$address_id,$notes))
				{
						$_SESSION['__error_logid'] = "5010";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
				} else {
						$_SESSION['__error_logid'] = "1010";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
				}
				break;

		case "ALTEROUTCORDE":
					$out_corde_id = $_POST["out_corde_id"];
					$out_mantype_id = $_POST["out_mantype_id"];
					$out_subtype_id = $_POST["out_subtype_id"];
					$address_id = $_POST["address_id"];
					$money = $_POST["money"];
					$notes = $_POST["notes"];

					require_once("head.php");

				if ( $_POST["alteractive"]  == 1 )
				{ 
						$money = $_POST["numlist_1000"].$_POST["numlist_100"].$_POST["numlist_10"].$_POST["numlist_1"].".".$_POST["numlist_01"].$_POST["numlist_001"];
						if ($Finance->updateOutCorde($out_corde_id,$money,$out_mantype_id,$out_subtype_id,$address_id,$notes))
						{				
							$_SESSION['__error_logid'] = "5012";		
							$_SESSION['__gettype']  = "ADDOUTCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";	
						} else {
							$_SESSION['__error_logid'] = "1012";		
							$_SESSION['__gettype']  = "ADDOUTCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";	
						}
				} else {
				?>
					<FORM  action="form_process.php" method="POST" >
								<?PHP 
								echo $_OUT.": ";
								?>
									<SELECT NAME="out_mantype_id" size="1" >
									<?PHP
										echo "<option value=".$out_mantype_id." selected=\"selected\">".$Finance->convertIdToNmae("_out_mantype",$out_mantype_id)."</option>\n";		
										$out_mantype_list = $Finance->getInOutType("_out_mantype");
										foreach( $out_mantype_list as $key => $value )
										{
											if ( $value['id'] == $out_mantype_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}

									?>
									</SELECT>
									<SELECT NAME="out_subtype_id" size="1" >
									<?PHP
										$out_subtype_list = $Finance->getInOutType("_out_subtype");
										echo "<option value=".$out_subtype_id." selected=\"selected\">".$Finance->convertIdToNmae("_out_subtype",$out_subtype_id)."</option>\n";		
										foreach( $out_subtype_list as $key => $value )
										{
											if ( $value['id'] == $out_subtype_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}

									?>
									</SELECT>
									<BR>地点：
									<SELECT NAME="address_id" size="1" >
									<?PHP
										$address = $Finance->getInOutType("_address");
										echo "<option value=".$address_id." selected=\"selected\">".$Finance->convertIdToNmae("_address",$address_id)."</option>\n";	
										foreach( $address as $key => $value )
										{
											if ( $value['id'] == $address_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}
									?>
									</SELECT>				
									<BR>
									<?PHP $Finance->NumList(); echo $_YUAN?>
									<BR><?PHP echo $_NOTES?><BR>
									<input type="text" name="notes" size="10" maxlength="50" value ="<?PHP echo $notes?>">
									<INPUT type="hidden" name="out_corde_id" value="<?PHP echo $out_corde_id ?>">
									<INPUT type="hidden" name="alteractive" value="1">
									<input type="hidden" name="alteroutcorde" value="ALTEROUTCORDE">
									<INPUT type="submit" value="<?PHP echo $_ALTER.$_ADD_OUT?>">
							</FORM>
	
			<?PHP
							}
					break;
			case "DELETEOUTCORDE":
					$outcorde_id = $_POST["outcorde_id"];
					
					if ($Finance->deleteInOutCorde("_out_corde",$outcorde_id))
						{				
							$_SESSION['__error_logid'] = "5014";
							$_SESSION['__gettype']  = "ADDOUTCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "1014";
							$_SESSION['__gettype']  = "ADDOUTCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
						}
				break;

			case "ADDINCORDE":
					$money = $_POST["numlist_1000"].$_POST["numlist_100"].$_POST["numlist_10"].$_POST["numlist_1"].".".$_POST["numlist_01"].$_POST["numlist_001"];
					$in_mantype_id = $_POST["in_mantype_id"];
					$in_subtype_id = $_POST["in_subtype_id"];
					$address_id = $_POST["address_id"];
					$notes = $_POST["notes"];


				$_SESSION['__gettype'] = "ADDINCORDE";
				if ($Finance->insertInOutRecord("_in_corde",$money,$in_mantype_id,$in_subtype_id,$address_id,$notes))
				{
						$_SESSION['__error_logid'] = "5011";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
				} else {
						$_SESSION['__error_logid'] = "1011";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
				}
				break;

		case "ALTERINCORDE":
					$in_corde_id = $_POST["in_corde_id"];
					$in_mantype_id = $_POST["in_mantype_id"];
					$in_subtype_id = $_POST["in_subtype_id"];
					$address_id = $_POST["address_id"];
					$money = $_POST["money"];
					$notes = $_POST["notes"];

					require_once("head.php");

				if ( $_POST["alteractive"]  == 1 )
				{ 
						$money = $_POST["numlist_1000"].$_POST["numlist_100"].$_POST["numlist_10"].$_POST["numlist_1"].".".$_POST["numlist_01"].$_POST["numlist_001"];
						if ($Finance->updateInCorde($in_corde_id,$money,$in_mantype_id,$in_subtype_id,$address_id,$notes))
						{				
							$_SESSION['__error_logid'] = "5012";		
							$_SESSION['__gettype']  = "ADDINCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";	
						} else {
							$_SESSION['__error_logid'] = "1012";		
							$_SESSION['__gettype']  = "ADDINCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";	
						}
				} else {
				?>
					<FORM  action="form_process.php" method="POST" >
								<?PHP 
								echo $_IN.": ";
								?>
									<SELECT NAME="in_mantype_id" size="1" >
									<?PHP
										echo "<option value=".$in_mantype_id." selected=\"selected\">".$Finance->convertIdToNmae("_in_mantype",$in_mantype_id)."</option>\n";		
										$in_mantype_list = $Finance->getInOutType("_in_mantype");
										foreach( $in_mantype_list as $key => $value )
										{
											if ( $value['id'] == $in_mantype_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}

									?>
									</SELECT>
									<SELECT NAME="in_subtype_id" size="1" >
									<?PHP
										$in_subtype_list = $Finance->getInOutType("_in_subtype");
										echo "<option value=".$in_subtype_id." selected=\"selected\">".$Finance->convertIdToNmae("_in_subtype",$in_subtype_id)."</option>\n";		
										foreach( $in_subtype_list as $key => $value )
										{
											if ( $value['id'] == $in_subtype_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}

									?>
									</SELECT>
									<BR>地点：
									<SELECT NAME="address_id" size="1" >
									<?PHP
										$address = $Finance->getInOutType("_address");
										echo "<option value=".$address_id." selected=\"selected\">".$Finance->convertIdToNmae("_address",$address_id)."</option>\n";	
										foreach( $address as $key => $value )
										{
											if ( $value['id'] == $address_id )  continue;
											echo "<option value=".$value['id'].">".$value['name']."</option>\n";		
										}
									?>
									</SELECT>				
									<BR>
									<?PHP $Finance->NumList(); echo $_YUAN?>
									<BR><?PHP echo $_NOTES?><BR>
									<input type="text" name="notes" size="10" maxlength="50" value ="<?PHP echo $notes?>">
									<INPUT type="hidden" name="in_corde_id" value="<?PHP echo $in_corde_id ?>">
									<INPUT type="hidden" name="alteractive" value="1">
									<input type="hidden" name="alterincorde" value="ALTERINCORDE">
									<INPUT type="submit" value="<?PHP echo $_ALTER.$_ADD_IN?>">
							</FORM>
	
			<?PHP
							}
					break;
			case "DELETEINCORDE":
					$incorde_id = $_POST["incorde_id"];
					
					if ($Finance->deleteInOutCorde("_in_corde",$incorde_id))
						{				
							$_SESSION['__error_logid'] = "5015";
							$_SESSION['__gettype']  = "ADDINCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "1015";
							$_SESSION['__gettype']  = "ADDINCORDE";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=in_out_record.php\">";
						}
				break;

			case "ADDUSER":
					$user_name = $_POST["user_name"];
					$user_alias = $_POST["user_alias"];
					$user_password = $_POST["user_password"];
					$group_id = $_POST["group_id"];
					$notes = $_POST["notes"];


				$_SESSION['__gettype'] = "ADDUSER";
				if ($Finance->insertUser($user_name,$user_alias,$user_password,$notes))
				{
					
						$user_id = $Finance->getUserID($user_name);
						/* 如果是管理添加用户，则$register为空。 */
						if (empty($register)) 
						{
							$Finance->insertUserGroup($user_id['0']['0'],$group_id);
						}

						/* 插入新用户的默认值 */
						$Finance->insertManTypeDefault($user_id['0']['0']);
						$Finance->insertSubTypeDefault($user_id['0']['0']);
						$Finance->insertAddressDefault($user_id['0']['0']);

						$_SESSION['__error_logid'] = "5016";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
				} else {
						$_SESSION['__error_logid'] = "1016";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
				}

				
				
				break;

			case "ALTERUSER":
					if ( $_POST["alteractive"]  == 1 )
					{ 
									if (empty($_POST["user_password"] ))
									{
													if ($Finance->updateUser($_POST["user_name"],$_POST["user_alias"],$_POST["user_password_old"],$_POST["notes"]))
													{	
														$_SESSION['__error_logid'] = "5017";		
														echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";	
														
													} else {
														$_SESSION['__error_logid'] = "1017";		
														echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
													}
									} else {
													if ( $_SESSION['__useralive'][0] == 1 && $_SESSION['__gettype_id'] != 1 )
													{			
																	if ( $Finance->updateUser($_POST["user_name"],$_POST["user_alias"],$_POST["user_password"],$_POST["notes"]))
																	{
																			$_SESSION['__error_logid'] = "5020";
																				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
																	} else {
																				$_SESSION['__error_logid'] = "1019";
																				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
																	}					
													} else {
																	if ( $Finance->updateUser( $_POST["user_name"],$_POST["user_alias"],$_POST["user_password"],$_POST["notes"]))
																	{
																				$_SESSION['__error_logid'] = "5019";
																				$_SESSION['__username'] = "";
																				echo $Finance->convertLogIdToContent($_SESSION['__error_logid'] );
																				echo "<BR><BR><a href=\"index.php\"><<返回  登录页面</a>";
																	} else {
																				$_SESSION['__error_logid'] = "1019";
																				echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
																	}					
													}
									}
						} else {
							$_SESSION['__gettype'] = "ALTERUSER";
							$_SESSION['__gettype_id'] = $_POST['user_id'];
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
						}
				break;

		case "DELETEUSER":	
					$Finance->deleteUserData("_out_corde",$_POST["user_id"]);
					$Finance->deleteUserData("_in_corde",$_POST["user_id"]);
					$Finance->deleteUserData("_out_subtype",$_POST["user_id"]);
					$Finance->deleteUserData("_out_mantype",$_POST["user_id"]);
					$Finance->deleteUserData("_in_subtype",$_POST["user_id"]);
					$Finance->deleteUserData("_in_mantype",$_POST["user_id"]);
					$Finance->deleteUserData("_address",$_POST["user_id"]);
					$Finance->deleteUserGroup($_POST["user_id"]);
					if ($Finance->deleteUser($_POST["user_id"]))
						{				
							$_SESSION['__error_logid'] = "5018";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "1018";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_user.php\">";
						}
				break;

			case "ADDGROUP":

				$_SESSION['__gettype'] = "ADDGROUP";
				if ($Finance->insertGroup($_POST['group_name'],$_POST['group_alias'],$_POST['group_password'],$_POST['notes']))
				{
						$Finance->insertUserGroup($_SESSION['__useralive'][0],$Finance->getGroupAdminID());
						if ($_SESSION['__useralive'][0] == 1 )
						{
							$_SESSION['__error_logid'] = "5016";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
						} else {

							$_SESSION['__error_logid'] = "5016";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";						
						}
				} else {
						if ($_SESSION['__useralive'][0] == 1 )
						{
							$_SESSION['__error_logid'] = "1016";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
						} else {
							$_SESSION['__error_logid'] = "1016";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";						
						}
				}
				break;


			case "ALTERGROUP":
					if ( $_POST["alteractive"]  == 1 )
					{ 
						if ( $_SESSION['__useralive'][0] == 1 ||  $Finance->getGroupAdmin($_POST['group_id'],$_SESSION['__useralive'][0]) )
						{
							if (empty($_POST["group_password"] ))
							{
								if ($Finance->updateGroup($_POST["group_name"],$_POST["group_alias"],$_POST["group_password_old"],$_POST["notes"]))
								{				
									$_SESSION['__error_logid'] = "5017";	
									$_SESSION['__gettype'] = "ADDGROUP";
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";	
								} else {
									$_SESSION['__error_logid'] = "1017";		
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
								}
							} else {
								if ( $Finance->updateGroup( $_POST["group_name"],$_POST["group_alias"],$_POST["group_password"],$_POST["notes"]))
								{
									$_SESSION['__error_logid'] = "5019";
									$_SESSION['__gettype'] = "ADDGROUP";
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
								} else {
									$_SESSION['__error_logid'] = "1019";
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
								}
							}
						}
					} else {
						$_SESSION['__gettype'] = "ALTERGROUP";
						$_SESSION['__gettype_id'] = $_POST['group_id'];
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
					}
				break;

		case "DELETEGROUP":					
				if ($_POST['groupadmin'] == 1 )
				{
					if ($Finance->deleteUserGroupForAdmin() && $Finance->deleteUserDataForGroupAdmin("_out_corde") && $Finance->deleteUserDataForGroupAdmin("_in_corde"))
					{
						echo "删除管理员组成功！";
					} else {
						$_SESSION['__error_logid'] = "1018";
						echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";
					}
				}

				if ($Finance->deleteGroup($_POST["group_id"]))
				{				
					$_SESSION['__error_logid'] = "5018";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
				} else {
					$_SESSION['__error_logid'] = "1018";
					echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_group.php\">";
				}
				break;


			case "ADDLOG":

						echo $_POST["log_id"]."TE" ;
						echo $_POST["content"]."TEE";

							if ($Finance->insertLogResolve($_POST["log_id"] ,$_POST["content"]))
							{				
									$_SESSION['__error_logid'] = "1";		
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";	
							} else {
									$_SESSION['__error_logid'] = "5000";		
									echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
							}
						break;

			case "ALTERLOG":
					if ( $_POST["alteractive"]  == 1 )
					{ 
										if ($Finance->updateLog($_SESSION['__log_id'] ,$_POST["log_id"],$_POST["content"]))
										{				
											$_SESSION['__error_logid'] = "1";		
											$_SESSION['__gettype'] = "";
											echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";	
										} else {
											$_SESSION['__error_logid'] = "5000";		
											$_SESSION['__gettype'] = "";
											echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
										}
						} else {
							$_SESSION['__gettype_id']  = $_POST["log_id"];
							$_SESSION['__gettype'] = "ALTERLOG";
							$_SESSION['__log_id'] = $_POST["id"];
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
						}
				break;

				case "DELETELOG":
					
					if ($Finance->deleteLog($_POST["id"]))
						{				
							$_SESSION['__error_logid'] = "1";
							$_SESSION['__gettype'] = "";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							$_SESSION['__gettype'] = "";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_log.php\">";
						}
				break;

				case "ADDTOGROUP":
					if ($_SESSION['__groupname'] == "公共组")
					{	
						if($Finance->checkGroupPassword($_POST['group_id'],$_POST['group_password']))
						{
							if ($Finance->insertUserGroup($_SESSION['__useralive'][0],$_POST['group_id']))
							{				
								$_SESSION['__error_logid'] = "1";
								echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";	
							} else {
								$_SESSION['__error_logid'] = "5000";
								echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";
							}
						} else {
								$_SESSION['__error_logid'] = "5000";
								echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";
						}
					} else {
						if ($Finance->updateUserGroup($_SESSION['__useralive'][0],$_POST['group_id']))
						{
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=index.php\">";	
						} else {
								$_SESSION['__error_logid'] = "5000";
								echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";
							}
					}
				break;

				case "ACCPETMEMBER":
					if ($Finance->addAccpetUserGroup($_POST["member"]))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
						}

				break;

				case "DENYMEMBER":
					if ($Finance->deleteUserGroup($_POST["member"]))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=main.php\">";
						}
				break;

				case "DELETEMEMBER":
					
					if ($Finance->deleteGroupMember($_POST["user_id"]))
						{				
							$_SESSION['__error_logid'] = "1";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";
							
						} else {
							$_SESSION['__error_logid'] = "5000";
							echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;URL=function_add_group.php\">";
						}
				break;

			default:
				echo "执行了默认操作";
				break;
			}

?>