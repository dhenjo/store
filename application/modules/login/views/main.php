<?php

print $this->form_eksternal->form_open();?>
    <div class="body bg-gray">
      <?php if($pesan){?>
        <div class="form-group">
          <button type="button" class="btn btn-warning btn-block"><?php print $pesan?></button>
        </div>
      <?php }?>
        <div class="form-group">
          <?php print $this->form_eksternal->form_input('memuname', '', 'placeholder="Username or Email" class="form-control"')?>
        </div>
        <div class="form-group">
          <?php print $this->form_eksternal->form_password('mempass', '', 'placeholder="Password" class="form-control"')?>
        </div>          
<!--                    <div class="form-group">
            <input type="checkbox" name="remember_me"/> Remember me
        </div>-->
    </div>
    <div class="footer">                                                               
        <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  

        <p><a href="<?php print site_url("login/forgot-password")?>">I forgot my password</a></p>

        <!--<a href="register.html" class="text-center">Register a new membership</a>-->
    </div>
</form>