<div ng-show="view_printed_deals_data" ng-cloak>
<h3> Deals what you are offering  </h3>
<hr>

<div ng-init="getprinted_Offers_deals('<?PHP echo $this->session->userdata('Business_Id'); ?>','add_printed_deal')" ng-cloak>

<table class="table table-condensed " >
    <thead>
        <tr>
            <th>Slno</th>
            <th>Print Deal</th>
            <th>Start Date</th>
            <th>Expired On</th>
            <th>Category</th>
            <th>Status</th>
            <th>View | Edit | Delete </th>
        </tr>
    </thead>
    <tbody>
  
      <tr ng-repeat="deals in dealsoffered.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage))" ng-cloak ng-class="{'success': {{deals.Expired_Active == 'Active'}}, 'danger': {{deals.Expired_Active == 'Expired'}} }" id="printed_deal_{{$index}}">
         <td>{{deals.SLNO}}</td>
        <td>{{deals.Offer_Name}}</td>
        <td>{{deals.Dealstarts}}</td>
        <td>{{deals.Dealends}}</td>
        <td>{{deals.categoryName}}</td>
        <td>{{deals.Expired_Active}}</td>
        <td>
        <a href="#viewOffer" data-toggle="modal" class="btn btn-sm btn-primary" ng-click="view_offer_printed_deal(deals.Deal_Id,'printed_deal')" > View</a>
        <a href="<?PHP echo base_url();?>Merchantpanel/editprintdeal/{{deals.Deal_Id}}" class="btn btn-sm btn-warning"> Edit </a>
        <a href="javascript:void(0)" ng-click="del_deal_printed(deals.Deal_Id,'printed',currentPage,$index)"  class="btn btn-sm btn-danger"> Delete </a>
        </td>
      </tr>
    </table>

<pagination total-items="totalItems" ng-model="currentPage" ng-change="pageChanged()" class="pagination-sm" items-per-page="itemsPerPage"></pagination>

</div>

</div>

<div ng-show="view_printed_deals_nodata" ng-cloak>
<h1>No printed deals added</h1>
</div>


<div class="DemoModal2">
    <!-- Modal Contents -->
    <div id="viewOffer" class="modal fade "> <!-- class modal and fade -->
      
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          
           <div class="modal-header"> <!-- modal header -->
            <button type="button" class="close" 
             data-dismiss="modal" aria-hidden="true">×</button>
			 
                    <h4 class="modal-title" ng-cloak>{{ viewprinted_deal.Offer_Name }}</h4>
           </div>
		 
     <div class="modal-body"> <!-- modal body -->

<div>       
       <h6><strong>Print Deal Description:</strong></h6> 
{{ viewprinted_deal.Offer_Description}}

</div>


<div>
<h6><strong>Print Deal Starts:</strong></h6>
{{ viewprinted_deal.Deal_Starts}}
</div>

<div>
<h6><strong>Print Deal Starts:</strong></h6>
{{ viewprinted_deal.Deal_Expires }}
</div>

<div>
<h6><strong>Category:</strong></h6>
{{ viewprinted_deal.categories }}
</div>

<div>
<h6><strong>Print Size:</strong></h6>
{{ viewprinted_deal.SizeName }}
</div>
	 
     <div class="modal-footer"> <!-- modal footer -->
    
     <a href="<?PHP echo base_url();?>Merchantpanel/editprintdeal/{{viewprinted_deal.dealid}}" class="btn btn-sm btn-warning">Edit Deal</a>
      </div>
				
      </div> <!-- / .modal-content -->
      
    </div> <!-- / .modal-dialog -->
      
 </div><!-- / .modal -->