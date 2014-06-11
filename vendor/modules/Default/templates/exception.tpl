
<div>
	<h2>{'Erreur'|__} - {$ppo->type}</h2>
	{$ppo->file}: {$ppo->line}<br />
	{$ppo->message}{if $ppo->code} : {$ppo->code}{/if}
</div>