<?php
$default_timesupport = ""; //Come from config. 
HTML_Render_Head($js_vars);
echo $JS_JQuery;
echo $CSS_JQX;
echo $JS_JQX;
echo $JS_Forms;
echo $CSS_Main;
?>
<script type="text/javascript">
var unitsid=0;
//Default Parameter
//Can be linked to the config page
var nodatavalue=-9999;

$(document).ready(function(){
	$("#msg").hide();
	$("#new_spec").hide();
	$("#unit").hide();
	$("#unittext").hide();
	$("#newunit").hide();
	$("#smother").hide();
	$("#newunitonly").hide();
	$("#valuetypenewb").hide();
	$("#newvarnameb").hide();

//Default starter for Variable Code
//	var d_varcode = $_SITE_default_varcode;

//	$("#VariableCode").val(d_varcode);

//List : Speciation
var selec_ind=0;
var url=base_url+"variable/getTable/speciationcv";
// prepare the data
var source =
{
	datatype: "json",
	datafields: [
		{ name: 'Term' },
		{ name: 'Definition' }
	],
	id: 'id',
	url: url,
	async: false
};
var dataAdapter = new $.jqx.dataAdapter(source);

// Create a jqxComboBox for Speciation
$("#specdata").jqxDropDownList({ selectedIndex: 0, source: dataAdapter, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
	
$("#specdata").bind('select', function (event) {
var args = event.args;
var item = $('#specdata').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					
 $("#specdef").val(item.value);
 $("#specdef").attr('disabled', true);
 $("#new_spec").hide();
$("#new_spec1").hide();
 }
 
 if(item.value=="-10")
 {
//If user selects other option
	$("#specdef").removeAttr("disabled");	 
	 $("#specdef").val(<?php echo "'".getTxt('EnterDefinition')."'"; ?>);
//Show the other box
$("#new_spec").show(200);
$("#new_spec1").show(200);



 }
 
  });
  
var url2=base_url+"variable/getUnitTypes";

                // prepare the data
                var source2 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'unitype' },
                        { name: 'unitid' }
                    ],
                    id: 'id',
                    url: url2,
                    async: false
                };
                var dataAdapter2 = new $.jqx.dataAdapter(source2);

// Create a jqxComboBox for the var unit types. 
$("#unittype").jqxDropDownList({ selectedIndex: 0, source: dataAdapter2, displayMember: "unitype", valueMember: "unitid", width: 250, height: 25, theme: 'darkblue'});

$("#unittype").bind('select', function (event) {
var args = event.args;
var item = $('#unittype').jqxDropDownList('getItem', args.index);

if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					

//Get all the units for that type and display it
$("#newunit").hide();
$("#newunitonly").hide();
$("#unit").show();
$("#unittext").show();
var url3=base_url+"variable/getUnitsByType?type="+item.label;

                // prepare the data
                var source3 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'unit' },
                        { name: 'unitid' }
                    ],
                    id: 'id',
                    url: url3,
                    async: false
                };
                var dataAdapter3 = new $.jqx.dataAdapter(source3);
	
// Create a jqxComboBox for the var unit types (this is for the units box that shows up once a variable type has been selected
$("#unit").jqxDropDownList({ selectedIndex: 0, source: dataAdapter3, displayMember: "unit", valueMember: "unitid", width: 250, height: 25, theme: 'darkblue'});

$("#unit").bind('select', function (event) {
var args = event.args;
var item = $('#unit').jqxDropDownList('getItem', args.index);

  if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					
$("#newunitonly").hide();
$("#newunit").hide();


}

if (item.value=="-10") 
{					
//Show the other box and other details required
$("#newunitonly").show(400);


}

});
}

if (item.value=="-10") 
{					

$("#unit").hide();
$("#unittext").hide();

//Show the other box and other details required
$("#newunit").show(400);
$("#newunitonly").show(400);


}

 
});


//Sample Medium List 
 var source4 =
{
	datatype: "json",
	datafields: [
		{ name: 'Term' },
		{ name: 'Definition' }
	],
	id: 'id',
	url: base_url+'variable/getTable/samplemediumcv',
	async: false
};
var dataAdapter4 = new $.jqx.dataAdapter(source4);


$("#samplemedium").jqxDropDownList({ selectedIndex: 0, source: dataAdapter4, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
	
$("#samplemedium").bind('select', function (event) {
var args = event.args;
var item = $('#samplemedium').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					


 $("#smdef").val(item.value);
 $("#smdef").attr('disabled', true);
 
 $("#smother").hide();
 }
 
 if(item.value=="-10")
 {
	 
//If user selects other option
	$("#smdef").removeAttr("disabled");	 
	 $("#smdef").val(<?php echo "'".getTxt('EnterDefinition')."'"; ?>);
//Show the other box
$("#smother").show(400);



 }
 
  });

//End of Sample Medium list

//Value type list
var source5 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Term' },
                        { name: 'Definition' }
                    ],
                    id: 'id',
                    url: base_url+'variable/getTable/valuetypecv',
                    async: false
                };
                var dataAdapter5 = new $.jqx.dataAdapter(source5);


$("#valuetype").jqxDropDownList({ selectedIndex: 0, source: dataAdapter5, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
	
$("#valuetype").bind('select', function (event) {
var args = event.args;
var item = $('#valuetype').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					


 $("#vtdef").val(item.value);
 $("#vtdef").attr('disabled', true);
 
 $("#valuetypenewb").hide();
 }
 
 if(item.value=="-10")
 {
	 
//If user selects other option
	$("#vtdef").removeAttr("disabled");	 
	 $("#vtdef").val(<?php echo "'".getTxt('EnterDefinition')."'"; ?>);
//Show the other box
$("#valuetypenewb").show(400);



 }
 
  });


//End of Value type list


//Start of isregular
var source7 = [
                    "<?php echo getTxt('SelectEllipsis');?>",
					"<?php echo getTxt('Regular');?>",
                    "<?php echo getTxt('Irregular');?>",
                    "<?php echo getTxt('Unknown');?>"
		        ];

                // Create a jqxDropDownList
$("#isreg").jqxDropDownList({ source: source7, selectedIndex: 0, width: '250', height: '25', theme: 'darkblue' });

//End of is regular

//begin time units id

var source8 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'unit' },
                        { name: 'unitid' }
                    ],
                    id: 'id',
                    url: base_url+"variable/getUnitsByType?type=Time&noNew=1",
                    async: false
                };
                var dataAdapter8 = new $.jqx.dataAdapter(source8);


$("#timeunit").jqxDropDownList({ selectedIndex: 0, source: dataAdapter8, displayMember: "unit", valueMember: "unitid", width: 250, height: 25, theme: 'darkblue'});
	

//End time units id

//begin Data type list
var source9 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Term' },
                        { name: 'Definition' }
                    ],
                    id: 'id',
                    url: base_url+'variable/getTable/datatypecv?noNew=1',
                    async: false
                };
                var dataAdapter9 = new $.jqx.dataAdapter(source9);
$("#datatype").jqxDropDownList({ selectedIndex: 0, source: dataAdapter9, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
	
$("#datatype").bind('select', function (event) {
var args = event.args;
var item = $('#datatype').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")) 
{					


 $("#dtdef").val(item.value);

 
 }
 
  });

// End of data type list


//begin general category list
var source10 =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'Term' },
                        { name: 'Definition' }
                    ],
                    id: 'id',
                    url: base_url+'variable/getTable/generalcategorycv?noNew=1',
                    async: false
                };
                var dataAdapter10 = new $.jqx.dataAdapter(source10);



$("#gc").jqxDropDownList({ selectedIndex: 0, source: dataAdapter10, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
	
$("#gc").bind('select', function (event) {
var args = event.args;
var item = $('#gc').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")) 
{					


 $("#gcdef").val(item.value);

 
 }
 
  });

// End of data type list

//Variable Name list : new option available

var url15=base_url+"variable/getTable/variablenamecv";

// prepare the data
var source15 =
{
	datatype: "json",
	datafields: [
		{ name: 'Term' },
		{ name: 'Definition' }
	],
	id: 'id',
	url: url15,
	async: false
};
var dataAdapter15 = new $.jqx.dataAdapter(source15);
$("#varname").jqxDropDownList({ selectedIndex:0,source: dataAdapter15, displayMember: "Term", valueMember: "Definition", width: 250, height: 25, theme: 'darkblue'});
$("#varname").bind('select', function (event) {
var args = event.args;
var item = $('#varname').jqxDropDownList('getItem', args.index);
    if ((item != null)&&(item.value!="-1")&&(item.value!="-10")) 
{					
 $("#vardef").val(item.value);
 $("#vardef").attr('disabled', true);
 	 $("#newvarnameb").hide();
 }
 
 if(item.value=="-10"){
	 
//If user selects other option
	$("#vardef").removeAttr("disabled");	 
	$("#vardef").val(<?php echo "'".getTxt('EnterDefinition')."'"; ?>);
//Show the other box
 $("#newvarnameb").show(200);


 }
 
  });

//End of variable list
	});

</script>

<script type="text/javascript">
//The following script is for the Method listbox
	var varmeth="";
	$(document).ready(function(){
	
		var source =
		{
	       	datatype: "json",
		   	datafields: [
        	  	{ name: 'methodname' },
	        	{ name: 'methodid' },
	       	],
    	       	url: 'db_get_methods2.php'
		};			
	
	var dataAdapter = new $.jqx.dataAdapter(source);
        // Create a jqxListBox
        $("#jqxWidget").jqxListBox({source: dataAdapter, theme: 'darkblue', multiple: true, width: 425, height: 300, displayMember: "methodname", valueMember: "methodid"});

	 	$("#jqxWidget").bind('change', function(){
			var items = $("#jqxWidget").jqxListBox('getItems');
			// get selected indexes.
			var selectedIndexes = $("#jqxWidget").jqxListBox('selectedIndexes');
			var selectedItems = [];
			varmeth="";
			// get selected items.
			for(var index in selectedIndexes){
				if(selectedIndexes[index] != -1){
					selectedItems[index] = items[index];
					varmeth+=selectedItems[index].value;
						if(index!=(selectedIndexes.length-1)){
							varmeth+=",";	
						}
				}
			}
	
        });
	});
</script>
<?php HTML_Render_Body_Start(); 
genHeading('AddNewVariable',true);
$attributes = array('class' => 'form-horizontal', 'name' => 'addvar');
echo form_open('variable/addvariable', $attributes);
genInputH('VariableCode','var_code', 'VariableCode',getTxt('ArbitraryCode'), true,"value='".$DefaultVarcode."'");

genDropLists('VariableName','varname','varname',true);

echo '<div id="newvarnameb">';
genInput('NewVarName','NewVarName', 'NewVarName', true);
echo '</div>';
genInputH('VariableDefinition','vardef', 'vardef',getTxt('VariableDefinitionMsg'), true);


genDropListsH('Speciation','specdata','specdata',getTxt('ValueCode'),true);

echo '<div id="new_spec">';
genInput('NewSpeciation','other_spec', 'other_spec', true);
genInput('SpeciationDef','specdef', 'specdef', true);
echo '</div>';

genDropListsH('VariableUnitType','unittype','unittype',getTxt('UnitsCategory'),true);
echo '<div id="unittext">';
genDropListsH('Unit','unit', 'unit',getTxt('UnitsMeasure'),true);
echo '</div>';
genDropLists('NewUnitDefinitionColon','NewUnitDefinitionColon', 'NewUnitDefinitionColon', true);
genInputH('UnitType','new_unit_type', 'new_unit_type', getTxt('UTAssociated'),true);
genInput('UnitName','new_unit_name', 'new_unit_name', true);
genInput('UnitAbbreviation','new_unit_abb', 'new_unit_abb', true);

genDropListsH('SampleMedium','samplemedium', 'samplemedium',getTxt('ObservationMedium'),true);
genInput('NewSampleMedium','smnew', 'smnew', true);
genInput('MediumDefinition','smdef', 'smdef', true);
genDropListsH('ValueType','valuetype', 'valuetype',getTxt('DataTypeMsg'),true);
genInput('ValueTypeNewColon','valuetypenew', 'valuetypenew', true);
genInput('ValueTypeDefinition','vtdef', 'vtdef', true);
genDropListsH('Regularity','isreg', 'isreg',getTxt('RegularlySampledTime'),true);
genInputH('TimeSupport','tsup', 'tsup',getTxt('TemporalFootprint'), true);
genDropLists('TimeUnit','timeunit', 'timeunit', true);
genDropLists('DataType','datatype', 'datatype', true);
echo '<textarea name="dtdef" cols="45" rows="4" readonly id="dtdef">'.getTxt('SelectData').'</textarea><span class="required">*</span>';
genDropListsH('Category','gc', 'gc',getTxt('ScientificCategory'),true);
genInput('CategoryDefinition','gcdef', 'gcdef', true);
genDropListsH('jqxWidget','jqxWidget', 'jqxWidget',getTxt('VariableCollectionMethod'),true);




?>
<div class="col-md-5 col-md-offset-5">
       <input type="SUBMIT" name="submit" value="<?php echo getTxt('AddVariableButton');?>" class="button"/>
       <input type="reset" name="Reset" value="<?php echo getTxt('Cancel'); ?>" class="button" style="width: auto" />
</div>
</div>
<?php
/*


      <p><br /><p class="em" align="right"><?php echo getTxt('RequiredFieldsAsterisk');?></p>
       <div id="msg">
          <p class=em2><?php echo getTxt('VariableSuccessfullyAdded');?></p></div>
        <h1><?php echo getTxt('AddNewVariable');?></h1>
      <form action="" method="post" name="add_var" id="add_var">
        <table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3" valign="top">&nbsp;</td>
          </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('VariableCode');?></strong></td>
          <td colspan="3" valign="top">
          <input type="text" id="var_code" name="VariableCode" value="<?php echo getTxt('_SITE_default_varcode'); ?>"  /><span class="required">*</span><span class="hint" title="<?php echo getTxt('ArbitraryCode')?>">?</span></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
          </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('VariableName');?></strong></td>
          <td valign="top"><div id="varname"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span></td>
          </tr>
        <tbody id="newvarnameb">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('NewVarName');?></strong>&nbsp;<input type="text" id="newvarname" name="newvarname" value="" class="medium" /><span class="required">*</span></td>
        </tr>
        </tbody>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('VariableDefinition');?></strong></td>
          <td colspan="3" valign="top"><input name="vardef" type="text" id="vardef" value="" class="long" maxlength="200" /><span class="required">*</span><span class="hint" title="<?php echo getTxt('VariableDefinitionMsg'); ?>">?</span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td width="175" valign="top"><strong><?php echo getTxt('Speciation');?></strong></td>
          <td valign="top"><div id="specdata"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('ValueCode'); ?>">?</span></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>

        <tr id="new_spec">
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('NewSpeciation');?></strong>&nbsp;<input type="text" id="other_spec" name="other_spec" value="" size="15" /><span class="required">*</span></td>
        </tr>
		<tr id="new_spec1">
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
          </tr>
          
        <tr>
          <td valign="top"><strong><?php echo getTxt('SpeciationDef');?></strong></td>
          <td colspan="3" valign="top"><input name="specdef" type="text" id="specdef" value="" class="medium" maxlength="200" /><span class="required">*</span></td>
        </tr>
        
        
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td height="30" valign="top"><strong><?php echo getTxt('VariableUnitType');?></strong></td>
          <td width="252" valign="top"><div id="unittype"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('UnitsCategory'); ?>">?</span></td>
          </tr>
        <tbody id="unitreq">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><div id="unittext"><strong><?php echo getTxt('Unit');?></strong></div></td>
          <td valign="top"><div id="unit"></div></td>
          <td colspan="2" valign="top"><span id="unitreqSpan"><span class="required">*</span><span class="hint" title="<?php echo getTxt('UnitsMeasure'); ?>">?</span></span></td>
          </tr>
        </tbody>
        <tbody id="newunit">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><span class=em2><?php echo getTxt('NewUnitDefinitionColon');?></span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('UnitType');?></strong>
		&nbsp;<input type="text" id="new_unit_type" name="new_unit_type" value="" class="medium" /><span class="required">*</span><span class="hint" title="<?php echo getTxt('UTAssociated'); ?>">?</span></td>
        </tr>
          </tbody>
        <tbody id="newunitonly">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
      
        
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('UnitName');?></strong>&nbsp;<input type="text" id="new_unit_name" name="new_unit_name" value="" class="medium" /><span class="required">*</span></td>
        </tr>
        
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('UnitAbbreviation');?></strong>&nbsp;<input type="text" id="new_unit_abb" name="new_unit_abb" value="" class="medium" /><span class="required">*</span></td>
        </tr>
        </tbody>
    
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('SampleMedium');?></strong></td>
          <td valign="top"><div id="samplemedium"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('ObservationMedium'); ?>">?</span></td>
          </tr>
        <tbody id="smother">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('NewSampleMedium');?></strong>&nbsp;<input type="text" id="smnew" name="smnew" value=""  class="medium" /><span class="required">*</span></td>
        </tr>
           </tbody>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('MediumDefinition');?></strong></td>
          <td colspan="3" valign="top"><input name="smdef" type="text" id="smdef" value=""  class="long" maxlength="200" /><span class="required">*</span></td>
        </tr>
        
     
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('ValueType');?></strong></td>
          <td valign="top"><div id="valuetype"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('DataTypeMsg'); ?>">?</span></td>
          </tr>
        <tbody id="valuetypenewb">
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top"><strong><?php echo getTxt('ValueTypeNew');?></strong>&nbsp;<input type="text" id="valuetypenew" name="valuetypenew" value="" class="medium" /><span class="required">*</span></td>
        </tr>
        </tbody>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('ValueTypeDefinition');?></strong></td>
          <td colspan="3" valign="top"><input name="vtdef" type="text" id="vtdef" value="" class="long" maxlength="200" /><span class="required">*</span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td height="18" valign="top"><strong><?php echo getTxt('Regularity');?></strong></td>
          <td valign="top"><div id="isreg"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('RegularlySampledTime'); ?>">?</span></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('TimeSupport');?></strong></td>
          <td colspan="3" valign="top"><input type="text" id="tsup" name="tsup" value="<?php echo getTxt('default_timesupport'); ?>"  /><span class="required">*</span>
		<span class="hint" title="<?php echo getTxt('TemporalFootprint'); ?>">?</span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('TimeUnit');?></strong></td>
          <td valign="top"><div id="timeunit"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('DataType');?></strong></td>
          <td valign="top"><div id="datatype"></div></td>
          <td colspan="2" valign="top"><span class="required">*</span></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('DataTypeDefinition');?></strong></td>
          <td colspan="3"><textarea name="dtdef" cols="45" rows="4" readonly id="dtdef"><?php echo getTxt('SelectData');?></textarea><span class="required">*</span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('Category');?></strong></td>
          <td valign="top"><div id="gc"></div></td>
          <td width="133" valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('ScientificCategory'); ?>">?</span></td>
          <td width="40" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><strong><?php echo getTxt('CategoryDefinition');?></strong></td>
          <td colspan="3" valign="top"><input name="gcdef" type="text" id="gcdef" value="<?php echo getTxt('SelectCategory');?>" class="long" readonly><span class="required">*</span></td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" valign="top"><strong><?php echo getTxt('SelectMethods');?></strong> <br>
<?php echo getTxt('SelectAllThatApply');?></td>
          </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" valign="top"><div id='jqxWidget'></div></td>
          <td valign="top"><span class="required">*</span><span class="hint" title="<?php echo getTxt('VariableCollectionMethod'); ?>">?</span></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">&nbsp;</td>
          <td colspan="3" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" valign="top"><input type="SUBMIT" name="submit" value="<?php echo getTxt('AddVariableButton');?>" class="button" />
		<input type="button" id="resetButton" class="button" value="<?php echo getTxt('Cancel')?>" /></div></td>
          </tr>
      </table>
    </FORM></p>

	<?php HTML_Render_Body_End(); ?>


<script>
//Reset function

$('#resetButton').click(function () {
	$("#add_var")[0].reset();
	unitsid=0;
$("#new_spec").hide();
$("#new_spec1").hide();
$("#unit").hide();
$("#unittext").hide();
$("#newunit").hide();
$("#smother").hide();
$("#newunitonly").hide();
$("#valuetypenewb").hide();
$("#newvarnameb").hide();
$("#varname").jqxDropDownList('selectIndex', 0 );
$("#specdata").jqxDropDownList('selectIndex', 0 );
$("#unittype").jqxDropDownList('selectIndex', 0 );
$("#unit").jqxDropDownList('selectIndex', 0 );
$("#samplemedium").jqxDropDownList('selectIndex', 0 );
$("#valuetype").jqxDropDownList('selectIndex', 0 );
$("#isreg").jqxDropDownList('selectIndex', 0 ); 
$("#timeunit").jqxDropDownList('selectIndex', 0 );
$("#datatype").jqxDropDownList('selectIndex', 0 );
$("#gc").jqxDropDownList('selectIndex', 0 );
$("#jqxWidget").jqxListBox('clearSelection');
$("#dtdef").val("Please select a data type to view its definition");
$("#gcdef").val("Please select a category to view its definition");
 $("html, body").animate({ scrollTop: 0 }, "slow");
});


//Calls a function to validate all fields when the submit button is hit.
$("form").submit(function(){
if(($("#var_code").val())==""){
		alert(<?php echo "'".getTxt('EnterVariableCode')."'"; ?>);
		return false;
	}
	
	if(($("#var_code").val().search("^[a-zA-Z0-9_.-]*$"))==-1)
{
		alert(<?php echo "'".getTxt('InvalidVariableCode')."'"; ?>);
		return false;
	}


//Check variable Name

var checkitem = $('#varname').jqxDropDownList('getSelectedItem');
//To prevent the ajax function from submitting
var Flag=0;
   if ((checkitem == null)||(checkitem.value=="-1"))
   {
	 alert(<?php echo "'".getTxt('SelectVariableName')."'"; ?>);
		return false;    
   }
   
   if(checkitem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#newvarname").val())==""){
		alert(<?php echo "'".getTxt('EnterNewVariable')."'"; ?>);
		return false;
	}
	
	if(($("#newvarname").val().search("^[a-zA-Z0-9_.-]*$"))==-1)
{
		alert(<?php echo "'".getTxt('InvalidVariableName')."'"; ?>);
		return false;
	}

	 
	 
	 if((($("#vardef").val())=="")||(($("#vardef").val())=="Please enter a definition")){
		alert(<?php echo "'".getTxt('EnterDefinitionNewVariable')."'"; ?>);
		return false;
	}  
	
var Flag=1;
   }

   
  
checkitem = $('#specdata').jqxDropDownList('getSelectedItem');
var Flag2=0;
   if ((checkitem == null)||(checkitem.value=="-1"))
   {
	alert(<?php echo "'".getTxt('SelectSpeciation')."'"; ?>);    
		return false;
   }
   
   if(checkitem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#other_spec").val())==""){
		alert(<?php echo "'".getTxt('SelectNewSpeciation')."'"; ?>);
		return false;
	}

	 if((($("#specdef").val())=="")||(($("#specdef").val())=="Please enter a definition")){
		alert(<?php echo "'".getTxt('EnterDefinitionNewSpeciation')."'"; ?>);
		return false;
	}  
var Flag2=1; 	
   }
 
 
checkitem = $('#unittype').jqxDropDownList('getSelectedItem');
//To prevent the ajax function from submitting
var Flag3=0;
var Flag4=0;

   if ((checkitem == null)||(checkitem.value=="-1"))
   {

	 alert(<?php echo "'".getTxt('SelectVariableUnitType')."'"; ?>);
		return false;    
   }

if ((checkitem != null)&&(checkitem.value!="-1")&&(checkitem.value!="-10"))    
{
//If type selected...check if unit selected

var unititem = $('#unit').jqxDropDownList('getSelectedItem');

if ((unititem == null)||(unititem.value=="-1"))
   {
	 alert(<?php echo "'".getTxt('SelectUnit')."'"; ?>);
		return false;    
   }
if(unititem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#new_unit_name").val())==""){
		alert(<?php echo "'".getTxt('EnterNameNewUnit')."'"; ?>);
		return false;
	}

	 if(($("#new_unit_abb").val())==""){
		alert(<?php echo "'".getTxt('EnterAbbreviationNewUnit')."'"; ?>);
		return false;
	}
	 	  
   }
}
   if(checkitem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#new_unit_name").val())==""){
		alert(<?php echo "'".getTxt('EnterNameNewUnit')."'"; ?>);
		return false;
	}

	 if(($("#new_unit_abb").val())==""){
		alert(<?php echo "'".getTxt('EnterAbbreviationNewUnit')."'"; ?>);
		return false;
	}  

 if(($("#new_unit_type").val())==""){
		alert(<?php echo "'".getTxt('EnterTypeNewUnit')."'"; ?>);
		return false;
	}  
var Flag3=1;   
var Flag4=1;	 

   }
 
//Check for Sample Medium


checkitem = $('#samplemedium').jqxDropDownList('getSelectedItem');
var Flag5=0;
   if ((checkitem == null)||(checkitem.value=="-1"))
   {
	 alert(<?php echo "'".getTxt('SelectMedium')."'"; ?>);
		return false;    
   }
   
   if(checkitem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#smnew").val())==""){
		alert(<?php echo "'".getTxt('EnterNewSampleMedium')."'"; ?>);
		return false;
	}
	
	if(($("#smnew").val().search("^[a-zA-Z0-9_.-]*$"))==-1)
	{
		alert(<?php echo "'".getTxt('InvalidSampleMedium')."'"; ?>);
		return false;
	}

	 
	 if((($("#smdef").val())=="")||(($("#smdef").val())=="Please enter a definition")){
		alert(<?php echo "'".getTxt('EnterDefinitionNewSampleMedium')."'"; ?>);
		return false;
	}  
var Flag5=1;	 
   }
  
//End Check SAMPLE MEDIUM

//Check Value type


checkitem = $('#valuetype').jqxDropDownList('getSelectedItem');
var Flag6=0;
   if ((checkitem == null)||(checkitem.value=="-1"))
   {
	 alert(<?php echo "'".getTxt('SelectValueType')."'"; ?>);
		return false;    
   }
   
   if(checkitem.value=="-10")
   {
	//A new selection...need to process it first so that the entry will be valid
	
	//Check if new fields are filled
	if(($("#valuetypenew").val())==""){
		alert(<?php echo "'".getTxt('EnterNewValueType')."'"; ?>);
		return false;
	}
	
	if(($("#valuetypenew").val().search("^[a-zA-Z0-9_.-]*$"))==-1){
		alert(<?php echo "'".getTxt('InvalidValueType')."'"; ?>);
		return false;
	}

	 
	 if((($("#vtdef").val())=="")||(($("#vtdef").val())=="Please enter a definition")){
		alert(<?php echo "'".getTxt('EnterDefinitionNewValueType')."'";?>);
		return false;
	}  
var Flag6=1;	 
   }
     

//End Check Value type


checkitem = $('#isreg').jqxDropDownList('getSelectedItem');

   if ((checkitem == null)||(checkitem.value=="-1"))
   {
	 alert(<?php echo "'".getTxt('SelectRegularity')."'"; ?>);
		return false;    
   }


checkitem = $('#timeunit').jqxDropDownList('getSelectedItem');

   if ((checkitem == null)||(checkitem.value=="-1")){
		alert(<?php echo "'".getTxt('SelectTimeUnit')."'"; ?>);
		return false;    
   }

checkitem = $('#datatype').jqxDropDownList('getSelectedItem');

   if ((checkitem == null)||(checkitem.value=="-1")){
		alert(<?php echo "'".getTxt('SelectDataTypeMsg')."'"; ?>);
		return false;    
   }

checkitem = $('#gc').jqxDropDownList('getSelectedItem');

   if ((checkitem == null)||(checkitem.value=="-1")){

		alert(<?php echo "'".getTxt('SelectCategoryMsg')."'"; ?>);
		return false;    
   }


if(($("#tsup").val())==""){
		alert(<?php echo "'".getTxt('EnterTimeSupportValue')."'"; ?>);
		return false;
	}

//Checking ends

var f_vc=$("#var_code").val();

checkitem = $('#varname').jqxDropDownList('getSelectedItem');

	if(checkitem.value=="-10"){
		var f_vn=$("#newvarname").val();
	}else{
		var f_vn=checkitem.label;
	}

checkitem = $('#specdata').jqxDropDownList('getSelectedItem');

	if(checkitem.value=="-10"){
		var f_sp=$("#other_spec").val();
	}else{
		var f_sp=checkitem.label;
	}

checkitem = $('#unittype').jqxDropDownList('getSelectedItem');
unititem = $('#unit').jqxDropDownList('getSelectedItem');

	if((checkitem.value=="-10")||(unititem.value=="-10")){
		var f_un=unitsid;
	}else{
		var f_un=unititem.value;
	}

checkitem = $('#samplemedium').jqxDropDownList('getSelectedItem');

	if(checkitem.value=="-10"){
	   var f_sm=$("#smnew").val();
	}else{
		var f_sm=checkitem.label;
	}

checkitem = $('#valuetype').jqxDropDownList('getSelectedItem');

	if(checkitem.value=="-10"){
		var f_vt=$("#valuetypenew").val();
	}else{
		var f_vt=checkitem.label;
	}

if(varmeth==""){
	alert(<?php echo "'".getTxt('SelectOneMethod')."'"; ?>);
	return false;
	}
	
if(Flag==1){
//Process the new var name
	
	$.ajax({
  type: "POST",
  url: "do_add_varname.php?varname="+$("#newvarname").val()+"&vardef="+$("#vardef").val()
}).done(function( msg ) {
  if(msg==1)
  {
  }
  else
  {
	  alert(msg);
	  return false;  
  }
 });	
}
if(Flag2==1){
	//Process new speciation name
$.ajax({
  type: "POST",
  url: "do_add_spec.php?varname="+$("#other_spec").val()+"&vardef="+$("#specdef").val()
}).done(function( msg ) {
  if(msg==1)
  {
  }
  else
  {
	  alert(msg);
	  return false;  
  }
 });	
}
if(Flag3==1){
//All tests Passed...Write code to insert NEW UNIT 
	  $.ajax({
  type: "POST",
  url: "do_add_unit.php?varname="+$("#new_unit_name").val()+"&vardef="+$("#new_unit_abb").val()+"&vartype="+checkitem.label
}).done(function( msg ) {
  if(msg=="The unit already exists. Cannot Add again. Please select it from the drop down list.")
  {
	  alert(msg);
	  return false;
  }
  else
  {
	unitsid=msg;
	 
  }
 });	
}
if(Flag4==1){
//add a new unit inlucing a new data type

   $.ajax({
  type: "POST",
  url: "do_add_unit.php?varname="+$("#new_unit_name").val()+"&vardef="+$("#new_unit_abb").val()+"&vartype="+$("#new_unit_type").val()
}).done(function( msg ) {
	var myMsg = new Array();
	myMsg = msg.split("|");
	
	if(myMsg[0] == "false") //the first part of the message is true/false whether we succeeded or not.  =="The unit already exists. Cannot Add again. Please select it from the drop down list.")
	  {
		  alert(myMsg[1]);
		  return false;
	  }
	  else
	  {
		unitsid=msg;
	  }
 });
}
if(Flag5==1){
$.ajax({
  type: "POST",
  url: "do_add_sm.php?varname="+$("#smnew").val()+"&vardef="+$("#smdef").val()
}).done(function( msg ) {
  if(msg==1)
  {
  }
  else
  {
	  alert(msg);
	  return false;  
  }
 });	
}
if(Flag6==1){
$.ajax({
  type: "POST",
  url: "do_add_vt.php?varname="+$("#valuetypenew").val()+"&vardef="+$("#vtdef").val()}).done(function( msg ) {
  if(msg==1)
  {
  }
  else
  {
	  alert(msg);
	  return false;  
  }
 });	
}

var isreg=$('#isreg').jqxDropDownList('getSelectedItem').value;
var f_tid=$('#timeunit').jqxDropDownList('getSelectedItem').value;
var f_dt=$('#datatype').jqxDropDownList('getSelectedItem').label;
var f_cat=$('#gc').jqxDropDownList('getSelectedItem').label;

   $.ajax({
  type: "POST",
  url: "do_add_variable.php?varcode="+f_vc+"&varname="+f_vn+"&sp="+f_sp+"&unit="+f_un+"&sm="+f_sm+"&vt="+f_vt+"&isreg="+isreg+"&ts="+$("#tsup").val()+"&tid="+f_tid+"&dt="+f_dt+"&cat="+f_cat+"&nodata="+nodatavalue+"&mid="+varmeth}).done(function( msg ){

	if(msg==1){

	  $("#msg").show(1600);
	  $("#msg").hide(5000);
	 
    $("form").find(':input').each(function(){
              switch(this.type) {
            case 'submit':
                break;
            default:
               $(this).val('');
        }
    });


unitsid=0;
$("#new_spec").hide();
$("#new_spec1").hide();
$("#unit").hide();
$("#unittext").hide();
$("#newunit").hide();
$("#smother").hide();
$("#newunitonly").hide();
$("#valuetypenewb").hide();
$("#newvarnameb").hide();
$("#varname").jqxDropDownList('selectIndex', 0 );
$("#specdata").jqxDropDownList('selectIndex', 0 );
$("#unittype").jqxDropDownList('selectIndex', 0 );
$("#unit").jqxDropDownList('selectIndex', 0 );
$("#samplemedium").jqxDropDownList('selectIndex', 0 );
$("#valuetype").jqxDropDownList('selectIndex', 0 );
$("#isreg").jqxDropDownList('selectIndex', 0 ); 
$("#timeunit").jqxDropDownList('selectIndex', 0 );
$("#datatype").jqxDropDownList('selectIndex', 0 );
$("#gc").jqxDropDownList('selectIndex', 0 );
$("#jqxWidget").jqxListBox('clearSelection');
$("#dtdef").val("Please select a data type to view its definition");
$("#gcdef").val("Please select a category to view its definition");
 $("html, body").animate({ scrollTop: 0 }, "slow")
  }
  else
  {
	  alert(msg);
	  return false;  
  }
 });
return false;
});
	
</script>
*/
?>