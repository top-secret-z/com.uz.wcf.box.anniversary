<ul class="sidebarItemList">
	{foreach from=$boxUserList item=$userProfile}
		{assign var='years' value=$userProfile->registrationDate|anniversary}
		<li class="box32">
			<a href="{link controller='User' object=$userProfile}{/link}" aria-hidden="true">{@$userProfile->getAvatar()->getImageTag(32)}</a>
			
			<div class="sidebarItemTitle">
				<h3><a href="{link controller='User' object=$userProfile}{/link}" class="userLink" data-user-id="{@$userProfile->userID}">{$userProfile->username}</a></h3>
				<small>{lang}wcf.user.box.anniversary.years{/lang}</small>
				<small>-</small>
				<small>{@$userProfile->registrationDate|date}</small>
			</div>
		</li>
	{/foreach}
</ul>
