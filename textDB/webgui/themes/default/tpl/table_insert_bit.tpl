			<tr bgcolor="$phase">
				<td><b>$colname</b></td>
				<td><input type="hidden" name="$fieldtype" value="$coltype">$coltype</td>
				<td><select name="$fieldfunction" onChange="functionControl('$fieldfunction','$fielddefault','$fieldvalue');">
					<option value="" selected></option>
					<option value="ABS">ABS</option>
					<option value="EVAL">EVAL</option>
					<option value="MD5">MD5</option>
					<option value="" disabled>----------</option>
					<option value="LOWER">LOWER</option>
					<option value="UPPER">UPPER</option>
					<option value="LCASE">LCASE</option>
					<option value="UCASE">UCASE</option>
					<option value="" disabled>----------</option>
					<option value="NOW">NOW</option>
					<option value="UNIX_TIMESTAMP">UNIX_TIMESTAMP</option>
				</select></td>
				<td>$coldval</td>
				<td><input size=30 name="$fieldvalue" onBlur="if(this.form.$fieldtype.value=='INT')checkNumeric(this,',','.','-');" value="$default_value" $disabled_dval></td>
			</tr>
