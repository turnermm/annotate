# annotate
Creates tooltip type boxes for extended annotations.  The boxes, initially hidden, 
open in place, immediately beneath the text being annotated and close out-of-sight
on the click of a button.
```
<anno:10>text</anno><@anno:10>wiki text</@anno>
<anno:15>text</anno><@anno:15>{{namespace:page}}</@anno> 
```
  text is what the annotation explains
  
  wiki-text is dokuwiki text for annotation
  
  namespace:page is a dokwiki page which will be read into the annotation block; thie form atakes only the wiki page and no other text.

  Internal markup:  
  ```
  <anno:20>text</anno><@anno:20><top>wiki:page</top>wiki text<bottom>wiki:page</bottom></@anno>
  <anno:20>text</anno><@anno:20>wiki text<bottom>wiki:page</bottom></@anno>
  <anno:20>text</anno><@anno:20><top>wiki:page</top>wiki text</@anno>
  ```
The ```top and bottom``` tags enable repeatable headers and footers to be read into the annotations.
    
The list must be prefaced by ```[List] and ended with tsiL```
