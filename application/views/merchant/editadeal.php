<h3>Edit a deal or an offer</h3>
<div ng-cloak ng-show="update_deal_succ" class="alert alert-success">
{{update_deal_succ_msg}}
</div>

<div ng-cloak ng-show="add_deal_fail" class="alert alert-danger">
{{add_deal_fail_msg}}
</div>

 <div ng-init="get_edit_printed_offer_deal('<?PHP echo $this->uri->segment(3); ?>','add_deal')"> 

        <form class="form-horizontal" role="form" name="form.editdeal" ng-submit="addadeal(edit_deal_mdl,'edit')" novalidate >
          <div class="form-group">
            <label class="col-lg-3 control-label">Deal name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="offername" ng-model="edit_deal_mdl.offername" required>
				<span ng-show="(form.editdeal.offername.$dirty || submitted) && form.editdeal.offername.$error.required" ng-cloak>Deal name is required</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Description:</label>
            <div class="col-lg-8">
            <textarea class="form-control" name="offerdescpr" ng-model="edit_deal_mdl.offerdescpr" required></textarea>
            <span ng-show="(form.editdeal.offerdescpr.$dirty || submitted) && form.editdeal.offerdescpr.$error.required" ng-cloak>Description is required</span>
            </div>          </div>
          
          
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Category</label>
            <div class="col-lg-8">
             <select name="categ" class="form-control" ng-options="option.category for option in categlist.availableCategories track by option.catid" ng-model="edit_deal_mdl.editcateg" ng-change="checkcategory(edit_deal_mdl.categ)" required >
             
             </select>
             
             <span ng-hide="invalid_deal_category"  ng-cloak>Select Category </span>
             
             
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Starts on</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" id="deal_starts" ng-change="chkdeal_startdate(edit_deal_mdl.deal_starts)" ng-blur="chkdeal_startdate(edit_deal_mdl.deal_starts)" name="deal_starts" ng-model="edit_deal_mdl.deal_starts">
         
              <span ng-show="invalid_deal_start_date"  ng-cloak>Enter offer start date </span>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Expires on</label>
                          <span ng-hide="invalid_deal_category"  ng-cloak>Enter offer start date </span>
            <div class="col-lg-8">
              <input class="form-control" type="text"id="deal_ends" ng-blur="chkdeal_enddate(edit_deal_mdl.deal_ends,'edit')" ng-change="chkdeal_enddate(edit_deal_mdl.deal_ends,'edit')" name="deal_ends" ng-model="edit_deal_mdl.deal_ends" >
              
              <input type="hidden" name="dealid" ng-model="edit_deal_mdl.dealid" />
              
               <span ng-show="invalid_deal_ends_date"  ng-cloak>{{end_date_negative}}</span>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label" style="margin-right:15px">Uploaded images</label>
			 <div ng-repeat="pics in edit_deal_mdl.Deal_pics" class="col-sm-2 thumbnail col-sm-offset-0 " id="dealpic_{{$index}}" ng-cloak>
   <!--     {{pics.name}} -->
   <div ng-cloak>
   <a href="javascript:void(0)" ng-click="deleteUploadedpic(pics.name,$index)" > Click On Image To Delete</a>
          	          <img ng-src="<?PHP echo base_url()?>Resources/dealpicuploads/<?PHP echo $this->session->userdata('Business_Id');?>/{{pics.name}}" class="img-responsive" title="{{pics.name}}" />
</div>

             </div>
          </div>
          

          
<div class="form-group">
            <label class="col-lg-3 control-label">Deal pics</label>
            <div class="col-lg-8">
            
            <input class="form-control" type="file" file-model="Myfile" name="Myfile" onchange="angular.element(this).scope().imageUpload(event,'merchant_deal_pics')" multiple >
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Update a deal" ng-disabled="(form.editdeal.$invalid || !invalid_deal_category || invalid_deal_start_date || invalid_deal_ends_date || !invalid_deal_addsize )">
              
            </div>
          </div>
        </form>
</div>        