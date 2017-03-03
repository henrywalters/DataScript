# DataScript
A javascript class for handling and filtering a dataset that handles a typical SQL query.
### Foreword
It has been brought to my attention there is an existing project called Closure DataScript. The difference between these two projects is Closure Datascript provides a wrapper for MySql queries where this project assumes data is already provided in an array format. 
# Download
Just <? include 'DataScript.php' ?> ;)
# Mathematical Formulation
### Set definitions
```
Let S = {s | s is an element of the super set} and F = {f | f is an element of the filter set}.
```
If F is not a subset of S then F is equal to the intersection of F and S.

Examples:
```
Let S = {0,1,2,3,4,5}, F1 = {0,1,2} and F2 = {0,1,8,20}.
F1 is clearly a subset where F2 is not. The intersection of S and F2 is {0,1} and therefore F2 = {0,1}.
```
### A one dimensional filter
A filter works in the following way:
```
For every s in S if the intersection of s and F2 is empty, then s is filtered out of the data set.
```
Example:
```
Let S = {0,1,2} F = {0,2}.
s_1 = 0, the inersection of F and s_1 = {0} and is therefore not filtered.
s_2 = 1, the intersection of F and s_2 = {} and is therefore filtered out.
s_3 = 2, the intersection of F and s_3 = {2} and is not filtered.
```
### The last important concept
The composite of a set is defined in the following way:
```
Let F be a subset of S. Then the composite of F_c = {s | s is not an element of F but is an element of S}.
```
Example:
```
Let S = {0,1,2,3,4,5} and F = {0,2,4} then F_c = {1,3,5}.
```
# Usage
### Declaration
A data object is declared with
```
headers = ['COL1','COL2','COL3'];
data = [
  ['ROW11','ROW12','ROW13'],
  ['ROW21','ROW22','ROW32']
]
const data = new Data(data,headers);
```
Currently, not declaring a header is unrecommended, but will soon be fixed to automatically handle lack of one.

### Basic Table Display
The next thing one might want to do is view their data set in its original state. To do this, one may call
```
var id = 'exampleTable';
var border = '1';
var style = 'width:50%;height:50%';
data.raw_table(id,border,style);
```
which will return an html formatted table with id,border, and css parameters.
### Filter Generation
It is likely one would like a list of a set of all unique values for filtering in a set of data. One may do this with to the raw data as well as filtered data with the following functions
```
data.get_raw_filter_options();
data.get_filter_options();
```
### Data Filtering
DataScript posseses two types of filters: header and data filtering. Header filtering controls which columns will be filtered out, where as data filtering controls the individual rows.

To filter headers, simply pass the following method:
```
var filters = ['COL1','COL3'];
var composite = false;
data.set_header_filters(filters,composite);
```
Composite is an optional parameter and by default is false. If composite is set to true, it calculates the composite set (See Mathematical Formulation).

To filter data, one must construct filter object(s) with the following parameters:
```
var filters = {
  HEADER_NAME_OR_INDEX : {
    'filters' : [FILTER_1, FILTER_2, ...],
    'composite' :BOOLEAN,
    'strict' : BOOLEAN,
    'condition' : CONDITION,
    'variables' : VARIABLES
  },...
}

FILTER_VALUE_i = {
  'value' : FILTER_VALUE_1,
  'highlight' : BOOLEAN,
  'color' : UNICODE COLOR,
  'type' : BOOLEAN
}
```
HEADER_NAME_OR_INDEX controls which column of data this filter pertains to.
Filters is to pass an array of filter values for that column.
Composite, when true, checks the composite of the filters parameter.
When Strict is false, value comparisons are not case sensitive.
Condition and variables allows for a more dynamic filtering system.

Each filter object has the option to be highlighted and if so, is given the respective color parameter. If type is set to false, the filter will not affect the data set, only highlight matching rows.

### Conditional filtering
In a filter object, one may define the following conditions with their respective variables:
```
'greater-than-exclusive' : One variable,
'greater-than-inclsuive' : One variable,
'less-than-exclusive' : One variable,
'less-than-inclusive' : One variable,
'range-inclusive' : An array of two sorted numbers,
'range-exclusive' : An array of two sorted numbers,
'raw-condition' : a condition
```
raw-conditional is special in that you may declare any conditional where 'cell' is the compared value. 
Example:
```
var filters = {'COL1' : {'condition':'raw-condition', 'variable': 'cell > 10 && cell < 15'}};
```







