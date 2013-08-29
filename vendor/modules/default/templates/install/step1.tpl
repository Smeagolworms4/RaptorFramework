<h2>{__}Installation :{/__}</h2>

<form action="{raptorurl dest='||step2' }" method="post" >
	<div class="paragraphe" >
		<label for="config_file" >
			{__}Créez le fichier de configuration personnel :{/__}
		</label>
	</div>
	
	<div class="paragraphe" >
		{codecolor name='config_file' rows='15' cols='75' }{$ppo->configFile}{/codecolor}
	</div>
	
	<div class="paragraphe" >
		<input type="submit" name="submit" value="{'Créer'|__}" />
	</div>
</form>