<h2>{__}Installtion :{/__}</h2>

<form action="{raptorurl dest='||step2' }" method="post" >
	<p>
		<label for="config_file" >
			{__}Créez le fichier de configuration personnel :{/__}
		</label>
	</p>
	<p>
		<textarea id="config_file" rows="15" cols="75">{$ppo->configFile}</textarea>
	</p>
	<p>
		<input type="submit" name="submit" value="{'Créer'|__}" />
	</p>
</form>