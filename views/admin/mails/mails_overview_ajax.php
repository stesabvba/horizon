<div class="col-md-8">
	<?php echo($template_vars['paginator']); ?>
</div>

<div class="col-md-4">
	<?php echo $template_vars['lbl_items_found']; ?>
</div>

<table class='table'>
	<th><?php echo ucfirst(translate("id")); ?></th>
	<th><?php echo ucfirst(translate("user")); ?></th>
	<th><?php echo ucfirst(translate("from")); ?></th>
	<th><?php echo ucfirst(translate("to")); ?></th>
	<th><?php echo ucfirst(translate("subject")); ?></th>
	<th><?php echo ucfirst(translate("sent_at")); ?></th>
	<th><?php echo ucfirst(translate("send")); ?></th>
	<th><?php echo ucfirst(translate("edit")); ?></th>
	<th><?php echo ucfirst(translate("delete")); ?></th>
</tr>

<?Php
foreach($template_vars['mails'] as $mail){
	?>
	<tr>
		<td><?php echo $mail->id; ?></td>
		<?php
		if($mail->user!=null){
			echo ("<td>" . $mail->user->firstname . " " . $mail->user->lastname . "</td>");
		}else{
			echo ("<td>" . translate("unknown_user") . "</td>");
		}
		?>
		<td><?php echo $mail->from; ?></td>
		<td><?php echo $mail->to; ?></td>
		<td><?php echo $mail->subject; ?></td>
		<td><?php echo $mail->sent_at; ?></td>


		<td class="action">
			<form method='post'>
				<input type='hidden' name='form_action' value="mail_send" />
				<input type='hidden' name='mail_id' value="<?php echo $mail->id; ?>" />
				<button class='btn btn-default' href="<?php echo $template_vars['pagelink_edit'].'/'.$mail->id; ?>"><?php echo ucfirst(translate("resend")); ?></button>
			</form>

		</td>

		<td class="action">
			<a class='btn btn-default btn-edit' href="<?php echo $template_vars['pagelink_edit'].'/'.$mail->id; ?>"><?php echo ucfirst(translate("edit")); ?></a>
		</td>
		<td class="action">
			<a class='btn btn-warning btn-danger btn-delete' href="<?php echo $template_vars['pagelink_delete'].'/'.$mail->id; ?>"><?php echo ucfirst(translate("delete")); ?></a>
		</td>
	</tr>
	<?Php	
}
?>
</table>