<style>
#slideshow{
    max-height: 400px !important;
    /*width: 50%;*/
}
#slideshow .slides img {
    max-height: 400px !important;
    /*width: 50%;*/
}
.tp-leftarrow{
  left: 0 !important;
}
.tp-rightarrow{
  right: 0 !important;
}
.fullwidthbanner-container{
  left: 0 !important;
}
.inti{
  width: 100% !important;
}
.details{
  background-color: #F5F5F5 !important;
}
.newcon{
  max-width: 1400px;
}
</style>
<section style="padding-top: 0; background-color: white;" class="nc">
    <div class="container newcon">
        <div class="row">
            <div id="main" class="col-sm-8 col-md-12 inti">
                <div class="page">
      <?php
      if($slide){
      ?>
        <div id="slideshow">
            <div class="fullwidthbanner-container">
                <div class="revolution-slider" style="height: 0; overflow: hidden;">
                    <ul>    <!-- SLIDE  -->
                        <?php
                        foreach($slide AS $sl){
                          print "<li data-transition='zoomin' data-slotamount='7' data-masterspeed='500' style='text-align: center; background-color: #bd2330'>"
                          . "<a href='".site_url()."'>"
                            . "<img style='width: 100%' src='".base_url()."files/antavaya/slideshow/{$sl->file}' alt='{$sl->title}'>"
                          . "</a>"
                          . "</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
      <?php }
      else{
        print '<div id="slideshow"></div>';
      }
?>
                    </div>
    </div>
    </div>
    </div>
    </section>
    <section id="content" style="background-color: white;">
            <div class="modify-back" style="width: 100%; background-color: #bd2330; position: absolute; margin-top: -80px">
              
            </div>
            <div class="search-box-wrapper" style="background-color: transparent" style="height: auto;">
                <div class="search-box container">
                    <ul class="search-tabs clearfix">
                        <!--<li class="active"><a href="#hotels-tab" data-toggle="tab">HOTELS</a></li>-->
                        <li class="active"><a href="#flights-tab" style="background-color: #bd2330; color: white; font-size: 18px" data-toggle="tab" class="judul">Cari Tiket</a></li>
<!--                        <li><a href="http://tiket.antavaya.com/index.php/component/bayar/?view=bayar&layout=byr" target="_blank" style="background-color: #bd2330; color: white" class="judul">Konfirmasi Pembayaran</a></li>
                        <li><a href="#faq-tab" style="background-color: #bd2330; color: white" data-toggle="tab" class="judul">FAQ & Terms Cond</a></li>-->
                        <!--<li><a href="#flight-and-hotel-tab" data-toggle="tab">FLIGHT &amp; HOTELS</a></li>
                        <li><a href="#cars-tab" data-toggle="tab">CARS</a></li>
                        <li><a href="#cruises-tab" data-toggle="tab">CRUISES</a></li>
                        <li><a href="#flight-status-tab" data-toggle="tab">FLIGHT STATUS</a></li>
                        <li><a href="#online-checkin-tab" data-toggle="tab">ONLINE CHECK IN</a></li>-->
                    </ul>
                    <div class="visible-mobile">
                        <ul id="mobile-search-tabs" class="search-tabs clearfix">
                            <!--<li class="active"><a href="#hotels-tab">HOTELS</a></li>-->
                            <li><a href="#flights-tab" style="background-color: #bd2330" class="judul">CARI TIKET</a></li>
<!--                            <li><a href="http://tiket.antavaya.com/index.php/component/bayar/?view=bayar&layout=byr" target="_blank" style="background-color: #bd2330; font-size: 11px" class="judul">Konfirmasi Pembayaran</a></li>
                            <li><a href="#faq-tab" style="background-color: #bd2330; color: white" data-toggle="tab" class="judul">FAQ & Terms Cond</a></li>-->
<!--                            <li><a href="#flight-and-hotel-tab">FLIGHT &amp; HOTELS</a></li>
                            <li><a href="#cars-tab">CARS</a></li>
                            <li><a href="#cruises-tab">CRUISES</a></li>
                            <li><a href="#flight-status-tab">FLIGHT STATUS</a></li>
                            <li><a href="#online-checkin-tab">ONLINE CHECK IN</a></li>-->
                        </ul>
                    </div>
                    
                    <div class="search-tab-content">
                        <!--<div class="tab-pane fade active in" id="hotels-tab">
                            <form action="hotel-list-view.html" method="post">
                                <div class="row">
                                    <div class="form-group col-sm-6 col-md-3">
                                        <h4 class="title">Where</h4>
                                        <label>Your Destination</label>
                                        <input type="text" class="input-text full-width" placeholder="enter a destination or hotel name" />
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-md-4">
                                        <h4 class="title">When</h4>
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <label>Check In</label>
                                                <div class="datepicker-wrap">
                                                    <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Check Out</label>
                                                <div class="datepicker-wrap">
                                                    <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-md-3">
                                        <h4 class="title">Who</h4>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <label>Rooms</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Adults</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-4">
                                                <label>Kids</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-sm-6 col-md-2 fixheight">
                                        <label class="hidden-xs">&nbsp;</label>
                                        <button type="submit" class="full-width icon-check animated" data-animation-type="bounce" data-animation-duration="1">SEARCH NOW</button>
                                    </div>
                                </div>
                            </form>
                        </div>-->
                        <div class="tab-pane fade active in" id="flights-tab">
                            <form name="form_search" method="post" onsubmit="return false" action="http://tiket.antavaya.com/widgets.php#">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!--<h4 class="title">Where</h4>-->
                                        <div class="form-group">
                                            <label style="color: white">Dari</label>
                                            <input value="Jakarta(CGK)" id="autocomplete" name="tdr" type="text" class="input-text full-width" placeholder="city, district or specific airport" />
                                        </div>
                                        <div class="form-group">
                                            <label style="color: white">Ke</label>
                                            <input value="Bali(DPS)" id="autocomplete" name="tke" type="text" class="input-text full-width" placeholder="city, district or specific airport" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <!--<h4 class="title">When</h4>-->
                                        <label style="color: white">Berangkat</label>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <div class="datepicker-wrap">
                                                    <input value="<?php print date("d F Y",strtotime("+1 days"))?>" type="text" id="tgl" name="tgl" class="input-text full-width" placeholder="dd MM YY" />
                                                </div>
                                                <input type="hidden" name="tnow" id="tnow" value="<?php print $key?>">
                                                <input type="hidden" name="agen" id="agen" value="testya">
                                            </div>
                                            <!--<div class="col-xs-6">
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">anytime</option>
                                                        <option value="2">morning</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                        </div>
                                        <label style="color: white"><input id="rdotrip" name="rdotrip" type="checkbox" checked="true" > Pulang</label>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <div class="datepicker-wrapo" id="tanggal_back">
                                                    <input value="<?php print date("d F Y",strtotime("+2 days"))?>" type="text" id="tglr" name="tglr" class="input-text full-width" placeholder="dd MM YY" />
                                                </div>
                                            </div>
                                            <!--<div class="col-xs-6">
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">anytime</option>
                                                        <option value="2">morning</option>
                                                    </select>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <!--<h4 class="title">Who</h4>-->
                                        <div class="form-group row">
                                            <div class="col-xs-3">
                                                <label style="color: white">Dewasa</label>
                                                <div class="selector">
                                                    <select name="adl" id="adl" class="full-width">
                                                        <!--<option value="0">00</option>-->
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label style="color: white">Anak</label>
                                                <div class="selector">
                                                    <select name="chd" id="chd" class="full-width">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label style="color: white">Bayi</label>
                                                <div class="selector">
                                                    <select name="inf" id="inf" class="full-width">
                                                        <option value="0">00</option>
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--<div class="col-xs-6">
                                                <label>Promo Code</label>
                                                <input type="text" class="input-text full-width" placeholder="type here" />
                                            </div>-->
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xs-9">
                                                <button id="cari" onclick="testopen()" class="full-width icon-check judul" style="height: 63px; font-size: 18px" >
                                                    CARI TIKET
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade in" id="faq-tab">
                            <label style="color: white"><a href="javascript:void(0)" onclick="faq_popup()">FAQ'S</a></label>
                                <br />
                            <label style="color: white"><a href="javascript:void(0)" onclick="term_popup()">Terms & Conditions</a></label>
                        </div>
                        
                        <!--<div class="tab-pane fade" id="flight-and-hotel-tab">
                            <form action="flight-list-view.html" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="title">Where</h4>
                                        <div class="form-group">
                                            <label>Leaving From</label>
                                            <input type="text" class="input-text full-width" placeholder="city, distirct or specific airpot" />
                                        </div>
                                        <div class="form-group">
                                            <label>Going To</label>
                                            <input type="text" class="input-text full-width" placeholder="city, distirct or specific airpot" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">When</h4>
                                        <label>Departing On</label>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <div class="datepicker-wrap">
                                                    <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">anytime</option>
                                                        <option value="2">morning</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <label>Arriving On</label>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <div class="datepicker-wrap">
                                                    <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">anytime</option>
                                                        <option value="2">morning</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">Who</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-3">
                                                <label>Adults</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label>Kids</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Promo Code</label>
                                                <input type="text" class="input-text full-width" placeholder="type here" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xs-3">
                                                <label>Rooms</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 pull-right">
                                                <label>&nbsp;</label>
                                                <button class="full-width icon-check">SERACH NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="cars-tab">
                            <form action="car-list-view.html" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="title">Where</h4>
                                        <div class="form-group">
                                            <label>Pick Up</label>
                                            <input type="text" class="input-text full-width" placeholder="city, distirct or specific airpot" />
                                        </div>
                                        <div class="form-group">
                                            <label>Drop Off</label>
                                            <input type="text" class="input-text full-width" placeholder="city, distirct or specific airpot" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">When</h4>
                                        <div class="form-group">
                                            <label>Pick-Up Date / Time</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="datepicker-wrap">
                                                        <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="selector">
                                                        <select class="full-width">
                                                            <option value="1">anytime</option>
                                                            <option value="2">morning</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Drop-Off Date / Time</label>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="datepicker-wrap">
                                                        <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="selector">
                                                        <select class="full-width">
                                                            <option value="1">anytime</option>
                                                            <option value="2">morning</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">Who</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-3">
                                                <label>Adults</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <label>Kids</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Promo Code</label>
                                                <input type="text" class="input-text full-width" placeholder="type here" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Car Type</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="">select a car type</option>
                                                        <option value="economy">Economy</option>
                                                        <option value="compact">Compact</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>&nbsp;</label>
                                                <button class="full-width icon-check">SERACH NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="cruises-tab">
                            <form action="cruise-list-view.html" method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h4 class="title">Where</h4>
                                        <div class="form-group">
                                            <label>Your Destination</label>
                                            <input type="text" class="input-text full-width" placeholder="enter a destination or hotel name" />
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">When</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Departure Date</label>
                                                <div class="datepicker-wrap">
                                                    <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Cruise Length</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="">select length</option>
                                                        <option value="1">1-2 Nights</option>
                                                        <option value="2">3-4 Nights</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h4 class="title">Who</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Cruise Line</label>
                                                <div class="selector">
                                                    <select class="full-width">
                                                        <option value="">select cruise line</option>
                                                        <option>Azamara Club Cruises</option>
                                                        <option>Carnival Cruise Lines</option>
                                                        <option>Celebrity Cruises</option>
                                                        <option>Costa Cruise Lines</option>
                                                        <option>Cruise &amp; Maritime Voyages</option>
                                                        <option>Crystal Cruises</option>
                                                        <option>Cunard Line Ltd.</option>
                                                        <option>Disney Cruise Line</option>
                                                        <option>Holland America Line</option>
                                                        <option>Hurtigruten Cruise Line</option>
                                                        <option>MSC Cruises</option>
                                                        <option>Norwegian Cruise Line</option>
                                                        <option>Oceania Cruises</option>
                                                        <option>Orion Expedition Cruises</option>
                                                        <option>P&amp;O Cruises</option>
                                                        <option>Paul Gauguin Cruises</option>
                                                        <option>Peter Deilmann Cruises</option>
                                                        <option>Princess Cruises</option>
                                                        <option>Regent Seven Seas Cruises</option>
                                                        <option>Royal Caribbean International</option>
                                                        <option>Seabourn Cruise Line</option>
                                                        <option>Silversea Cruises</option>
                                                        <option>Star Clippers</option>
                                                        <option>Swan Hellenic Cruises</option>
                                                        <option>Thomson Cruises</option>
                                                        <option>Viking River Cruises</option>
                                                        <option>Windstar Cruises</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <label>&nbsp;</label>
                                                <button class="icon-check full-width">SEARCH NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="flight-status-tab">
                            <form action="flight-list-view.html" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="title">Where</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Leaving From</label>
                                                <input type="text" class="input-text full-width" placeholder="enter a city or place name" />
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Going To</label>
                                                <input type="text" class="input-text full-width" placeholder="enter a city or place name" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-2">
                                        <h4 class="title">When</h4>
                                        <div class="form-group">
                                            <label>Departure Date</label>
                                            <div class="datepicker-wrap">
                                                <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-2">
                                        <h4 class="title">Who</h4>
                                        <div class="form-group">
                                            <label>Flight Number</label>
                                            <input type="text" class="input-text full-width" placeholder="enter flight number" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 fixheight">
                                        <label class="hidden-xs">&nbsp;</label>
                                        <button class="icon-check full-width">SEARCH NOW</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="online-checkin-tab">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="title">Where</h4>
                                        <div class="form-group row">
                                            <div class="col-xs-6">
                                                <label>Leaving From</label>
                                                <input type="text" class="input-text full-width" placeholder="enter a city or place name" />
                                            </div>
                                            <div class="col-xs-6">
                                                <label>Going To</label>
                                                <input type="text" class="input-text full-width" placeholder="enter a city or place name" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-2">
                                        <h4 class="title">When</h4>
                                        <div class="form-group">
                                            <label>Departure Date</label>
                                            <div class="datepicker-wrap">
                                                <input type="text" class="input-text full-width" placeholder="mm/dd/yy" />
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-6 col-md-2">
                                        <h4 class="title">Who</h4>
                                        <div class="form-group">
                                            <label>Full Name</label>
                                            <input type="text" class="input-text full-width" placeholder="enter your full name" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 fixheight">
                                        <label class="hidden-xs">&nbsp;</label>
                                        <button class="icon-check full-width">SEARCH NOW</button>
                                    </div>
                                </div>
                            </form>
                        </div>-->
                    </div>
                </div>
            </div>
            
            <!-- Popuplar Destinations -->
<!--            <div class="destinations section">
                <div class="container">
                    <h2>Popular Destinations</h2>
                    <div class="row image-box style1 add-clearfix">
                        <div class="col-sms-6 col-sm-6 col-md-3">
                            <article class="box">
                                <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1">
                                    <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
                                </figure>
                                <div class="details">
                                    <span class="price"><small>FROM</small>$490</span>
                                    <h4 class="box-title"><a href="hotel-detailed.html">Atlantis - The Palm<small>Paris</small></a></h4>
                                </div>
                            </article>
                        </div>
                        <div class="col-sms-6 col-sm-6 col-md-3">
                            <article class="box">
                                <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.3">
                                    <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
                                </figure>
                                <div class="details">
                                    <span class="price"><small>FROM</small>$170</span>
                                    <h4 class="box-title"><a href="hotel-detailed.html">Hilton Hotel<small>LONDON</small></a></h4>
                                </div>
                            </article>
                        </div>
                        <div class="col-sms-6 col-sm-6 col-md-3">
                            <article class="box">
                                <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.6">
                                    <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
                                </figure>
                                <div class="details">
                                    <span class="price"><small>FROM</small>$130</span>
                                    <h4 class="box-title"><a href="hotel-detailed.html">MGM Grand<small>LAS VEGAS</small></a></h4>
                                </div>
                            </article>
                        </div>
                        <div class="col-sms-6 col-sm-6 col-md-3">
                            <article class="box">
                                <figure class="animated" data-animation-type="fadeInDown" data-animation-duration="1" data-animation-delay="0.9">
                                    <a href="ajax/slideshow-popup.html" title="" class="hover-effect popup-gallery"><img src="http://placehold.it/270x160" alt="" width="270" height="160" /></a>
                                </figure>
                                <div class="details">
                                    <span class="price"><small>FROM</small>$290</span>
                                    <h4 class="box-title"><a href="hotel-detailed.html">Crown Casino<small>ASUTRALIA</small></a></h4>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>-->
            <!-- Did you Know? section -->
            <div class="offers section" style="background-color: white; padding-bottom: 0 !important; padding-top: 0 !important">
                <div class="container">
                    <div class="col-md-12 content-section description pull-left">
                <div class="honeymoon section promo-box parallax menu2nd" data-stellar-background-ratio="0.5" style="float: left;">
                <div class="container">
                    <div class="col-md-12 content-section description pull-left" style="padding-top: 0; padding-bottom: 15px">
                        <a style='font-size: 24px; margin-top: 0; background-color: #bd2330' href='http://tiket.antavaya.com/index.php/component/bayar/?view=bayar&layout=byr' target='_blank' title='' class='button'>Konfirmasi Pembayaran</a>
                        <a style='font-size: 24px; margin-top: 0; background-color: #bd2330' href="javascript:void(0)" onclick="faq_popup()" title='' class='button'>FAQ'S</a>
                        <a style='font-size: 24px; margin-top: 0; background-color: #bd2330' href="javascript:void(0)" onclick="term_popup()" title='' class='button'>Terms Conditions</a>
                    </div>
                  
<!--                  <div class="col-md-6" style="text-align: center">
                      <img src="<?php print $url."maskapai/citilink.png"?>" alt="" class="middle-item" width="21%" />
                      <img src="<?php print $url."maskapai/garuda.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/lion.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/batik.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/air-asia.png"?>" alt="" class="middle-item" width="20%" />
                      <img src="<?php print $url."maskapai/sriwijaya.png"?>" alt="" class="middle-item" width="18%" />
                      <img src="<?php print $url."maskapai/wings.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/nam.png"?>" alt="" class="middle-item" width="22%" />
                      <hr />
                      <h1 class="text-center">Pembayaran</h1>
                      <div class="row image-box style7">
                          <div class="col-md-12" style="text-align: center">
                            <img src="<?php print $url."maskapai/bca.png"?>" alt="" class="middle-item" width="20%" />
                            <img src="<?php print $url."maskapai/mandiri.png"?>" alt="" class="middle-item" width="20%" />
                            <img src="<?php print $url."maskapai/kk.png"?>" alt="" class="middle-item" width="20%" />
                          </div>
                      </div>
                  </div>-->
                  
                </div>
            </div>
            </div>
            </div>
            </div>
            <div class="offers section" style="background-color: white">
                <div class="container">
                    <div class="col-md-12 content-section description pull-left">
                        <!--<h1><b>Promo</b></h1>-->
                        <div style="padding-bottom: 15px">
                            <img src="<?php print $url."images/TOUR PROMO logo-07.png"?>" width="20%" />
                        </div>
                        <div class="row places image-box style9">
                            <?php
//                            foreach($promosi AS $pr){
                            for($f = 0 ; $f < 4 ; $f++){
                              if($promosi[$f]->id_website_promosi){
                                print "<div class='col-xs-3'>"
                                . "<article class='box'>"
                                  . "<figure>"
                                    . "<a href='".site_url("promosi/detail/{$promosi[$f]->nicename}")."' title='' class='hover-effect yellow animated' data-animation-type='fadeInUp' data-animation-duration='1'>"
                                    . "<img src='".base_url()."files/antavaya/promosi/{$promosi[$f]->file_temp}' alt='' /></a>"
                                  . "</figure>"
                                  . "<div class='details' style='min-height: 205px' style='background-color: #F5F5F5'>"
                                    . "<h4 style='min-height: 115px; color: #bd2330'>{$promosi[$f]->title}<br /><small style='color: black'>"
                                    . "{$promosi[$f]->sub_title} <br /><span style='font-size: 11px; color: #727070'>{$promosi[$f]->summary}</span></small></h4>"
                                    . "<a style='font-size: 18px; margin-top: 0' href='".site_url("promosi/detail/{$promosi[$f]->nicename}")."' title='' class='button'>Detail</a>"
                                  . "</div>"
                                . "</article>"
                                . "</div>";
                              }
                            }
                            ?>
                        </div>
                        <div class="row places image-box style9">
                            <?php
                            for($f = 4 ; $f < 8 ; $f++){
                              if($promosi[$f]->id_website_promosi){
                                print "<div class='col-xs-3'>"
                                . "<article class='box'>"
                                  . "<figure>"
                                    . "<a href='".site_url("promosi/detail/{$promosi[$f]->nicename}")."' title='' class='hover-effect yellow animated' data-animation-type='fadeInUp' data-animation-duration='1'>"
                                    . "<img src='".base_url()."files/antavaya/promosi/{$promosi[$f]->file_temp}' alt='' /></a>"
                                  . "</figure>"
                                  . "<div class='details' style='min-height: 205px' style='background-color: #F5F5F5'>"
                                    . "<h4 style='min-height: 115px; color: #bd2330'>{$promosi[$f]->title}<br /><small style='color: black'>"
                                    . "{$promosi[$f]->sub_title} <br /><span style='font-size: 11px; color: #727070'>{$promosi[$f]->summary}</span></small></h4>"
                                    . "<a style='font-size: 18px; margin-top: 0' href='".site_url("promosi/detail/{$promosi[$f]->nicename}")."' title='' class='button'>Detail</a>"
                                  . "</div>"
                                . "</article>"
                                . "</div>";
                              }
                            }
                            ?>
                        </div>
                    </div>
                  
<!--                  <div class="col-md-6" style="text-align: center">
                      <img src="<?php print $url."maskapai/citilink.png"?>" alt="" class="middle-item" width="21%" />
                      <img src="<?php print $url."maskapai/garuda.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/lion.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/batik.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/air-asia.png"?>" alt="" class="middle-item" width="20%" />
                      <img src="<?php print $url."maskapai/sriwijaya.png"?>" alt="" class="middle-item" width="18%" />
                      <img src="<?php print $url."maskapai/wings.png"?>" alt="" class="middle-item" width="22%" />
                      <img src="<?php print $url."maskapai/nam.png"?>" alt="" class="middle-item" width="22%" />
                      <hr />
                      <h1 class="text-center">Pembayaran</h1>
                      <div class="row image-box style7">
                          <div class="col-md-12" style="text-align: center">
                            <img src="<?php print $url."maskapai/bca.png"?>" alt="" class="middle-item" width="20%" />
                            <img src="<?php print $url."maskapai/mandiri.png"?>" alt="" class="middle-item" width="20%" />
                            <img src="<?php print $url."maskapai/kk.png"?>" alt="" class="middle-item" width="20%" />
                          </div>
                      </div>
                  </div>-->
                  
                </div>
            </div>
            
            
            <div class="honeymoon section promo-box parallax" data-stellar-background-ratio="0.5">
                <div class="container">
                    <div class="col-md-12" style="text-align: justify">
                        <div class="flexslider photo-gallery style4">
                            <ul class="slides">
                                <li><a href='javascript:void(0)'><img src='<?php print $url."banner/PROSEDUR-01.png"?>' alt=''></a></li>
                                <li><a href='javascript:void(0)'><img src='<?php print $url."banner/partner-02.png"?>' alt=''></a></li>
                            </ul>
                        </div>
                  </div>
                </div>
            </div>
            
        </section>
        
        
    </div>