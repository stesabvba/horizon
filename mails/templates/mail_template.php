<html>
<style>
	html, body
	{
		font: Verdana;
		font-family: Verdana, sans-serif; 
		font-size: 12px; 
		color: #929292;
	}
	
	table
	{
		font: Verdana;
		font-family: Verdana, sans-serif; 
		font-size: 12px; 
	}
	h1
	{
		color: #75cdcd;
		font-size: 20px;
	}

	.greeting
	{
		font-size: 10px;
		color: #929292;
	}

</style>

<table>
	<tr>
		<td><?php echo $template_vars['content']; ?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>
			<p class='greeting'>Met vriendelijke groet - Nos meilleures salutations - Best regards</p>
			<a href='http://www.diaz.be'><img src='http://www.diaz.be/img/diaz-logo.png' alt='Diaz'/></a>
		</td>
	</tr>
</table>