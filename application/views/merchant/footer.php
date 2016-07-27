




</div> <!-- container ends here -->


<!-- Website modal starts here -->


<!-- Modal for merchant registration -->
<div class="modal fade" id="MerchantRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" ng-show="merchantheader1">Mechant Registration</h4>
        <h4 class="modal-title" id="myModalLabel" ng-show="merchantheader2">Mechant Registration Success</h4>
                <h4 class="modal-title" id="myModalLabel" ng-show="merchantheader3">Unable to register the merchat</h4>
      </div>
      <div class="modal-body" ng-show="merchantreg_forme">
        
   <form name="form.merc_regform" ng-submit="merchant_reg(merc_regform_mdl)" novalidate>
  <div class="form-group">
    <label for="Email">Email address</label>
    <input type="email" class="form-control" id="Email" placeholder="Email" name="Email" ng-model="merc_regform_mdl.Email" ng-focus="Meremail_exists=false" required>
  
  <span ng-show="(form.merc_regform.Email.$dirty || submitted) && form.merc_regform.Email.$error.required">Email is required</span>
  <span ng-show="(form.merc_regform.Email.$error.email)">Invalid email format</span>
    <span ng-show="Meremail_exists">Email already exists</span>
  </div>
  
 
  
  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control" id="Password" placeholder="Password" name="Password" ng-model="merc_regform_mdl.Password" ng-minlength="6" required>

    <span ng-show="(form.merc_regform.Password.$dirty || submitted) && form.merc_regform.Password.$error.required">Password is required</span>
        <span ng-show="(form.merc_regform.Password.$dirty || submitted) && form.merc_regform.Password.$invalid">Password is minimum of characters</span>
    
  </div>
  
  <div class="form-group">
    <label for="cnfPassword">Confirm Password</label>
    <input type="password" class="form-control" id="cnfPassword" placeholder="cnfPassword" name="cnfPassword" ng-model="merc_regform_mdl.cnfPassword"  ng-minlength="6" required>
        <span ng-show="(form.merc_regform.Password.$dirty || submitted) && form.merc_regform.Password.$error.required">Confirm Password is required</span>
        <span ng-show="(form.merc_regform.Password.$dirty || submitted) && merc_regform_mdl.cnfPassword!==merc_regform_mdl.Password">Password Mismatches</span>
  </div>
  
  <div class="form-group">
    <label for="Contact_Number">Contact Numbder</label>
    <input type="text" class="form-control" id="Contact_Number" placeholder="9963985612" name="Contact_Number" ng-model="merc_regform_mdl.Contact_Number" ng-pattern="/^[0-9]{7,}$/" required >
    
    <span  ng-show="form.merc_regform.Contact_Number.$dirty && form.merc_regform.Contact_Number.$error.required" >Contact number required</span> 

<span ng-show="form.merc_regform.Contact_Number.$dirty && form.merc_regform.Contact_Number.$error.pattern" >Minimum 7 characters</span>

  </div>
  
  
  <div class="checkbox">
    <label>
      <input type="checkbox" checked disabled="disabled"> I accept terms & conditions
    </label>
  </div>
<button type="submit" class="btn btn-primary" ng-disabled="( (form.merc_regform.$invalid || merc_regform_mdl.cnfPassword!==merc_regform_mdl.Password) )">Submit</button>
</form>
        
        
        
      </div>
      
      <!--
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
      -->
    </div>
  </div>
</div>
<!-- Modal for merchant registration ends here-->





<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="Resources/jsfiles/common/bootstrap-min.js"> </script>

<!-- <script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/common/Angular-uncom.js"> </script> -->
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.js"> </script>

<script language="http://localhost/limitedads/Resources/jsfiles/common/Angularuncom.js"></script>
<script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/common/angular-controller.js"> </script>
<script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/merchant/ui-bootstrap-tpls-0.11.0.js"> </script>
<script src="http://localhost/limitedads/Resources/jsfiles/common/Jquery-ui-1.12.0.js">

</script>
<script>

$(document).ready(function(){ 
var date = new Date();
$( "#deal_starts,#deal_ends" ).datepicker({ 

format: 'dd/mm/yyyy',
    todayHighlight:'TRUE',
    minDate: 0,
    autoclose: true,

});



 });

</script>


<script src="http://localhost/limitedads/Resources/jsfiles/common/Jquery-ui-slider.js">  </script>
<script src="http://localhost/limitedads/Resources/jsfiles/common/jquery-ui-timepicker-addon.js">  </script>

<script src="http://localhost/limitedads/Resources/jsfiles/common/JQuerytimepicker.js">  </script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCDtv651n9D06ZeEvO-grr9OOgVUvtq4Zs"></script>
</body>
</html>