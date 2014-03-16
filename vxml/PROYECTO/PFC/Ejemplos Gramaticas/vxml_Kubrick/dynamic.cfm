<CFQUERY NAME="q1" DATASOURCE="Kubrick">
SELECT * FROM KubrickTable
</CFQUERY>KUBRICK[
<CFOUTPUT query="q1">

(#Title#)		{<KubrickMovie   "#Title#">}

</CFOUTPUT>
]