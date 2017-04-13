<?php
include "head.php";
print $template['body'];
$foot = <<<EOD
  <script type="text/javascript">
  var keyStr = "ABCDEFGHIJKLMNOP" +
              "QRSTUVWXYZabcdef" +
              "ghijklmnopqrstuv" +
              "wxyz0123456789+/" +
              "=";
    tjq(document).ready(function() {
        tjq('.revolution-slider').revolution(
        {
            dottedOverlay:"none",
            delay:8000,
            startwidth:1170,
            startheight:646,
            onHoverStop:"on",
            hideThumbs:10,
            fullWidth:"on",
            forceFullWidth:"on",
            navigationType:"none",
            shadow:0,
            spinner:"spinner4",
            hideTimerBar:"on",
        });
    });

$(document).ready(function() {
  var availableTags = [ "Ambon(AMQ)","Alor(ARD)","Anggi(AGD)","Arso(ARJ)","Atambua(ABU)",
        "Babo(BXB)","Denpasar-Bali(DPS)","Balikpapan(BPN)","Banda Aceh(BTJ)","Bandar Lampung(TKG)",
        "Bandung(BDO)","Bangkok(DMK)","Banjarmasin(BDJ)","Batam(BTH)","Bajawa(BJW)","Bau-bau(BUW)","Buli(WUB)",
        "Bengkulu(BKS)","Berau(BEJ)","Biak(BIK)","Bima(BMU)","Bintuni(NTI)",
        "Buol(UOL)","Banyuwangi(DQJ)",
        "Cirebon(CBN)","Cilacap(CXP)","Cengkareng(CGK)", "Ciamis(NSW)",
        "Dabo Singkep(SQI)","Djambi(DJB)", "Djayapura(DJJ)", "Dili(DIL)",
        "Enarotali(EWI)","Ende(ENE)",
        "Fakfak(FKQ)",
        "Galela(GLX)","Gebe(GBE)","Gorontalo(GTO)","Gunung Sitoli(GNS)",
        "Halim(HLP)","Hat Yai(HDY)","Ho Chi Minh City(SGN)",
        "Inanwatan(INX)",
        "Jakarta(CGK)","Jakarta(HalimPerdanaKusuma)(HLP)","Jambi(DJB)","Jayapura(DJJ)","Jogjakarta(JOG)","JohorBaru(JHB)",
        "Kaimana(KNG)","Karimunjawa(KWB)","Kendari(KDI)","Kerinci(KRC)",
        "Ketapang(KTG)","Kualalumpur(KUL)","Kupang(KOE)","Kambuaya(KBX)", "Kebar(KEQ)", "Kepi(KEI)", "Kiman(KMM)", "Kotabaru(KBU)",
        "Labuhan Bajo(LBJ)","Larantuka(LKA)","Lewoleba(LOW)","Lubuklinggau(LLG)","Luwuk(LUW)",
        "Lahore(LHE)","Lampung(TKG)","Langgur(LUV)", "Langkawi(LGK)","Larnaca(LCA)", "Lereh(LHI)",
        "Lhokseumawe(LSW)","Lombok(LOP)", "Luyuk(LYK)",
        "Malang(MLG)","Makasar(UPG)","Mamuju(MJU)","Manado(MDC)","Manokwari(MKW)","Masamba(MXB)",
        "Mataram(AMI)","Malaka(MKZ)",
        "Maumere(MOF)","Medan(KNO)","Melonguane(MNA)","Merauke(MKQ)","Mangole(MAL)", "Morotai(OTI)","Matak(MWK)",
        "Natuna(NTX)","Nunukan(NNX)","Nabire(NBX)","Namlea(NAM)","Namrole(NRE)","Numfor Timur","Nias(GNS)",
        "Okaba(OKQ)", "Oksibil(OKL)",
        "Padang(PDG)","Palangka Raya(PKY)","Palu(PLW)","Pangkalan Bun(PKN)","Pangkalpinang(PGK)","Palembang(PLM)",
        "Pekanbaru(PKU)","Penang(PEN)","Pinangsori(FLZ)",
        "Pomalaa(PUM)","Pontianak(PNK)","Poso(PSJ)", "Pangandaran(NSW)","Papua(DJJ)","Purwokerto(PWL)",
        "Raha(RAQ)","Rote(RTI)","Ruteng(RTG)","Rengat(RGT)",
        "Samarinda(SRI)","Sampit(SMQ)","Sanana(SQN)","Sarmi(ZRM)","Saumlaki(SXK)","Semarang(SRG)","Serui(ZRI)",
        "Sibolga(AEG)","Silangit(DTB)","Singapore(SIN)","Singkep(SIQ)","Solo(SOC)","Sorong(SOQ)","Sumbawa(SWQ)","Surabaya(SUB)",
        "Sawu(SAU)","Sinak(NKD)",
        "Tahuna(NAH)","Taliabu(TAX)","Tanah Merah(TMH)","Tanjung Pandan(TJQ)","Tanjung Pinang(TNJ)",
        "Tanjung Karang(TKG)", "Tawau(TWU)",
        "Tarakan(TRK)","Ternate(TTE)","Tobelo(KAZ)","Tolitoli(TLI)","Tambolaka(TMC)", "Tambulaka(TMC)",
        "Timika(TIM)", "Tual(LUV)", "Tiom(TMY)", "Tembilahan(TBH)",
        "Ujungpandang(UPG)", "Wamena(WMX)","Wangi-wangi(WGI)","Waingapu(WGP)","Wakatobi(WNI)","Wasior(WSR)",
        "Yogyakarta(JOG)"];
  $( "input#autocomplete" ).autocomplete({
    source: availableTags
  });
  $('#rdotrip').click('ifChecked ifUnchecked', function(event){
//      alert($('#rdotrip').is(':checked'));
    if($('#rdotrip').is(':checked')){
      var temp_tgl = $('#tgl').val();
      var tgl_array = temp_tgl.split(' ');
      var gt = new Date(tgl_array[1]+' '+tgl_array[0]+', '+tgl_array[2]);
      var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";
      gt.setDate(gt.getDate() + 1);
//      alert(gt.getDate());
      $('#tglr').val(gt.getDate()+' '+month[gt.getMonth()]+' '+gt.getFullYear());
     $("#tanggal_back").show();
    }
    else{
     //$("#tgl").focus();
      $("#tanggal_back").hide();
      $("#tglr").prop('value', '');
    }
  });
});
function valid() {
//      return false;
  tdari = document.form_search.tdr,
  tke = document.form_search.tke,//getElementById('autocomplete'),
  tglpergi = document.getElementById('tgl'),
  tglkembali = document.getElementById('tglr');
  adult = document.getElementById('adl');
      //infant = document.getElementById('inf');
  if(adult=="" || adult == "0") { alert("adult tidak boleh kosong"); return false; } 

  if (isKota(tdari, "Kota asal tidak boleh kosong !")){
    if (isKota(tke, "kota tujuan tidak kosong !")){
      if (isTgl(tglpergi, "Tanggal berangkat tidak boleh kosong !")){
          //if(iscekinf(adult,infant,"Jumlah Infant melebihi jumlah Adult !")){      
        if ( document.form_search.rdotrip.checked == true){
          if (isTgl(tglkembali, "Anda memilih Round Trip maka tanggal kembali tidak boleh kosong !")){
            if (iscekpp(tglpergi,tglkembali,"Tanggal kembali lebih kecil dari tanggal pergi !")){
                 // if(iscekinf(adult,infant,"Jumlah Infant melebihi jumlah Adult !")){
              return true;
                 // }
            }
          }

        }
        else{
             //if(iscekinf(adult,infant,"Jumlah Infant melebihi jumlah Adult !")){
          return true;
             //}
            //return true;
        }
         //}
      }
    }
  }
  return false;
 }
 function iscekpp(elem1,elem2, helperMsg) {
var tgl1=new Date(elem1.value);
var tgl2=new Date(elem2.value);
if (tgl1>tgl2) {
 alert(helperMsg);
 elem2.focus();
 return false;
}
return true;

}
  
function pesan(elem, helperMsg) {
  alert(helperMsg);
  elem.focus();
  return false;
}

function isKota(elem, helperMsg) {
if (elem.value == "") {
  alert(helperMsg);
  elem.focus();
  return false;
}
var thelength= elem.value.length;
var lastchar = elem.value.charAt(thelength-1)

if (lastchar!=")") {
  alert(helperMsg);
  elem.focus();
  return false;
}
return true;
}

function isTgl(elem, helperMsg) {
if (elem.value == "") {
  alert(helperMsg);
  elem.focus();
  return false;
}
return true;
}
function encode64(input) {
  var output = "";
  var chr1, chr2, chr3 = "";
  var enc1, enc2, enc3, enc4 = "";
  var i = 0;
    do {
          chr1 = input.charCodeAt(i++);
          chr2 = input.charCodeAt(i++);
          chr3 = input.charCodeAt(i++);

          enc1 = chr1 >> 2;
          enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
          enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
          enc4 = chr3 & 63;

        if (isNaN(chr2)) {
          enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
        enc4 = 64;
        }

        output = output +
        keyStr.charAt(enc1) +   
        keyStr.charAt(enc2) +
        keyStr.charAt(enc3) +
        keyStr.charAt(enc4);
        chr1 = chr2 = chr3 = "";
        enc1 = enc2 = enc3 = enc4 = "";
  } while (i < input.length);
  return output;
}
function testopen(){
   //alert("test");

var tdari = document.form_search.tdr.value;
//alert(tdari);
var tke = document.form_search.tke.value;
var tkecom = document.form_search.tke;
//alert(tke);
var tgl = document.getElementById('tgl').value;
var tglr = document.getElementById('tglr').value;
var adl = document.getElementById('adl').value;
var chd = document.getElementById('chd').value;
var inf = document.getElementById('inf').value;

var tnow = document.form_search.tnow.value;
var agen = document.form_search.agen.value;

var url='';

//alert(document.form_search.rdotrip.checked);          

if (tdari != '')
{
  if (tke != '')
   {
     if (tgl != '')
      {
         if (document.form_search.rdotrip.checked == true) 
           {
             if (tglr == '') { return false; }

             var d1=new Date(tgl);
             var id1 = d1.getTime() + " milliseconds since 1970/01/01";
             var d2=new Date(tglr);
             var id2 = d2.getTime() + " milliseconds since 1970/01/01";
             if(id1 > id2){
              isKota(document.form_search.tglr, 'Tanggal Pulang Harus di Atas Tanggal Berangkat!');

              var temp_tgl = $('#tgl').val();
              var tgl_array = temp_tgl.split(' ');
              var gt = new Date(tgl_array[1]+' '+tgl_array[0]+', '+tgl_array[2]);
              var month = new Array();
                month[0] = "January";
                month[1] = "February";
                month[2] = "March";
                month[3] = "April";
                month[4] = "May";
                month[5] = "June";
                month[6] = "July";
                month[7] = "August";
                month[8] = "September";
                month[9] = "October";
                month[10] = "November";
                month[11] = "December";
              gt.setDate(gt.getDate() + 1);
              $('#tglr').val(gt.getDate()+' '+month[gt.getMonth()]+' '+gt.getFullYear());

              return false;
             }
             
             if(tdari == tke){
              pesan(tkecom, 'Tanggal Pulang Harus di Atas Tanggal Berangkat!');
              return false;
             }

             tdari = encode64(tdari);
             tke = encode64(tke);
             tgl = encode64(tgl);
             tglr = encode64(tglr);   
             adl = encode64(adl);
             chd = encode64(chd);
             inf = encode64(inf);
             url='http://tiket.antavaya.com/modules/mod_helloworld/default.php?adl='+adl+'&chd='+chd+'&inf='+inf+'&tgl='+tgl+'&tgl2='+tglr+'&dr='+tdari+'&ke='+tke+'&c='+tnow+'&agen='+agen;
             //alert(url);
             window.open(url);
            }
           else
            { 
             tdari = encode64(tdari);
             tke = encode64(tke);
             tgl=encode64(tgl);
             adl = encode64(adl);
             chd = encode64(chd);
             inf = encode64(inf);
             url='http://tiket.antavaya.com/modules/mod_helloworld/default.php?adl='+adl+'&chd='+chd+'&inf='+inf+'&tgl='+tgl+'&tgl2=&dr='+tdari+'&ke='+tke+'&c='+tnow+'&agen='+agen;
             window.open(url);
            }
            return true
      }
     else
      {
      return false;
      }
    return true;   
   }
  else
   {
    isKota(document.form_search.tke, 'Tentukan kota tujuan!');
    return false;
   }
  return true;
}
else
{
  isKota(document.form_search.tdr, 'Kota asal tidak boleh kosong!');
return false;
}
}
</script>
EOD;

include "foot.php";
?>