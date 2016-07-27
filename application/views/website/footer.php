




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


<!-- Modal for merchant Login -->
<div class="modal fade" id="MerchantLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" >Mechant Login</h4>

      </div>
      <div class="modal-body" >
        
   <form name="form.merc_loginform" ng-submit="merchant_login(merc_logform_mdl)" novalidate>
  <div class="form-group">
    <label for="Email">Email address</label>
    <input type="email" class="form-control" id="Email" placeholder="Email" name="Email" ng-model="merc_logform_mdl.Email" ng-focus="merchant_invalid_credentials=false" required>
  
  <span ng-show="(form.merc_loginform.Email.$dirty || submitted) && form.merc_loginform.Email.$error.required">Email is required</span>
  <span ng-show="(form.merc_loginform.Email.$error.email)">Invalid email format</span>
 
  </div>
  
 
  
  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control" id="Password" placeholder="Password" name="Password" ng-focus="merchant_invalid_credentials=false" ng-model="merc_logform_mdl.Password" required>

    <span ng-show="(form.merc_loginform.Password.$dirty || submitted) && form.merc_loginform.Password.$error.required">Password is required</span>

    
  </div>
  
<button type="submit" class="btn btn-primary" ng-disabled="( (form.merc_loginform.$invalid ) )">Login</button>
<span style="color:red" ng-show="merchant_invalid_credentials"> Invalid credentials </span>
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
<!-- Modal for merchant Loginends here-->




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="Resources/jsfiles/common/bootstrap-min.js"> </script>

<!-- <script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/common/Angular-uncom.js"> </script> -->
<script language="javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.js"> </script>

<script language="http://localhost/limitedads/Resources/jsfiles/common/Angularuncom.js"></script>
<script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/common/angular-controller.js"> </script>
<script language="javascript" src="http://localhost/limitedads/Resources/jsfiles/merchant/ui-bootstrap-tpls-0.11.0.js"> </script>


</body>
</html>