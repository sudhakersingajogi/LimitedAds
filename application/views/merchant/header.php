<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="LimitedAps" ng-controller="LACtrl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title ng-cloak>{{title}}</title>

<base href="http://localhost/limitedads/" />


<link rel="stylesheet" href="Resources/css/common/bootstrap-min.css" />
<link rel="stylesheet" href="Resources/css/common/Jqueryui.css" />
<link rel="stylesheet" href="Resources/css/common/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" href="Resources/css/merchant/pagination-bootstrap.css" />
<!--<script language="javascript" src="Resources/jsfiles/common/JQuery.js"> </script>-->
<style>
[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
  display: none !important;
}

.datepickerdemoBasicUsage {
  /** Demo styles for mdCalendar. */ }
  .datepickerdemoBasicUsage md-content {
    padding-bottom: 200px; }
  .datepickerdemoBasicUsage .validation-messages {
    font-size: 12px;
    color: #dd2c00;
    margin: 10px 0 0 25px; }
	
	#prfleIMG{ width:1024px; heght:120px;}
	.prfleIMG{ width:1024px; heght:120px;}
	
	.checkedClass{ background:#096;}
	.uncheckedClass{background:#C33;}
	
</style>
</head>

<body >

<?PHP
if( $this->session->userdata('Mechant_Email')=='' || $this->session->userdata('Business_Id') =='')
{
	redirect(base_url());
}
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">LIMITED-ADS  </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <li class="<?PHP if( $this->uri->segment(2) == "") { echo 'active';}?>"><a href="<?PHP echo base_url()?>Merchantpanel/">Dashboard</a></li>
        <li class="<?PHP if( $this->uri->segment(2) == "edit-profile") { echo 'active';}?>"><a href="<?PHP echo base_url();?>Merchantpanel/edit-profile">Edit-Profile  </a></li>

        <li class="<?PHP if( $this->uri->segment(2) == "add-a-deal") { echo 'active';}?>"><a href="<?PHP echo base_url();?>Merchantpanel/add-a-deal">Add a deal</a></li>
        
         <li class="<?PHP if( $this->uri->segment(2) == "view-a-deal") { echo 'active';}?>"><a href="<?PHP echo base_url();?>Merchantpanel/view-a-deal">View a deal</a></li>

        <li class="<?PHP if( $this->uri->segment(2) == "Add-print-deal") { echo 'active';}?>"><a href="<?PHP echo base_url();?>Merchantpanel/Add-print-deal">Add print deal</a></li>
         <li class="<?PHP if( $this->uri->segment(2) == "view-print-deal") { echo 'active';}?>"><a href="<?PHP echo base_url();?>Merchantpanel/view-print-deal">View print deal</a></li>
        
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
     
        
        
        
        <li class="dropdown">
        
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?PHP echo substr($this->session->userdata('Mechant_Email'),0,14)."..."; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
           
           <li><a href="<?PHP echo base_url()?>Merchantpanel/edit-profile">Edit profile</a></li>

            <li role="separator" class="divider"></li>
            <li><a href="javascript:void(0)" ng-click="logout('Merchant')">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
