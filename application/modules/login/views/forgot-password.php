<?php print $this->form_eksternal->form_open()?>
    <div class="body bg-gray">
        <div class="form-group">
          <?php print $this->form_eksternal->form_input('email', '', 'placeholder="Email" class="form-control mail"')?>
        </div>
    </div>
    <div class="footer">
        <?php print $this->form_eksternal->form_submit('reset', 'Reset Password', 'class="btn btn-inverse login-btn"')?><br />
        <a href="<?php print   site_url("login")?>">Back to login</a>
    </div>
</form>