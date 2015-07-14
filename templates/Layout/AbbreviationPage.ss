$Content

<% loop $FirstLetterNavigation %>
	<% if $hasItems %>
        <a href="#$Title">$Title</a>
	<% else %>
		$Title
	<% end_if %>
<% end_loop %>
<% loop $GroupedItems.GroupedBy('TitleFirstLetter') %>
    <a name="$TitleFirstLetter"></a>
	<h2>$TitleFirstLetter</h2>
	<ul>
	<% loop $Children %>
        <strong><a href="$Link">$Title</a>:</strong> $Description
	<% end_loop %>
    </ul>
<% end_loop %>
