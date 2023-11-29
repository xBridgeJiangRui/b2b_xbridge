<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>Location / Branch</h1> -->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Location / Branch</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-md-3"></div>
              <div class="col-md-6">
                <form action="<?php echo site_url('Branch_dashboard/branch_setsession');?>" method='post'>
                <div class="form-group">
                Please Choose a Location
                <select id="location" name="location" class="form-control select2">
                    <?php foreach($location->result() as $row)
                    { ?>
                        <option value="<?php echo $row->branch_code ?>" ><?php echo $row->branch_name; ?> - <?php echo $row->branch_code; ?><?php if($row->branch_desc != '' && $row->branch_desc != null){echo ' - '.$row->branch_desc;};?></option>
                    <?php }
                    ?>
                    </select>
                </div>
                <p><button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button></p>

                </form>
              </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->