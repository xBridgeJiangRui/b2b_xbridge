  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-block">
      Policy:&nbsp;<a href="https://b2b.xbridge.my/admin_files/Privacy%20Policy%20(ENGLISH).pdf" target="_blank">(EN)</a> <a href="https://b2b.xbridge.my/admin_files/Privacy%20Policy%20(BM).pdf" target="_blank">(BM)</a>&nbsp;<span data-toggle="modal" data-target="#contactus"><b style="cursor:pointer">Contact Us</b></span>&nbsp<img src="<?php echo base_url('asset/dist/img/rexbridge.JPG');?>" class="img-circle" alt="User Image" style="height: 32px">
    </div>
    <strong>Copyright &copy; 2023 <a href="https://www.xbridge.my/"></a>Rexbridge Sdn. Bhd.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">  -->
    <!-- Control sidebar content goes here -->
  <!-- </aside> -->
  <!-- /.control-sidebar -->

<!-- Modal Here -->
<!-- Large-Modal -->
<div class="modal fade" id="large-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive modal-control-size">
        
      </div>
      <div class="modal-footer justify-content-between">
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal-alert -->
<div class="modal fade" id="alertmodal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <p class="icons"></p><br>
          <p class="msg"></p>                    
        </center>
      </div>
      <div class="modal-footer button">

      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

  <!-- All Script for footer user -->
  <?php 
  $ticket_topic = $this->db->query("SELECT * FROM ticket_topic ORDER BY name ")->result();

  $super_admin = $this->db->query("SELECT * FROM lite_b2b.set_user WHERE user_group_guid IN ('3379ECDBDB0711E7B504A81E8453CCF0') AND user_id LIKE '%xbridge%' AND isactive = '1' GROUP BY user_guid ORDER BY user_name ASC")->result();

  $supplier_name = $this->db->query("SELECT * FROM lite_b2b.set_supplier WHERE isactive = '1' ORDER BY supplier_name ")->result();

  if($this->session->userdata('customer_guid') == '' || $this->session->userdata('customer_guid') == null)
  {
    $retailer_name = $this->db->query("SELECT DISTINCT e.logo,d.acc_guid,e.acc_name,e.seq FROM `set_user` AS a 
    INNER JOIN `set_user_branch` b ON a.user_guid = b.user_guid
    INNER JOIN `acc_branch` c ON b.branch_guid = c.branch_guid 
    INNER JOIN `acc_concept` d ON c.concept_guid = d.concept_guid 
    INNER JOIN `acc` e ON d.`acc_guid` = e.`acc_guid` 
    WHERE a.user_id = '".$_SESSION['userid']."' 
    AND e.isactive = '1' 
    AND a.module_group_guid = '".$_SESSION['module_group_guid']."' 
    ORDER BY e.seq asc,e.row_seq ASC" )->result() ;
  }
  else
  {
    $retailer_name =  $this->db->query("SELECT DISTINCT e.logo,d.acc_guid,e.acc_name,e.seq FROM `set_user` AS a 
    INNER JOIN `set_user_branch` b ON a.user_guid = b.user_guid
    INNER JOIN `acc_branch` c ON b.branch_guid = c.branch_guid 
    INNER JOIN `acc_concept` d ON c.concept_guid = d.concept_guid 
    INNER JOIN `acc` e ON d.`acc_guid` = e.`acc_guid` 
    WHERE a.user_id = '".$_SESSION['userid']."' 
    AND e.isactive = '1' 
    AND a.module_group_guid = '".$_SESSION['module_group_guid']."' 
    AND e.acc_guid = '".$this->session->userdata('customer_guid')."'
    ORDER BY e.seq asc,e.row_seq ASC" )->result() ;
  }

  ?>
  <!-- End Script here -->

  <div class="chat-popup" id="activity_box" style="width:300px;background-color: white;bottom:50px;">
    <h3 style="margin-top: 10px"><i class="fa fa-info-circle" aria-hidden="true"></i>Activities</h3>
      <div class="box-body">
        <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
        <ul class="todo-list ui-sortable" style="max-height: 400px;overflow-y: scroll;" id="activity_box_body">
        </ul>
      </div>
    <button type="button" id="cancel_button" class="btn btn-block btn-danger" style="border: none;border-radius: 0;">Close</button>
  </div>

  <div class="chat-popup" id="chat_box" style="max-height: 100% ; overflow-y: auto;">
    <form action="<?php echo site_url('Ticket/user_open_ticket') ?>" class="form-container" method="post" id="chat" enctype="multipart/form-data">
      <h4 style="margin-top: 0px"><i class="fa fa-ticket" aria-hidden="true"></i>Create Ticket</h4>

      <div class="tooltip9">
        <i class="fa fa-question-circle"></i>
        <span class="tooltiptext">In order for us to serve you better, here is where you can directly contact us about the issue you had faced. If you can't find any category that is related to your issue, kindly let us know. Thanks for cooperation.</span>
      </div>

      <div class="form-group">
        <label for="acc_guid">Retailer</label>
        <select class="form-control" name="acc_guid" id="acc_guid" required>
          <option value="">-Select-</option>
          <?php foreach ($retailer_name as $key) { ?>
            <option value="<?php echo $key->acc_guid ?>"><?php echo $key->acc_name ?></option>
          <?php } ?>
        </select>

        <label for="supplier_guid">Supplier</label>
        <select class="form-control" name="supplier_guid" id="supplier_guid" required>
          <option value="">-Select-</option>
        </select>

        <label for="topic_guid">Category</label>
        <select class="form-control" name="topic_guid" id="topic_guid" required>
          <option value="">-Select-</option>
          <?php foreach ($ticket_topic as $key) { ?>
            <option value="<?php echo $key->t_topic_guid ?>"><?php echo $key->name ?></option>
          <?php } ?>
        </select>

        <label for="sub_topic_guid">Sub Category</label>
        <select class="form-control" name="sub_topic_guid" id="sub_topic_guid" required>
          <option value="">-Please Pick Topic-</option>
        </select>

        <?php if ($_SESSION['user_group_name'] == 'SUPER_ADMIN') { ?>

        <label for="topic_guid">Staff(Admin)</label>
        <select class="form-control" name="assigned_guid" id="assigned_guid" >
          <option value="">-Select-</option>
          <?php foreach ($super_admin as $key) { ?>
            <option value="<?php echo $key->user_guid ?>"><?php echo $key->user_name .'-'.$key->user_id ?></option>
          <?php } ?>
        </select>

        <?php } ?>

      </div>

      <label for="ticket_summernote_message" id="msg"><b>Message</b></label>
      <textarea class="summernote_textarea_ticket" style="min-height: 60px;" placeholder="Message.." name="messages" id="ticket_summernote_message" required="required"></textarea>

      <div class="upload" style="margin-bottom: 10px;">
        <span class="btn btn-default btn-file"> Choose Files <input type="file" id="uploadBtn" name="myFile[]" multiple /></span>
        <ul id="myFile" style="list-style: decimal;"></ul>
      </div>

      <button id="submit_ticket" type="submit" name="submit" class="btn_chat">Submit</button>
      <button type="button" class="btn_chat cancel" onclick="closeForm()">Close</button>
    </form>
  </div>
  
</div>



<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('asset/plugins/jquery/jquery.min.js')?>"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>

<!-- Select2 -->
<script src="<?php echo base_url('asset/plugins/select2/js/select2.full.min.js')?>"></script>

<!-- InputMask -->
<script src="<?php echo base_url('asset/plugins/moment/moment.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/inputmask/jquery.inputmask.min.js')?>"></script>

<!-- date-range-picker -->
<script src="<?php echo base_url('asset/plugins/daterangepicker/daterangepicker.js')?>"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')?>"></script>

<!-- ChartJS -->
<script src="<?php echo base_url('asset/plugins/chart.js/Chart.min.js')?>"></script>

<!-- FLOT CHARTS -->
<script src="<?php echo base_url('asset/plugins/flot/jquery.flot.js')?>"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="<?php echo base_url('asset/plugins/flot/plugins/jquery.flot.resize.js')?>"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="<?php echo base_url('asset/plugins/flot/plugins/jquery.flot.pie.js')?>"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url('asset/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>

<script src="<?php echo base_url('asset/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?php echo base_url('asset/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>

<!-- AdminLTE App -->
<script src="<?php echo base_url('asset/dist/js/adminlte.min.js')?>"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url('asset/dist/js/demo.js')?>"></script> -->

<!-- Toastr -->
<link rel="stylesheet" href="<?php echo base_url('asset/plugins/toastr/toastr.min.css')?>">
<script src="<?php echo base_url('asset/plugins/toastr/toastr.min.js')?>"></script>

</body>
</html>

<script>

alertmodal = function(data)
{
  $("#alertmodal").modal();
  $('#alertmodal .button').html('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
  $('#alertmodal .icons').html('<i class="fa fa-exclamation-circle fa-5x" style="color:red;"></i>');
  $('#alertmodal .msg').html(data);
  $('#alertmodal .modal-title').html('Information');
};

confirmation_modal = function(data)
{
  $("#alertmodal").modal();
  $('#alertmodal .button').html('<button type="button" class="btn btn-danger pull-right btn-gap" data-dismiss="modal" style="float:left">No</button><button type="button" class="btn btn-success pull-right btn-gap" id="confirmation_yes" style="margin-right:5px;">Yes</button>');
  $('#alertmodal .icons').html('<i class="fa fa-question fa-5x"></i>');
  $('#alertmodal .msg').html(data);
  $('#alertmodal .modal-title').html('Confirmation');
};

informationalertmodal = function(button,icons,msg,title)
{
  var modal = $("#alertmodal").modal();
  modal.find('.button').html(button);
  modal.find('.icons').html(icons);
  modal.find('.msg').html(msg);
  modal.find('.modal-title').html(title);
  $('.btn').button('loading');
}

function openForm() 
{
  document.getElementById("chat_box").style.display = "block";
}

function closeForm()
{
  acc_guid = $('#acc_guid').val();
  supp_guid = $('#supplier_guid').val();
  topic_guid = $('#topic_guid').val();
  sub_topic_guid = $('#sub_topic_guid').val();
  msg = $('#msg').val();
  uploadBtn = $('#uploadBtn').val();
  status = $('#status').val();

  if(acc_guid !== '' || supp_guid !== '' || topic_guid !== '' || sub_topic_guid !== '' || msg !== '' || uploadBtn !== '' || status !== '')  
  {
    var test = confirm('Are you sure to exit?');
    {
      if (test == true)
      {
        document.getElementById("chat").reset();
        document.getElementById("chat_box").style.display = "none";
        document.getElementById("myFile").style.display = "none";
        location.reload();
        return true;
      }
      else
      {
        return false;
        //document.getElementById("chat_box").style.display = "block";
      }
    }
  }
  else
  {
    document.getElementById("chat_box").style.display = "none";
  }
}

function loadingButton($class,$id)
{
  $value = $class+$id;
  $($value).prop('disabled', true);
  // $($value).text('Loading...');
}

function resetButton($class,$id)
{
  $value = $class+$id;
  $($value).prop('disabled', false);
  // $($value).text($get_attr_value);
}

</script>

