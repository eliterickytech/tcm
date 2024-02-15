function handleGritterNotificationMessages(title, message) {
	$.gritter.add({
		title: title,
		text: message
	});
	return false;
}