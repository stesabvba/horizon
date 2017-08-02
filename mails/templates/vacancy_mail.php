<h1><?php echo $template_vars['vacancy_mail_title']; ?></h1>
<p><?php echo $template_vars['vacancy_mail_content']; ?></p>
<table>
	<tr>
		<td>
			<table>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['vacancy']; ?></td>
					<td><?php echo e($template_vars['data']['vacancy_name']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['name']; ?></td>
					<td><?php echo e($template_vars['data']['name']); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['firstname']; ?>:</td>
					<td><?php echo e($template_vars['data']['firstname']); ?></td>
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
					<td width="220"><?php echo $template_vars['labels']['message']; ?></td>
					<td><?php echo nl2br(e($template_vars['data']['message'])); ?></td>
				</tr>
				<tr>
					<td width="220"><?php echo $template_vars['labels']['cv']; ?></td>
					<td><a href="<?php echo e($template_vars['data']['cv']); ?>"><?php echo e($template_vars['data']['cv']); ?></a></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>