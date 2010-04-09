			<tr bgcolor="$phase" class="row">
				<td><a href="index.php?show=database_details&db=$databasename$SID">$databasename</a></td>
				<td><a href="index.php?show=table_create&db=$databasename&create_table_form=true$SID" title="$strActionCreateTblTitle"><img class="icon" src="$templateroot/img/b_newtbl.png" alt="$strActionCreate"></a></td>
				<td><a href="index.php?show=database_details&db=$databasename$SID" title="$strActionView"><img class="icon" src="$templateroot/img/b_select.png" alt="$strActionView"></a></td>
				<td><a href="index.php?show=database_delete&db=$databasename$SID" title="$strActionDeleteDbsTitle"><img class="icon" src="$templateroot/img/b_deldb.png" alt="$strActionDelete"></a></td>
				<td align="right">$total_tabl</td>
				<td align="right">$total_rows</td>
				<td align="right">$db_lastmod</td>
				<td align="right"><font color="{fontcolorlink}">$total_size</font></td>
			</tr>
