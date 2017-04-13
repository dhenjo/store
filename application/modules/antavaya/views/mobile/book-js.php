        <script>
        function isValidEmailAddress(emailAddress) {
            var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return pattern(emailAddress);
           }
    $(document).ready(function() {
       
        $("#book_form").submit(function(){
        var frname = $("#firstname").val();
        var lname = $("#lastname").val();
        var hp = $("#hp").val();
        var mail = $("#mail").val();
        var cek = 1; 
        var bulan = [];
            bulan[1] = 'January';
            bulan[2] = 'February';
            bulan[3] = 'March';
            bulan[4] = 'April';
            bulan[5] = 'May';
            bulan[6] = 'June';
            bulan[7] = 'July';
            bulan[8] = 'August';
            bulan[9] = 'September';
            bulan[10] = 'October';
            bulan[11] = 'November';
            bulan[12] = 'December';
         var akhir = $('#batas_dewasa').val() * 1;
        for(var t = akhir ; t >= 1 ; t--){
        
            if(!$('#fname'+t).val()){
                if(cek == 2){
               cek = 2;
                }else{
                        alert ('Firstname Penumpang '+t+' Harus Diisi');
                cek = 2;
                }
           }
           
           if(!$('#lname'+t).val()){
               if(cek == 2){
               cek = 2;
                }else{
                        alert ('Lastname Penumpan '+t+' Harus Diisi');
                cek = 2;
                }
           }
           
        var lahir = new Date($('#dtgl'+t).val()+' '+bulan[$('#dbln'+t).val()]+' '+$('#dthn'+t).val());      
        var penerbangan = new Date($('#tglberangkat').val());
        var age = Math.floor((penerbangan-lahir) / (365.25 * 24 * 60 * 60 * 1000));
        
        if(age < 12){
            if(cek == 2){
               cek = 2;
                }else{
                alert('Umur Penumpan '+t+' Harus >= 12 Tahun Pada Hari Penerbangan');
                cek = 2;
                }
               
        } 
              }
              
             var akhir_chl = $('#batas_anak').val() * 1; 
             for(var t_chl = akhir_chl ; t_chl >= 1 ; t_chl--){
                 if(!$('#tfirstc'+t_chl).val()){
                if(cek == 2){
               cek = 2;
                }else{
                        alert ('Firstname Penumpang anak '+t_chl+' Harus Diisi');
                cek = 2;
                }
           }
           
           if(!$('#tlastc'+t_chl).val()){
               if(cek == 2){
               cek = 2;
                }else{
                        alert ('Lastname Penumpang anak '+t_chl+' Harus Diisi');
                cek = 2;
                }
           }
           
           var lahir_chl = new Date($('#lahirtglc'+t_chl).val()+' '+bulan[$('#lahirblnc'+t_chl).val()]+' '+$('#lahirthnc'+t_chl).val());
              var penerbangan_chl = new Date($('#tglberangkat').val());
              var age_chl = Math.floor((penerbangan_chl-lahir_chl) / (365.25 * 24 * 60 * 60 * 1000));
             
              if(age_chl < 2 || age_chl >= 12){
                  if(cek == 2){
                    cek = 2;
                }else{
                        alert('Umur Penumpan Anak '+t_chl+' Tidak Boleh < 2 Tahun atau  => 12 Tahun Pada Hari Penerbangan');
                cek = 2;
                }
               
              }
             }
             var akhir_inf = $('#batas_bayi').val() * 1;
             for(var t_inf = akhir_inf ; t_inf >= 1 ; t_inf--){
                 if(!$('#tfirsti'+t_inf).val()){
                if(cek == 2){
               cek = 2;
                }else{
                        alert ('Firstname Penumpang bayi '+t_inf+' Harus Diisi');
                cek = 2;
                }
           }
           
           if(!$('#tlasti'+t_inf).val()){
               if(cek == 2){
               cek = 2;
                }else{
                        alert ('Lastname Penumpang bayi '+t_inf+' Harus Diisi');
                cek = 2;
                }
           }
           
           var lahir_inf = new Date($('#lahirtgli'+t_inf).val()+' '+bulan[$('#lahirblni'+t_inf).val()]+' '+$('#lahirthni'+t_inf).val());
              var penerbangan_inf = new Date($('#tglberangkat').val());
              var age_inf = Math.floor((penerbangan_inf-lahir_inf) / (30 * 24 * 60 * 60 * 1000));
            
              if(age_inf <= 0 || age_inf >= 24){
                  if(cek == 2){
                    cek = 2;
                }else{
                        alert('Umur Penumpan Bayi '+t+' Tidak Boleh >= 2 Tahun Pada Hari Penerbangan');
                cek = 2;
                }
               
              }
             }
        
       if(frname == ""){
           if(cek == 2){
               cek = 2;
           }else{
                alert ("Nama Pertama Pemesan Tidak boleh kosong");
           cek = 2;
           }
           
       }
       
       if (lname == ""){
           if(cek == 2){
               cek = 2;
           }else{
                alert ("Nama Belakang Pemesan Tidak boleh kosong");
           cek = 2;
           }
          
       }
       
       if(hp == ""){
           if(cek == 2){
               cek = 2;
           }else{
               alert ("No HP Tidak boleh kosong");
           cek = 2;
           }
       } 
       if(mail == ""){
           if(cek == 2){
               cek = 2;
           }else{
               alert ("email tidak boleh kosong");
           cek = 2;
           }
           
       }else{
          
           if(!isValidEmailAddress(mail)){
                if(cek == 2){
               cek = 2;
           }else{
                alert("Format Email Salah");
               cek = 2;
           }
              
           }
       }
       if(cek == 1){
           return true;
       }else{
           return false;
       }
       
        });
    });
</script>