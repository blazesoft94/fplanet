<!-- Window-popup-CHAT for responsive min-width: 768px -->

<div id="popup-chat" class="ui-block popup-chat popup-chat-responsive">
	<div class="ui-block-title">
		<span class="icon-status online"></span>
		<h6 class="title" >Chat</h6>
		<div class="more">
			<svg class="olymp-three-dots-icon"><use xlink:href="icons/icons.svg#olymp-three-dots-icon"></use></svg>
			<svg class="olymp-little-delete js-chat-open"><use xlink:href="icons/icons.svg#olymp-little-delete"></use></svg>
		</div>
	</div>
	<div class="mCustomScrollbar">
		<ul id="msgs-list" class="notification-list chat-message chat-message-field">
		
		</ul>
	</div>

	<form id="message-form">
		<div class="form-group label-floating is-empty">
			<label class="control-label">Press enter to post...</label>
			<textarea id="message-textbox" name="message-content" class="form-control" placeholder=""></textarea>
			<div class="add-options-message">
				<a class="options-message">
					<svg class="send-message olymp-popup-right-icon" ><use xlink:href="icons/icons.svg#olymp-popup-right-arrow"></use></svg>
				</a>
				
			</div>
			 </div>

	</form>


</div>


<!-- ... end Window-popup-CHAT for responsive min-width: 768px -->
