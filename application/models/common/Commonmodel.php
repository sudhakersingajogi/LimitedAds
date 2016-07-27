<?PHP
class Commonmodel extends CI_Model {
	

public function getAfield($table,$field,$cond)
{
	$this->db->select($field);
	$this->db->from($table);
	$this->db->where($cond);
	$qry = $this->db->get();
	
	//echo $this->db->last_query().":". $qry->num_rows(); exit;
	if( $qry->num_rows() == 1)
	{
		/*
		$ret = $qry->row();
		return $ret->Contact_Number;
		*/
		return $qry;
		
	}
	else
		return "0";
	
	
	
}//get a field function ends here


//get rows 

public function getrows($table,$cond,$limit,$starts_at,$order,$order_by)
{
	
	$this->db->where($cond);
	$this->db->limit($limit,$starts_at);
	$this->db->order_by($order_by,$order) ;
	$qry = $this->db->get($table);
	
	if($qry->num_rows()>0)
	return $qry;
	else
	return "0";	
}

public function getonefield($table,$cond,$field)
{
	$this->db->select($field);
	$this->db->where($cond);
	$qry = $this->db->get($table);
	$ret = $qry->row();
	
	return $ret->$field;
	
	
}

public function insertdata($table,$updatedata)
{
	$this->db->insert($table,$updatedata);
	if( $this->db->insert_id())
		return true;
	else
		return false;
}

//join two table

public function twotablesjoin($lefttab,$righttab,$selectfields,$joinright,$joinleft,$cond)
{
	$this->db->select("$selectfields");
	$this->db->from($lefttab);
	$this->db->join($righttab, $joinleft=$joinright);
	$this->db->where($cond);
	
	 
	$query = $this->db->get();	
	
	echo $this->db->last_query();
	
}

public function update($table,$cond,$setdata)
{
		$this->db->where($cond);
		$this->db->update($table,$setdata);
		
		if( $this->db->affected_rows() )
		{
			return true;	
		}
		else
			return false;
}

	
public function checkexistance($cond,$table)
{
	
	$this->db->where($cond);
	$qry = $this->db->get($table);
	
	if($qry->num_rows())
		return "1";
	else
		return "0";
}


public function activatemerchant($cond, $table)
{
	
	$this->db->where($cond);
	$this->db->where("DATE(Expires_On) >= DATE(NOW())");
	$qry = $this->db->get($table);
	
	if( $qry->num_rows() == 1 )
	{
		$this->db->select('User_Merchant_Id');
		$this->db->from('verificationcodes');
		$this->db->where('Verification_Code',$cond['Verification_Code']);
		
		$qry = $this->db->get();
		$ret = $qry->row();
		
		
		$this->db->where('Business_Id',$ret->User_Merchant_Id);
		$qry = $this->db->get('business');
		
		if($qry->num_rows()==1)
		{
			
			$cond = array();
			$setdata = array();
			
			$cond['Business_Id'] = $ret->User_Merchant_Id;
			$setdata['Status'] = "Active";
			
			$this->db->where($cond);
			$this->db->update("business",$setdata);
			
			if( $this->db->affected_rows() )
			{
				$cond= array();
				$cond['User_Merchant_Id'] = $ret->User_Merchant_Id;
				$this->db->where($cond);
				$this->db->delete('verificationcodes');
				
				return "1";
			}
			else
				return "3";
		}
		else
		return "2";
		
		
	}
	else
	{
		return "0";
	}
	
	
}
	
	
	public function insertbusinessdata($table,$insertdata)
	{
		
		 
				$config = array();
                $config['useragent']           = "CodeIgniter";
                $config['mailpath']            = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
                $config['protocol']            = "smtp";
                $config['smtp_host']           = "ssl://smtp.gmail.com";
                $config['smtp_port']           = "465";
                $config['mailtype'] = 'html';
                $config['charset']  = 'utf-8';
                $config['newline']  = "\r\n";
                $config['wordwrap'] = TRUE;

                $this->load->library('email');
				$this->load->helper('userdefined');
				
				$verificationcode = generateEmailConfirmationCode(); //calling this function from the userdefined helper file
				
				$verificationcode = $verificationcode."limitedads".base64_encode($insertdata['Email']);
				
                $this->email->initialize($config);

                $this->email->from('sudhaker.1228@gmail.com', 'Merchant Registration');
               // $this->email->to('ssr.sudhakar@gmail.com');
			    $this->email->to($insertdata['Email']);
               // $this->email->cc('sudhaker.ssr@gmail.com'); 
                $this->email->bcc($this->input->post('email')); 
                $this->email->subject('Registration Verification: Limited-Ads');
                $msg = "Thanks for signing up!
            Your account has been created, 
            you can login with your credentials after once you activate your account by pressing the url below.
            <a href='".base_url()."Requestdispatcher/merchant/$verificationcode'> Please click this link to activate your account:</a>Click Here</a>";

            $this->email->message($msg);   
            //$this->email->message($this->load->view('email/'.$type.'-html', $data, TRUE));

            if( $this->email->send() )
			{	
				$this->db->insert($table,$insertdata);
				if( $this->db->insert_id() )
				{
					
					$datainsert = array();
					
					$insertedId = $this->db->insert_id();
					
					$this->db->select('User_Type');
					$this->db->from('business');
					$this->db->where('Business_Id',$insertedId);
					$qry = $this->db->get();
					$ret = $qry->row();
					
					$usertype = $ret->User_Type;
					
					
					$today_date = date('Y-m-d');
					$date = strtotime($today_date);
					$date = strtotime("+2 day", $date);
					
					$expires_on = date('Y-m-d', $date);
					
					
					$datainsert['Verification_Code'] = $verificationcode; 
					$datainsert['User_Merchant_Id'] = $insertedId; 
					
					$datainsert['User_Type'] = $usertype; 
					
					$datainsert['Created_On'] = $today_date; 					
					$datainsert['Expires_On'] = $expires_on; 					
					
					
					$this->db->insert('verificationcodes',$datainsert);
					
					return "1";
				}
				else
					return "0";
			}
			else
			{
					echo  $this->email->print_debugger(); die();
			}
	
	
	
	}
	
	//validate function starts here
	
	public function validateUser($table,$cond)
	{
		
		$this->db->where($cond);
		$qry = $this->db->get($table);
		
		if( $qry->num_rows() == 1 )
		{
			return $qry;
		}
		else
		{
			return "0";
		}
		
		
	
	}
	
	
}

?>	