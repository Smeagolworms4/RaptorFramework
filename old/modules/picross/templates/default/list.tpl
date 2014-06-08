<ul>
	{foreach from=$ppo->images key=$key item=image}
		<li><a href="{raptorurl dest='picross||grille' i=$image}" >{$image}</a></li>
	{/foreach}
</ul>