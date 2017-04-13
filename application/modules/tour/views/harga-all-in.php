<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <!--<h3 class="box-title">Quick Example</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->
            <?php print $this->form_eksternal->form_open("", 'role="form"', array("code" => $book_code))?>
              <div class="box-body">

                <div class="control-group">
                  <label>Note (<?php print $book_code;?>)</label>
                  <p>Harga akan di input oleh team operation tour dan jika sudah ada, users dapat menerima harga tersebut</p>
                </div>

              </div>
              <div class="box-footer">
                  <button class="btn btn-primary" type="submit">Ya</button>
                  <a href="<?php print site_url("grouptour/product-tour/book-information/{$book_code}")?>" class="btn btn-warning"><?php print lang("cancel")?></a>
              </div>
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>   <!-- /.row -->