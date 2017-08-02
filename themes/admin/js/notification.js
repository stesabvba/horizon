function deleteNotification(id){
	$.post(site, { form_action : "notification_delete", delete_notification_id : id});
	$("#notification"+id).remove();
}