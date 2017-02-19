# DataScript
A javascript class for handling and filtering a dataset that handles a typical SQL query.
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

The next thing one might want to do is view their data set in its original state. To do this, one may call
```
var id = 'exampleTable';
var border = '1';
var style = 'width:50%;height:50%';
data.raw_table(id,border,style);
```
which will return an html formatted table with id,border, and css parameters.

DataScript posseses two types of filters: header and data filtering. Header filtering controls which columns will be filtered out, where as data filtering controls the individual rows.


