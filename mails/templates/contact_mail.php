<h1><?php echo $template_vars['contact_mail_subject']; ?></h1>
<p><?php echo $template_vars['contact_mail_content']; ?></p>
<table>
	<tr>
		<td>
			<table>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['name']; ?></td>
					<td><?php echo e($template_vars['data']['name']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['company']; ?>:</td>
					<td><?php echo e($template_vars['data']['company']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['email']; ?></td>
					<td><?php echo e($template_vars['data']['email']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['phone']; ?></td>
					<td><?php echo e($template_vars['data']['phone']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['postal_code']; ?></td>
					<td><?php echo e($template_vars['data']['postal_code']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['message']; ?></td>
					<td><?php echo nl2br(e($template_vars['data']['message'])); ?></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>