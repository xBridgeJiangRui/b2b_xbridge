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
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
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
          <button id="upload" class="btn btn-default"><i class="fas fa-upload"></i> Upload</button>
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
              <button id="createButton" class="btn btn-success btn-xs"><i class="fas fa-plus"></i> Create</button>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  var refno = '';
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
    
    main_table = function(refno, einvno, invno, einv_generated_date, generate_daterange_data) {

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
            data.refno = refno;
            data.generate_daterange_data = generate_daterange_data;
            data.einvno = einvno;
            data.invno = invno;
            data.einv_generated_date = einv_generated_date;
            },
        },
          columns: [
            {
              "data": "refno", render:function(data, type ,row){

                var element = '';
                var element1 = row['form_status'];

                if((element1 == '') || (element1 == 'null') || (element1 == null))
                {
                    element += '<input type="checkbox" class="form-checkbox" name="trigger_check_box" id="trigger_check_box" refno ="'+row['refno']+'" refno ="'+row['refno']+'"/>';
                }
                return element;
              }
            },
            { "data": "refno", render: function (data, type, row) {
                var buttons = '';

                buttons += '<button id="editrefno_btn" title="EDIT" class="btn btn-warning btn-xs" style="margin-right: 5px;" refno ="' +row['refno']+ '"><i class="fa fa-edit"></i></button>';
                buttons += '<button id="deleterefno_btn" title="DELETE" class="btn btn-danger btn-xs" style="margin-right: 5px;" refno ="' +row['refno']+ '"><i class="fa fa-trash"></i></button>';

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
    
    main_table(refno, einvno, invno, einv_generated_date, generate_daterange_data);
    
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

    $(document).on('click', '#upload', function() {
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
        var modal = $("#large-modal").modal();

        modal.find('.modal-title').html('Create Data');

        methodd = '';

        methodd +='<form><div class="card-body">';
        methodd += '<div class="form-group"><label for="refno">GRN RefNo</label>';
        methodd += '<input type="text" class="form-control" id="refno" placeholder="Grn Ref No"></div>';
        methodd += '<div class="form-group"><label for="einvno">E Inv No</label>';
        methodd += '<input type="text" class="form-control" id="einvno" placeholder="E Inv No"></div>';
        methodd += '<div class="form-group"><label for="invno">Inv No</label>';
        methodd += '<input type="text" class="form-control" id="invno" placeholder="Inv No"></div>';
        methodd += '</div></form>';

        methodd_footer ='';
        methodd_footer += '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>';
        methodd_footer += '<button type="submit" id="createButtonfunc" class="btn btn-primary">Create</button>';

        modal.find('.modal-footer').html(methodd_footer);
        modal.find('.modal-body').html(methodd);
    });

    $(document).on('click', '#createButtonfunc', function() {
      var refno = $('#refno').val();
      var einvno = $('#einvno').val();
      var invno = $('#invno').val();

      if((refno == '') || (refno == null) || (refno == 'null'))
        {
            toastr.error('Invalid Process.');
            return;
        }

      if((einvno == '') || (einvno == null) || (einvno == 'null'))
      {
          toastr.error('Invalid Process.');
          return;
      }

      if((invno == '') || (invno == null) || (invno == 'null'))
      {
          toastr.error('Invalid Process.');
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
              if (json.status === 'success') {
                  toastr.success('Data added successfully!');
                  table.ajax.reload(null, false);
                  $('#large-modal').modal('hide');

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

    $(document).on('click', '#editrefno_btn', function() {
        var refno = $(this).attr('refno');

        var modal = $("#large-modal").modal();

        modal.find('.modal-title').html('Update Data');

        methodd = '';

        methodd +='<form><div class="card-body">';
        methodd += '<div class="form-group"><label for="refno">GRN RefNo</label>';
        methodd += '<input type="text" class="form-control" id="refno" placeholder="Grn Ref No" value="" readonly></div>';
        methodd += '<div class="form-group"><label for="einvno">E Inv No</label>';
        methodd += '<input type="text" class="form-control" id="einvno" placeholder="E Inv No" value=""></div>';
        methodd += '<div class="form-group"><label for="invno">Inv No</label>';
        methodd += '<input type="text" class="form-control" id="invno" placeholder="Inv No" value=""></div>';
        methodd += '</div></form>';

        methodd_footer ='';
        methodd_footer += '<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>';
        methodd_footer += '<button type="submit" id="updateButtonfunc" class="btn btn-primary">Update</button>';

        modal.find('.modal-footer').html(methodd_footer);
        modal.find('.modal-body').html(methodd);

        $.ajax({
          url: "<?php echo site_url('Testing/get_row_data'); ?>" ,
          type: 'POST',
          data: { refno: refno },
          dataType: 'json',
          success: function (data) {
              // Populate the edit modal with user data
              //$('#user_id').val(data.edit_user_id);
              $('#refno').val(data.refno);
              $('#einvno').val(data.einvno);
              $('#invno').val(data.invno);
          }
        });
    });

    $(document).on('click','#updateButtonfunc',function(){
        
      var refno = $('#refno').val();
      var einvno = $('#einvno').val();
      var invno = $('#invno').val();

      confirmation_modal('Are you sure want to Update Data?');
      
      $(document).off('click', '#confirmation_yes').on('click', '#confirmation_yes', function(){
        // Send Ajax request to update the record
        $.ajax({
            url: "<?php echo site_url('Testing/update_row_data'); ?>",
            type: 'POST',
            data: {
              refno:refno,
              einvno:einvno,
              invno:invno
            },
            success: function (data) {
              var response = JSON.parse(data);
              //console.log('Server Response:', response);  
              if (response.status === 'success') {
                $('#alertmodal').modal('hide');
                toastr.success('Data updated successfully!');
                table.ajax.reload(null, false);
                // Hide the edit modal after DataTable reload is complete
                $('#large-modal').modal('hide');
              }
            }
        });
      });
    });

    $(document).on('click', '#deleterefno_btn', function () {
      var refno = $(this).attr('refno');

      confirmation_modal('Are you sure want to Delete Data?');
      $(document).off('click', '#confirmation_yes').on('click', '#confirmation_yes', function(){
           $.ajax({
            url: "<?php echo site_url('Testing/delete_row_data');?>",
            method: "POST",
            data: { refno: refno },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.status) {
                    // Success: Handle UI changes or notifications
                    toastr.success('Data deleted successfully!');
                    $('#alertmodal').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    // Failure: Handle error notifications
                    alert("Error");
                    $('#alertModal').modal('hide');
                }
            },
            error: function () {
                // Error: Handle error notifications
                alert("An error occurred while deleting the data. Please try again.");
            }
          });
      });
    });

  });

</script>