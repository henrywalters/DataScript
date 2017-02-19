# DataScript
A javascript class for handling and filtering a dataset that handles a typical SQL query.
# Download
Just <? include 'DataScript.php' ?> ;)
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
