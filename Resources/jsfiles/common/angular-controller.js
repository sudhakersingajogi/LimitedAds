var LimitedAps = angular.module("LimitedAps", ['ui.bootstrap']);
var	prflimg = '';
var baseurl='http://localhost/limitedads/';
function setprofilepath(prflimg)
{
	prflimg = prflimg;
	$("#prflpath").val(prflimg);
}


 LimitedAps.directive('fileModel', ['$parse', function ($parse) {
            return {
               restrict: 'A',
               link: function(scope, element, attrs) {
                  var model = $parse(attrs.fileModel);
                  var modelSetter = model.assign;
                  
                  element.bind('change', function(){
                     scope.$apply(function(){
                        modelSetter(scope, element[0].files[0]);
                     });
                  });
               }
            };
         }]);
		 
 LimitedAps.service('fileUpload', ['$http', function ($http,$rootscope) {
			
		
            this.uploadFileToUrl = function(file, uploadUrl){
               var fd = new FormData();
               fd.append('file', file);
			              
               $http.post(uploadUrl, fd, {
                  transformRequest: angular.identity,
                  headers : {'Content-Type':undefined},
               }).success(function(respp){
				   respp=respp.trim();
				   prflimg = baseurl+respp;
				  // setprofilepath(prflimg);
				  if(prflimg!='0')
				  document.getElementById("prfleIMG").src=prflimg;
				  
				   
				  
               })
            
               .error(function(){
               });
				
			}
			
			//this.getpath=function() { console.log(this.prflimg);  }
         }]);

//LimitedAps.controller('LACtrl',function($scope,$http){ 
LimitedAps.controller('LACtrl', ['$scope', '$http', 'fileUpload', function($scope, $http, fileUpload){
 


$scope.form={};

$scope.merc_regform_mdl={};
$scope.merc_logform_mdl={};
$scope.merc_profile_mdl = {};
$scope.merc_storeinfo_mdl=[];
$scope.add_deal_mdl={};
$scope.edit_deal_mdl={};

$scope.merc_loc_details={};

$scope.stateslist;
$scope.dealcategories = '';
$scope.add_deal_sizes_mdl = {};
$scope.mer_profile_banner = "Resources/profilepicuploads/dock.jpg";


$scope.title='Limited Ads'; 

$scope.Merchantemail_exists = false;

$scope.submitted = false;

$scope.merchantheader1= true;
$scope.merchantheader2= false;
$scope.merchantheader3= false;

$scope.merchantreg_forme=true;

$scope.merchant_reg_failuremessge = false;
$scope.merchant_reg_succmessge = false;


$scope.Meremail_exists=false;
$scope.merchant_invalid_credentials=false;

$scope.dealpics_selected = false;


$scope.mechantprofile_succ = false;
$scope.mechantprofile_fail=false;

$scope.mechantprofile_success = false;
$scope.mechantprofile_failure=false;

$scope.mechantstore_succ = false;
$scope.mechantstore_success = true;
				


$scope.businesscontactnumber='';

$scope.invalid_deal_category=true;
$scope.invalid_deal_addsize = true;

$scope.invalid_deal_start_date = false;
$scope.invalid_deal_ends_date = false;

$scope.end_date_negative='Enter offer end date';

$scope.add_deal_succ=false;
$scope.add_deal_succ_msg = '';

$scope.add_deal_fail=false;
$scope.add_deal_fail_msg = '';

$scope.dealsoffered = '';

$scope.offer_deal_title='';
$scope.deal_for_edit='';

$scope.pageno = 1; // initialize page no to 1
$scope.total_count = 0;
$scope.itemsPerPage = 5;



$scope.update_deal_succ=false;
$scope.update_deal_succ_msg = '';

$scope.view_printed_deals_data=false;
$scope.view_printed_deals_nodata=false;


$scope.pics_del=[];

$scope.viewprinteddeal={};


//reseting the merchant registration form when merchant clicks on the register link

$scope.resetmerchant_reg=function()
{
	

	$scope.merchantheader1= true;
	$scope.merchantheader2= false;
	$scope.merchantheader3= false;
	$scope.Merchantemail_exists=false;
	
	$scope.merchantreg_forme=true;
	
	
	$scope.merc_regform_mdl.Email='';
	$scope.merc_regform_mdl.Password='';
	$scope.merc_regform_mdl.cnfPassword='';
	$scope.merc_regform_mdl.Contact_Number='';
	
	$scope.form.merc_regform.$setPristine();
	
	
}


$scope.merchant_reg=function(merformdetails) 
{
	 

$scope.submitted = true; 


var merchant_email = merformdetails.Email;
var merchant_password = merformdetails.Password;
var merchant_contact = merformdetails.Contact_Number;



$http({
		  method:'post',
		  url     : baseurl+'Requestdispatcher/emailexistance',
		  data:{"merchant_email":merchant_email,"usertype":'Merchant'},
		  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		  }).success(function(respon) { 
		  								
										if(respon == "Yes")
										{
//											$scope.Merchantemail_exists=true;
											$scope.Meremail_exists=true;
										}
										else
										{
											// send the data to the controller to insert into the table
											
												$http({
											  method:'post',
											  url     : baseurl+'Requestdispatcher/merchantregistration',
											  data:{"merchant_email":merchant_email,"merchant_password":merchant_password,"merchant_contact":merchant_contact},
											  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
											  }).success(function(respon) { 
							   													
														if(respon.trim() == "Yes")
															{
																//$scope.SuccessUserName = 'Hi '+respon[0];
																$scope.merchantheader1= false;
																$scope.merchantheader2= true;
																$scope.merchantheader3= false;
																$scope.merchantreg_forme=false;
																
																
																$scope.merc_regform_mdl.Email='';
																$scope.merc_regform_mdl.Password='';
																$scope.merc_regform_mdl.cnfPassword='';
																$scope.merc_regform_mdl.Contact_Number='';
																
																$scope.form.merc_regform.$setPristine();
																
															}
														else if( respon.trim() == "No" )
															{
																
																$scope.merchantheader1= true;
																$scope.merchantheader3= true;
																$scope.merchantheader2= false;
																$scope.merchantreg_forme=false;
															}
										
											   			});
											
										}//else ends here 
		  
		  });
};


$scope.merchant_login=function(merchantcredentials)
{

	var email = merchantcredentials.Email;
	var pwd = merchantcredentials.Password;
	
	$http({
		  method:'post',
		  url     : baseurl+'Requestdispatcher/loginvalidation',
		  data:{"Email":email,"usertype":'Merchant','Password':pwd},
		  headers : {'Content-Type': 'application/x-www-form-urlencoded'} 
		  }).success(function(respon) 
		  { 
//		  alert(respon);
//console.log(respon.trim());
				if(respon.trim() !='0')
					window.location.href=baseurl+'Merchantpanel';
				else
					{
						$scope.merchant_invalid_credentials=true;
					}
					
		  });
	
	
};// login ends here


$scope.logout=function(param) { 

$http({ 
		method:'post',
		url:baseurl+'Requestdispatcher/logout',
		data:{'Usertype':param},
		headers:{'content-Type':'application/x-www-form-urlencoded'}
		}).success(function(respo) {
			 if(respo.trim() == "1"){ window.location.href=baseurl; } 
		});

	 };// logout ends here
	 
	 //get stateslist
	 
//	 stateslist

$scope.getstates=function(email)
{
	$scope.mechantprofile_succ = false;


$scope.mechantstore_succ = false;
	
	
	$http({
			method:'post',
			url:baseurl+'Requestdispatcher/getstates',
			headers:{'content-Type':'application/x-www-form-urlencoded'}
			}).success(function(states){
				$scope.merc_storeinfo_mdl.state="Select State";
				$scope.stateslist = { availableOptions:states };
				
				$scope.merc_storeinfo_mdl.state = $scope.stateslist.availableOptions[0];
				console.log($scope.merc_storeinfo_mdl.state);
				
				
				
				$http({
						method:'post',
						url:baseurl+'Requestdispatcher/getstoredetails',
						data:{"email":email},
						headers:{'content-Type':'application/x-www-form-urlencoded'}
						}).success(function(merchantstoreinfo_resp){ 
													//resp = resp.trim();
													
													if(merchantstoreinfo_resp!='0')
													{
														$scope.merc_storeinfo_mdl=merchantstoreinfo_resp[0];	
														if(merchantstoreinfo_resp[0].StateName=="no")
														{
															
															//$scope.stateslist.availableOptions[0] = [{"name":"select State","stateid":"0"}];
															//$scope.merc_storeinfo_mdl.store_state = $scope.stateslist.availableOptions[0][0];
															$scope.merc_storeinfo_mdl.store_state = $scope.stateslist.availableOptions[0]
															
														}
														
														else
														{
														$scope.stateslist.availableOptions[0] = [{"name":merchantstoreinfo_resp[0].StateName,"stateid":merchantstoreinfo_resp[0].State}];
												$scope.merc_storeinfo_mdl.store_state = $scope.stateslist.availableOptions[0][0];
														}
												//console.log(merchantstoreinfo_resp[0].StateName+"hey");

													
													}
													else{
														$scope.merc_storeinfo_mdl={};
														
													$scope.merc_storeinfo_mdl.store_state = $scope.stateslist.availableOptions[0];	
													}
													
												});//successs ends here
				
				
				
				
				
			});//http success ends here
	
	
};
	 
	 
	 //get profile details
	 
	 $scope.getbusinessprofile=function(param)
	 {
		
		$http({ 
				method:'post',
				url:baseurl+'Requestdispatcher/getbusinessprofile',
				data:{'businessemail':param},
				headers:{'content-Type':'application/x-www-form-urlencoded'}	
					}).success(function(merchant_profile) {  $scope.merc_profile_mdl = merchant_profile[0];  });
		
	 };//get business profile ends here

///get merchant profile imahe

$scope.getmerchantprofilepic = function(param)
{
	$scope.getstates(param);
};

//get the business address details

$scope.getlocatondetails=function(business_ide)
{


		$http({
				method:'post',
				url:baseurl+"Requestdispatcher/getlocatondetails",
				data:{"Business_Id":business_ide},
				headers:{"content-Type":"application/x-www-form-urlencoded"}
			}).success(function(loc_resp) { 
											
											var Store_Name = loc_resp[0].Store_Name.split(' ').join('+');
											var Address	=  loc_resp[0].Address.split(' ').join('+');
											var Area = loc_resp[0].Area.split(' ').join('+');
											var City = loc_resp[0].City.split(' ').join('+');
											var State = loc_resp[0].StateName.split(' ').join('+');
											
//											var addr = Store_Name+","+Address+","+Area+","+City+","+State+",India";
											
											var addr = Address+","+Area+","+City+","+State+",India";											
//	var addr="3-16-112/25,ram+reddy+Nagar,Ramanthapur,Hyderabad,Telangana,India";
var results = '';
var map='';
var marker= '';

results = "https://maps.googleapis.com/maps/api/geocode/json?address="+addr+"&key=AIzaSyCDtv651n9D06ZeEvO-grr9OOgVUvtq4Zs";
		
		
		$http({
				url:results,
				}).success(function(data) {
					var latitude = data.results[0].geometry.location.lat;
					var longitude = data.results[0].geometry.location.lng;
					var center = new google.maps.LatLng(latitude,longitude);
					var mapProp = {
					center:new google.maps.LatLng(latitude,longitude),
					zoom:15,
					mapTypeId:google.maps.MapTypeId.ROAD
					};

alert();					map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
					marker=new google.maps.Marker({
					position:center,
					animation:google.maps.Animation.BOUNCE
					});
					
					marker.setMap(map);
					
					
					var infowindow = new google.maps.InfoWindow({ content:Store_Name });
					infowindow.open(map,marker);			
 
										
}); //success funciton ends here
		
			  });	
};

//edit merchant profile details
	 
	 $scope.editmerchantprofile=function(formdata)
	 {
		var businessemail = formdata.businessemail;
		var Contact_Number = formdata.Contact_Number;		
		
		$http({ 
				method:'post',
				url:baseurl+'Requestdispatcher/editprofile',
				data:{'businessemail':businessemail,'Contact_Number':Contact_Number},
				headers:{'content-Type':'application/x-www-form-urlencoded'}
			}).success(function(response) {  
				
				if( response.trim() == 'ok' )
				{
					$scope.mechantprofile_success='Successfully updated';
				
					$scope.mechantprofile_succ=true;
					$scope.mechantprofile_failure='';
					$scope.mechantprofile_fail=false;
					
				}
				else
				{
					$scope.mechantprofile_success='';
					$scope.mechantprofile_succ=false;
					
					$scope.mechantprofile_failure='failed to update'
					$scope.mechantprofile_fail=true;
				}
			
			});
				

		
	 };
	
	$scope.hidemerchantsprofilemessages = function()
	{
		$scope.mechantprofile_succ=false;
		$scope.mechantprofile_fail=false;
		
			
	}//edit merchant profile ends here
	
	$scope.editmerchantstoreinfo=function(storeinfo)
	{
		$http({
				method:'post',
				url:baseurl+'Requestdispatcher/editstoreinfo',
				data:{'storeinfodata':storeinfo},
				headers:{'content-Type':'application/x-www-form-urlencoded'},
				}).success(function(store_info) { 
				if(store_info.trim()=="ok") 
				{ 
					$scope.mechantstore_succ = true;
					$scope.mechantstore_success = "Successfully updated"; 
					}  
				});
	}
	
	$scope.imageUpload = function(event,path){
				
			if(path=='merchant_deal_pics')
			{	
				$http({
								method:'post',
								url:"http://localhost/limitedads/Requestdispatcher/unsetdeal_offerpics",
								headers:{'content-Type':'application/x-www-form-urlencoded'},
								}).success(function(resp) { 
																console.log(resp); //alert(resp);  
															});
			}
			$scope.invalidimage_type=false;
				
				var files = event.target.files; //FileList object
				console.log(files);
				if(files.length>0)
				{
					$scope.dealpics_selected = true;
				}
				else
				{
					$scope.dealpics_selected = false;
					
				}
				
				for (var i = 0; i < files.length; i++) 
				{
					var file = files[i];
					
					
					if( file.type == "image/jpeg" || file.type == "image/png" )
					{
						//console.log(file.type);
						$scope.invalidimage_type=false;
//						return false;
					}
					else
					{
						//console.log("ok:"+file.name);
						$scope.invalidimage_type=true;
						//
					}
					
					var reader = new FileReader();
					reader.onload = $scope.imageIsLoaded; 
					reader.readAsDataURL(file);
					
					console.log($scope.invalidimage_type);
					
					if($scope.invalidimage_type == false)
					$scope.upload_file(file,path);	
				}
				// 
				 
//				 console.log(file);
			 };
			 
			 $scope.upload_file = function(myFile,path)
    			{
					
					if(path=='merchant_deal_pics')
					{
						
						
					var baseurl = 	"http://localhost/limitedads/Requestdispatcher/uploaddeal_pics/";
					baseurl = baseurl.trim();
					var val = fileUpload.uploadFileToUrl(myFile, baseurl);
					}
					else{
					var baseurl = 	"http://localhost/limitedads/Requestdispatcher/uploadmerprofile/";
					baseurl = baseurl.trim();
					var val = fileUpload.uploadFileToUrl(myFile, baseurl+path);
					}
				};

//delete uploaded pic

$scope.deleteUploadedpic = function(param,ide)
{
	var len = $scope.pics_del.length;
	
	$scope.pics_del[len]=param;
	
	var myEl = angular.element( document.querySelector( '#dealpic_'+ide ) );
   myEl.remove();
}



// category list

$scope.getdealcategories = function()
{
	$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/getdealcategories',
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(categorylist) { 
									$scope.categlist = { availableCategories:categorylist};
									$scope.add_deal_mdl.categ = $scope.categlist.availableCategories[0];
	
									console.log($scope.add_deal_mdl.categ);
									});
	
};


//getdealsizes list
$scope.getdealsizes = function()
{
	$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/getdealsizes',
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(size_list) { 
									$scope.sizeslist = { available_sizes:size_list};
									$scope.add_deal_mdl.addsize = $scope.sizeslist.available_sizes[0];
	
									console.log($scope.add_deal_mdl.addsize);
									});
	
};


		
//check category had selected or not
$scope.checkcategory = function(slectedcateg) 		
{
	
	if(slectedcateg.catid>0)
	{
		$scope.invalid_deal_category=true;
	}
	else
	$scope.invalid_deal_category=false;
}


//check deal sizes
$scope.checkdealsize = function(selected_addsize)
{
	if(selected_addsize.sizeid>0)
	{
		$scope.invalid_deal_addsize=true;
	}
	else
	$scope.invalid_deal_addsize=false
}


//check whether deal starts date selected or not
$scope.chkdeal_startdate = function (add_deal_mdldeal_starts)
{
	
	var add_deal_mdldeal_starts = $.trim(add_deal_mdldeal_starts);
	if(add_deal_mdldeal_starts !='')
	{
		$scope.invalid_deal_start_date = false;
	}
	else
	{
		$scope.invalid_deal_start_date = true;
	}
	
}

//check whether deal ends date selected or not
$scope.chkdeal_enddate = function (add_deal_mdldeal_ends,edit_add)
{
	var add_deal_mdldeal_ends = $.trim(add_deal_mdldeal_ends);
	if(add_deal_mdldeal_ends !='')
	{
		if(edit_add == 'add')
		{
			var date1 = new Date($scope.add_deal_mdl.deal_starts);
			var date2 = new Date($scope.add_deal_mdl.deal_ends);
		}
		else
		{
			var date1 = new Date($scope.edit_deal_mdl.deal_starts);
			var date2 = new Date($scope.edit_deal_mdl.deal_ends);
		}
		
		
		var diffDays = date2.getDate() - date1.getDate(); 
		
		
		
		if( diffDays>=0){ $scope.invalid_deal_ends_date = false; }
		else{ $scope.invalid_deal_ends_date = true; $scope.end_date_negative ="End date is less than start date";  }
		
		
		
	}
	else
	{
		$scope.invalid_deal_ends_date = true;
		$scope.end_date_negative ="Enter offer end date"; 
	}
	
}
				

$scope.addadeal=function(dealoroffer,edit_add)
{
	
//	console.log(dealoroffer); return false;
	if($scope.pics_del.length>0)
	{
			dealoroffer.updatePics=$scope.pics_del;
	}
	if( edit_add !='edit')
	{

		if(!$scope.dealpics_selected)
		{
			$scope.dealpic_message ="Please select an image for the deal";
			return false;
		}
	
	}

	$http({ 
				method:'post',
				url:baseurl+'Requestdispatcher/addadeal',
				data:{'adddealdata':dealoroffer,'edit_add':edit_add},
				headers:{'content-Type':'application/x-www-form-urlencoded'}	
					}).success(function(adddealresp) {  
															adddealresp = adddealresp.trim();
															if(adddealresp == "1")
															{
																if( edit_add == 'add')
																{	
																	$scope.add_deal_succ=true;
																	$scope.add_deal_succ_msg = 'A deal added successfully';
																	
																	$scope.add_deal_fail=false;
																	$scope.add_deal_fail_msg = '';
																	
																	$scope.add_deal_mdl = {};
																	$scope.form.adddeal.$setPristine();
																	$scope.add_deal_mdl.categ = $scope.categlist.availableCategories[0];

																	//reset the input type fie to null
																	
																	angular.forEach( angular.element("input[type='file']"), function(inputElem) {
																		angular.element(inputElem).val(null);
																	});
																	
															}
															else
															{
																
																$scope.update_deal_succ=true;
																$scope.update_deal_succ_msg = 'A deal Updated successfully';
																
																
															}
																	
																	
															}
															
															else
															{
																if( edit_add == 'add' )
																{
																	$scope.add_deal_succ=false;
																	$scope.add_deal_succ_msg = '';
																	
																	$scope.add_deal_fail=true;
																	$scope.add_deal_fail_msg = 'Unable to add a deal contact administrator';
																}
																else
																{
																	
																}
	
																
															}
					 								 });
													 
}; // add a deal ends here


$scope.addprintdeal=function(dealoroffer,edit_add)
{
	

	$http({ 
				method:'post',
				url:baseurl+'Requestdispatcher/addprintdeal',
				data:{'adddealdata':dealoroffer,'edit_add':edit_add},
				headers:{'content-Type':'application/x-www-form-urlencoded'}	
					}).success(function(adddealresp) {  
															adddealresp = adddealresp.trim();
															if(adddealresp == "1")
															{
																if( edit_add == 'add')
																{	
																	$scope.add_deal_succ=true;
																	$scope.add_deal_succ_msg = 'A deal added successfully';
																	
																	$scope.add_deal_fail=false;
																	$scope.add_deal_fail_msg = '';
																	
																	$scope.add_deal_mdl = {};
																	$scope.form.adddeal.$setPristine();
																	$scope.add_deal_mdl.categ = $scope.categlist.availableCategories[0];

																	//reset the input type fie to null
																	
																	angular.forEach( angular.element("input[type='file']"), function(inputElem) {
																		angular.element(inputElem).val(null);
																	});
																	
															}
															else
															{
																
																$scope.update_deal_succ=true;
																$scope.update_deal_succ_msg = 'A deal Updated successfully';
																
																
															}
																	
																	
															}
															
															else
															{
																if( edit_add == 'add' )
																{
																	$scope.add_deal_succ=false;
																	$scope.add_deal_succ_msg = '';
																	
																	$scope.add_deal_fail=true;
																	$scope.add_deal_fail_msg = 'Unable to add a deal contact administrator';
																}
																else
																{
																	
																}
	
																
															}
					 								 });
}; // add a deal ends here

/*
	Coded By 	::::::::	Sudhaker
	Coded On 	::::::::	21-07-2016
	Modified On ::::::::	
	
	Description ::::::::
							Calling the printed or deal offers offered by a mechant and show in the respective view pages

*/

$scope.getprinted_Offers_deals = function(businesside,table)
{
	
	$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/getprinted_Offers_deals',
			data:{'businesside':businesside,'table':table},
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(getoffer_deal_response) { 
			console.log(getoffer_deal_response);
			if( $.trim(getoffer_deal_response)!='0' )
			{
		
				$scope.view_printed_deals_data=true;
				$scope.view_printed_deals_nodata=false;

				$scope.dealsoffered = getoffer_deal_response;
				$scope.viewby = 10;
				$scope.totalItems = $scope.dealsoffered.length;
				$scope.currentPage = 1;
				$scope.itemsPerPage = $scope.viewby;
				$scope.maxSize = 5; //Number of pager buttons to show
				
	
				$scope.setPage = function (pageNo) {
				$scope.currentPage = pageNo;
				};
				
				$scope.pageChanged = function() {
				//console.log('Page changed to: ' + $scope.currentPage);
				};
				$scope.setItemsPerPage = function(num) {
				
				$scope.itemsPerPage = num;
				$scope.currentPage = 1; //reset to first paghe
				}
			}
			else
			{
				$scope.view_printed_deals_nodata=true;
				$scope.view_printed_deals_data=false;
			}
			});
	
}; // getprinted-deals eds here

/*
	Coded By 	::::::::	Sudhaker
	Coded On 	::::::::	22-07-2016
	Modified On ::::::::	
	
	Description ::::::::
							Used to delete the deal or the printed deal

*/



$scope.del_deal_printed =  function(dealid,printed_deal,curnt_pge,indx)
{
	
	
	if( printed_deal == "printed" ) 
	var table = 'add_printed_deal';
	else if ( printed_deal == "adddeal" ) 
	var table = 'add_deal';
	
	var dealid = dealid;
	
	$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/del_deal_printed',
			data:{'dealid':dealid,'table':table},
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(del_resp) { 
										if(del_resp!='0')
										{
											$scope.currentPage = curnt_pge;
											var myEl = angular.element( document.querySelector( '#printed_deal_'+indx ) );
											myEl.remove();
										}
										else
										console.log(del_resp);
										});
	
	
	
	
	
	
};


/*
	Coded By 	::::::::	Sudhaker
	Coded On 	::::::::	21-07-2016
	Modified On ::::::::	
	
	Description ::::::::
							Calling the single printed deal and showing the related info in the modal popup

*/

$scope.view_offer_printed_deal = function(dealide,deal_print)
{
	
	if( deal_print == "printed_deal" )
	{
		var url_method = 'viewprinteddeal';	
	}
	else if( deal_print == "adddeal" )
	{
		var url_method = 'viewoffereddeal';	
	}
	
	
	$http({ 
			method:'post',
			url:baseurl+"Requestdispatcher/"+url_method,
			data:{'printeddealid':dealide},
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(viewprinteddeal_resp){ 
														// console.log(viewprinteddeal_resp); 
														 $scope.viewprinted_deal = viewprinteddeal_resp;
														// console.log($scope.viewprinted_deal); 
														});


};
	
$scope.get_edit_printed_offer_deal = function(offerid,table)
{
	
		$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/getdealcategories',
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(categorylist) { 
									$scope.categlist = { availableCategories:categorylist};

		$http({ 
				method:'post',
				url:baseurl+'Requestdispatcher/get_edit_printed_offer_deal',
				data:{'offerid':offerid,'table':table},
				headers:{'content-Type':'application/x-www-form-urlencoded'},
				}).success(function(deal_for_edit_resp){
				
				$scope.edit_deal_mdl = deal_for_edit_resp;
				$scope.edit_deal_mdl.dealid = deal_for_edit_resp.Deal_Id;
				$scope.edit_deal_mdl.editcateg = deal_for_edit_resp.Category;
					
					$http({ 
			method:'post',
			url:baseurl+'Requestdispatcher/getdealsizes',
			headers:{'content-Type':'application/x-www-form-urlencoded'},
			}).success(function(size_list) { 
									$scope.sizeslist = { available_sizes:size_list};
									$scope.edit_deal_mdl.addsize = deal_for_edit_resp.SelectedSize;
									console.log(deal_for_edit_resp.SelectedSize);
	
									});
				});
									
			});
	
		
		
		
		
		
};
//});
	}]);
	
