<?php

//redirect anyone that is not an administrator
//	if (!isAdmin()){
//	header("Location: index.php?state=pass2");
//	exit;	
//	}


/*
//filter the Site results after Source is selected
$sql ="SELECT * FROM sources";
$result = transQuery($sql,0,0);

	if (count($result) < 1){
		$msg = "<p class=em2>$NoSoureces</em></p>";
	} else {
		foreach ($result as $row) {
			$s_id = $row["SourceID"];
			$s_org = $row["Organization"];
			$option_block_s .= "<option value=$s_id>$s_org</option>";
		}
	}

*/
HTML_Render_Head($js_vars);
echo $CSS_JQX;
echo $JS_GetTheme;
echo $JS_JQuery;
echo $JS_Forms;
echo $JS_JQX;
echo $CSS_Main;
?>

<script type="text/javascript">

$(document).ready(function(){

	$("#editsource").hide();
	$('#window').hide();

	$('#window').jqxWindow({ height: 150, width: 200, theme: 'darkblue' });
    	$('#window').jqxWindow('hide');

	$("#Yessir").click(function(){
		deleteSource();	
		$('#window').jqxWindow('hide');
	 });
	 
	$("#No").click(function(){
    	$('#window').jqxWindow('hide');
	});
});	

function confirmBox(){
	$("html, body").animate({ scrollTop: 0 }, "slow");
$('#window').show();
    $('#window').jqxWindow('show');
}

function show_answerProf(){
alert(<?php echo "'".getTxt('ProfileVersionLabel')."'"; ?>);
}

</script>
<?php HTML_Render_Body_Start(); 
genHeading('EditDeleteSource',true);
echo '<p>'.getTxt('SelectSource').'</p>';


genSelect('Source','SourceID','SourceID',$sourceOptions,'SelectEllipsis',true,' onChange="editSource()"');
?>
<strong class="em2"><?php echo getTxt('NoteColon');?></strong> <span class="em"><?php echo getTxt('NoteText');?></span>
<div id="msg3"></div>
<?php

$attributes = array('class' => 'form-horizontal', 'name' => 'editsource', 'id' => 'editsource');
echo form_open('source/change', $attributes);
genInput('Organization','Organization', 'Organization', true);
echo '<span class="em">' .getTxt('ExTitle1').'</span>';
genInput('Description','SourceDescription','SourceDescription', true);
echo '<span class="em">' .getTxt('ExDescript').'</span>';
genInput('Link','SourceLink','SourceLink', true);
echo '<span class="em">' .getTxt('ExMetaLink').'</span>';
genInput('ContactName','ContactName','ContactName', true);
echo '<span class="em">' .getTxt('ExName').'</span>';
genInput('Phone','Phone','Phone', true);
echo '<span class="em">' .getTxt('ExPhone').'</span>';
genInput('Email','Email','Email', true);
echo '<span class="em">' .getTxt('ExEmail').'</span>';
genInput('Address','Address','Address', true);
genInput('City','City','City', true);
genSelect('State','State','State',$stateOptions,'SelectEllipsis',true);
genInput('Zip','ZipCode','ZipCode', true);
genInput('Citation','Citation','Citation');
echo '<span class="em">' .getTxt('ExCitation').'</span>';
genInput('MetadataIDSemicolon','MetadataID','MetadataID', false,' readonly');
echo '<span class="em">' .getTxt('MetadataAutoGenerated').'</span>';
genSelect('TopicCategory','TopicCategory','TopicCategory',$topicOptions,'SelectEllipsis', true);
genInput('Title','Title','Title', true);
echo '<span class="em">' .getTxt('ExTitle2').'</span>';
genInput('Abstract','Abstract','Abstract', true);
echo '<span class="em">' .getTxt('ExAbstract1').'</span>';
genInput('MetaLink','MetadataLink','MetadataLink');
echo '<p class="help-block">' .getTxt('ExMetaLink').'</span>';
?>
<div class="col-md-5 col-md-offset-5">
<input type='submit' name='submit' value='<?php echo getTxt('SaveEdits');?>' class='button' style='width: auto' onClick='updateSource()'/>&nbsp;&nbsp;
<input type='button' name='delete' value='<?php echo getTxt('Delete');?>' class='button' style='width: auto' onClick='confirmBox()'/>&nbsp;&nbsp;
<input type='button' name='Reset' value='<?php echo getTxt('Cancel');?>' class='button' style='width: auto' onClick='clearEverything()'/>
</form>
</div>
<div id="window">
	<div id="windowHeader">
		<span><?php echo getTxt('ConfirmationBox');?></span>
	</div>
    <div style="overflow: hidden;" id="windowContent"><center><strong><?php echo getTxt('AreYouSure');?></strong><br /><br /><input name="Yes" type="button" value="<?php echo getTxt('Yes');?>" id="Yessir"/>&nbsp;<input name="No" type="button" value="<?php echo getTxt('No');?>" id="No"/></center></div>
</div>
</div>
<?php HTML_Render_Body_End(); ?>

<script>
//When a selection from the Source dropdown menu, a query is used to fill in the form.
function editSource(){
	
		var sourceid=$("#SourceID").val();
		if(sourceid==-1)
		{
			//Clear the form
			$("#editsource")[0].reset();
			$("#editsource").hide();
			return;
		}
		$.ajax({
		dataType: 'json',
		url: base_url+"source/get/"+sourceid}).done(function(data){
			
			if(data.SourceID==sourceid){
				
				//Set the forms.
				
				$("#Organization").val(data.Organization);
				$("#SourceDescription").val(data.SourceDescription);
				$("#SourceLink").val(data.SourceLink);
				$("#ContactName").val(data.ContactName);
				$("#Phone").val(data.Phone);
				$("#Email").val(data.Email);
				$("#State").val(data.State);
				$("#ZipCode").val(data.ZipCode);
				$("#Citation").val(data.Citation);
				$("#MetadataID").val(data.MetadataID);
				$("#TopicCategory").val(data.TopicCategory);
				$("#Title").val(data.Title);
				$("#Abstract").val(data.Abstract);
				$("#MetadataLink").val(data.MetadataLink);
				$("#Address").val(data.Address);
				$("#City").val(data.City)
				
            	setHintHandlers();
				$("#editsource").show();
				return true;
			
			}else{
				alert(<?php echo "'".getTxt('ErrorDuringRequest')."'";?>);
				return false;
				}
		});
};


//When the "Delete" button is clicked, validate the method selected and then submit the request
function deleteSource(){

		if(($("#SourceID").val())==-1){
			alert(<?php echo "'".getTxt('SelectSourceDelete')."'"; ?>);
			return false;
		}
	
		if(($("#MetadataID2").val())==""){
			alert(<?php echo "'".getTxt('SourceWithoutMetadataID')."'"; ?>);
			return false;
		}
	
	//Validation is now complete, so send to the processing page
	var sourceid = $("#SourceID").val();
	var metadataid = $("#MetadataID2").val();
	
		$.ajax({
		dataType:'json',
		url: base_url+"source/delete/"+sourceid+"?ui=1"}).done(function(data){
		
			if(data.status=="success"){
					window.open(base_url+"source/change","_self");	
			}else{
				alert(<?php echo "'".getTxt('ProcessingError')."'"; ?>);
				return false;
			}
		});		
return false;
};



//When the "Save Edits" button is clicked, validate the fields and then submit the request
function updateSource(){

	$("#editsource").submit(function(){

		//Validate all fields
		if(($("#SourceID").val())==""){
			alert(<?php echo "'".getTxt('SelectSourceEdit')."'"; ?>);
			return false;
		}
		//Add this to the form. 
		
		var selectedItem = $('#SourceID').jqxDropDownList('getSelectedItem');
			$('<input>').attr({
			type: 'hidden',
			id: 'SourceID',
			name: 'SourceID',
			value: $("#SourceID").val()
		}).appendTo('#editsource');

		if(($("#Organization").val())==""){
			alert(<?php echo "'".getTxt('EnterOrganization')."'"; ?>);
			return false;
		}

		if(($("#SourceDescription").val())==""){
			alert(<?php echo "'".getTxt('EnterDescription')."'"; ?>);
			return false;
		}

		//SourceLink Validation
		if(($("#SourceLink").val())!=""){
			var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
			if(!($("#SourceLink").val().match(regexp))){
				alert(<?php echo "'".getTxt('InvalidSourceLinkURL')."'"; ?>);
				return false;
			}
		}

		//Contact Name Validation
		if(($("#ContactName").val())==""){
			alert(<?php echo "'".getTxt('EnterContactNameSource')."'"; ?>);
			return false;
		}

		//Phone Validation
		if(($("#Phone").val())==""){
			alert(<?php echo "'".getTxt('EnterPhoneNumber')."'"; ?>);
			return false;
		}
		
		var regex = /^[0-9+\(\)#\.\s\/ext-]+$/
		if(!($("#Phone").val().match(regex))){
			alert(<?php echo "'".getTxt('InvalidPhoneNumber')."'"; ?>);
			return false;
		}

		//Email Validation
		if(($("#Email").val())==""){
			alert(<?php echo "'".getTxt('EnterEmailAddress')."'"; ?>);
			return false;
		}
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		if(!($("#Email").val().match(pattern))){
			alert(<?php echo "'".getTxt('InvalidEmailAddress')."'"; ?>);
			return false;
		}

		//Address Validation
		if(($("#Address").val())==""){
			alert(<?php echo "'".getTxt('EnterAddress')."'"; ?>);
			return false;
		}

		//City Validation
		if(($("#City").val())==""){
			alert(<?php echo "'".getTxt('EnterCity')."'"; ?>);
			return false;
		}
	
		//State Validation
		if(($("#State option:selected").val())==-1){
			alert(<?php echo "'".getTxt('SelectSourceState')."'"; ?>);
			return false;
		}

		//Zip Code Validation
		if(($("#ZipCode").val())==""){
			alert(<?php echo "'".getTxt('EnterZipCode')."'"; ?>);
			return false;
		}
		if(!($("#ZipCode").val().match(/^\d{5}(-\d{4})?$/))){
			alert(<?php echo "'".getTxt('InvalidZipCode')."'"; ?>);
			return false;
		}

		//MetadataID Validation
		if(($("#MetadataID").val())==""){
			alert(<?php echo "'".getTxt('SourceWithoutMetadataID')."'"; ?>);
			return false;
		}
	
		//Topic Category Validation
		if(($("#TopicCategory").val())==""){
			alert(<?php echo "'".getTxt('SelectTopicCategory')."'"; ?>);
			return false;
		}

		//Title Validation
		if(($("#Title").val())==""){
			alert(<?php echo "'".getTxt('EnterMetadataTitle')."'"; ?>);
			return false;
		}

		//Abstract Validation
		if(($("#Abstract").val())==""){
			alert(<?php echo "'".getTxt('EnterMetadataAbstract')."'"; ?>);
			return false;
		}

		//Profile Version Validation
		if(($("#ProfileVersion").val())==""){
			alert(<?php echo "'".getTxt('EnterProfileVersionContact')."'"; ?>);
			return false;
		}

		//MetadataLink Validation
		if(($("#MetadataLink").val())!=""){
			var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
			if(!($("#MetadataLink").val().match(regexp))){

				alert(<?php echo "'".getTxt('InvalidURLMetadata')."'"; ?>);
				return false;
			}
		}
	});
}

//When the "Cancel" button is clicked, clear the fields and reload the page
function clearEverything(){
	$("#SourceID").val(-1);
	//Clear the form
	$("#editsource")[0].reset();
	$("#editsource").hide();
}

</script>