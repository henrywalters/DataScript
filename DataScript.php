<script>

	function Data(raw_data,raw_headers) {
		if (raw_data) {
			this._raw_data = raw_data;
			this._data = raw_data;
		}
		else {
			this._raw_data = null;
			this._data = null;
		}
		if (raw_headers) {
			this._raw_headers = raw_headers;
			this._headers = raw_headers;
		}
		else {
			this._raw_headers = null;
			this._headers = null;
		}
		this._filters = null;
		this._header_filters = null;
		if (!this.valid_data()){
			console.log("ERROR: entered data was invalid and has been nullified");
			this._raw_data = null;
			this._raw_headers = null;
		}
	}

	Data.prototype.headers = function(){
		return this._headers;
	}

	Data.prototype.raw_headers = function(){
		return this._raw_headers;
	}

	Data.prototype.data = function(){
		return this._data;
	}

	Data.prototype.raw_data = function(){
		return this._raw_data;
	}

	Data.prototype.update_raw_headers = function(new_headers){
		this._raw_headers = new_headers;
	}

	Data.prototype.update_raw_data = function(raw_data){
		this._raw_data = raw_data;
	}

	Data.prototype.valid_data = function(){
		if (this._raw_headers){
			var headers = this._raw_headers.length;
		}
		else{
			var headers = this._raw_data[0].length;
		}
		var good_data = true;
		if (this._raw_data){
			for (var i = 0; i < this._raw_data.length; i++){
				if (this._raw_data[i].length > headers){
					good_data = false;
					console.log("ERROR: row " + (i+1) + " has too many columns");
				}
				if (this._raw_data[i].length < headers){
					good_data = false;
					console.log("ERROR: row " + (i+1) + " has too few columns");
				}
			}
		}
		if (!good_data){
			console.log("ERROR: current data is invalid");
		}
		return good_data;
	}

	Data.prototype.raw_table = function(id,border,style){
		if (this.valid_data()) {
			var html = '<table';
			if (id){
				html += ' id="' + id + '"';
			}
			if (border){
				html += ' border="' + border + '"';
			}
			if (style){
				html += ' style="' + style + '"';
			}
			html += '>';
			if (this._raw_headers && this._raw_headers.length > 0){
				html += '<thead><tr>';
				for (var i = 0; i < this._raw_headers.length; i++){
					html += '<th>' + this._raw_headers[i] + '</th>';
				} 
				html += '</tr></thead>';
			}
			if (this._raw_data && this._raw_data.length > 0){
				html += '<tbody>';
				for (var i = 0; i < this._raw_data.length; i++){
					html += '<tr>';
					for (var j = 0; j < this._raw_data[i].length; j++){
						html += '<td>' + this._raw_data[i][j] + '</td>';
					}
					html + '</tr>';
				}
				html += '</tbody>';
			}
			html += '</table>';
			return html;
		}
	}

	Data.prototype.table = function(id,border,style){
		if (this.valid_data()) {
			var html = '<table';
			if (id){
				html += ' id="' + id + '"';
			}
			if (border){
				html += ' border="' + border + '"';
			}
			if (style){
				html += ' style="' + style + '"';
			}
			html += '>';
			if (this._headers && this._headers.length > 0){
				html += '<thead><tr>';
				for (var i = 0; i < this._headers.length; i++){
					html += '<th>' + this._headers[i] + '</th>';
				} 
				html += '</tr></thead>';
			}
			if (this._data && this._data.length > 0){
				html += '<tbody>';
				for (var i = 0; i < this._data.length; i++){
					html += '<tr>';
					for (var j = 0; j < this._data[i].length; j++){
						html += '<td>' + this._data[i][j] + '</td>';
					}
					html + '</tr>';
				}
				html += '</tbody>';
			}
			html += '</table>';
			return html;
		}
	}

	Data.prototype.set_header_filters = function(filters,composite, strict){
		this._header_filters = {filters: filters};
		this._header_filters['composite'] = ((composite) ? composite : false);
		this._header_filters['strict'] = ((strict) ? strict : false);
	}

	Data.prototype.set_filters = function(filters){
		this._filters = filters;
	}

	Data.prototype.get_raw_filter_options = function(){
		var headers = this._raw_headers;
		var data = this._raw_data;
		var filters = {};
		if (headers){
			for (var row in data){
				for (var i = 0; i < data[row].length; i++){
					if (!filters.hasOwnProperty(headers[i])){
						filters[headers[i]] = [];
					}
					if (filters[headers[i]].indexOf(data[row][i]) == -1 && data[row][i] != ''){
						filters[headers[i]].push(data[row][i]);
					}
				}
			}
			for (var filter in filters){
				filters[filter] = filters[filter].sort();
			}
			return filters;
		} 
		else {
			console.log('WARNING: headers required for this feature');
		}
	}

	Data.prototype.get_filter_options = function(){
		var headers = this._headers;
		var data = this._data;
		var filters = {};
		if (headers){
			for (var row in data){
				for (var i = 0; i < data[row].length; i++){
					if (!filters.hasOwnProperty(headers[i])){
						filters[headers[i]] = [];
					}
					if (filters[headers[i]].indexOf(data[row][i]) == -1  && data[row][i] != ''){
						filters[headers[i]].push(data[row][i]);
					}
				}
			}
			for (var filter in filters){
				filters[filter] = filters[filter].sort();
			}
			return filters;
		} 
		else {
			console.log('WARNING: headers required for this feature');
		}
	}

	Data.prototype.filter_data = function(){
		var headers = ((this._raw_headers) ? this._raw_headers : null);
		var data = ((this._raw_data) ? this._raw_data : null);
		var header_filters = ((this._header_filters) ? this._header_filters : {'filters':[],'composite':true});
		var index_header = [];
		for (var i = 0; i<headers.length; i++){ index_header.push(i);}
			var filters = ((this._filters) ? this._filters : null);
		var tmp_header = [];
		var tmp_header_names = [];
		if (headers){
			for (var i = 0; i < headers.length; i++){
				if (typeof headers[i] === 'string' || headers[i] instanceof String){
					var index = ((header_filters['filters'].indexOf(headers[i]) != -1) ? header_filters['filters'].indexOf(headers[i]) : null);
					if (index != null){
						if (!header_filters['composite']){
							tmp_header.push(i);
							tmp_header_names.push(headers[i]);
						}
					}
					else{
						if (header_filters['composite']){
							tmp_header.push(i);
							tmp_header_names.push(headers[i]);
						}
					}
				}
				else{
					var index = ((headers[i] in index_header) ? headers[i] : null);
					if (index){
						if (!header_filters['composite']){
							tmp_header.push(i);
							tmp_header_names.push(headers[i]);
						}
					}
					else
					{
						if (header_filters['composite']){
							tmp_header.push(i);
							tmp_header_names.push(headers[i]);
						}
					}
				}
			}
		}

		if (tmp_header != []){
			var indexes = tmp_header;
			this._headers = tmp_header_names;
		}
		else{
			var indexes = index_header;
		}
		var filter_indexes = [];
		var data_columns = [];
		for (var column in filters){
			for (var index in index_header){
				if (column == headers[index]){
					if (headers.indexOf(column) != -1){
						filter_indexes.push(headers.indexOf(column));
						data_columns.push(column);
					}
					else {
						data_columns.push(column);
						filter_indexes.push(column);
					}
				}
			}
		}
		var tmp_data = [];
		for (var i = 0; i < data.length; i++){
			var data_match = true;
			var good_cells = 0;
			var tmp_row = [];
			for (var j = 0; j < filter_indexes.length; j++){
				var col_filters = filters[data_columns[j]]['filters'];
				var cell = data[i][filter_indexes[j]];
				var cell_comp = filters[data_columns[j]]['composite'];
				var strict = filters[data_columns[j]]['strict'];
				var condition = filters[data_columns[j]]['condition'];
				var variables = filters[data_columns[j]]['variables'];
				if (col_filters){
					if (!strict)
					{
						for (var m = 0; m < col_filters.length; m++){
							if (typeof col_filters[m] === 'string' || col_filters[m] instanceof String) {
								col_filters[m] = col_filters[m].toUpperCase();
							}
						}
						if (typeof cell === 'string' || cell instanceof String){
							cell = cell.toUpperCase();
						}
					}
					var valid_cell = false;
					if (col_filters.indexOf(cell) != -1){
						valid_cell = true;
					}
				}
				else {
					var valid_cell = false;
					switch(condition){
						case 'range-inclusive':
						if (variables.length == 2 && variables[0] <= variables[1]){
							if (cell <= variables[1] && cell >= variables[0]){
								valid_cell = true;
							}
						}   
						else {
							console.log('range-inclusive needs an array of two sorted numbers');
						}
						break;
						case 'range-exclusive':
						if (variables.length == 2 && variables[0] < variables[1]){
							if (cell < variables[1] && cell > variables[0]){
								valid_cell = true;
							}
						}   
						else {
							console.log('range-inclusive needs an array of two sorted numbers');
						}
						break;
						case 'greater-than-inclusive':
						if (cell >= variables){
							valid_cell = true;
						}
						break;
						case 'greater-than-exclusive':
						if (cell > variables){
							valid_cell = true;
						}
						break;
						case 'less-than-inclusive':
						if (cell <= variables){
							valid_cell = true;
						}
						break;
						case 'less-than-exclusive':
						if (cell < variables){
							valid_cell = true;
						}
						break;
						case 'equals':
						if (cell == variables){
							valid_cell = true;
						}
						break;
						case 'raw-condition':
						if (eval(variables)){
							valid_cell = true;
						}
						break;
						default:
						break;
					}
				}
				if (valid_cell){
					if (!cell_comp) {
						good_cells += 1;
					}
				}
				else
				{
					if (cell_comp){
						good_cells += 1;
					}
				}
			}
			for (var j = 0; j < indexes.length; j++){
				tmp_row.push(data[i][indexes[j]]);
			}
			if ( good_cells == filter_indexes.length) {
				tmp_data.push(tmp_row);
			}
		}

		this._data = tmp_data;
	}
</script>
