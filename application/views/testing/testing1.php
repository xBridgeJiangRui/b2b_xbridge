<style>
.content-wrapper{
  min-height: 800px !important; 
}

/* Smaller Filtering Content Section */
.filtering-section {
    padding: 10px;
  }

</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    </div>
    <!-- Filtering content -->
    <!-- Default box -->
    <section class="filtering-section">
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
                <input type="text" class="form-control datetimepicker-input datepicker" id="einv_generated_date" name="einv_generated_date" data-toggle="datetimepicker">
              </div>
              <!-- <div class="input-group datepicker" id="generate_date_data" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#generate_date_data"/>
                <div class="input-group-append" data-target="#generate_date_data" data-toggle="datetimepicker">
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
      <div class="card" >
        <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title">E-Invoice List</h3>
              <button id="createButton" class="btn btn-success"><i class="fas fa-plus"></i> Create</button>
            </div>
          </div>
          <div class="card-body">
            <table id="main_table" class="table table-bordered table-hover" width="100%" cellspacing="0">
              <thead style="white-space: nowrap;">
              <tr>
                  <th>
                    <input type="checkbox" id="checkall_input_table" name="checkall_input_table" table_id="main_table">
                  </th>
                  <th>Action</th>
                  <th>GRN Refno</th>
                  <th>E-INV No</th>
                  <th>Inv No</th>
                  <th>Retailer Name</th>
                  <th>Generated Date</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
            
          </div>  
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
  var generate_daterange_data = '';
  var einvno = '';
  var invno = '';
  var einv_generated_date = '';
  var table;
  $(document).ready(function() {
    
    main_table = function(ref_no, einvno, invno, einv_generated_date, generate_daterange_data) {

      if ($.fn.DataTable.isDataTable('#main_table')) {
        $('#main_table').DataTable().destroy();
      }

      table = $('#main_table').DataTable({
        "scrollX": true,
        "processing": true,
        "serverSide": true,
        "lengthMenu": [ [10, 25, 50, 9999999], [10, 25, 50, 'All'] ],
        "sScrollX": "100%", 
        "sScrollXInner": "100%", 
        "sScrollY": "50vh",
        "bScrollCollapse": true,
        "order": [
          [1, "desc"]
        ],
        "columnDefs": [
          {
            "targets": 0, //first column
            "orderable": false, //set not orderable
          }
        ],
        "ajax": {
          "url": "<?php echo site_url('Testing/einvoice_list_tb') ?>",
          "type": "POST",
          "data": function(data) {
            data.ref_no = ref_no;
            data.generate_daterange_data = generate_daterange_data;
            data.einvno = einvno;
            data.invno = invno;
            data.einv_generated_date = einv_generated_date;
            },
        },
          columns: [
            {
              "data": "einvno", render:function(data, type ,row){

                var element = '';
                var element1 = row['form_status'];

                if((element1 == '') || (element1 == 'null') || (element1 == null))
                {
                    element += '<input type="checkbox" class="form-checkbox" name="trigger_check_box" id="trigger_check_box" einvno ="'+row['einvno']+'" refno ="'+row['refno']+'"/>';
                }
                return element;
              }
            },
            { "data": "einvno", render: function (data, type, row) {
                var buttons = '';

                buttons += '<button id="einv_btn" title="TRIGGER" class="btn btn-warning btn-xs" style="margin-right: 5px;" einvno ="' +row['einvno']+ '"><i class="fa fa-edit"></i></button>';

                return buttons;
            }},
            {
              "data": "refno"
            },
            {
              "data": "einvno"
            },
            {
              "data": "invno"
            },
            {
              "data": "acc_name"
            },
            {
              "data": "einv_generated_date"
            }
          ],
          //dom: 'lBfrtip',
          dom: "<'row'<'col-sm-4'l>" + "<'col-sm-8'f>>" +'Brtip',
          buttons: [
            'csv', 'excel'
          ],
      });

      $(document).on('change','#checkall_input_table',function(){

        var id = $(this).attr('table_id');

        var table = $('#'+id).DataTable();

        if($(this).is(':checked'))
        {
          table.rows().nodes().to$().each(function(){

            $(this).find('td').find('#trigger_check_box').prop('checked',true)

          });//close small loop
        }
        else
        {
          table.rows().nodes().to$().each(function(){

            $(this).find('td').find('#trigger_check_box').prop('checked',false)

          });//close small loop
        }//close else

        });//close checkbox all set_group_table
    }
    
    main_table(ref_no, einvno, invno, einv_generated_date, generate_daterange_data);
    
    $(document).on('click', '#search', function() {
        // Get the values from the filter inputs
        var refno_data = $('#refno_data').val();
        var einv_data = $('#einv_data').val();
        var inv_data = $('#inv_data').val();
        var einv_generated_date = $('#einv_generated_date').val();
        var generate_daterange_data = $('#generate_daterange_data').val();

        // Call the main_table function with the filter values
        main_table(refno_data, einv_data, inv_data, einv_generated_date, generate_daterange_data);
    });

    $(document).on('click', '#reset', function() {
        // Clear filter inputs
        $('#refno_data').val('');
        $('#einv_data').val('');
        $('#inv_data').val('');
        $('#einv_generated_date').val('');
        $('#generate_daterange_data').val('');

        // Call the main_table function with empty filter values
        main_table('', '', '', '', '');
    });

    $(document).on('click', '#createButton', function() {
        // Display the modal
        $('#createModal').html(`
        <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
              </div>
              <div class="modal-body">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="refno" class="col-sm-2 control-label">GRN RefNo</label>
                  <input type="text" class="form-control" id="refno" placeholder="Grn Ref No">
                  <label for="einvno" class="col-sm-2 control-label">E Inv No</label>
                  <input type="text" class="form-control" id="einvno" placeholder="E Inv No">
                  <label for="invno" class="col-sm-2 control-label">Inv No</label>
                  <input type="text" class="form-control" id="invno" placeholder="Inv No">
                </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                <button type="submit" id="createButtonfunc" class="btn btn-primary">Create</button>
              </div>
          </div>
        </div>
        `);

        $('#createModal').modal('show');
    });

    $(document).on('click', '#createButtonfunc', function() {
      var refno = $('#refno').val();
      var einvno = $('#einvno').val();
      var invno = $('#invno').val();

      if((refno == '') || (refno == null) || (refno == 'null'))
        {
            alert('Invalid Process.');
            return;
        }

      if((einvno == '') || (einvno == null) || (einvno == 'null'))
      {
          alert('Invalid Process.');
          return;
      }

      if((invno == '') || (invno == null) || (invno == 'null'))
      {
          alert('Invalid Process.');
          return;
      }

      // Send Ajax request to create the record
      $.ajax({
          url: "<?php echo site_url('Testing/testCreate'); ?>",
          method: 'POST',
          data: {
            refno:refno,
            einvno:einvno,
            invno:invno
          },
          beforeSend: function () {
              $('#createButtonfunc').prop('disabled', true).html('Saving...');
          },
          success: function (data) {
              $('#createButtonfunc').prop('disabled', false).html('Save');
              var json = JSON.parse(data);
              if (json.status) {
                  alert("New data saved successfully.");
                  table.ajax.reload(null, false);
                  $('#createModal').modal('hide');

              } else {
                  alert("Failed to save new data. Please try again.");
              }
          },
          error: function () {
              $('#createButtonfunc').prop('disabled', false).html('Save');
              alert("An error occurred while saving new data. Please try again.");
          }

      });
    });

    

  });

</script>