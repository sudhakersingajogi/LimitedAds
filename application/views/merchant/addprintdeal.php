<h3>Add a deal or an offer</h3>
<div ng-cloak ng-show="add_deal_succ" class="alert alert-success">
{{add_deal_succ_msg}}
</div>

<div ng-cloak ng-show="add_deal_fail" class="alert alert-danger">
{{add_deal_fail_msg}}
</div>

 
        <form class="form-horizontal" role="form" name="form.adddeal" ng-submit="addprintdeal(add_deal_mdl,'add')" novalidate>
          <div class="form-group">
            <label class="col-lg-3 control-label">Deal name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="offername" ng-model="add_deal_mdl.offername" required>
				<span ng-show="(form.adddeal.offername.$dirty || submitted) && form.adddeal.offername.$error.required" ng-cloak>Deal name is required</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Description:</label>
            <div class="col-lg-8">
            <textarea class="form-control" name="offerdescpr" ng-model="add_deal_mdl.offerdescpr" required></textarea>
            <span ng-show="(form.adddeal.offerdescpr.$dirty || submitted) && form.adddeal.offerdescpr.$error.required" ng-cloak>Description is required</span>
            </div>          </div>
          
          
          
          <div class="form-group" ng-init="getdealcategories()">
            <label class="col-lg-3 control-label">Category</label>
            <div class="col-lg-8">
             <select name="categ" class="form-control" ng-options="option.category for option in categlist.availableCategories track by option.catid" ng-model="add_deal_mdl.categ" ng-change="checkcategory(add_deal_mdl.categ)" required >
             
             </select>
             
             <span ng-hide="invalid_deal_category"  ng-cloak>Select Category </span>
             
             
            </div>
          </div>
          
          <div class="form-group" ng-init="getdealsizes()">
            <label class="col-lg-3 control-label">Select Sizes</label>
            <div class="col-lg-8">
             <select name="addsize" class="form-control" ng-options="option.size for option in sizeslist.available_sizes track by option.sizeid" ng-model="add_deal_mdl.addsize" ng-change="checkdealsize(add_deal_mdl.addsize)" required >
             
             </select>
             
             <span ng-hide="invalid_deal_addsize"  ng-cloak>Select Size </span>
             
             
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Starts on</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" id="deal_starts" ng-change="chkdeal_startdate(add_deal_mdl.deal_starts)" ng-blur="chkdeal_startdate(add_deal_mdl.deal_starts)" name="deal_starts" ng-model="add_deal_mdl.deal_starts">
         
              <span ng-show="invalid_deal_start_date"  ng-cloak>Enter offer start date </span>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Expires on</label>
                          <span ng-hide="invalid_deal_category"  ng-cloak>Enter offer start date </span>
            <div class="col-lg-8">
              <input class="form-control" type="text"id="deal_ends" ng-blur="chkdeal_enddate(add_deal_mdl.deal_ends,'add')" ng-change="chkdeal_enddate(add_deal_mdl.deal_ends,'add')" name="deal_starts" ng-model="add_deal_mdl.deal_ends" >
               <span ng-show="invalid_deal_ends_date"  ng-cloak>{{end_date_negative}}</span>
            </div>
          </div>
          
          
<!--          
          <div class="form-group">
            <label class="col-lg-3 control-label">Deal pics</label>
            <div class="col-lg-8">
         
            <input class="form-control" type="file" file-model="Myfile" name="Myfile" onchange="angular.element(this).scope().imageUpload(event,'merchant_deal_pics')" multiple >
            </div>
          </div>
-->          
          
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Add a deal" ng-disabled="(form.adddeal.$invalid || !invalid_deal_category || invalid_deal_start_date || invalid_deal_ends_date || !invalid_deal_addsize)">
              
            </div>
          </div>
        </form>