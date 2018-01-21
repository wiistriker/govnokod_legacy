{title append=$page->getTitle()}

<ol class="posts">
    <li class="hentry">
        <h2>{$page->getTitle()|h} {$page->getJip()}</h2>
        {if $page->getCompiled()}{eval var=$page->getContent()}{else}{$page->getContent()}{/if}
    </li>
</ol>