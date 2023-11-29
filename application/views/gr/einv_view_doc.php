<style>
.content-wrapper{
  min-height: 800px !important; 
}

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <!-- Filtering content -->
    <section class="content">
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Filter By</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

          <!-- Branch Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Branch/ Location Code</label>
            <div class="col-sm-6">
              <select id="branch_data" name="branch_data" class="form-control select2">
                <?php foreach($get_location_query->result() as $row)
                { ?>
                    <option value="<?php echo $row->branch_code ?>" ><?php echo $row->branch_name; ?> - <?php echo $row->branch_code; ?><?php if($row->branch_desc != '' && $row->branch_desc != null){echo ' - '.$row->branch_desc;};?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>

          <!-- Supplier Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Supplier Info</label>
            <div class="col-sm-6">
              <select id="supplier_data" name="supplier_data" class="form-control select2">
                <?php foreach($get_supplier_query->result() as $row)
                { ?>
                    <option value="<?php echo $row->supplier_guid ?>" ><?php echo addslashes($row->supplier_name); ?> - <?php echo $row->supplier_code; ?></option>
                <?php }
                ?>
              </select>
            </div>
          </div>

          <!-- RefNo Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">RefNo</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="refno_data" name="refno_data" autocomplete="off">
            </div>
          </div>

          <!-- E-Invoice Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">E-Invoice No</label>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="einv_data" name="einv_data" autocomplete="off">
            </div>
          </div>

          <!-- Invoice Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Invoice No</label>
            <div class="col-sm-4">
            <input type="text" class="form-control" id="inv_data" name="inv_data" autocomplete="off">
            </div>
          </div>

          <!-- Generated Date Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Generated Date</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control datetimepicker-input datepicker" id="generate_date_data" name="generate_date_data" data-toggle="datetimepicker">
              </div>
              <!-- <div class="input-group datepicker" id="generate_date_data" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#generate_date_data"/>
                <div class="input-group-append" data-target="#generate_date_data" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div> -->
            </div>
          </div>

          <!-- Generated Date Time Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Generated Time</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-clock"></i>
                  </span>
                </div>
                <input type="text" class="form-control datetimepicker-input timepicker" id="generate_time_data" name="generate_time_data" data-toggle="datetimepicker">
              </div>
              <!-- <div class="input-group datetimepicker" id="generate_datetime_data" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#generate_datetime_data"/>
                <div class="input-group-append" data-target="#generate_datetime_data" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div> -->
            </div>
          </div>

          <!-- Generated Date Time Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Generated Date & Time</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control datetimepicker-input datetimepicker" id="generate_datetime_data" name="generate_datetime_data" data-toggle="datetimepicker">
              </div>
              <!-- <div class="input-group datetimepicker" id="generate_datetime_data" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#generate_datetime_data"/>
                <div class="input-group-append" data-target="#generate_datetime_data" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
              </div> -->
            </div>
          </div>

          <!-- Generated Date Range Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Generated Date Range</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control float-right drangepicker" id="generate_daterange_data" name="generate_daterange_data">
              </div>
            </div>
          </div>

          <!-- Generated Date & Time Range Filter -->
          <div class="form-group row">
            <label class="col-sm-2 col-form-label">Generated Date & Time Range</label>
            <div class="col-sm-4">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                </div>
                <input type="text" class="form-control float-right dtrangepicker" id="generate_daterange_data" name="generate_daterange_data">
              </div>
            </div>
          </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <button id="search" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
          <button id="reset" class="btn btn-default"><i class="fas fa-sync-alt"></i> Reset</button>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content Filtering -->

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">E-Invoice List</h3>

          <div class="card-tools">
          </div>
        </div>
        <div class="card-body">
            <table id="main_table" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <!--Begin=Column Header-->
                    <th>GRN Refno</th>
                    <th>E-INV No</th>
                    <th>Inv No</th>
                    <!--End=Column Header-->
                  </tr>
                </thead>
            </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  var ref_no = '';
  var status = '';
  var datefrom = '';
  var dateto = '';
  var exp_datefrom = '';
  var exp_dateto = '';
  var period_code = '';
  var loc = '';

  $(document).ready(function() {
    main_table = function(ref_no, status, datefrom, dateto, exp_datefrom, exp_dateto, period_code, loc) {

      if ($.fn.DataTable.isDataTable('#main_table')) {
        $('#main_table').DataTable().destroy();
      }

      var table;

      table = $('#main_table').DataTable({
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 25, 50, 9999999], [10, 25, 50, 'All'] ],
        "sScrollX": "100%", 
        "sScrollXInner": "100%", 
        "order": [
          [0, "desc"]
        ],
        "columnDefs": [{
            "targets": [],
            "className": "alignright",
          },
          {
            "targets": [], //first column
            "orderable": false, //set not orderable
          }
        ],
        "ajax": {
          "url": "<?php echo site_url('B2b_grn/einvoice_list_tb') ?>",
          "type": "POST",
          "data": function(data) {
            data.ref_no = ref_no
            data.status = status
            data.datefrom = datefrom
          },
        },
        "columns": [{
            "name": "refno",
            "data": "refno"
          },
          {
            "name": "einvno",
            "data": "einvno"
          },
          {
            "name": "invno",
            "data": "invno"
          }
        ],
        //dom: 'lBfrtip',
        dom: "<'row'<'col-sm-4'l>" + "<'col-sm-8'f>>" +'Brtip',
        buttons: [
          'csv', 'excel'
        ]

      });
    }

    main_table(ref_no, status, datefrom, dateto, exp_datefrom, exp_dateto, period_code, loc);


  });


</script>