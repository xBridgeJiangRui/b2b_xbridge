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

</script>

<script type="text/javascript">

interval = function(){
  var interval =  setInterval(function(){
      $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust();

     clearInterval(interval);
    }, 300);//adjust the table column;
};

$(function () {
  //Initialize Select2 Elements
  $(".select2").select2()

  // $('.select2').select2({
  //   theme: 'bootstrap4'
  // })

  $('.datepicker').datetimepicker({
    forceParse: false,
    autoclose: true,
    todayHighlight: true,
    format: 'Y-MM-DD'
  });

  $('.timepicker').datetimepicker({
    format: 'HH:mm'
    // format : 'LT' // AM & PM 
  })

  $('.datetimepicker').datetimepicker({ 
    forceParse: false,
    autoclose: true,
    todayHighlight: true,
    format: 'YYYY-MM-DD HH:mm:ss',
    icons: { 
      time: 'far fa-clock'
    }
  });

  //Date range picker
  $('.drangepicker').daterangepicker({
    locale: {
      format: 'Y-MM-DD'
    }
  });

  //Date range picker with time picker
  $('.dtrangepicker').daterangepicker({
    timePicker: true,
    locale: {
      format: 'YYYY-MM-DD HH:mm:ss'
    }
  });

})

$(document).ready(function() {

  $(document).on('click','#open_log_ticket',function(){
    $('.btn-group-fab').toggleClass('active');
  });

  $('has-tooltip').tooltip();

  button_variable = '';

  button_variable += '<div class="btn-group-fab active" role="group" aria-label="FAB Menu"> <div>  ';

  button_variable+= '<button type="button" class="btn btn-main btn-primary has-tooltip" id="open_log_ticket" data-placement="left" title="More"> <i class="fa fa-plus"></i> </button>';

  button_variable+='<button type="button" class="btn btn-sub btn-info has-tooltip" data-placement="left" onclick="openForm()" title="Open Ticket"><i class="ion ion-chatbubbles"></i> </button>';

  <?php
  if(isset($activity_logs_section))
  {
  ?>

    button_variable+=' <button type="button" class="btn btn-sub btn-danger has-tooltip" data-placement="left" title="Logs" id="activity_logs_button" section="<?=$activity_logs_section;?>"> <i class="fa fa-bars"></i> </button> ';
  <?php
  }
  else
  {
  ?>

    button_variable+=' <button type="button" class="btn btn-sub btn-danger has-tooltip" data-placement="left" title="Activity logs" id="activity_logs_button" section=""> <i class="fa fa-bars"></i> </button> ';

  <?php
  }
  ?>

  button_variable += '</div> </div>';

  <?php if($this->uri->segment(1) != 'login_c')
  {
  ?>
    $('body').append(button_variable);
  <?php
  }
  ?>

  start = 0;
  end = 10;

  $(document).on('click','#activity_logs_button',function(){

    $('#activity_box').show();

    <?php
    if(isset($activity_logs_section))
    {
    ?>
      if(start>0)
      {
        return;
      }

      <?php
      if(isset($_REQUEST['loc']))
      {
      ?>
        var loc = '<?= $_REQUEST["loc"];?>';
      <?php
      }
      else
      {
      ?>
        var loc = 'HQ';
      <?php
      }
      ?>

      var section = $(this).attr('section');

      $.ajax({

          url:"<?php echo site_url('User_log/logs');?>",
          method:"POST",
          data:{section:section,start:start,end:end,loc:loc},
          beforeSend:function()
          { 
            loading_li = 1;
            // $('.btn').button('loading');
            html = ''

            html += '<li class="notification_spinner"><a><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></a></li>'

            $("#activity_box_body").append(html);
            
          },
          success:function(data)
          {

            json = JSON.parse(data);

            if(json['logs'] == '')
            { 
              $('#activity_box').find('#activity_box_body').html('<label>No activities recently...</label>');

              $('#activity_box_body .notification_spinner').remove();
              
              loading_li = 0;
            }
            else
            {
              $('#activity_box').find('#activity_box_body').html(json['logs']);

              $('#activity_box_body .notification_spinner').remove();

              loading_li = 0;
            }
          }//close success
      });//close ajax
    <?php
    }
    else
    {
    ?>

      $('#activity_box').find('#activity_box_body').html('<label>No activities recently...</label>');

      $('#activity_box_body .notification_spinner').remove();
      
      loading_li = 0;

    <?php
    }
    ?>

  });//close activity_logs_button

  loading_li = 0;
  final_stop = 0;

  $("#activity_box_body").on( 'scroll', function(){
    console.log('Event Fired');

    // alert($(this).scrollTop()+$(this).innerHeight()+50'--'+$(this)[0].scrollHeight);

    if($(this).scrollTop() + $(this).innerHeight() + 50 >= $(this)[0].scrollHeight) {

      <?php
      if(isset($activity_logs_section))
      {
      ?>
        var section = '<?=$activity_logs_section;?>';
      <?php
      }
      else
      {
      ?>
        var section = '';
      <?php
      }
      ?>
      


      // end = start;

      if(loading_li == 0)
      {


        <?php
        if(isset($_REQUEST['loc']))
        {
        ?>
          var loc = '<?= $_REQUEST["loc"];?>';
        <?php
        }
        else
        {
        ?>
          var loc = 'HQ';
        <?php
        }
        ?>
        if(final_stop == 0)
        {
        $.ajax({

            url:"<?php echo site_url('User_log/logs');?>",
            method:"POST",
            data:{section:section,start:start,end:end,loc:loc},
            beforeSend:function()
            { 
              loading_li = 1;
              // $('.btn').button('loading');
              html = ''

              html += '<li class="notification_spinner"><a><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></a></li>'

              $("#activity_box_body").append(html);
              
            },
            success:function(data)
            {

              json = JSON.parse(data);
              console.log(json['haha']);
              if(json['logs'] != '' && json['logs'] != null)
              {
                setTimeout(function(){
                  $('#activity_box').find('#activity_box_body').append(json['logs']);

                  $('#activity_box_body .notification_spinner').remove();

                  loading_li = 0;
                  start = start+end;
                },300);//close time out
              }
              else
              {
                final_stop = 1;
                $('#activity_box_body .notification_spinner').remove();

                  loading_li = 0;
              }


              

            }//close success
        });//close ajax
      }//close final_stop

      }

    }//close if

  });

  $(document).on('click','#cancel_button',function(){

    $(this).closest('div.chat-popup').hide();

  });//close cancel_button

  $(document).on('show.bs.modal', '.modal', function (e) {

    if (e.namespace === 'bs.modal') {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    }
    
  });

  <?php
  if(isset($activity_logs_section))
  {
  ?>
      setTimeout(function(){
        $('#activity_logs_button').click();
      },300);
  <?php
  }
  ?>

  $(document).on('click','#cancel_button',function(){

    $(this).closest('div.chat-popup').hide();

    $.ajax({
      url:"<?php echo site_url('General/create_close_notification');?>",
      method:"POST",
      success:function(data)
      { 
        json = JSON.parse(data);

      }//close succcess
    });//close ajax

  });//close cancel_button

  $(document).on('click','#cancel_button',function(){

    $(this).closest('div.chat-popup').hide();

  });//close cancel_button

});
</script>