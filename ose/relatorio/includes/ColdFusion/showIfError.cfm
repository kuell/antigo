<cfif Attributes.tng.errorNo EQ 0>
	<cfif thisTag.ExecutionMode is 'end'>
	   <cfset thisTag.GeneratedContent =''>
	</cfif>
</cfif>