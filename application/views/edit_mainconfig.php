<?php
HTML_Render_Head($js_vars,'Setup');
echo $JS_JQuery;
echo $CSS_Main;
?>
<script type="text/javascript">

$(document).ready(function() {
	
 $("input[name='setuptype']").change(radioValueChanged);
 
 //As default displays only basic setup
 	$("#advSetup").hide();
	$("#advSetup2").hide();
	var tempvalue=document.getElementById('Profile Version');
	tempvalue.value = "Unknown";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalX');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalY');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalProjectionID');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('PosAccuracy');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('VerticalDatum');?>');
	tempvalue.value = "Unknown";
	
	var tempvalue=document.getElementById('<?php echo getTxt('SpatialReference');?>');
	tempvalue.value = "Unknown";
	
	
 $("#wwdb").change(function () {

	var val = $("#wwdb").val();
	if(val=="1")
	{
	//Hide the Database settings 
		$("#dbsettings").hide();
	}
	else
	{
		$("#dbsettings").show();
	}
 });
});


//This function changes the visibility of certain configuration fields 
//for the main setup screen. The more detailed settings are only shown 
//in the advanced setup and are not shown and filled with default values
//when in basic mode
function radioValueChanged(){
		
if ($("input[type=radio][name='setuptype'][value='Basic']").is(':checked')) 		{
	$("#advSetup").hide();
	$("#advSetup2").hide();
	var tempvalue=document.getElementById('Profile Version');
	tempvalue.value = "Unknown";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalX');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalY');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalProjectionID');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('PosAccuracy');?>');
	tempvalue.value = "NULL";
	
	var tempvalue=document.getElementById('<?php echo getTxt('VerticalDatum');?>');
	tempvalue.value = "Unknown";
	
	var tempvalue=document.getElementById('<?php echo getTxt('SpatialReference');?>');
	tempvalue.value = "Unknown";
	
	}
else{
	$("#advSetup").show();
	$("#advSetup2").show();
	var tempvalue=document.getElementById('Profile Version');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalX');?>');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalY');?>');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('LocalProjectionID');?>');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('PosAccuracy');?>');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('VerticalDatum');?>');
	tempvalue.value = "";
	
	var tempvalue=document.getElementById('<?php echo getTxt('SpatialReference');?>');
	tempvalue.value = "";
	
	}
}

</script>
<?php
HTML_Render_Body_StartInstall(); 
genHeading('MainConfigTitle',true);
$attributes = array('class' => 'form-horizontal', 'name' => 'createConfig', 'id' => 'createConfig');
echo form_open('home/installation', $attributes);
?>
<div class="col-sm-12"><p class="h1"><strong><?php echo getTxt('AdminWelcome');?></strong></p></div>
<div class="col-sm-12"><span class="help-block"><?php echo getTxt('MainConfigDirections');?></span></div>
<?php 	
genInput('CurrentUsername','username', 'username1', false, " readonly value='his_admin'"); 
genInputT('NewPassword','password','password1',true,'','EnterNow');
?>
<div class="col-sm-12"><p class="h12"><strong><?php echo getTxt('EnterDefaultSettings');?></strong></p></div></br>
			<div class="col-sm-12"><p class="h6"><strong><?php echo getTxt('SetupType');?></strong>&nbsp;
        <input type="radio" name= "setuptype" value="Basic" checked="checked" >Basic</input> &nbsp;
        <input type="radio" name= "setuptype" value="Advanced" >Advanced</input><br /><br />
        </p>
			</div>
<div class="col-md-12"><span class="h4"><strong><?php echo getTxt('MySQLConfiguration');?></strong></span><br/><br/></div>
<p><?php echo getTxt('databaseInstructions');?></p>
<?php
if(!$default)
{
$options = genOptions(array(
			1=>"Yes",
			0=>"No"
		));
genSelect('useExistingDB',"wwdb","wwdb",$options,'SelectEllipsis',true);}
echo '<div id="dbsettings">';
genInputH('DatabaseHost','DatabaseHost','databasehost',getTxt('DatabaseHostInfo'),true);
genInput('DatabaseUsername','DatabaseUserName','databaseusername',true);
genInput('DatabasePassword','DatabasePassword','databasepassword',true);
genInputH('DatabaseName','DatabaseName','databasename',getTxt('DatabaseNameInfo'),true);
echo '</div>';
?>
<div class="col-sm-12"><p class="h4"><strong><?php echo getTxt('ConfigurationSettingsLook');?></strong></p></div>
<?php
$extraText="";
if($default)
{
	$options = "<option value='true'>".getTxt('Yes')."</option>";
	genSelect('multipleInstall',"multi","multi",$options,'No',true);
	$extraText = " value='default' readonly";
}
genInputT('ConfigName','WebsitePath','ConfigName',true,$extraText,'ConfigDesc');
genSelect('LanguageCode',"LangCode","lang",$langOptions,'SelectEllipsis',true);
genInputT('OrganizationName','OrganizationName','orgname',true,'','OrganizationNameEx');
genInputT('ParentWebsiteName','ParentWebsiteName','parentname',true,'','ParentWebsiteNameEx');
genInputT('ParentWebsite','ParentWebsite','parentweb',true,'','WebsiteDomainEx');								
?>            

<div id="advSetup">
<div class="col-sm-12"><p class="h4"><strong><?php echo getTxt('ConfigurationSettingsSource');?></strong></p></div>
<?php
genInputH('MetaDataProfileVersion','Profile Version','profilev',getTxt('ProfileVersionInfo'));
?>
<div class="col-sm-12"><p class="h4"><strong><?php echo getTxt('ConfigurationSettingsSites');?></strong></p></div>
<?php
genInputT('Source','Source','source',true,'','OrganizationNameEx');
genInputH('LocalX','LocalX','localx',getTxt('LocalXInfo'));	
genInputH('LocalY','LocalY','localy',getTxt('LocalYInfo'));	
genInputH('LocalProjectionID','LocalProjectionID','localpid',getTxt('LocalProjectionIDInfo'));	
genInputH('PosAccuracy','PosAccuracy','posaccuracy',getTxt('PositionalAccuracyInfo'));	
genInputH('VerticalDatum','VerticalDatum','vdatum',getTxt('VerticalDatumInfo'));	
genInputH('SpatialReference','SpatialReference','spatialref',getTxt('SpatialReferenceInfo'));	
?>
</div>
<div class="col-sm-12"><p class="h4"><strong><?php echo getTxt('ConfigurationSettingsVariables');?></strong></p></div>
<?php
genInputH('VariableCode','VariableCode','varcode',getTxt('VariableCodeInfo'));	
genInputH('TimeSupport','TimeSupport','timesupport',getTxt('LocalXInfo'));	
?>
<div class="col-sm-12"><p class="h4"><strong><?php echo getTxt('ConfigurationSettingsDataValues');?></strong></p></div>
<?php
genInputH('UTCOffset','UTC Offset','utcoffset1',getTxt('UTCOffsetInfo'));
?>
<div id="advSetup2">
<?php
genInputH('CensorCode','CensorCode','censorcode',getTxt('CensorCodeInfo'),true,' value="nc"');
genInputH('QualityControlLevel','QualityControlLevel','qcl',getTxt('QualityControlLevelInfo'),true,' value="0"');
genInputH('ValueAccuracy','ValueAccuracy','valueacc',getTxt('ValueAccuracyInfo'),true,' value="NULL"');
genInputH('OffsetTypeID','OffsetTypeID','offsettype',getTxt('OffsetIntergerInfo'),true,' value="NULL"');
genInputH('QualifierID','QualifierID','qualifier',getTxt('QualifierIDInfo'),true,' value="1"');
genInputH('SampleID','sampleid','sampleid',getTxt('SampleIDInfo'),true,' value="NULL"');
genInputH('DerivedFromID','DerivedfromID','derived',getTxt('DerivedFromIDInfo'),true,' value="NULL"');
?> 
</div>
 <input type="hidden" name="hiddenstuff" value="<?php echo $hiddenStuff;?>" class="button"/>
            <div class="col-md-5 col-md-offset-5">
       <input type="SUBMIT" name="submit" value="<?php echo getTxt('SaveSettings');?>" class="button"/>
       <input type="reset" name="Reset" value="<?php echo getTxt('Cancel'); ?>" class="button" style="width: auto" />
       <div id="plsWait" hidden="true"><?php echo getTxt('PleaseWait');?></div>
	</div>
	</div>
<?php HTML_Render_Body_End();?>
<script>
	//Script Processing instead of standard form processing. The reason being all CI functionality is kinda disabled until the config file 
	//is initialized. 

	var setupScriptURL=asset_url.replace('assets','setup');

	$("form").submit(function(){

		if(($("#password").val())==""){
		alert("Please enter a Password");
		return false;
		}
		if(($("#wwdb").val())=="-1"){
		alert("Please indicate if you'd like to use default database connection");
		return false;
		}
		if(($("#DatabaseHost").val())==""){
		alert("Please enter a Database Host name");
		return false;
		}
		if(($("#DatabaseUserName").val())==""){
		alert("Please enter a Database Username");
		return false;
		}
		if(($("#DatabasePassword").val())==""){
		alert("Please enter a Database Password");
		return false;
		}
		if(($("#DatabaseName").val())==""){
		alert("Please enter a Database Name");
		return false;
		}
		if(($("#WebsitePath").val())==""){
		alert("Please enter a Database Name");
		return false;
		}
		if(($("#OrganizationName").val())==""){
		alert("Please enter a Organization Name");
		return false;
		}
		if(($("#ParentWebsiteName").val())==""){
		alert("Please enter a Parent Website Name");
		return false;
		}
		if(($("#ParentWebsite").val())==""){
		alert("Please enter a Parent Website");
		return false;
		}
		
		var regex = /[0-9]/;
	if(!($("#TimeSupport").val().match(regex))){
		alert("Please enter a valid number. Time Support can only be a number.");
		return false;
	}
		
		

		var tempvalue=document.getElementById("<?php echo getTxt('OrganizationName');?>");
		document.getElementById('<?php echo getTxt('Source');?>').value=tempvalue.value;

		if(!($.isNumeric($("[id='UTC Offset']").val())))
		{
			$("[id='UTC Offset']").focus();
				$("[id='UTC Offset']").hide('slow',function(){$("[id='UTC Offset']").show('slow');
					alert("<?php echo getTxt('UTCOffsetError')?>");});
			return false;	
		}


		if($("#LangCode").val()=="-1")
		{
			alert("<?php echo 'Please select a '.getTxt('LanguageCode')?>");
			return false;	
		}

		var fal=0;
		//If Default DB selected: 

		$("#createConfig input[type=text]").each(function() {
				
			if ((($(this).val())=="")&&(($(this).attr('name'))!="databasepassword"))
			{ 
			
			if ($("#wwdb").val()=="1")
			{
			
			if ($(this).attr('name')=="databasename")
			{
				return true;	
			}
			
			if ($(this).attr('name')=="databaseusername")
			{
				return true;	
			}
			if ($(this).attr('name')=="databasehost")
			{
				return true;	
			}		
			}
			
			$(this).focus();
				$(this).hide('slow',function(){$(this).show('slow');alert(<?php echo "'".getTxt('CannotLeave')."'";?> + " " +$(this).attr('id')+" " + <?php echo "'".getTxt('Blank')."'";?>);});
				fal=1;
				return false;	
			}
			});

		if (fal==1)
		return false;
		$("#plsWait").show(200);
		$.post(setupScriptURL+"db_check.php", $("#createConfig").serialize(),  function( data ) {
			if(data!="success")
			  {
			  	$("#plsWait").hide();
				  alert(data);
			 	 return false;
			  }
			  else
			  {
			  	//Database Check succeeded. 
			  	console.log($("#createConfig").serialize());
			  	$.post(setupScriptURL+"do_add_table.php", $("#createConfig").serialize(),  function( data ) {
			  		console.log(data);
					if(data!="success")
					{
						$("#plsWait").hide();
						alert(data);
						return false;
					}
					else
					{
						//Table creation successful. 
						$.post(setupScriptURL+"createConfig.php", $("#createConfig").serialize(),  function( data ) {

							if(data=="success")
							{
								$("#plsWait").hide();
								//Redirect to success view. 
								<?php
									if($default)
										echo 'window.location.href = base_url+"default/home/successinstall?db="+$("#Website\\\\ Path").val();';
									else
										echo 'window.location.href = base_url+"home/successinstall?db="+$("#Website\\\\ Path").val();';
								?>
								
								return false;
							}
							else
							{
								$("#plsWait").hide();
								alert("<?php echo getTxt('ProcessingError');?>");
								console.log(data);
							}

						});
					}
		  			
			  		});
			  	}

		});

		return false;
	});
	//Validation for the form goes here. 

</script>