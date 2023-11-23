
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('tcpdf/tcpdf.php');



class Pdf_invoice_new extends TCPDF {

  //Page header
  public function Header() {

$com = new Panda("");
$test = $com->get_serverdb();


$conn = new mysqli($test['servername'],$test['username'],$test['password'],$test['dbname']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


if(isset($_REQUEST['trans']))
{
  $refno = $_REQUEST['trans'];
  $customer_guid = $_SESSION['customer_guid'];

// $header_customer_guid = "SELECT customer_guid FROM b2b_summary.einv_main WHERE refno = '$refno' ";
// $result = $conn->query($header_customer_guid);
// $header_customer_guid = $result->fetch_assoc();


// $header_customer_info = "SELECT BRANCH_CODE,BRANCH_NAME,REPLACE(BRANCH_ADD,'\n','<br>') AS BRANCH_ADD, BRANCH_TEL, BRANCH_FAX,comp_reg_no , gst_no FROM backend.`cp_set_branch` JOIN (SELECT comp_reg_no , gst_no FROM backend.`companyprofile` LIMIT 1 )a ";
// $result = $conn->query($header_customer_info);
// $header_customer_info = $result->fetch_assoc();



$url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

$to_shoot_url = $url."/Select/S_einv_main";
// $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
$data = array(
    'customer_guid' => $customer_guid,
    'refno' => $refno,
);

$cuser_name = 'ADMIN';
$cuser_pass = '1234';

$ch = curl_init($to_shoot_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$output = json_decode($result);
// $status = json_encode($output);
// print_r($output->result);die;
// echo $result;die;
//close connection
curl_close($ch);  
// echo $output->status;
// die;

if($output->status == "true")
{
    $header = $output->result;
}
else
{
    $header = $output->result;
} 


// $header = "SELECT * FROM b2b_summary.einv_main WHERE refno = '$refno' ";
// $result = $conn->query($header);
// $header = $result->fetch_assoc();



// $customer_hq_branch_info = "SELECT * FROM b2b_summary.cp_set_branch WHERE SET_SUPPLIER_CODE = 'HQ' AND SET_CUSTOMER_CODE = 'HQ' ";
// $result = $conn->query($customer_hq_branch_info);
// $customer_hq_branch_info = $result->fetch_assoc();


$url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

$to_shoot_url = $url."/Select/S_gr_info";
// $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
$data = array(
    'customer_guid' => $customer_guid,
    'refno' => $refno,
);

$cuser_name = 'ADMIN';
$cuser_pass = '1234';

$ch = curl_init($to_shoot_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$output = json_decode($result);
// $status = json_encode($output);
// print_r($output->result);die;
// echo $result;die;
//close connection
curl_close($ch);  
// echo $output->status;
// die;

if($output->status == "true")
{
    $gr_info = $output->result;
}
else
{
    $gr_info = $output->result;
} 

// echo $gr_info[0]->Location;die;

$url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

$to_shoot_url = $url."/Select/S_supcus_customer";
// $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
$data = array(
    'customer_guid' => $customer_guid,
    'loc' => $gr_info[0]->Location,
    // 'loc' => 'T990',
);

$cuser_name = 'ADMIN';
$cuser_pass = '1234';

$ch = curl_init($to_shoot_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$output = json_decode($result);
// $status = json_encode($output);
// print_r($output->result);die;
// echo $result;die;
//close connection
curl_close($ch);  
// echo $output->status;
// die;

if($output->status == "true")
{
    $supcus_customer = $output->result;
}
else
{
    $supcus_customer = $output->result;
} 

// $supcus_customer = "SELECT * FROM b2b_summary.supcus WHERE Code = '".$gr_info[0]->Location."' ";
// $result = $conn->query($supcus_customer);
// $supcus_customer = $result->fetch_assoc();

$url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

$to_shoot_url = $url."/Select/S_supcus_setting";
// $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
$data = array(
    'customer_guid' => $customer_guid,
    'code' => $gr_info[0]->Code,
);

$cuser_name = 'ADMIN';
$cuser_pass = '1234';

$ch = curl_init($to_shoot_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$output = json_decode($result);
// $status = json_encode($output);
// print_r($output->result);die;
// echo $result;die;
//close connection
curl_close($ch);  
// echo $output->status;
// die;

if($output->status == "true")
{
    $supcus_supplier = $output->result;
}
else
{
    $supcus_supplier = $output->result;
} 
// echo $supcus_supplier[0]->Name;die;
// echo $gr_info[0]->Location;die;
// $supcus_supplier = "SELECT * FROM b2b_summary.supcus WHERE Code = '".$gr_info[0]->Code."' ";
// $result = $conn->query($supcus_supplier);
// $supcus_supplier = $result->fetch_assoc();

$url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

$to_shoot_url = $url."/Select/S_cp_set_branch";
// $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
$data = array(
    'customer_guid' => $customer_guid,
    'check_loc' => $gr_info[0]->Location,
);

$cuser_name = 'ADMIN';
$cuser_pass = '1234';

$ch = curl_init($to_shoot_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
curl_setopt($ch, CURLOPT_TIMEOUT, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
$output = json_decode($result);
// $status = json_encode($output);
// print_r($output->result);die;
// echo $result;die;
//close connection
curl_close($ch);  
// echo $output->status;
// die;

if($output->status == "true")
{
    $customer_branch_info = $output->result;
}
else
{
    $customer_branch_info = $output->result;
} 

// $customer_branch_info = "SELECT * FROM b2b_summary.cp_set_branch WHERE BRANCH_CODE = '".$gr_info[0]->Location."' ";
// // $customer_branch_info = "SELECT * FROM b2b_summary.cp_set_branch WHERE BRANCH_CODE = '".$gr_info[0]->Location."' ";
// $result = $conn->query($customer_branch_info);
// $customer_branch_info = $result->fetch_assoc();

 if($header[0]->einvno != $header[0]->invno)
 {
  $ori_inv = '<br><b>['.$header[0]->invno.']</b>';
 }
        $this->SetFont('helvetica', '', 9.5);
        ob_start();


        $html = '
<table class="table table-striped" cellspacing="0" cellpadding="0" style="border-collapse: collapse; width: 100%;">
<tr>
<td style="width: 80%;text-align: left">
        
       <table cellspacing="0" cellpadding="0">
         
        <tbody>
          
          <tr>
            
            <td style="border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
              
              Purchase from Registered GST Supplier

            </td>

            <td style="border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
              
              Goods Received Note Issued by

            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              <b>'.$supcus_supplier[0]->Name.'</b>
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              <b>'.$customer_branch_info[0]->BRANCH_NAME.' </b>
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              Co Reg No: '.$supcus_supplier[0]->reg_no.'  
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              Co Reg No: '.$supcus_customer[0]->reg_no.'  
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              <table>
                
                <td>'.$supcus_supplier[0]->Add1.'
                <br>'.$supcus_supplier[0]->Add2.'
                <br>'.$supcus_supplier[0]->Add3.'
                <br>'.$supcus_supplier[0]->Add4.'<br>
                </td>

              </table>
              
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              <table>
                
                <td>'.$customer_branch_info[0]->BRANCH_ADD.'<br>
                </td>

              </table>
              
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><br><br><b>Tel:</b> '.$supcus_supplier[0]->Tel.' <b>  Fax:</b> '.$supcus_supplier[0]->Fax.'</td>

              </table>
              
              
            </td>

             <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><br><br><b>Tel:</b> '.$customer_branch_info[0]->BRANCH_TEL.' <b>  Fax:</b> '.$customer_branch_info[0]->BRANCH_FAX.'</td>

              </table>
              
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><b>Sup Code:</b> '.$gr_info[0]->Code.' - '.$gr_info[0]->Name.' <b><br>Received Loc:</b> '.$gr_info[0]->Location.' - '.$supcus_customer[0]->Name.'</td>

              </table>
              
              
            </td>

             <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td colspan="2"><b>Tax Invoice No:</b> '.$header[0]->invno.' <b><br>Delivery Order:</b> '.$header[0]->dono.'</td>

                <td  ><b>Invoice Date:</b> '.$header[0]->inv_date.' <b><br>Ref No:</b> '.$header[0]->refno.'</td>

              </table>
              
              
            </td>

          </tr>

        </tbody>

       </table>
 
   
       
  
</td>
<td style="width: 20%;">


        
        <table id="right-table"  border="0" cellspacing="0" cellpadding="0" style="width: 100%;height:500px;">
        
        <tbody style="height:500px;"> 
                <tr>
                  
                  <td  style="height:60px;border: 1px solid black;" nowrap=""><p style=""> </p><p style="font-size:12px;text-align: center;"><b>E-Invoice</b></p></td>



                </tr>

         <tr>

                  <td style="height:60px; text-align: center; border: 1px solid black;" colspan="2"><p style="text-align:left;"> Inv No</p><p style="font-size:12px;"><b>'.$header[0]->einvno.'</b>'.$ori_inv.'</p></td>


                </tr>


        </tbody>
      
        </table>


  </td>
</tr>

    </table>
    ';


        $this->WriteHTML($html, true, 0, true, 0);
        ob_end_clean();
      }//close isset
  
  }
 
  // Page footer
  public function Footer() {

$com = new Panda("");
$test = $com->get_serverdb();

// Create connection
$conn = new mysqli($test['servername'],$test['username'],$test['password'],$test['dbname']);    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    

    if(isset($_REQUEST['trans']))
    {
      $refno = $_REQUEST['trans'];
    }
    else
    {
      $refno = $this->RefNo;
    }

    $customer_guid = $_SESSION['customer_guid'];

    // $header_customer_guid = "SELECT customer_guid FROM b2b_summary.einv_main WHERE refno = '$refno' ";
    // $result = $conn->query($header_customer_guid);
    // $header_customer_guid = $result->fetch_assoc();

    $url = '127.0.0.1/PANDA_GITHUB/rest_b2b/index.php/';

    $to_shoot_url = $url."/Select/S_einv_main";
    // $block = $this->db->query("SELECT * FROM set_setting WHERE module_name = 'CONSIGNMENT' AND code = 'CONS' LIMIT 1");
    $data = array(
        'customer_guid' => $customer_guid,
        'refno' => $refno,
    );

    $cuser_name = 'ADMIN';
    $cuser_pass = '1234';

    $ch = curl_init($to_shoot_url);
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . "CODEX1234" ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Api-KEY: 123456"));
    curl_setopt($ch, CURLOPT_USERPWD, "$cuser_name:$cuser_pass");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec($ch);
    $output = json_decode($result);
    // $status = json_encode($output);
    // print_r($output->result);die;
    // echo $result;die;
    //close connection
    curl_close($ch);  
    // echo $output->status;
    // die;

    if($output->status == "true")
    {
        $header = $output->result;
    }
    else
    {
        $header = $output->result;
    } 

    // $header = "SELECT * FROM b2b_summary.einv_main WHERE refno = '$refno' ";
    // $result = $conn->query($header);
    // $header = $result->fetch_assoc();

   // Make more space in footer for additional text
    $this->SetY(-25);

    // CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
/*$this->Cell(0, 0, $refno, 0, 1);
$this->write1DBarcode($refno, 'C39', '', '', '', 300, 2, $style, 'N');*/

    $this->SetFont('helvetica', 'I', 8);

    // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

    // New line in footer
    $this->Ln(0);

    // First line of 3x "sometext"
    $this->MultiCell(55, 10, 'Issued on', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $this->MultiCell(55, 10, (count($header) > 0 ? $header[0]->created_at : '')  , 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $this->MultiCell(55, 10, (count($header) > 0 ? $header[0]->created_by : ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    // New line for next 3 elements
    $this->Ln(10);

    // Second line of 3x "sometext"
    $this->MultiCell(55, 10, 'Posted on', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $this->MultiCell(55, 10, (count($header) > 0 ? $header[0]->posted_at : '')  , 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    $this->MultiCell(55, 10, (count($header) > 0 ? $header[0]->posted_by : ''), 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    $this->MultiCell(500, 40, 'Prepared by _____________  Checked by _____________  Approved by _____________  Accepted by _____________', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
  }
}

/* End of file Pdfheaderfooter.php */
