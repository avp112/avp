   var newSel='<select id="select_centren" onchange="if(this.selectedIndex>0)getLocation(this.options[this.selectedIndex].value);">';
   newSel+='<option>Bitte wählen Sie ein Centrum</option>';
   if(!Ort || Ort.length==0)
      return;
   for(var Key in centren[Ort]) {
      if(Key!='url') {
         newSel+='<optgroup label="'+Key+'">';
         for(var Center in centren[Ort][Key]) {
            newSel+='<option value="'+centren[Ort][Key][center]+'">'+Center+'</option>';
         }
         newSel+='</optgroup>';
      }
   }
   newSel+='</select>';
   document.getElementById("selDum").innerHTML=newSel;