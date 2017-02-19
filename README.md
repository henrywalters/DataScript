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

