<?php

$add_pagelink = pagelink('migration_add',$language_id);

$content.=("<p><a class='btn btn-default' data-toggle='modal' data-target='#modal' href='$add_pagelink" . "'>". ucfirst(translate("add")) . "</a></p>");
$content.= "<table class='table'>";

$content.=("<th>" . ucfirst(translate("name")) . "</th>");
$content.=("<th>" . ucfirst(translate("execute")) . "</th>");
$content.=("<th>" . ucfirst(translate("rollback")) . "</th>");
$content.=("<th>" . ucfirst(translate("edit")) . "</th>");
$content.=("<th>" . ucfirst(translate("delete")) . "</th>");
$content.=("</tr>");

$execute_pagelink = actionlink('MigrationController@migration_execute',$active_pagemeta->id);
$rollback_pagelink = actionlink('MigrationController@migration_rollback',$active_pagemeta->id);
$edit_pagelink = pagelink('migration_edit',$language_id);
$delete_pagelink = pagelink('migration_delete',$language_id);

$migrations = glob('migrations/*.php');


	
foreach($migrations as $migration){
	
	$migration=str_replace('migrations/','',$migration);
	$migration=str_replace('.php','',$migration);
	
	$content.=("<tr>");
	$content.=("<td>" . $migration . "</td>");
	$content.=("<td><a class='btn btn-default' href='$execute_pagelink/" . $migration . "'>". ucfirst(translate("execute")) . "</a></td>");
	$content.=("<td><a class='btn btn-default' href='$rollback_pagelink/" . $migration . "'>". ucfirst(translate("rollback")) . "</a></td>");
	$content.=("<td><a class='btn btn-default' href='$edit_pagelink/" . $migration . "'>". ucfirst(translate("edit")) . "</a></td>");
	$content.=("<td><a class='btn btn-default' data-toggle='modal' data-target='#modal' href='$delete_pagelink/" . $migration . "'>". ucfirst(translate("delete")) . "</a></td>");
	$content.=("</tr>");
	
	
}

$content.= "</table>";

?>