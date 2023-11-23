
<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('tcpdf/tcpdf.php');



class tcpdf_new extends TCPDF {

  //Page header
  public function Header() {

$com = new Panda("");
$test = $com->get_serverdb();


$conn = new mysqli($test['servername'],$test['username'],$test['password'],$test['dbname']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
        

        $this->SetFont('helvetica', '', 9.5);
        ob_start();
        $html = '<p style="text-align:right;font-size: 7px;">Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages().'</p>
        <p style="text-align:right;font-size: 7px;">printed on : '.date('Y-m-d H:i:s').'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>

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
              
              <b>haha</b>
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              <b>haha </b>
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              Co Reg No: haha  
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              
              Co Reg No: haha
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              <table>
                
                <td>haha
                <br>haha
                <br>haha
                <br>haha
                </td>

              </table>
              
              
            </td>

            <td style="border-left: 1px solid black;border-right: 1px solid black;">
              <table>
                
                <td>haha
                <br>haha
                <br>haha
                <br>haha<br>
                </td>

              </table>
              
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><br><br><b>Tel:</b> 123456 <b>  Fax:</b> 123456</td>

              </table>
              
              
            </td>

             <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><br><br><b>Tel:</b> 111111 <b>  Fax:</b> 111111</td>

              </table>
              
              
            </td>

          </tr>

          <tr>
            
            <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td><b>Sup Code:</b> aa - aa <b><br>Received Loc:</b> aa - aa</td>

              </table>
              
              
            </td>

             <td style="border-left: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;">
              
              <table>
                
                <td colspan="2"><b>Tax Invoice No:</b> aa <b><br>Delivery Order:</b> aa </td>

                <td  ><b>Invoice Date:</b> aa <b><br>Ref No:</b> aa </td>

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
                  
                  <td  style="height:60px;border: 1px solid black;padding:0;" nowrap=""><p style=""> </p><p style="font-size:12px;text-align: center;"><b>E-Invoice</b></p></td>



                </tr>

         <tr>

                  <td style="height:60px; text-align: center; border: 1px solid black;" colspan="2"><p style="text-align:left;"> Inv No</p><p style="font-size:12px;"><b>aa</b></p></td>


                </tr>


        </tbody>
      
        </table>


  </td>
</tr>

    </table>
    ';


        $this->WriteHTML($html, true, 0, true, 0);
  ob_end_clean();
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



   // Make more space in footer for additional text
    $this->SetY(-25);


  //   $this->SetFont('helvetica', 'I', 8);

  //       ob_start();
  //       $html = '<table border="1">
  //       <thead>
  //       <tr style ="text-align:center;">
  //           <th style="width:23.32%;border-radius: 15px 50px 30px 5px;"><b>Barcode / Itemcode</b></th>
  //           <th style="width:23.66%;"><b>Description</b></th>
  //           <th style="width:6.66%;"><b>Packsize</b></th>
  //           <th style="width:6.66%;"><b>Unit Price</b></th>
  //           <th style="width:6.66%;"><b>Discount Description</b></th>
  //           <th style="width:6.66%;"><b>Discount Amt</b></th>
  //           <th style="width:6.66%;"><b>Total Bill Disc Prorated</b></th>
  //           <th style="width:6.66%;"><b>Quantity</b></th>
  //           <th style="width:6.66%;"><b>Total Amt Exclude Tax</b></th>
  //           <th style="width:6.66%;"><b>Total Amount Include Tax</b></th>
  //       </tr>
  //       </thead>
  //       <tbody>
  //       <tr style ="text-align:center;background-color:red;" nobr="true">
  //               <td style="width:23.32%;"><b>Barcode / Itemcode</b></td>
  //               <td style="width:23.66%;"><b>Description</b></td>
  //               <td style="width:6.66%;"><b>Packsize</b></td>
  //               <td style="width:6.66%;"><b>Unit Price</b></td>
  //               <td style="width:6.66%;"><b>Discount Description</b></td>
  //               <td style="width:6.66%;"><b>Discount Amt</b></td>
  //               <td style="width:6.66%;"><b>Total Bill Disc Prorated</b></td>
  //               <td style="width:6.66%;"><b>Quantity</b></td>
  //               <td style="width:6.66%;"><b>Total Amt Exclude Tax</b></td>
  //               <td style="width:6.66%;"><b>Total Amount Include Tax</b></td>
  //           </tr>
  //           </tbody>
  //           </table>
  //   ';


  //       $this->WriteHTML($html, true, 0, true, 0);
  // ob_end_clean();


    // // Page number
    //     $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

    // // New line in footer
    // $this->Ln(0);

    // // First line of 3x "sometext"
    // $this->MultiCell(55, 10, 'Issued on', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    // $this->MultiCell(55, 10, date('Y-m-d') , 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    // $this->MultiCell(55, 10, 'gaga', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    // // New line for next 3 elements
    // $this->Ln(10);

    // // Second line of 3x "sometext"
    // $this->MultiCell(55, 10, 'Posted on', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    // $this->MultiCell(55, 10, date('Y-m-d')  , 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
    // $this->MultiCell(55, 10, 'gaga', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');

    // $this->MultiCell(500, 40, 'Prepared by _____________  Checked by _____________  Approved by _____________  Accepted by _____________', 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
  }
}

/* End of file Pdfheaderfooter.php */