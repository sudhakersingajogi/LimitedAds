<div ng-show="view_printed_deals_data" ng-cloak>
<h3> Deals what you are offering  </h3>
<hr>

<div ng-init="getprinted_Offers_deals('<?PHP echo $this->session->userdata('Business_Id'); ?>','add_deal')" ng-cloak>



<table class="table table-condensed " >
    <thead>
        <tr>
            <th>Slno</th>
            <th>Deal Name</th>
            <th>Start Date</th>
            <th>Expired On</th>
            <th>Category</th>
            <th>Status</th>
            <th>View | Edit | Delete </th>
        </tr>
    </thead>
    <tbody>
  
      <tr ng-show="dealsoffered.length>0" ng-repeat="deals in dealsoffered.slice(((currentPage-1)*itemsPerPage), ((currentPage)*itemsPerPage))" ng-cloak id="printed_deal_{{$index}}">
         <td>{{deals.SLNO}}</td>
        <td>{{deals.Offer_Name}}</td>
        <td>{{deals.Dealstarts}}</td>
        <td>{{deals.Dealends}}</td>
        <td>{{deals.categoryName}}</td>
        <td>{{deals.Expired_Active}}</td>
        <td>
        <a href="#viewOffer" data-toggle="modal" class="btn btn-sm btn-primary" ng-click="view_offer_printed_deal(deals.Deal_Id,'adddeal')" > View</a>
        <a href="<?PHP echo base_url();?>Merchantpanel/editadeal/{{deals.Deal_Id}}" class="btn btn-sm btn-warning"> Edit </a>
        <a href="javascript:void(0)" class="btn btn-sm btn-danger" ng-click="del_deal_printed(deals.Deal_Id,'adddeal',currentPage,$index)"> Delete </a>
        </td>
      </tr>
      </tbody>
    </table>
    <!--
View <select ng-model="viewby" ng-change="setItemsPerPage(viewby)"><option>3</option><option>5</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option></select> records at a time.
-->
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

	 
     <div class="modal-footer"> <!-- modal footer -->
    
     <a href="<?PHP echo base_url();?>Merchantpanel/editadeal/{{viewprinted_deal.dealid}}" class="btn btn-sm btn-warning">Edit Deal</a>
      </div>
				
      </div> <!-- / .modal-content -->
      
    </div> <!-- / .modal-dialog -->
      
 </div><!-- / .modal -->