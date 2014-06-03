<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		
		<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
		<meta name="HandheldFriendly" content="true" />
		
		<title>{$ppo->TITLE_PAGE}{if $ppo->SUB_TITLE_PAGE} - {$ppo->SUB_TITLE_PAGE}{/if}</title>
		
		{$ppo->HEAD}
		
	</head>
	<body>
		<div id="main" class="main" >
			<div id="main-content" class="main-content" >
				<div id="content" class="content" >
					
					<script type="text/javascript">
					//<!--
					// {literal}
						
						(function () {
							var display = Display.getInstance ();
							display.resizeOnScreen ($('main'));
							window.addEvent ('resize', function () {
								display.resizeOnScreen ($('main'));
								display.adapteZoomContent ($('content'));
							});
							
						}) ();
						
						
					// {/literal}
					//-->
					</script>
					
					{$ppo->MAIN}
					
					
					<script type="text/javascript">
					//<!--
					// {literal}
						
						(function () {
							
							var display = Display.getInstance ();
							display.adapteZoomContent ($('content'));
						}) ();
						
					// {/literal}
					//-->
					</script>
					
				</div>
			</div>
		</div>
	</body>
</html>