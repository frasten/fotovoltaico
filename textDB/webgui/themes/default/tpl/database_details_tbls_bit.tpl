			<tr bgcolor="$phase" class="row">
				<td><b>$basename</b></td>
				<td><a href="index.php?show=table_view&db=$_GET[db]&tbl=$basename$SID" title="$strActionView"><img class="icon" src="$templateroot/img/b_browse.png" alt="$strActionView"></a></td>
				<td><a href="index.php?show=table_insert&db=$_GET[db]&tbl=$basename$SID" title="$strActionInsertRow"><img class="icon" src="$templateroot/img/b_insrow.png" alt="$strActionInsertRow"></a></td>
				<td><a href="index.php?show=table_details&db=$_GET[db]&tbl=$basename$SID" title="$strActionStructure"><img class="icon" src="$templateroot/img/b_props.png" alt="$strActionStructure"></a></td>
				<td><a href="index.php?show=table_empty&db=$_GET[db]&tbl=$basename$SID" title="$strActionEmpty"><img class="icon" src="$templateroot/img/b_empty.png" alt="$strActionEmpty"></a></td>
				<td><a href="index.php?show=table_delete&db=$_GET[db]&tbl=$basename$SID" title="$strActionDelete"><img class="icon" src="$templateroot/img/b_deltbl.png" alt="$strActionDelete"></a></td>
				<td align="right">$num_rows</td>
				<td align="right">$table_lastmod</td>
				<td align="right"><font color="{fontcolorlink}">$table_size</font></td>
			</tr>
