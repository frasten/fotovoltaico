			<tr>
				<td bgcolor="$phase">
					<input size=30 name="$fieldname">
				</td>
				<td bgcolor="$phase">
					<select name="$fieldtype" onChange="valueControl(this.value,'$fieldnull','$fielddval')" style="width:80px;" size=1>
						<option value="str">STR</option>
						<option value="int">INT</option>
					</select>
				</td>
				<td bgcolor="$phase">
					<select name="$fieldnull" onChange="valueControl(this.form.$fieldtype.value,'$fieldnull','$fielddval')" size=1>
						<option value="NULL">NULL</option>
						<option value="">NOT_NULL</option>
					</select>
				</td>
				<td bgcolor="$phase">
					<input size=30 name="$fielddval" onBlur="if(this.form.$fieldtype.value=='int')checkNumeric(this,',','.','-');" value="NULL" disabled>
				</td>
			</tr>
