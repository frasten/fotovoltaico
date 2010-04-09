		<tr bgcolor="$phase" class="row">
			<td><b>$colname</b></td>
			<td>INT</td>
			<td>$coldval</td>
			<td><a href="index.php?show=column_edit&db=$_GET[db]&tbl=$_GET[tbl]&col=$i&fname=$colname&ftype=$coltype&fdval=$coldval$SID" title="$strActionEdit"><img class="icon" src="$templateroot/img/b_edit.png" alt="$strActionEdit"></a></td>
			<td><a href="index.php?show=column_delete&db=$_GET[db]&tbl=$_GET[tbl]&col=$colname$SID" title="$strActionDelete"><img class="icon" src="$templateroot/img/b_drop.png" alt="$strActionDelete"></a></td>
			<td><img class="icon" src="$templateroot/img/bd_primary.png" alt="$strPrimary"></td>
			<td><img class="icon" src="$templateroot/img/b_integer.png" alt="$strInteger"></td>
		</tr>
