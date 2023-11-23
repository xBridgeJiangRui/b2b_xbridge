<!-- Content Wrapper. Contains page content -->
<style>
  .imagess {
    opacity: 1;
    display: block;
    width: 100%;
    height: auto;
    transition: .5s ease;
    backface-visibility: hidden;
  }

  .middle {
    transition: .5s ease;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    text-align: center;
  }

  .img_wrap:hover .imagess {
    opacity: 0.3;
  }

  .img_wrap:hover .middle {
    opacity: 1;
  }

  .buttonn {
    background-color: #4da6ff;
    color: white;
    font-size: 13px;
    padding: 1em 1em;
    outline: none;
    box-shadow: 2px 4px #888888;
  }

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <?php
  if ($this->session->userdata('message')) {
  ?>
    <div class="alert alert-success text-center" style="font-size: 18px">
      <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br>
    </div>
  <?php
  }
  ?>

  <?php
  if ($this->session->userdata('warning')) {
  ?>
    <div class="alert alert-danger text-center" style="font-size: 18px">
      <?php echo $this->session->userdata('warning') <> '' ? $this->session->userdata('warning') : ''; ?>
      <button type="button" class="close" data-dismiss="alert"><i class="fa fa-remove"></i></button><br>
    </div>
  <?php
  }
  ?>
  <!-- Main content -->
  <section class="content-header">
    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Select Customer (Click on the logo button to select customer)</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <span class="append_blocked"></span>
        <div class="row">
        <?php 
          $i = 1;
          foreach ($customer->result() as $row) 
          {
            if ($i == 1) {
              $last = $row->seq;
            }

            if ($last != $row->seq) {
              echo '</div><hr><div class="row">';
              $last = $row->seq;
            }

            ?>

            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6 img_wrap">
              <img src="<?php echo $row->logo; ?>" alt="<?php echo $row->acc_name; ?>" class="imagess img-square" style="width:100%">
              <div class="middle">
                <button class="buttonn img-circle" name="choose_retailer" id="choose_retailer" type="button" acc_guid="<?php echo $row->acc_guid ?>" seq="<?php echo $i ?>" register_guid="<?php echo $row->register_guid ?>" m_l="<?php echo $row->maintenance ?>" m_d="<?php echo $row->maintenance_date ?>" ><?php echo $row->acc_name; ?></button>
              </div>
            </div>
            
            <?php
             if ($last != $row->seq) {
              echo '/div>';

            }
            $i++;
          }
        ?>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script>
  $(document).ready(function() {



    //disable inspect element
    // document.onkeydown = function(e) {
    //   if(event.keyCode == 123) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
    //      return false;
    //   }
    //   if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
    //      return false;
    //   }
    // }

  });
</script>