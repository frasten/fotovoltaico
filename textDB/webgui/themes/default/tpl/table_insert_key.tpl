			<tr bgcolor="$phase">
				<td><b>$colname</b></td>
				<td>AUTO_INC</td>
				<td><select name="$fieldfunction" disabled>
					<option value="" selected></option>
					<option value="ABS">ABS</option>
					<option value="EVAL">EVAL</option>
					<option value="MD5">MD5</option>
					<option value="">----------</option>
					<option value="LOWER">LOWER</option>
					<option value="UPPER">UPPER</option>
					<option value="LCASE">LCASE</option>
					<option value="UCASE">UCASE</option>
					<option value="">----------</option>
					<option value="NOW">NOW</option>
					<option value="UNIX_TIMESTAMP">UNIX_TIMESTAMP</option>
				</select></td>
				<td><img src="$templateroot/img/spacer.png" width="50" height="1" alt=""></td>
				<td><input size=30 name="$fieldvalue" value="" disabled></td>
			</tr>
