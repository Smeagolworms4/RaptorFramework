<div id="metagrille" ></div>
<div id="debug" ></div>
<div id="debug2" ></div>

<script type="text/javascript">
//<!--
// {literal}
	
	var GET = Raptor.extractUrlParams();
	var metagrille = null;
	
	var request = new Request.JSON({
		url:'{/literal}{raptorresource path="picross|datas/'+GET['i']+'.json"}{literal}',
		onSuccess: function (image) {
			metagrille = new Picross.MetaGrille ($('metagrille'), image);
			
			metagrille.display ();
			
		}
	});
	
	request.get();
	
	alert ("ddddd");
	
// {/literal}
//-->
</script>
