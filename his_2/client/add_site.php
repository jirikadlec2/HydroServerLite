<?php
//check authority to be here
require_once 'authorization_check.php';

//connect to server and select database
require_once 'database_connection.php';
require_once 'main_config.php';

//add the SourceID's options
$sql = "Select * FROM sources";

$result = @mysql_query($sql, $connection) or die(mysql_error());

$num = @mysql_num_rows($result);
if ($num < 1) {

    $msg = "<P><em2>Sorry, there are no SourceID names.</em></p>";
} else {

    while ($row = mysql_fetch_array($result)) {

        $sourceid = $row["SourceID"];
        $sourcename = $row["Organization"];

        if ($sourcename == $default_source) {


            $option_block .= "<option selected='selected' value=$sourceid>$sourcename</option>";
        } else {
            $option_block .= "<option value=$sourceid>$sourcename</option>";
        }
    }
}

//add the SiteType options
$sql2 = "Select * FROM sitetypecv";

$result2 = @mysql_query($sql2, $connection) or die(mysql_error());

$num2 = @mysql_num_rows($result2);
if ($num2 < 1) {

    $msg = "<P><em2>Sorry, there are no Site Types.</em></p>";
} else {

    while ($row2 = mysql_fetch_array($result2)) {

        $sitetype = $row2["Term"];

        $option_block2 .= "<option value=$sitetype>$sitetype</option>";
    }
}

//add the VerticalDatum options
$sql3 = "Select * FROM verticaldatumcv";

$result3 = @mysql_query($sql3, $connection) or die(mysql_error());

$num3 = @mysql_num_rows($result3);
if ($num3 < 1) {

    $msg = "<P><em2>Sorry, there are no Vertical Datums.</em></p>";
} else {

    while ($row3 = mysql_fetch_array($result3)) {

        $vd = $row3["Term"];
        if ($vd == $default_datum) {

            $option_block3 .= "<option selected='selected' value=$vd>$vd</option>";
        } else {
            $option_block3 .= "<option value=$vd>$vd</option>";
        }
    }
}

//add the LatLongDatumID options
$sql4 = "Select * FROM spatialreferences";

$result4 = @mysql_query($sql4, $connection) or die(mysql_error());

$num4 = @mysql_num_rows($result4);
if ($num4 < 1) {

    $msg = "<P><em2>Sorry, there are no Vertical Datums.</em></p>";
} else {

    while ($row4 = mysql_fetch_array($result4)) {

        $srid = $row4["SpatialReferenceID"];
        $srsname = $row4["SRSName"];


        if ($srsname == $default_spatial) {

            $option_block4 .= "<option selected='selected' value=$srid>$srsname</option>";
        } else {
            $option_block4 .= "<option value=$srid>$srsname</option>";
        }
    }
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>HydroServer Lite Web Client</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="favicon.ico" >

        <link href="styles/main_css.css" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript">

            function show_answerSC(){
                alert("The Site Code is a unqiue identifier used by an organization that collects the data. For example, if the organization's name was McCall Outdoor Science Center and the name of the site was Boulder Creek at Jug Mountain Ranch, then your Site Code could be MOSS-BC-JMR");
            }

            function show_answerState(){
                alert("The current version of this software does not autmatically select the State and County. Please select them mannually.");
            }

            function show_answerVD(){
                alert("The vertical datum of the elevation. Controlled Vocabulary from VerticalDatumCV. For example, MSL, which stands for Mean Sea Level.");
            }

            function show_answerSR(){
                alert("The spatial reference is for the purpose of recording the name and EPSG code of each Spatial Reference System used. For example, NAD83 / Idaho Central.");
            }

            function show_answerE(){
                alert("The elevation corresponds to Mean Sea Level (MSL) vertical datum.");
            }

            function TrainingAlert(){
                alert("To automatically enter the latitude/longitude/elevation, simply double click the location on the map. Once the marker is placed on the map, you may then click and drag it to the exact location you desire to adjust the results to be more accurate."); 
            } 

        </script>
        <!-- JQuery JS -->
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>

        <!-- Drop Down JS -->
        <script type="text/javascript" src="js/drop_down.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC3d042tZnUAA8256hCC2Y6QeTSREaxrY0&sensor=true"></script>

        <!-- Preload Images -->
        <SCRIPT language="JavaScript">
            <!--
            pic1 = new Image(16, 16); 
            pic1.src="images/loader.gif";
            //-->
        </SCRIPT>

        <script type="text/javascript">
            var map;
            var marker=null;
            var elevator;
	 
            function initialize() {
                GetSourceName();
                var myLatlng = new google.maps.LatLng(43.52764,-112.04951);
	

  
                var myOptions = {
                    zoom: 14,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    disableDoubleClickZoom : true
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
                elevator = new google.maps.ElevationService();
                google.maps.event.addListener(map, 'dblclick', function(event) {
	 
                    // $('#Latitude').value('askjhsdf');

                    placeMarker(event.latLng);
                });
            }

            if(navigator.geolocation) {
                browserSupportFlag = true;
                navigator.geolocation.getCurrentPosition(function(position) {
                    initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	   
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({location: initialLocation}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
		 
                            map.setCenter(results[0].geometry.location);  
		   
       
                            ;
                        } else {
                            alert(address + ' not found');
                        }
                    });
  
	   
	   
                }, function() {
                    handleNoGeolocation(browserSupportFlag);
                });
            }
            // Browser doesn't support Geolocation
            else {
                browserSupportFlag = false;
                handleNoGeolocation(browserSupportFlag);
            }
  


            function placeMarker(location) {
 
 
                if(marker==null)
                {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: true
                    });
  
                    google.maps.event.addListener(marker, 'dragend', function(event) {
	 
                        //Again Update the Latitude longitude values
                        update(event.latLng)
                        //    placeMarker(event.latLng);
                    });
  
  
                    //Update values in the 
                    update(location)
  
                }
                else
                {
                    marker.setPosition(location); 
                    //Update Values into the form	
                    update(location)

                }
                map.setCenter(location);
            }

            function update(location)
            {
	
	
                $("#Latitude").val(parseFloat(location.lat()).toFixed(5));
                $("#Longitude").val(parseFloat(location.lng()).toFixed(5));

                //Update Elevation




                var locations = [];
                locations.push(location);

                // Create a LocationElevationRequest object using the array's one value
                var positionalRequest = {
                    'locations': locations
                }

                // Initiate the location request
                elevator.getElevationForLocations(positionalRequest, function(results, status) {
                    if (status == google.maps.ElevationStatus.OK) {

                        // Retrieve the first result
                        if (results[0]) {

                            // Open an info window indicating the elevation at the clicked position
                            $("#Elevation").val(parseFloat(results[0].elevation).toFixed(1));
	
        
                        } else {
                            alert("No results found");
                        }
                    } else {
                        alert("Elevation service failed due to: " + status);
                    }
                });

	

                // Now to update the state
                var latlng1 = new google.maps.LatLng(location.lat(), location.lng());
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng1}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
			
                            $("#locationtext").html("Your selected location according to us is: " + results[0].formatted_address + ". Please select the state and county accordingly.");
			
        
          
                        }
                    } else {
                        alert("Geocoder failed due to: " + status);
                    }
                });

            }
 
            //Function to run on form submission to implement a validation and then run an ajax request to post the data to the server and display the message that the site has been added successfully

        </script>

        <STYLE TYPE="text/css">
            <!--
            #county_drop_down, #no_county_drop_down, #loading_county_drop_down
            {
                display: none;
            }
            --> 
        </STYLE>

        <!-- Creating the Site Code automatically -->
        <script type="text/javascript" src="js/create_site_code.js"></script>

    </head>

    <body background="images/bkgrdimage.jpg" onLoad="initialize()">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="2"><img src="images/WebClientBanner.png" width="960" height="200" alt="logo" /></td>
            </tr>
            <tr>
                <td colspan="2" align="right" valign="middle" bgcolor="#3c3c3c"><?php require_once 'header.php'; ?></td>
            </tr>
            <tr>
                <td width="240" valign="top" bgcolor="#f2e6d6"><?php echo "$nav"; ?></td>
                <td width="720" valign="top" bgcolor="#FFFFFF"><blockquote><br /><?php //echo "$msg";  ?><p class="em" align="right">Required fields are marked with an asterick (*).</p>
                        <h1>Add a New Site    </h1>
                        <p>&nbsp;</p><FORM METHOD="POST" ACTION="" name="addsite" id="addsite">
                            <table width="650" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="93"><strong>Source:</strong></td>
                                    <td width="557"><select name="SourceID" id="SourceID" onChange="GetSourceName()">
                                            <option value="-1">Select....</option>
<?php echo "$option_block"; ?>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Site Name:</strong></td>
                                    <td><input type="text" id="SiteName" name="SiteName" size=20 maxlength="200" onKeyUp="GetSiteName()"/>*&nbsp;<span class="em">(Ex: Boulder Creek at Jug Mountain Ranch)</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Site Code:</strong></td>
                                    <td><input type="text" id="SiteCode" name="SiteCode" size=20 maxlength="200"/>*&nbsp;<a href="#" onClick="show_answerSC()" border="0"><img src="images/questionmark.png" border="0"></a>&nbsp;<span class="em">(You may adjust this if needed)</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Site Type:</strong></td>
                                    <td><select name="SiteType" id="SiteType" onChange="TrainingAlert()">
                                            <option value="-1">Select....</option>
<?php echo "$option_block2"; ?>
                                        </select>*</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top"><strong>Site Photo:</strong></td>
                                    <td><input type="file" name="file" id="file" size="30">
                                        <br>
                                        (Photo must be in .JPG format; File will be uploaded upon submit below.)</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <table width="650" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="4" valign="top"><strong>You may either enter the latitude/longitude/elevation manually or simply double click the location on the map. Once the marker is placed on the map, you may then click and drag it to the exact location you desire to adjust the results to be more accurate.</strong></td>
                                </tr>
                                <tr>
                                    <td width="100" valign="top">&nbsp;</td>
                                    <td width="155" valign="top">&nbsp;</td>
                                    <td width="86" valign="top">&nbsp;</td>
                                    <td width="309" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="100" align="right" valign="top"><strong>Latitude:&nbsp;</strong></td>
                                    <td width="155" valign="top"><input type="text" id="Latitude" name="Latitude" size=20 maxlength=20/>*</td>
                                    <td width="86" align="right" valign="top"><strong>Longitude:&nbsp;</strong></td>
                                    <td width="309" valign="top"><input type="text" id="Longitude" name="Longitude" size=20 maxlength=20/>*</td>
                                </tr>
                                <tr>
                                    <td width="100" valign="top">&nbsp;</td>
                                    <td width="155" valign="top">&nbsp;</td>
                                    <td width="86" valign="top">&nbsp;</td>
                                    <td width="309" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4" valign="top"><div id="map_canvas" style="width:650px; height:450px"></div></td>
                                </tr>
                            </table><table width="650" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="130">&nbsp;</td>
                                    <td width="520">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Elevation:</strong></td>
                                    <td><input type="text" id="Elevation" name="Elevation" size=20 maxlength=20/>
                                        * Meters&nbsp;<a href="#" onClick="show_answerE()" border="0"><img src="images/questionmark.png" border="0"></a></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><div id="locationtext"></div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td valign="top"><strong>Country:</strong></td>
                                    <td colspan="2" valign="top"> <select name="country" id="country">
                                            <option value="-1" selected>(please select a country)</option>
                                            <option value="AF">Afghanistan</option>
                                            <option value="AL">Albania</option>
                                            <option value="DZ">Algeria</option>
                                            <option value="AS">American Samoa</option>
                                            <option value="AD">Andorra</option>
                                            <option value="AO">Angola</option>
                                            <option value="AI">Anguilla</option>
                                            <option value="AQ">Antarctica</option>
                                            <option value="AG">Antigua and Barbuda</option>
                                            <option value="AR">Argentina</option>
                                            <option value="AM">Armenia</option>
                                            <option value="AW">Aruba</option>
                                            <option value="AU">Australia</option>
                                            <option value="AT">Austria</option>
                                            <option value="AZ">Azerbaijan</option>
                                            <option value="BS">Bahamas</option>
                                            <option value="BH">Bahrain</option>
                                            <option value="BD">Bangladesh</option>
                                            <option value="BB">Barbados</option>
                                            <option value="BY">Belarus</option>
                                            <option value="BE">Belgium</option>
                                            <option value="BZ">Belize</option>
                                            <option value="BJ">Benin</option>
                                            <option value="BM">Bermuda</option>
                                            <option value="BT">Bhutan</option>
                                            <option value="BO">Bolivia</option>
                                            <option value="BA">Bosnia and Herzegowina</option>
                                            <option value="BW">Botswana</option>
                                            <option value="BV">Bouvet Island</option>
                                            <option value="BR">Brazil</option>
                                            <option value="IO">British Indian Ocean Territory</option>
                                            <option value="BN">Brunei Darussalam</option>
                                            <option value="BG">Bulgaria</option>
                                            <option value="BF">Burkina Faso</option>
                                            <option value="BI">Burundi</option>
                                            <option value="KH">Cambodia</option>
                                            <option value="CM">Cameroon</option>
                                            <option value="CA">Canada</option>
                                            <option value="CV">Cape Verde</option>
                                            <option value="KY">Cayman Islands</option>
                                            <option value="CF">Central African Republic</option>
                                            <option value="TD">Chad</option>
                                            <option value="CL">Chile</option>
                                            <option value="CN">China</option>
                                            <option value="CX">Christmas Island</option>
                                            <option value="CC">Cocos (Keeling) Islands</option>
                                            <option value="CO">Colombia</option>
                                            <option value="KM">Comoros</option>
                                            <option value="CG">Congo</option>
                                            <option value="CD">Congo, the Democratic Republic of the</option>
                                            <option value="CK">Cook Islands</option>
                                            <option value="CR">Costa Rica</option>
                                            <option value="CI">Cote d'Ivoire</option>
                                            <option value="HR">Croatia (Hrvatska)</option>
                                            <option value="CU">Cuba</option>
                                            <option value="CY">Cyprus</option>
                                            <option value="CZ">Czech Republic</option>
                                            <option value="DK">Denmark</option>
                                            <option value="DJ">Djibouti</option>
                                            <option value="DM">Dominica</option>
                                            <option value="DO">Dominican Republic</option>
                                            <option value="TP">East Timor</option>
                                            <option value="EC">Ecuador</option>
                                            <option value="EG">Egypt</option>
                                            <option value="SV">El Salvador</option>
                                            <option value="GQ">Equatorial Guinea</option>
                                            <option value="ER">Eritrea</option>
                                            <option value="EE">Estonia</option>
                                            <option value="ET">Ethiopia</option>
                                            <option value="FK">Falkland Islands (Malvinas)</option>
                                            <option value="FO">Faroe Islands</option>
                                            <option value="FJ">Fiji</option>
                                            <option value="FI">Finland</option>
                                            <option value="FR">France</option>
                                            <option value="FX">France, Metropolitan</option>
                                            <option value="GF">French Guiana</option>
                                            <option value="PF">French Polynesia</option>
                                            <option value="TF">French Southern Territories</option>
                                            <option value="GA">Gabon</option>
                                            <option value="GM">Gambia</option>
                                            <option value="GE">Georgia</option>
                                            <option value="DE">Germany</option>
                                            <option value="GH">Ghana</option>
                                            <option value="GI">Gibraltar</option>
                                            <option value="GR">Greece</option>
                                            <option value="GL">Greenland</option>
                                            <option value="GD">Grenada</option>
                                            <option value="GP">Guadeloupe</option>
                                            <option value="GU">Guam</option>
                                            <option value="GT">Guatemala</option>
                                            <option value="GN">Guinea</option>
                                            <option value="GW">Guinea-Bissau</option>
                                            <option value="GY">Guyana</option>
                                            <option value="HT">Haiti</option>
                                            <option value="HM">Heard and Mc Donald Islands</option>
                                            <option value="VA">Holy See (Vatican City State)</option>
                                            <option value="HN">Honduras</option>
                                            <option value="HK">Hong Kong</option>
                                            <option value="HU">Hungary</option>
                                            <option value="IS">Iceland</option>
                                            <option value="IN">India</option>
                                            <option value="ID">Indonesia</option>
                                            <option value="IR">Iran (Islamic Republic of)</option>
                                            <option value="IQ">Iraq</option>
                                            <option value="IE">Ireland</option>
                                            <option value="IL">Israel</option>
                                            <option value="IT">Italy</option>
                                            <option value="JM">Jamaica</option>
                                            <option value="JP">Japan</option>
                                            <option value="JO">Jordan</option>
                                            <option value="KZ">Kazakhstan</option>
                                            <option value="KE">Kenya</option>
                                            <option value="KI">Kiribati</option>
                                            <option value="KP">Korea, Democratic People's Republic of</option>
                                            <option value="KR">Korea, Republic of</option>
                                            <option value="KW">Kuwait</option>
                                            <option value="KG">Kyrgyzstan</option>
                                            <option value="LA">Lao People's Democratic Republic</option>
                                            <option value="LV">Latvia</option>
                                            <option value="LB">Lebanon</option>
                                            <option value="LS">Lesotho</option>
                                            <option value="LR">Liberia</option>
                                            <option value="LY">Libyan Arab Jamahiriya</option>
                                            <option value="LI">Liechtenstein</option>
                                            <option value="LT">Lithuania</option>
                                            <option value="LU">Luxembourg</option>
                                            <option value="MO">Macau</option>
                                            <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                            <option value="MG">Madagascar</option>
                                            <option value="MW">Malawi</option>
                                            <option value="MY">Malaysia</option>
                                            <option value="MV">Maldives</option>
                                            <option value="ML">Mali</option>
                                            <option value="MT">Malta</option>
                                            <option value="MH">Marshall Islands</option>
                                            <option value="MQ">Martinique</option>
                                            <option value="MR">Mauritania</option>
                                            <option value="MU">Mauritius</option>
                                            <option value="YT">Mayotte</option>
                                            <option value="MX">Mexico</option>
                                            <option value="FM">Micronesia, Federated States of</option>
                                            <option value="MD">Moldova, Republic of</option>
                                            <option value="MC">Monaco</option>
                                            <option value="MN">Mongolia</option>
                                            <option value="MS">Montserrat</option>
                                            <option value="MA">Morocco</option>
                                            <option value="MZ">Mozambique</option>
                                            <option value="MM">Myanmar</option>
                                            <option value="NA">Namibia</option>
                                            <option value="NR">Nauru</option>
                                            <option value="NP">Nepal</option>
                                            <option value="NL">Netherlands</option>
                                            <option value="AN">Netherlands Antilles</option>
                                            <option value="NC">New Caledonia</option>
                                            <option value="NZ">New Zealand</option>
                                            <option value="NI">Nicaragua</option>
                                            <option value="NE">Niger</option>
                                            <option value="NG">Nigeria</option>
                                            <option value="NU">Niue</option>
                                            <option value="NF">Norfolk Island</option>
                                            <option value="MP">Northern Mariana Islands</option>
                                            <option value="NO">Norway</option>
                                            <option value="OM">Oman</option>
                                            <option value="PK">Pakistan</option>
                                            <option value="PW">Palau</option>
                                            <option value="PA">Panama</option>
                                            <option value="PG">Papua New Guinea</option>
                                            <option value="PY">Paraguay</option>
                                            <option value="PE">Peru</option>
                                            <option value="PH">Philippines</option>
                                            <option value="PN">Pitcairn</option>
                                            <option value="PL">Poland</option>
                                            <option value="PT">Portugal</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="QA">Qatar</option>
                                            <option value="RE">Reunion</option>
                                            <option value="RO">Romania</option>
                                            <option value="RU">Russian Federation</option>
                                            <option value="RW">Rwanda</option>
                                            <option value="KN">Saint Kitts and Nevis</option> 
                                            <option value="LC">Saint LUCIA</option>
                                            <option value="VC">Saint Vincent and the Grenadines</option>
                                            <option value="WS">Samoa</option>
                                            <option value="SM">San Marino</option>
                                            <option value="ST">Sao Tome and Principe</option> 
                                            <option value="SA">Saudi Arabia</option>
                                            <option value="SN">Senegal</option>
                                            <option value="SC">Seychelles</option>
                                            <option value="SL">Sierra Leone</option>
                                            <option value="SG">Singapore</option>
                                            <option value="SK">Slovakia (Slovak Republic)</option>
                                            <option value="SI">Slovenia</option>
                                            <option value="SB">Solomon Islands</option>
                                            <option value="SO">Somalia</option>
                                            <option value="ZA">South Africa</option>
                                            <option value="GS">South Georgia and the South Sandwich Islands</option>
                                            <option value="ES">Spain</option>
                                            <option value="LK">Sri Lanka</option>
                                            <option value="SH">St. Helena</option>
                                            <option value="PM">St. Pierre and Miquelon</option>
                                            <option value="SD">Sudan</option>
                                            <option value="SR">Suriname</option>
                                            <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                            <option value="SZ">Swaziland</option>
                                            <option value="SE">Sweden</option>
                                            <option value="CH">Switzerland</option>
                                            <option value="SY">Syrian Arab Republic</option>
                                            <option value="TW">Taiwan, Province of China</option>
                                            <option value="TJ">Tajikistan</option>
                                            <option value="TZ">Tanzania, United Republic of</option>
                                            <option value="TH">Thailand</option>
                                            <option value="TG">Togo</option>
                                            <option value="TK">Tokelau</option>
                                            <option value="TO">Tonga</option>
                                            <option value="TT">Trinidad and Tobago</option>
                                            <option value="TN">Tunisia</option>
                                            <option value="TR">Turkey</option>
                                            <option value="TM">Turkmenistan</option>
                                            <option value="TC">Turks and Caicos Islands</option>
                                            <option value="TV">Tuvalu</option>
                                            <option value="UG">Uganda</option>
                                            <option value="UA">Ukraine</option>
                                            <option value="AE">United Arab Emirates</option>
                                            <option value="GB">United Kingdom</option>
                                            <option value="US">United States</option>
                                            <option value="UM">United States Minor Outlying Islands</option>
                                            <option value="UY">Uruguay</option>
                                            <option value="UZ">Uzbekistan</option>
                                            <option value="VU">Vanuatu</option>
                                            <option value="VE">Venezuela</option>
                                            <option value="VN">Viet Nam</option>
                                            <option value="VG">Virgin Islands (British)</option>
                                            <option value="VI">Virgin Islands (U.S.)</option>
                                            <option value="WF">Wallis and Futuna Islands</option>
                                            <option value="EH">Western Sahara</option>
                                            <option value="YE">Yemen</option>
                                            <option value="YU">Yugoslavia</option>
                                            <option value="ZM">Zambia</option>
                                            <option value="ZW">Zimbabwe</option>
                                        </select>*</td>
                                </tr>
                                <tr>
                                    <td valign="top">&nbsp;</td>
                                    <td valign="top">&nbsp;</td>
                                    <td valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>State:</strong></td>
                                    <td><select name="state" id="state">
                                            <option value="-1">Select....</option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="DC">District of Columbia</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                            <option value="NULL">International</option>
                                        </select>*&nbsp;<a href="#" onClick="show_answerState()" border="0"><img src="images/questionmark.png" border="0"></a></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>County:</strong></td>
                                    <td><div id="county_drop_down"><select id="county" name="county"><option value="">County...</option></select>*</div>
                                        <span id="loading_county_drop_down"><img src="images/loader.gif" width="16" height="16" align="absmiddle">&nbsp;Select state first...</span>
                                        <div id="no_county_drop_down">This state has no counties.</div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Vertical Datum:</strong></td>
                                    <td><select name="VerticalDatum" id="VerticalDatum">
                                            <option value="-1">Select....</option>
<?php echo "$option_block3"; ?>
                                        </select>*&nbsp;<a href="#" onClick="show_answerVD()" border="0"><img src="images/questionmark.png" border="0"></a></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Spatial Reference:</strong></td>
                                    <td><select name="LatLongDatumID" id="LatLongDatumID">
                                            <option value="-1">Select....</option>
<?php echo "$option_block4"; ?>
                                        </select>*&nbsp;<a href="#" onClick="show_answerSR()" border="0"><img src="images/questionmark.png" border="0"></a></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Comments:</strong></td>
                                    <td><input type="text" id="com" name="value" size=50 maxlength=500/>
                                        <span class="em">&nbsp;(Optional)</span></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><input type="SUBMIT" name="submit" value="Add Site" class="button"/></td>
                                    <td><div id='response'></div></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </FORM>

                    </blockquote>
                    <p></p></td>
            </tr>
            <tr>
            <script src="js/footer.js"></script>
        </tr>
    </table>

    <script>
        $(document).ready(function(){
            $('#country').change(function(){
                if($(this).val() == 'US'){
                    $('#state').removeAttr('disabled');
                }                
                else{ 
                    $('#state').attr('disabled','disabled');
                }           
            });

        });
        $("form").submit(function() {
            //Validate all fields
	  
            if(($("#SourceID option:selected").val())==-1)
            {
                alert("Please select a Source. If you do not find it in the list, please visit the 'Add a new source' page");
                return false;
            }

            if(($("#SiteName").val())=="")
            {
                alert("Please enter a name for the site.");
                return false;
            }

            if(($("#SiteCode").val())=="")
            {
                alert("Please enter a code for the site.");
                return false;
            }

            if(($("#SiteType option:selected").val())==-1)
            {
                alert("Please select a Site Type.");
                return false;
            }	  

            if(($("#Latitude").val())=="")
            {
                alert("Please enter the latitude for the site or select a point from the map");
                return false;
            }

            if(($("#Longitude").val())=="")
            {
                alert("Please enter the longitude for the site or select a point from the map");
                return false;
            }

            if(($("#Elevation").val())=="")
            {
                alert("Please enter the elevation for the site or select a point from the map");
                return false;
            }


            var floatRegex = '[-+]?([0-9]*\.[0-9]+|[0-9]+)';
            var myInt = $("#Latitude").val().match(floatRegex);


            if(myInt==null)
            {alert("Invalid characters present in latitude. Please correct it.");
                return false;
            }


            if(myInt[0]!=$("#Latitude").val())
            {alert("Invalid characters present in latitude. Please correct it.");
                return false;
            }


            myInt = $("#Longitude").val().match(floatRegex);


            if(myInt==null)
            {alert("Invalid characters present in longitude. Please correct it.");
                return false;
            }


            if(myInt[0]!=$("#Longitude").val())
            {alert("Invalid characters present in longitude. Please correct it.");
                return false;
            }

            myInt = $("#Elevation").val().match(floatRegex);


            if(myInt==null)
            {alert("Invalid characters present in elevation. Please correct it.");
                return false;
            }


            if(myInt[0]!=$("#Elevation").val())
            {alert("Invalid characters present in elevation. Please correct it.");
                return false;
            }

            if(($("#country option:selected").val())== 'US'){
                if(($("#state option:selected").val())==-1){
                    alert("Please select a state for the source.");
                    return false;
                }
            }
            
            if(($("#VerticalDatum option:selected").val())==-1)
            {
                alert("Please select a vertical datum.");
                return false;
            }
            if(($("#LatLongDatumID option:selected").val())==-1)
            {
                alert("Please select a spatial reference.");
                return false;
            }

            //All Validation Checks completed.Now add data to the database

            $.ajax({
                type: "POST",
                url: "do_add_site.php?sc="+$("#SiteCode").val()+"&sn="+$("#SiteName").val()+"&lat="+$("#Latitude").val()+"&lng="+$("#Longitude").val()+"&llid="+$("#LatLongDatumID option:selected").val()+"&type="+$("#SiteType option:selected").text()+"&elev="+$("#Elevation").val()+"&datum="+$("#VerticalDatum option:selected").text()+"&state="+$("#state option:selected").text()+"&county="+$("#county option:selected").text()+"&com="+$("#com").val()+"&source="+$("#SourceID").val()
            }).done(function( msg ) {
                if(msg==1)
                {

                    formdata = new FormData();	
                    document.getElementById("response").innerHTML = "Uploading . . ." 
                    //Upload the image
                    var input = document.getElementById("file");
                    var file = input.files[0];
                    if (file!=null)
                    {


                        formdata.append("images[]", file);

                        $.ajax({
                            url: "do_add_site2.php",
                            type: "POST",
                            data: formdata,
                            processData: false,
                            contentType: false,
                            success: function (res) {
			
                                if(res==1)
                                {
                                    alert("Site successfully added");
                                    window.location.href = "add_site.php";
                                    return true;
                                }
                                else
                                {document.getElementById("response").innerHTML = "" 
                                    alert(res);
                                    return false;}
			
			
                            }
                        });

                    }
                    else
                    {


                        alert("Site successfully added");
                        window.location.href = "add_site.php";
                        return true;
	
                    }
	
	  
                }
                else
                {
                    alert("Error in database configuration");
                    return false;
                }
  
            });


            return false;
        });
    </script>


</body>
</html>