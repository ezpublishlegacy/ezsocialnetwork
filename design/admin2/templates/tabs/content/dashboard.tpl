{def $data = fetch('social', 'data', hash('url', $node.url_alias))}
<div class="block">
    {if and(is_set($data.ezpublish.date_modified), $data.ezpublish.date_modified))}
    <fieldset>
        <legend>eZPublish data (dernière date de mise à jour : {$data.ezpublish.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre de Visites : {$data.ezpublish.visit_count}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.facebook.date_modified), $data.facebook.date_modified))}
    <fieldset>
        <legend>Facebook data (dernière date de mise à jour : {$data.facebook.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre de partages : {$data.facebook.share_count}</span><br />
        <span>Nombre de likes : {$data.facebook.like_count}</span><br />
        <span>Nombre de commentaires : {$data.facebook.comment_count}</span><br />
        <span>Nombre de clicks : {$data.facebook.click_count}</span><br />
        <span>Nombre de boxcomments  : {$data.facebook.commentsbox_count}</span><br />
        <span>Total : {$data.facebook.total_count}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.date_modified), $data.date_modified))}
    <fieldset>
        <legend>Twitter data (dernière date de mise à jour : {$data.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre de tweets : {$data.twitter}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.googleplus.date_modified), $data.googleplus.date_modified))}
    <fieldset>
        <legend>Google Plus data (dernière date de mise à jour : {$data.googleplus.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre de partages : {$data.googleplus.count}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.date_modified), $data.date_modified))}
    <fieldset>
        <legend>Linkedin data (dernière date de mise à jour : {$data.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre : {$data.linkedin}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.date_modified), $data.date_modified))}
    <fieldset>
        <legend>Delicious data (dernière date de mise à jour : {$data.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre : {$data.delicious}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.date_modified), $data.date_modified))}
    <fieldset>
        <legend>Stumbleupon data (dernière date de mise à jour : {$data.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre : {$data.stumbleupon}</span>
    </fieldset>
    {/if}
    {if and(is_set($data.date_modified), $data.date_modified))}
    <fieldset>
        <legend>Pintereset data (dernière date de mise à jour : {$data.date_modified|l10n(shortdatetime)})</legend>
        <span>Nombre : {$data.pinterest}</span>
    </fieldset>
    {/if}
</div>