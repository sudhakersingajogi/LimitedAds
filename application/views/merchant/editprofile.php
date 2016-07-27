
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#profile">Profie</a></li>
  <li><a data-toggle="tab" href="#store" ng-click="getstates('<?PHP echo $this->session->userdata('Mechant_Email'); ?>')">Store</a></li>
  <li><a data-toggle="tab" href="#Storebanner" ng-click="getmerchantprofilepic('<?PHP echo $this->session->userdata('Mechant_Email'); ?>')">Store banner pic</a></li>
  <li><a data-toggle="tab" href="#Locateme" ng-click="getlocatondetails('<?PHP echo $this->session->userdata('Business_Id'); ?>')">Locate Me</a></li>
</ul>

<div class="tab-content">
  <div id="profile" class="tab-pane fade in active">
    
    
    
    
<h3>Personal info</h3>

<div ng-cloak ng-show="mechantprofile_succ" class="alert alert-success">
{{mechantprofile_success}}
</div>

<div ng-show='mechantprofile_fail' ng-cloak class="alert alert-warning">
 {{mechantprofile_failure}}
</div>

        
        <form  name="form.merc_profile" ng-submit="editmerchantprofile(merc_profile_mdl)" class="form-horizontal" role="form" ng-init="getbusinessprofile('<?PHP echo $this->session->userdata('Mechant_Email'); ?>')">
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Contact Email Id:</label>
            <div class="col-lg-8">
              <input class="form-control" name="businessemail" type="text" ng-model="merc_profile_mdl.businessemail" disabled>
            </div>
          </div>
<!--          
          <div class="form-group">
            <label class="col-lg-3 control-label">Contact Person:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="Bishop">
            </div>
          </div>
-->          
          <div class="form-group">
            <label class="col-lg-3 control-label">Contact Number:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="Contact_Number" ng-model="merc_profile_mdl.Contact_Number" ng-focus="hidemerchantsprofilemessages()" required>
              <span ng-show="form.merc_profile.Contact_Number.$error.required" ng-cloak>Contact number is required</span>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Save Changes" ng-disabled="form.merc_profile.$invalid">

            </div>
          </div>
        </form>

    
    
    
    
    
  </div>
  <!-- profile ends here -->
  
  <div id="store" class="tab-pane fade" >

    
<h3>Store info</h3>
  
<div ng-cloak ng-show="mechantstore_succ" class="alert alert-success">
{{mechantstore_success}}
</div>  
  
  
<div class="col-md-8">    
    <form name="form.merc_store_info" ng-submit="editmerchantstoreinfo(merc_storeinfo_mdl)" class="form-horizontal" role="form">
    
    <div class="form-group">
        <label for="storename">Store Name</label>
        <input type="text" class="form-control" id="storename" name="storename" ng-model="merc_storeinfo_mdl.storename">
    </div>
    
    <div class="form-group">
        <label for="contactname">Contact Person</label>
        <input type="text" class="form-control" id="contactname" name="contactname" ng-model="merc_storeinfo_mdl.contactname">
    </div>
    
    <div class="form-group" >
        <label for="state">Select State</label>
<!--		<select class="form-control" name="state" id="name" ng-model="merc_storeinfo_mdl.state"> 
        		<option >Select State</option>
        </select> -->
<!--        
        <select name="state" class="form-control" ng-options="option.name for option in stateslist.availableOptions track by option.stateid" ng-model="merc_storeinfo_mdl.store_state" required >
        </select>
        -->
        
<select name="state" class="form-control" ng-options="option.name for option in stateslist.availableOptions track by option.stateid" ng-model="merc_storeinfo_mdl.store_state" required >
        </select>        
        
    </div>
    
    <div class="form-group">
        <label for="city">City</label>
        <input type="text" class="form-control" id="city" name="city" ng-model="merc_storeinfo_mdl.City">
    </div>
    
    <div class="form-group">
        <label for="area">Area</label>
        <input type="text" class="form-control" id="area" name="area" ng-model="merc_storeinfo_mdl.Area">
    </div>
    

    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" name="address" ng-model="merc_storeinfo_mdl.Address">
    </div>    
    
        
     <div class="form-group">
        <label for="storedescription">Store Description</label>
    <textarea class="form-control"  id="storedescription" name="storedescription" ng-model="merc_storeinfo_mdl.Store_Description">
    </textarea>
        
    </div>
    
    <div class="form-group">
        <label for="datepicker">Opens At</label>
        	<input type="text"  class="form-control" id="opensat" name="opensat" ng-model="merc_storeinfo_mdl.OpensAt" />
           



    </div>
    
     <div class="form-group">
        <label for="closesat">Closes At</label>
        <input type="text" class="form-control" id="closesat" name="closesat" ng-model="merc_storeinfo_mdl.ClosesAt">

    </div>
    
     <div class="form-group">
        <label for="website">Website url</label>
        <input type="text" class="form-control" id="website" name="website" ng-model="merc_storeinfo_mdl.Website">

    </div>
    
    
  
    <button type="submit" class="btn btn-primary" ng-disabled="false">Save Changes</button>
</form>
    
 </div>   
    
  </div>
  
<!-- Store related  -->  
  <div id="Storebanner" class="tab-pane fade">
    
    
    <img ng-src="{{merc_storeinfo_mdl.Store_Pics}}" id="prfleIMG" class="prfleIMG"  style="position:relative; border:1px solid #ccc; width:1024px; height:220px;" />

    
    <input type="file"  style="position:absolute; top:20%; left:63%; bottom:60%" file-model="Myfile" name="Myfile" onchange="angular.element(this).scope().imageUpload(event,'')" >
    
    
  </div>
  <!-- store banner pic -->
  
  
  
  <!-- locate me starts here -->
  <div id="Locateme" class="tab-pane fade">
    
  <div id="googleMap" style="width:1024px;height:380px;"></div> 

<!--
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3806.2776735452085!2d78.37892131487715!3d17.44641898804323!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb915f95d13673%3A0x7495deed53906602!2sinovies%2C+HUDA+Techno+Enclave%2C+HITEC+City%2C+Hyderabad%2C+Telangana+500081!5e0!3m2!1sen!2sin!4v1468578844206" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
-->    
  </div>
  
  <!-- locate me ends here -->
  
  
  
</div>

