<cffunction name="addReplaceParam" output="false" hint="adds or replaces a param in an URL like string">
	<cfargument name="KT_Url" type="string" required="yes" hint="URL to search">
	<cfargument name="param" type="string" required="yes" hint="param to replace or add">
	<cfargument name="value" type="string" default="" required="no" hint="[new ]value for param">
	<cfif Find("?", KT_Url) eq 0>
		<cfset sep = "?">
	<cfelse>
		<cfset sep = "&">
	</cfif>
	<cfif ReFind("^'.*'$", value) neq 0>
		<cfset value = Mid(value, 2, Len(value) - 2)>
	</cfif>
	<cfscript>
		// our way
		
		if (REFindNoCase("#param#=[^&]*", KT_Url)) {
			KT_Url = REReplaceNoCase(KT_Url, "#param#=[^&]*", "#param#=#value#", "all");
		} else {
			KT_Url = KT_Url & "#sep##param#=#value#";
		}
		if (value eq "") {
			KT_Url = REReplaceNoCase(KT_Url, "#param#=", "", "all");
		}
		
		
		// cf way
		/*KT_Url = "&" & KT_Url;
		tempPos=ListContainsNoCase(KT_Url,param,"&");
		if (tempPos NEQ 0) {
			KT_Url=ListDeleteAt(KT_Url,tempPos,"&");
		}
		KT_Url = "&" & KT_Url;*/
		
		// cleanup
		KT_Url = Replace(KT_Url, "?&", "?", "all");
		KT_Url = REReplace(KT_Url, "&+", "&", "all");
		KT_Url = REReplace(KT_Url, "&$", "", "all");
		KT_Url = REReplace(KT_Url, "\?$", "", "all");
		return KT_Url;
	</cfscript>
</cffunction>
<cfset request.addReplaceParam = addReplaceParam>

<cffunction name="KT_FieldHasChanged" output="true" returntype="boolean" hint="Checks if a field in a recordset has changed from the previous invocation of this function">
	<cfargument name="recordset" required="yes" type="string" hint="Recordset to search">
	<cfargument name="field" required="yes" type="string" hint="Fieldname">
	<cfscript>
		rs = Evaluate(recordset); // recordset variable
		if (rs.currentRow gt 0) {
			// if not the first field
			if (rs[field][rs.currentRow-1] eq rs[field][rs.currentRow]) {
				// if field has not changed
				return false;
			}
		}
		// if field has changed or is new
		return true;
	</cfscript>
</cffunction>
<cfset request.KT_FieldHasChanged = KT_FieldHasChanged>

<cffunction name="KT_uploadFile" output="false" hint="handles the upload of a file and copies it in Request.uploaded_formFieldName">
	<cfargument name="field" type="string" required="yes" hint="form field name">
	<cfset tempDir = GetTempDirectory()>
	<cftry>
		<cffile action="upload" filefield="#field#" destination="#tempDir#" nameconflict="makeunique">
		<cfcatch type="any">
			<cfreturn false>
		</cfcatch>
	</cftry>
	<cfset Request["uploaded_#field#"] = Duplicate(cffile)>
	<cfreturn Request["uploaded_#field#"]>
</cffunction>
<cfset Request.KT_uploadFile = KT_uploadFile>

<cffunction name="KT_removeParam" output="false" hint="Removes a param in an URL like string">
	<cfargument name="qstring" type="string" required="yes" hint="querystring">
	<cfargument name="paramName" type="string" required="yes" hint="param to remove">
	<cfscript>
		if(qstring eq "&"){
		  qstring = "";
		}
		tmp = REReplaceNoCase(qstring, "&" & paramName & "=[^&]*", "", "all");
		if (tmp eq qstring) {
			tmp = REReplaceNoCase(tmp, "\?" & paramName & "=[^&]*", "?", "all");
			tmp = ReplaceNoCase(tmp, "?&", "?", "all");
			tmp = REReplaceNoCase(tmp, "\?$", "", "all");
		}
		return tmp;
	</cfscript>
</cffunction>

<cfscript>
function inc(nam) {
	WriteOutput(Evaluate(nam));
	Evaluate("#nam# = #nam# + 1");
}
</cfscript>