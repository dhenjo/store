<script>

function hitungSelisihHari(tgl1, tgl2){
    // varibel miliday sebagai pembagi untuk menghasilkan hari
    var miliday = 24 * 60 * 60 * 1000;
    //buat object Date
    var tanggal1 = new Date(tgl1);
    var tanggal2 = new Date(tgl2);
    // Date.parse akan menghasilkan nilai bernilai integer dalam bentuk milisecond
    var tglPertama = Date.parse(tanggal1);
    var tglKedua = Date.parse(tanggal2);
    var selisih = (tglKedua - tglPertama) / miliday;
    return selisih;
    }
    function date_now(){
        var date = new Date();

var yyyy = date.getFullYear().toString();
var mm = (date.getMonth()+1).toString();
var dd  = date.getDate().toString();
 
// CONVERT mm AND dd INTO chars
var mmChars = mm.split('');
var ddChars = dd.split('');

// CONCAT THE STRINGS IN YYYY-MM-DD FORMAT
return today1 = yyyy + '-' + mm + '-' + dd;
    }
    function grab(datavar){
        pj = datavar.length;
     ls = pj - 5;
    return datavar.substring(ls, pj);
    }
    
$(document).ready(function() {
    
   $('html, body').animate({
       scrollTop: $('#page1').offset().top
   });
      
   $("#datepicker1").toggle(function() {
       $("#datepicker").slideDown(500);},
       function() { $("#datepicker").slideUp(500);
   });
  
   $("#datepicker").datepicker({
      dateFormat: 'dd MM yy',
      minDate: '0',
      onSelect: function(theDate) {
         $("#datepicker1").val(theDate);
         //$("#dttujuan").val(theDate);
         $("#dttujuan1").datepicker('option','minDate',new Date(theDate));
         $("#dttujuan1").datepicker('option','dateFormat','dd MM yy');
         $("#datepicker").slideUp(500);
      }
   }).hide();
   
   $("#dttujuan").toggle(function() {
      $("#dttujuan1").slideDown(500);},
      function() {$("#dttujuan1").slideUp(500);
   });
   
   $("#dttujuan1").datepicker({
      dateFormat: 'dd MM yy',
      minDate: '0',
      onSelect: function(theDate) {
         $("#datepicker").datepicker('option','minDate',new Date(theDate));
         $("#datepicker").datepicker('option','dateFormat','dd MM yy');
         $("#dttujuan1").slideUp(500);
         $("#dttujuan").val(theDate);
      }
   }).hide();
   
   //$("#dtpick").datepicker();
   
   $("#rdoneway").change(function() {
      $("#hilang").slideUp(500);
      //alert("test1");
   });
   $("#rdtrip").change(function() {   
      $("#hilang").slideDown(500);
      //alert("test2");
   });
   
   $("#autocomplt,#autocomplt2").autocomplete({
     source: ["Ambon(AMQ)","Alor(ARD)","Anggi(AGD)","Arso(ARJ)","Atambua(ABU)",
     "Babo(BXB)","Bali(DPS)","Balikpapan(BPN)","Banda Aceh(BTJ)","Bandar Lampung(TKG)",
     "Bandung(BDO)","Banjarmasin(BDJ)","Batam(BTH)","Bajawa(BJW)","Bau-bau(BUW)","Buli(WUB)",
     "Bengkulu(BKS)","Berau(BEJ)","Biak(BIK)","Bima(BMU)","Bintuni(NTI)",
     "Buol(UOL)","Banyuwangi(BWW)",
     "Cirebon(CBN)","Cilacap(CXP)","Cengkareng(CGK)", "Ciamis(NSW)",
     "Dabo Singkep(SQI)","Dumai(DUM)","Denpasar(DPS)", "Djambi(DJB)", "Djayapura(DJJ)", "Dili(DIL)",
     "Enarotali(EWI)","Ende(ENE)",
     "Fakfak(FKQ)",
     "Galela(GLX)","Gebe(GBE)","Gorontalo(GTO)","Gunung Sitoli(GNS)",
     "Halim(HLP)",
     "Inanwatan(INX)",
     "Jakarta(CGK)","Jambi(DJB)","Jayapura(DJJ)","Jogjakarta(JOG)",  
     "Kaimana(KNG)","Karimunjawa(KWB)","Kendari(KDI)","Kerinci(KRC)",
     "Ketapang(KTG)","Kupang(KOE)","Kambuaya(KBX)", "Kebar(KEQ)", "Kepi(KEI)", "Kiman(KMM)",
     "Labuhan Bajo(LBJ)","Larantuka(LKA)","Lewoleba(LOW)","Lubuklinggau(LLG)","Luwuk(LUW)",
     "Lahore(LHE)","Lampung(TKG)","Langgur(LUV)", "Langkawi(LGK)","Larnaca(LCA)", "Lereh(LHI)",
     "Lombok(LOP)", "Luyuk(LYK)",
     "Malang(MLG)","Makasar(UPG)","Mamuju(MJU)","Manado(MDC)","Manokwari(MKW)","Masamba(MXB)",
     "Mataram(AMI)","Malaka(MKZ)",
     "Maumere(MOF)","Medan(KNO)","Melonguane(MNA)","Merauke(MKQ)","Mangole(MAL)", "Morotai(OTI)","Matak(MWK)",
     "Natuna(NTX)","Nunukan(NNX)","Nabire(NBX)","Namlea(NAM)","Namrole(NRE)","Numfor Timur","Nias(GNS)",
     "Okaba(OKQ)", "Oksibil(OKL)",
     "Padang(PDG)","Palangka Raya(PKY)","Palu(PLW)","Pangkalan Bun(PKN)","Pangkalpinang(PGK)","Palembang(PLM)",
     "Pekanbaru(PKU)",
     "Pomalaa(PUM)","Pontianak(PNK)","Poso(PSJ)", "Pangandaran(NSW)","Papua(DJJ)","Purwokerto(PWL)",
     "Raha(RAQ)","Rote(RTI)","Ruteng(RTG)","Rengat(RGT)","Riau(BTH)",
     "Samarinda(SRI)","Sampit(SMQ)","Sanana(SQN)","Sarmi(ZRM)","Saumlaki(SXK)","Semarang(SRG)","Serui(ZRI)",
     "Sibolga(SBQ)","Singkep(SIQ)","Solo(SOC)","Sorong(SOQ)","Sumbawa(SWQ)","Surabaya(SUB)",
     "Sawu(SAU)","Sinak(NKD)",
     "Taliabu(TAX)","Tanah Merah(TMH)","Tanjung Pandan(TJQ)","Tanjung Pinang(TNJ)",
     "Tanjung Karang(TKG)", "Tawau(TWU)",
     "Tarakan(TRK)","Ternate(TTE)","Tobelo(KAZ)","Tolitoli(TLI)","Tambolaka(TMC)", "Tambulaka(TMC)",
     "Timika(TIM)", "Tual(LUV)", "Tiom(TMY)", "Tembilahan(TBH)",
     "Ujungpandang(UPG)",
     "Wamena(WMX)","Wangi-wangi(WGI)","Waingapu(WGP)","Wasior(WSR)",
     "Yogyakarta(JOG)"]
   });
   
   $("#fdtpicker1").submit(function(){
     var dtdr = $("#datepicker1").val();
     var dr = $("#autocomplt").val();
     var dtke = $("#dttujuan").val();
     var ke = $("#autocomplt2").val();
     var pp = $("input[name=rdotrip]:checked").val();
     
     var adult = $('#dewasa option:selected').val();
     var inf = $('#bayi option:selected').val();
     
     if(hitungSelisihHari(date_now(),dtdr) >= 365){
         alert("Pilih Tanggal berangkat tidak boleh lebih dari satu tahun ");
         $("#datepicker1").focus(); return false;
     }
     
     if(hitungSelisihHari(date_now(),dtke) >= 365){
         alert("Pilih Tanggal kembali tidak boleh lebih dari satu tahun ");
         $("#dttujuan").focus(); return false;
     }
     
     if(inf >= adult){
         alert("Jumlah Infant melebihi jumlah Adult !");
       $("#bayi").focus(); return false;
     }
     
     if(dtdr != ""){
         
         
       if(pp == "Round trip"){
          
         if(dtke != ""){
              if(hitungSelisihHari(dtdr,dtke) <= -1){
         alert("Tanggal berangkat tidak boleh lebih besar dari tanggal kembali ");
         $("#dtke").focus(); return false;
     }
           if(dr != ""){
               if(grab(dr) == grab(ke)){
         alert("kota asal Penerbangan tidak boleh sama dengan kota tujuan ");
         $("#autocomplt2").focus(); return false;
     }
             if(ke != ""){
               //alert("Ok.");
               ///$.mobile.pageLoading();
               ///$(window).load(function(){ $.mobile.pageLoading('hide'); });
               //$.mobile.pageLoading( true );
               //$.mobile.pageLoading("sedang proses, mohon menunggu");
               /**
               $.mobile.loading( 'show', {
                 text: 'sedang proses, mohon menunggu',
                 textVisible: true,
                 theme: 'b'
               }); **/
               return true;
             }else{
               alert("Kota tujuan tidak boleh kosong !");
               $("#autocomplt2").focus(); return false;
             }
           }else{
             alert("Kota asal tidak boleh kosong !");
             $("#autocomplt").focus(); return false;
           }
         
         }else{
           alert("Untuk rute pulang pergi, tanggal kembali harus diisi !");
           $("#dttujuan").focus(); return false;
         }
       }else{
         if(dr != ""){
             if(grab(dr) == grab(ke)){
         alert("kota asal Penerbangan tidak boleh sama dengan kota tujuan ");
         $("#autocomplt2").focus(); return false;
     }
           if(ke != ""){
             ///$.mobile.pageLoading();
             ///$(window).load(function(){ $.mobile.pageLoading('hide'); });
             //$.mobile.pageLoading( true );
             //$.mobile.pageLoading("sedang proses, mohon menunggu");
             /**
             $.mobile.loading( 'show', {
                 text: 'sedang proses, mohon menunggu',
                 textVisible: true,
                 theme: 'b'
             }); **/
             return true;
           }else{
             alert("Kota tujuan tidak boleh kosong !");
             $("#autocomplt2").focus(); return false;
           }
         }else{
           alert("Kota asal tidak boleh kosong !");
           $("#autocomplt").focus(); return false;
         }
       }
     }else{
       alert("Tanggal berangkat tidak boleh kosong !");
       $("#datepicker1").focus(); return false;
     }
     
     return false;
   });
   
  
    $('[data-rel=back]').live('click', function(){
         //console.log('headed back now');
         $.mobile.pageLoading('hide');
    });
       
});
</script>