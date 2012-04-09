function getLocation(url) {
   if(url.substr(0,7)=="http://")
      window.open(url);
   else
      self.location.href=url;
}

var modSel=function(Ort) {
   var sel=document.getElementById("select_centren");
   while(sel.options.length && sel.options.length>0) {
      sel.options[sel.options.length - 1] = null;
   }
   sel.innerHTML="";
   o_option = new Option("Bitte wählen Sie ein Centrum", "", true, true);
   sel.appendChild(o_option);
   if(!Ort || Ort.length==0)
      return;
   for(var Key in centren[Ort]) {
      if(Key!='url') {
         var o_group = document.createElement('optgroup');
         o_group.label = Key;
         for(var Center in centren[Ort][Key]) {
            o_option = new Option(Center, centren[Ort][Key][Center], false, false);
            o_group.appendChild(o_option);
         }
         sel.appendChild(o_group);
      }
   }
};
var centren=new Object();

var key='Bayern1';
var senType='Senioren Centren';
if(!centren[key]) {
   centren[key]=new Object();
   centren[key]['url']='/de/senioren_centren/bayern/bayern_uebersicht.php';
}
if(!centren[key][senType])
   centren[key][senType]=new Object();
centren[key][senType]['Höchstadt, St. Anna']='/de/senioren_centren/bayern/st_anna_hoechstadt/seniorencentrum_st_anna_hoechstadt.php';

var key='Schleswig-Holstein';
var senType='Integrations Centren';
if(!centren[key]) {
   centren[key]=new Object();
   centren[key]['url']='/de/integrations_centren/uebersicht_integrations_centren.php';
}
if(!centren[key][senType])
   centren[key][senType]=new Object();
centren[key][senType]['Glückstadt, Psychiatrisches Centrum']='/de/integrations_centren/psychiatrisches_centrum_glueckstadt/psychiatrisches_centrum.php';
centren[key][senType]['Brunsbüttel, Sozialpsychiatrisches Centrum Koog-Haus']='/de/integrations_centren/sozialpsychiatrisches_centrum_kooghaus/sozialpsychiatrisches_centrum.php';

document.write('<select onchange="modSel(this.options[this.selectedIndex].value);">');
document.write('<option value="">Bitte wählen Sie ein Bundesland:</option>');
for(var Ort in centren) {
   document.write('<option value="'+Ort+'">'+Ort+'</option>');
}
document.write('</select>');
document.write('<select id="select_centren" onchange="if(this.selectedIndex>0)getLocation(this.options[this.selectedIndex].value);">');
document.write('</select>');
document.write('<a href="javascript:if(document.getElementById(\'select_centren\').options.length>0 && document.getElementById(\'select_centren\').selectedIndex>0)getLocation(document.getElementById(\'select_centren\').options[document.getElementById(\'select_centren\').selectedIndex].value);" class="pfeil" style="margin-bottom:15px;">Suche starten</a>');