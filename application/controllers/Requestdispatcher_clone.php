<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requestdispatcher extends CI_Controller {

public function __construct()
{
	parent::__construct();
	$this->load->model('common/Commonmodel');
	$this->load->helper('userdefined');
	
}

public function emailexistance()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
		
	
	$cond = array();
	
	$cond['Email'] = $postdata['merchant_email'];
	if($postdata['usertype'] == 'Merchant')
	$table='business';
	else
	$table='users';
	
	if( $this->Commonmodel->checkexistance($cond,$table) )
		echo "Yes";
	else
		echo "No";
		
		
}



public function merchantregistration()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$insertdata = array();
	
	$insertdata['Email'] 			= $postdata['merchant_email'];
	$insertdata['Password']			= md5($postdata['merchant_password']);
	$insertdata['Contact_Number'] 	= $postdata['merchant_contact'];
	$insertdata['Status'] 			= 'Inactive';
	$insertdata['User_Type']		=	'Merchant';
		
	
	$table='business';
	
	$resp = $this->Commonmodel->insertbusinessdata($table,$insertdata);
	
	if( $resp == "1" )
	{
		
		echo "Yes";
	}
	else
		echo $resp;
	
} // merchantregistration function ends here

public function activatemerchant($usertype,$vericode)
{
	
	$verf = explode("limitedads",$vericode);

	$email = base64_decode(end($verf));
	$verificationcode = $vericode;
	
	$cond = array();
	$table = 'verificationcodes';
	
	$cond['Verification_Code'] = $verificationcode;
	
	
	$res = $this->Commonmodel->activatemerchant($cond, $table);
	
	if( $res =='1')
	{
		redirect("http://localhost/limitedads/");
	}
	elseif( $res == "0")
	{
		echo "Your activation code expires kindly register with some other email id and activate with-in two days";
	}
	elseif( $res == "2" )
	{
		echo "Activation code is not related to the correct merchant";
	}
	
	elseif( $res == "3" )
	{
		echo 'Unable to activate the user';
	}
	
	
	
}//activatemerchant ends here 


public function loginvalidation()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	
	if($postdata['usertype'] == 'Merchant')
	{
			$cond['Email'] 		=	$postdata['Email'];
			$cond['Password']	=	md5( $postdata['Password'] );
			$cond['Status']		=	'Active';
			
			$table="business";
	}
	
	else
	{
		
	}
	
	$rest = $this->Commonmodel->validateUser($table,$cond);
	

	if( $rest != '0' )
	{
		foreach($rest->result() as $credi)
		{
			$this->session->set_userdata('Mechant_Email',$credi->Email);
			$this->session->set_userdata('Business_Id',$credi->Business_Id);	
			
		}
		
		echo "1";
	}
	else
		{
			echo "0";	
		}
		
	

	
} //login validation ends here

public function logout()
{
	$postdata = array();
	
	$postdata = json_decode(file_get_contents('php://input'),true);
	
	if( $postdata['Usertype'] == 'Merchant')
	{

		$this->session->set_userdata('Mechant_Email','');
		$this->session->set_userdata('Business_Id','');
		echo "1";
		
	}
	
	
	
}	//logout ends here

public function getbusinessprofile()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),true);	
	
	$cond = array();
	
	$table='business';
	$field="Contact_Number,Email";
	
	$cond['Email'] = $postdata['businessemail'];
	
	$output = array();
	
	$qry = $this->Commonmodel->getAfield($table,$field,$cond);
	if( $qry!='0')
	{
		foreach($qry->result() as $mcrprf)
		{
			$output[] = array(
								'businessemail'=>$mcrprf->Email,
								'Contact_Number'=>$mcrprf->Contact_Number
								);
		}
		echo json_encode($output);
	}
	else
	{
		echo " ";
	}
	
}

//edit profile starts here
public function editprofile()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	
	$table='business';
	
	$cond['Email'] = $postdata['businessemail'];
	
	$setdata['Contact_Number'] = $postdata['Contact_Number'];
	$setdata['Lastupdated'] = 	date('Y-m-d H:i:s');
	
	if( $this->Commonmodel->update($table,$cond,$setdata) )
		echo "ok";
	else
		echo "no";
	
}
// edit profile ends here

public function getstates()
{
	$postdata = array();
	
	$postdata=json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	$limit="";
	$starts_at = '';
	$order='ASC';
	$order_by='StateName';
	
	$table = 'states';
	
	$qry = $this->Commonmodel->getrows($table,$cond,$limit,$starts_at,$order,$order_by);
	
	$states_list = array();
	
	if($qry!='0')
	{
		$cnt=0;
		foreach($qry->result() as $states)
		{
			$cnt++;
			
			if($cnt==1)
			{
				$states_list[] =	array(
											'name'			=>	"Select State",
											'stateid'		=>	"0",
										);
			}
			else
			{
				$states_list[] =	array(
											'name'			=>	$states->StateName,
											'stateid'		=>	$states->StateID,
										);
			}
		}
	}
	
	print_r( json_encode($states_list) );
	
	
		
}//getstates ends here


public function getstoredetails()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	$lefttab = 'business as b';
	$righttab = 'stores as s';
	
	$joinright	 =	'b.Business_Id';
	$joinleft	 =	's.Business_Id';
	
	$cond['Email'] = $postdata['email'];
	$selectfields = "s.*";
	
	//$qry = $this->Commonmodel->twotablesjoin($lefttab,$righttab,$selectfields,$joinright,$joinleft,$cond);
$storeinfodata = array();	
$qry = $this->db->query("select s.*, st.StateName from business as b join stores as s on s.Business_Id=b.Business_Id left join states as st on s.State=st.StateID where Email='".$postdata['email']."'");

//print_r($qry->result());
//echo $this->db->last_query(); exit; 
if($qry->num_rows()>0)
{
foreach($qry->result() as $storeinfo)
{
	if($storeinfo->StateName=='')
	{
		$state = "no";	
	}
	else
	{
		$state	= $storeinfo->StateName;
	}
	
	$storeinfodata[] = array(
							"storename"=>$storeinfo->Store_Name,
							"contactname"=>$storeinfo->Contact_Name,
							"Store_Description"=>$storeinfo->Store_Description,
							"Address"=>$storeinfo->Address,
							"OpensAt"=>$storeinfo->OpensAt,
							"ClosesAt"=>$storeinfo->ClosesAt,
							"Website"=>$storeinfo->Website,
							"Store_Pics"=>$storeinfo->Store_Pics,
							"Area"=>$storeinfo->Area,
							"City"=>$storeinfo->City,
							"State"=>$storeinfo->State,
							"StateName"=>$state,
							"Store_Id"=>$storeinfo->Store_Id,
						
						);
}
print_r( json_encode($storeinfodata) );
}
else
	echo "0";
	
	//select b.Business_Id,s.Store_Name from business as b join stores as s on s.Business_Id=b.Business_Id where b.Email='sudhaker.ssr@mailinator.com'
	
	
	
}//getstoredetails ends here

public function editstoreinfo()
{
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$updatedata = array();
	$cond = array();
	$table="stores";
//	print_r($postdata);
	
	foreach($postdata['storeinfodata'] as $key=>$val)
	{
		
		if(is_array($val))
		{
			//if($key == "stateid")
				$updatedata['State'] = $val['stateid'];	
				
		}
		else
		{
			if($key == "storename")
				$updatedata['Store_Name'] = $val;
			if($key == "contactname")
				$updatedata['Contact_Name'] = $val;
			if($key == "Store_Description")
				$updatedata['Store_Description'] = $val;
			if($key == "OpensAt")
				$updatedata['OpensAt'] = $val;
			if($key == "ClosesAt")
				$updatedata['ClosesAt'] = $val;
			if($key == "Website")
				$updatedata['Website'] = $val;	
			if($key == "Area")
				$updatedata['Area'] = $val;	
			if($key == "Address")
				$updatedata['Address'] = $val;										
			if($key == "City")
				$updatedata['City'] = $val;
						
			if($key == "Store_Id")	
				$cond['Store_Id'] = $val;
				
		}
	}
	
	
	$this->db->where('Business_Id',$this->session->userdata('Business_Id'));
	$qry = $this->db->get($table);

	$updatedata['Last_Updated'] = time();
	$updatedata['Timings']	=	$updatedata['OpensAt']." To ".$updatedata['ClosesAt'];
	
	//echo $qry->num_rows();

	if($qry->num_rows() == "1")
	{
		
		if( $this->Commonmodel->update($table,$cond,$updatedata) )
		echo "ok";
		else
			echo "no";	
	}
	else
	{
		$updatedata['Business_Id'] = $this->session->userdata('Business_Id');
		if( $this->Commonmodel->insertdata($table,$updatedata) )
		echo "ok";
		else
			echo "no";
	}
	
	
}

public function uploadmerprofile()
{

	$merchantdir = FCPATH."Resources\\profilepicuploads\\".$this->session->userdata('Business_Id');
//echo $merchantdir; 
	if( is_dir($merchantdir) )
	{
		//echo ":".FCPATH;
	}
	else
		mkdir($merchantdir);
	
	move_uploaded_file($_FILES['file']['tmp_name'],"Resources/profilepicuploads/".$this->session->userdata('Business_Id')."/".$_FILES['file']['name']);
	
	$cond = array();
	$table="stores";
	
	$setdata = array();
	
	$cond['Business_Id'] = $this->session->userdata('Business_Id');
	$setdata['Store_Pics'] = "Resources/profilepicuploads/".$this->session->userdata('Business_Id')."/".$_FILES['file']['name'];
	
	if( $this->Commonmodel->update($table,$cond,$setdata) )
	{
		echo "Resources/profilepicuploads/".$this->session->userdata('Business_Id')."/".$_FILES['file']['name'];	
	}
	else
		echo "0";
	
	
	
	
}
//upload merchant profile ends here


public function getlocatondetails()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);	
	
	$cond = array();
	$table="stores";
	$field = "Address,Area,City,State,Store_Name";
	$cond['Business_Id'] = $postdata['Business_Id'];
	
	$output_array=array();
	
	$resp = $this->Commonmodel->getAfield($table,$field,$cond);
	
	if($resp!='0')
	{
		foreach($resp->result() as $locdetails)
		{
			$Address = $locdetails->Address;
			$Address = str_replace("+"," ", $Address);
			$Address = stripslashes($Address);
			
			
			$Area = $locdetails->Area;
			$City = $locdetails->City;
			$State = $locdetails->State;
			$Store_Name = $locdetails->Store_Name;
			
		}
			$this->db->select('StateName');
			$this->db->where('StateID',$locdetails->State);
			$qry = $this->db->get('states');
			$ret = $qry->row();
		

					$output_array[] = array(
												"Store_Name"=>$Store_Name,
												"Address"=>$Address,
												"Area"=>$Area,
												"City"=>$City,
												"StateName"=>$ret->StateName,
												"Country"=>"India"
											);
		
		print_r( json_encode($output_array) );

	}
	else
		echo $resp;

}


public function getdealcategories()
{
	$cond = array();
	$table='categories';
	
	$cond['Status'] = 'Active';
	$limit = '';
	$starts_at = '';
	$order = 'ASC';
	$order_by = 'Category';
	
	$qry = $this->Commonmodel->getrows($table,$cond,$limit,$starts_at,$order,$order_by);
	
	if($qry!='0')
	{
		$category_list = array();
		
		$cnt=0;
		foreach($qry->result() as $categ)
		{
			$cnt++;
			
			if($cnt==1)
			{
				$category_list[] =	array(
											'category'			=>	"Select Category",
											'catid'				=>	"0",
										);
			}
			else
			{
				$category_list[] =	array(
											'category'			=>	$categ->Category,
											'catid'				=>	$categ->Category_Id,
										);
			}
		}
		print_r( json_encode($category_list) );
		
		
	}
	else
		echo "0";
		
} //get deal categories ends here


// getdealsizes starts here

public function getdealsizes()
{
	
	
	$cond = array();
	$table='getdealsizes';
	
	$cond['Status'] = 'Active';
	$limit = '';
	$starts_at = '';
	$order = 'ASC';
	$order_by = 'SizeName';
	
	$qry = $this->Commonmodel->getrows($table,$cond,$limit,$starts_at,$order,$order_by);
	
	if($qry!='0')
	{
		$dealsize_list = array();
		
		$cnt=0;
		foreach($qry->result() as $deal_size)
		{
			$cnt++;
			
			if($cnt==1)
			{
				$dealsize[] =	array(
											'size'					=>	"Select Size",
											'sizeid'				=>	"0",
										);
			}
			else
			{
				$dealsize[] =	array(
											'size'					=>	$deal_size->SizeName,
											'sizeid'				=>	$deal_size->SizeId,
										);
			}
		}
		print_r( json_encode($dealsize) );
		
		
	}
	else
		echo "0";
	
	
}

//unset deal offer pics session

public function unsetdeal_offerpics()
{
	$this->session->set_userdata($this->session->userdata('Business_Id')."_".'deal_pic','');
	echo 'unset deal offer pics';
}
public function uploaddeal_pics()
{
	
$postdata = array();
$postdata = json_decode(file_get_contents('php://input'),TRUE);	
$merchantdir = FCPATH."Resources\\dealpicuploads\\".$this->session->userdata('Business_Id');


//echo $merchantdir; 
	if( is_dir($merchantdir) )
	{
		//echo ":".FCPATH;
	}
	else
		mkdir($merchantdir);
		
		
	if( $this->session->userdata($this->session->userdata('Business_Id')."_".'deal_pic') =='')
	{
		$deal_pics = time()."_".$_FILES['file']['name'];	
		$this->session->set_userdata($this->session->userdata('Business_Id')."_".'deal_pic',$deal_pics);	
		
	}
	else
	{
		$deal_pics = time()."_".$_FILES['file']['name'];
		$deal_pics = $this->session->userdata($this->session->userdata('Business_Id')."_".'deal_pic').",".$deal_pics;
		$this->session->set_userdata($this->session->userdata('Business_Id')."_".'deal_pic',$deal_pics);	
	}
		
		move_uploaded_file($_FILES['file']['tmp_name'],"Resources/dealpicuploads/".$this->session->userdata('Business_Id')."/".$deal_pics);

} //uploadeddeal_pics ends here
	

public function addadeal()
{
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);	
	
if($postdata['edit_add'] == "add")
{
		
	$cond = array();
	
	$cond['Business_Id'] = $this->session->userdata('Business_Id');
	
	$table = 'add_deal';
	
	$insertdata = array();
	
	$insertdata['Offer_Name'] = $postdata['adddealdata']['offername'];
	$insertdata['Offer_Description'] = $postdata['adddealdata']['offerdescpr'];

//	$insertdata['Deal_Starts'] = $postdata['adddealdata']['deal_starts'];
//	$insertdata['Deal_Expires'] = $postdata['adddealdata']['deal_ends'];
	
	
	$date1=date_create($postdata['adddealdata']['deal_starts']);
 	$insertdata['Deal_Starts'] = date_format($date1,"Y-m-d");
	
	$date2=date_create($postdata['adddealdata']['deal_ends']);
 	$insertdata['Deal_Expires'] = date_format($date2,"Y-m-d");
	
	
	$insertdata['Category'] = $postdata['adddealdata']['categ']['catid'];
	$insertdata['Add_Size'] = $postdata['adddealdata']['addsize']['sizeid'];
	
/*	
	$sessvari = $this->session->userdata('Business_Id')."_".'deal_pic';
	
	$offer_pics = $this->session->userdata($sessvari);
	
	$insertdata['Deal_Pics'] = $offer_pics;
*/
	
	$qry = $this->Commonmodel->getrows('stores',$cond,'','','','');
	
	if( $qry !='0')
	{
		
		foreach($qry->result() as $store_det)
		{
			$storeid = $store_det->Store_Id;
			$insertdata['Store_Id'] = $storeid;
			
			if( $this->Commonmodel->insertdata($table,$insertdata) )
			{
				echo "1";
			}
			else echo "0";
		}		
	}
}
	
	
	
	
}




public function addprintdeal()
{
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);	
	
	//print_r($postdata['adddealdata']['deal_starts']);

if($postdata['edit_add'] == "add")
{	
	$cond = array();
	
	$cond['Business_Id'] = $this->session->userdata('Business_Id');
	
	$table = 'add_deal';
	
	$insertdata = array();
	
	$insertdata['Offer_Name'] = $postdata['adddealdata']['offername'];
	$insertdata['Offer_Description'] = $postdata['adddealdata']['offerdescpr'];

//	$insertdata['Deal_Starts'] = $postdata['adddealdata']['deal_starts'];
//	$insertdata['Deal_Expires'] = $postdata['adddealdata']['deal_ends'];
	
	
	$date1=date_create($postdata['adddealdata']['deal_starts']);
 	$insertdata['Deal_Starts'] = date_format($date1,"Y-m-d");
	
	$date2=date_create($postdata['adddealdata']['deal_ends']);
 	$insertdata['Deal_Expires'] = date_format($date2,"Y-m-d");
	
	
	$insertdata['Category'] = $postdata['adddealdata']['categ']['catid'];
	$insertdata['Add_Size'] = $postdata['adddealdata']['addsize']['sizeid'];
	
/*	
	$sessvari = $this->session->userdata('Business_Id')."_".'deal_pic';
	
	$offer_pics = $this->session->userdata($sessvari);
	
	$insertdata['Deal_Pics'] = $offer_pics;
*/
	
	$qry = $this->Commonmodel->getrows('stores',$cond,'','','','');
	
	if( $qry !='0')
	{
		
		foreach($qry->result() as $store_det)
		{
			$storeid = $store_det->Store_Id;
			$insertdata['Store_Id'] = $storeid;
			
			if( $this->Commonmodel->insertdata($table,$insertdata) )
			{
				echo "1";
			}
			else echo "0";
		}		
	}
}
elseif($postdata['edit_add'] == "edit")
{

	$cond = array();
	$table = 'add_deal';
	
	$updatedata = array();
	
	$updatedata['Offer_Name'] = $postdata['adddealdata']['offername'];
	$updatedata['Offer_Description'] = $postdata['adddealdata']['offerdescpr'];

	
	$date1 = '';
	$date2 = '';
	
	$date1= $postdata['adddealdata']['deal_starts'];
	$date2= $postdata['adddealdata']['deal_ends'];
	
	$date = explode("/",$date1);
	
	$date1 = end($date)."-".$date[0]."-".$date[1];
	
	$date1 = date('Y-m-d', strtotime($date1));
	
	
	$date = explode("/",$date2);
	
	$date2 = end($date)."-".$date[0]."-".$date[1];
	
	$date2 = date('Y-m-d', strtotime($date2));

	
	$updatedata['Deal_Starts'] = $date1;


 	$updatedata['Deal_Expires'] = $date2;
	
	
	$updatedata['Category'] = $postdata['adddealdata']['editcateg']['catid'];
	$updatedata['Add_Size'] = $postdata['adddealdata']['addsize']['sizeid'];
	$updatedata['Deal_Added_On'] = date('Y-m-d H:i:s');
	$cond['Deal_Id'] = $postdata['adddealdata']['dealid'];
	
//	print_r($updatedata); exit;
	
	
	if( $this->Commonmodel->update($table,$cond,$updatedata) )
	{
		echo "1";
	}
	else
	echo "0";
	
	
}
		
}// add deal ends here

public function getOffers_deals()
{
	
	$postdata = array();
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	$cond['Business_Id'] = $postdata['businesside'];
	
	$table = 'stores';
	$field = "Store_Id";
	
	
	$qry = $this->Commonmodel->getonefield($table,$cond,$field);
	
	if($qry!='0')	
	{
		
		$qry_total = $this->db->query("select deal.Offer_Name, deal.Deal_Id, DATE_FORMAT(deal.Deal_Starts,'%d-%b-%Y') as Dealstarts,DATE_FORMAT(deal.Deal_Expires,'%d-%b-%Y') as Dealends, CASE 'deal.Deal_Expires' WHEN DATE(deal.Deal_Expires)>(CURDATE()-1) THEN 'Expired' WHEN DATE(deal.Deal_Expires)<=(CURDATE()-1) THEN 'Active' END AS Expired_Active, cat.Category as categoryName from add_deal as deal join  categories as cat on cat.Category_Id=deal.Category where deal.Store_Id='".$qry."' and deal.Status='Active' order by deal.Deal_Id DESC ");
		
		$toal_records = $qry_total->num_rows();
		
		$total_pages = ($toal_records)/5;
		
		$total_pages = ceil($total_pages);
		
		$qry = $this->db->query("select deal.Offer_Name, deal.Deal_Id, DATE_FORMAT(deal.Deal_Starts,'%d-%b-%Y') as Dealstarts,DATE_FORMAT(deal.Deal_Expires,'%d-%b-%Y') as Dealends, CASE 'deal.Deal_Expires' WHEN DATE(deal.Deal_Expires)>(CURDATE()-1) THEN 'Expired' WHEN DATE(deal.Deal_Expires)<=(CURDATE()-1) THEN 'Active' END AS Expired_Active, cat.Category as categoryName from add_deal as deal join  categories as cat on cat.Category_Id=deal.Category where deal.Store_Id='".$qry."' and deal.Status='Active' order by deal.Deal_Id DESC ");
		
		
		
		if($qry->num_rows()>0)
		{
			$deals_output = array();
			$cnt=1;
			foreach($qry->result() as $deals)	
			{
				$deals_output[] = array(
										'SLNO'=>$cnt,
										'Deal_Id'=>$deals->Deal_Id,										
										'Offer_Name'=>$deals->Offer_Name,
										'Dealstarts'=>$deals->Dealstarts,
										'Dealends'=>$deals->Dealends,
										'Expired_Active' =>$deals->Expired_Active,
										'categoryName'=>$deals->categoryName,
										'total_records'=>$total_pages

										);
				$cnt++;
			}
			

			
			echo json_encode($deals_output);
		}
		
		//echo $this->Commonmodel->twotablesjoin($lefttab,$righttab,$selectfields,$joinright,$joinleft,$cond);
	}
	
} //getoffers_deals ends here

public function get_edit_offer_deal()
{
	$postdata = array();
	
	$postdata = json_decode(file_get_contents('php://input'),TRUE);
	
	$cond = array();
	$table = 'add_deal';
	
	$cond['Deal_Id'] = $postdata['offerid'];
	
	$qry = $this->Commonmodel->getrows($table,$cond,'','','','');
	
	$deal_op = array();
	
	if($qry!='0')
	{
		foreach($qry->result() as $deal)
			{
				
				$date1=date_create($deal->Deal_Starts);
				$Deal_Starts = date_format($date1,"m/d/Y");
				
				$date2=date_create($deal->Deal_Expires);
				$Deal_Expires = date_format($date2,"m/d/Y");
				
				//$pics = explode(",",$deal->Deal_Pics);
				$this->db->select('Category');
				$this->db->from('categories');
				$this->db->where('Category_Id',$deal->Category);
				$qry = $this->db->get();
				
				$ret = $qry->row();
				$category = array("category"=>$ret->Category,"catid"=>$deal->Category);
				
				$qry='';
				$ret='';
				
				
				$this->db->select('SizeName');
				$this->db->from('getdealsizes');
				$this->db->where('SizeId',$deal->Add_Size);
				$qry = $this->db->get();
				
				$ret = $qry->row();
				$Add_Size = array("size"=>$ret->SizeName,"sizeid"=>$deal->Add_Size);
				
				
				
				$deal_op = array(
									'Business_id'	 	=> $this->session->userdata('Business_Id'),
									'Deal_Id'		 	=> $deal->Deal_Id,
									'offername'	 	=> $deal->Offer_Name,
									'offerdescpr' => $deal->Offer_Description,
									'deal_starts'		=>	$Deal_Starts,
									'deal_ends'		=>	$Deal_Expires,
									'Store_Id'			=> $deal->Store_Id,
									'Category'			=> $category,
									'SelectedSize'		=>	$Add_Size
									//'Deal_pics'			=>	$pics,
									
								);	
			}
			
			echo json_encode($deal_op);
	}
	
}

//viewprinteddeal strats here
	
	public function viewprinteddeal()
	{
		
		$postdata = array();
		$postdata = json_decode(file_get_contents('php://input'),TRUE);
		
		$cond = array();		
		$table1 = "add_deal";
		$table2 = "categories";
		$table3 = "getdealsizes";
		
		$limit='';
		$starts_at='';
		$order='';
		$order_by='';
		
		$Deal_Id = $postdata['printeddealid'];
		
		$stmt= "select deal.Offer_Name as Offer_Name, deal.Offer_Description as Offer_Description, DATE_FORMAT(deal.Deal_Starts,'%d-%b-%Y') as Deal_Starts,DATE_FORMAT(deal.Deal_Expires,'%d-%b-%Y') as Deal_Expires, cat.Category as categories, dealsize.SizeName as SizeName  from add_deal as deal join categories as cat on cat.Category_Id=deal.Category join getdealsizes as dealsize on dealsize.SizeId=deal.Add_Size where deal.Deal_Id=$Deal_Id";
		

		$qry =  $this->db->query($stmt);
		
		//$qry = $this->Commonmodel->getrows($table,$cond,$limit,$starts_at,$order,$order_by);
		
		
		
		
		$view_printed_offer = array();
		
		
		if($qry!='0')
		{
			foreach( $qry->result() as $printedOffer)
			{
					$view_printed_offer = array(
													"Offer_Name"=>$printedOffer->Offer_Name,
													"Offer_Description"=>$printedOffer->Offer_Description,
													"Deal_Starts"=>$printedOffer->Deal_Starts,
													"Deal_Expires"=>$printedOffer->Deal_Expires,
													"categories"=>$printedOffer->categories,
													"SizeName"=>$printedOffer->SizeName
												);
			}
			echo json_encode($view_printed_offer);
			
		}
		else
		echo "0";
			
			
		
	}
//viewprinteddeal ends here

} // Requestdispatcher class ends here
