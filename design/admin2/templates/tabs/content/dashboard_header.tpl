<li id="node-tab-dashboard" class="{if $last}last{else}middle{/if}{if $node_tab_index|eq('dashboard')} selected{/if}">
    {if $tabs_disabled}
        <span class="disabled" title="Display Social Media">Dashboard Social</span>
    {else}
        <a href={concat( $node_url_alias, '/(tab)/dashboard' )|ezurl} title="Display Social Media">Dashboard Social</a>
    {/if}
</li>