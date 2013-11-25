<?php
	$TitleInstall = "HydroServer Lite Web Client: Install";
	$MainConfigTitle = "HydroServer Lite: Editing your site's main configuration file";
	$AdminWelcome = "Welcome, Administrator!";
	$MainConfigDirections = "Please take a few minutes to change all of the fields below to setup your application with the correct default settings needed for it to run properly. If you have any questions during the process, please click the information icon next to the field or refer to the example provided.";
	$CurrentUsername = "Current username:";
	$EnterNow = "(Must be entered  now.)";
	$EnterDefaultSettings = "Please enter your default settings below...";
	$MySQLConfiguration = "Configuration settings for MySql Database";
	$DatabaseHost = "Database Host:";
	$DatabaseUsername = "Database Username:";
	$DatabasePassword = "Database Password:";
	$DatabaseName = "Database Name:";
	$LanguageCode = "Language Code";
	$ConfigurationSettingsLook = "Configuration settings for website's look and functionality";
	$OrganizationName = "Organization's Name:";
	$OrganizationNameEx = "(Ex: McCall Outdoor Science School)";
	$ParentWebsiteName = "Parent Website's Name:";
	$ParentWebsiteNameEx = "(Ex: MOSS blog)";
	$ParentWebsite = "Parent Website:";
	$ParentWebsiteEx = "(Ex: adventurelearningat.com)";
	$SoftwareVersion = "Software Version:";
	$VersionNumber = "Version 2.0";
	$SoftwareVersionEx = "(Ex: Version 2.0)";
	$ConfigurationSettingsSecurity = "Configuration settings for security purposes";
	$WebsiteDomain = "Website's Domain:";
	$WebsiteDomainEx = "(Ex: adventurelearningat.com)";
	$ConfigurationSettingsSource = "Configuration settings for adding a new Source";
	$ConfigurationSettingsSites = "Configuration settings for adding Sites";
	$LocalX = "Local X:";
	$LocalY = "Local Y:";
	$LocalProjectionID = "Local Projection ID:";
	$PosAccuracy = "PosAccuracy_m:";
	$SpatialReference = "Spatial Reference:";
	$ConfigurationSettingsVariables = "Configuration settings for adding a new Variable";
	$ConfigurationSettingsDataValues = "Configuration settings for adding Data Values";
	$UTCOffset = "UTCOffset:";
	$UTCOffsetTwo = "UTCOffset 2:";
	$CensorCode = "Censor Code:";
	$QualityControlLevel = "Quality Control Level:";
	$ValueAccuracy = "Value Accuracy:";
	$OffsetTypeID = "Offset Type ID:";
	$QualifierID = "Qualifier ID:";
	$SampleID = "Sample ID:";
	$DerivedFromID = "Derived From ID:";
	$SaveSettings = "Save Settings";
	
//For JavaScript
	$DatabaseHostInfo = "This may be either localhost or the server\'s IP address such as 8.23.154.5 if you are using a different server to host the database than the software.";
	$VariableCodeInfo = "An arbitrary code used by your organization to specify a specific variable record. For example, IDCS- could be used for International Data Collection System.";
	$TimeSupportInfo = "A numerical value that indicates the temporal footprint of the data values. 0 indicates instantaneous samples (samples taken at random or irregular intervals). Other values indicate the time over which data values are aggregated. For example, the value was collected every 10 minutes.";
	$DatabaseNameInfo = "The name of the database when the tables of data will be stored.";
	$ProfileVersionInfo = "The Profile Version field should be populated with the version of the ISO metadata profile that is being used. For example, ISO 19115 or ISO 8601. This field can be populated with Unknown if there is no profile version for the data.";
	$LocalXInfo = "This is the Local Projection X coordinate. For example, 456700. Or you simply put NULL if not known.";
	$LocalYInfo = "This is the Local Projection Y coordinate. For example, 232000. Or you simply put NULL if not known.";
	$LocalProjectionIDInfo = "An identifier that references the Spatial Reference System of the local coordinates in the SpatialReferences table. This field is required if local coordinates are given. For example, 7. Or you simply put NULL if not known.";
	$PositionalAccuracyInfo = "Value giving the accuracy with which the positional information is specified in meters. For example, 100. Or you simply put NULL if not known.";
	$VerticalDatumInfo = "Vertical datum of the elevation. Controlled Vocabulary from VerticalDatumCV. For example, MSL, which stands for Mean Sea Level.";
	$SpatialReferenceInfo = "SpatialReferences is for the purpose of recording the name and EPSG code of each Spatial Reference System used. For example, NAD83 / Idaho Central.";
	$UTCOffsetInfo = "Unambiguous interpretation of date and time information requires specification of the time zone or offset from universal time (UTC). A UTCOffset field is included to ensure that local times recorded in the database can be referenced to standard time and to enable comparison of results across databases that may store data values collected in different time zones. For example, McCall Idaho is Mountain Standard Time (MST), and therefore the value is -7.";
	$UTCOffset2Info = "To automatically adjust Date and Time a second UTC value is needed for calculations in the software. The value of this UTC is the exact opposite of the first UTC. For example, McCall Idaho is Mountain Standard Time (MST), and therefore the value is 7.";
	$CensorCodeInfo = "The Censor Code is a controlled vocabulary used to define whether the data value is censored. \'nc\' means that data is not censored. If not known, simply put nc.";
	$QualityControlLevelInfo = "A unique integer identifying the quality control level of the data values collected. For example, a quality control level code of 0 is suggested for data which is raw and unprocessed, and have not undergone quality control. Or a quality control level code of -9999 is suggested for data whose quality control level is unknown.";
	$ValueAccuracyInfo = "Value Accuracy is a numeric value that describes the measurement accuracy of the data value. If not known, simply put NULL.";
	$OffsetIntergerInfo = "An integer identifier that references the measurement offset type in the OffsetTypes table. If not known, simply put NULL.";
	$QualifierIDInfo = "Integer identifier that references the Qualifiers table. In this environment, the Qualifier is 1 and refers to Citizen Science.";
	$SampleIDInfo = "Integer identifier that references into the Samples table. This is required only if the data value resulted from a physical sample processed in a lab. If not known, simply put NULL.";
	$DerivedFromIDInfo = "Integer identifier for the derived from group of data values that the current data value is derived from. This refers to a group of derived from records in the DerivedFrom table. If NULL, the data value is inferred to not be derived from another data value.";
	$CannotLeave = "Cannot Leave";
	$Blank = "Blank";
	$ErrorDatabaseTables = "Error in database configuration.Could Not Add the base tables.";
?>