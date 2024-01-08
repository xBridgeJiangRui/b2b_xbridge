<style>
.content-wrapper{
  min-height: 800px !important; 
}

/* Smaller Filtering Content Section */
.filtering-section {
    padding: 10px;
  }
  

</style>
<!-- BS Stepper -->
<link rel="stylesheet" href="../../asset/plugins/bs-stepper/css/bs-stepper.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    </div>
    <!-- Filtering content -->
    <!-- Default box -->
    <br>
    <div class="col-md-12" style="padding-left: 50px; padding-right: 50px;">
      <div class="card card-default">
          <div class="card-header">
              <h3 class="card-title">Form</h3>
          </div>
          <div class="card-body p-0">
              <div class="bs-stepper linear">
                  <div class="bs-stepper-header" role="tablist">
                      <div class="step active" data-target="#retailer-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="retailer-part" id="retailer-part-trigger" aria-selected="true">
                              <span class="bs-stepper-circle">1</span>
                              <span class="bs-stepper-label">Retailer Information</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#supplier-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="supplier-part" id="supplier-part-trigger" aria-selected="false" disabled="disabled">
                              <span class="bs-stepper-circle">2</span>
                              <span class="bs-stepper-label">Supplier Information</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#user-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="user-part" id="user-part-trigger" aria-selected="false" disabled="disabled">
                              <span class="bs-stepper-circle">3</span>
                              <span class="bs-stepper-label">User Information</span>
                          </button>
                      </div>
                      <div class="line"></div>
                      <div class="step" data-target="#bank-part">
                          <button type="button" class="step-trigger" role="tab" aria-controls="bank-part" id="bank-part-trigger" aria-selected="false" disabled="disabled">
                              <span class="bs-stepper-circle">4</span>
                              <span class="bs-stepper-label">Bank Information</span>
                          </button>
                      </div>
                  </div>
            <!--------------------------------------------FORM-------------------------------------------------->      
                  <div class="bs-stepper-content">
                      <div id="retailer-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="retailer-part-trigger">
                          <div class="form-group">
                              <label for="retailer_name">Retailer Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="retailer_name" placeholder="Enter Retailer Name" required/>
                          </div>
                          <div class="form-group">
                              <label for="retailer_regno">Retailer Reg No <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="retailer_regno" placeholder="Retailer Reg No" required/>
                          </div>
                          <button class="btn btn-primary" onclick="validateAndProceed('retailer-part')">Next</button>
                      </div>

                      <div id="supplier-part" class="content" role="tabpanel" aria-labelledby="supplier-part-trigger">
                          <div class="form-group">
                              <label for="supplier_name">Supplier Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="supplier_name" placeholder="Enter Supplier Name" required/>
                          </div>
                          <div class="form-group">
                              <label for="supplier_regno">Supplier Reg No <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="supplier_regno" placeholder="Supplier Reg No" required/>
                          </div>
                          <div class="form-group">
                              <label for="supplier_code">Supplier Code <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="supplier_code" placeholder="Supplier Code" required/>
                          </div>
                          <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                          <button class="btn btn-primary" onclick="validateAndProceed('supplier-part')">Next</button>
                      </div>

                      <div id="user-part" class="content" role="tabpanel" aria-labelledby="user-part-trigger">
                          <div class="form-group">
                              <label for="user_login_email">User Login ID (by Valid Email Address) <span class="text-danger">*</span></label>
                              <input type="email" class="form-control" id="user_login_email" placeholder="Enter email" required/>
                          </div>
                          <div class="form-group">
                              <label for="user_password">User Login Password <span class="text-danger">*</span></label>
                              <input type="password" class="form-control" id="user_password" placeholder="Password" required/>
                          </div>
                          <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                          <button class="btn btn-primary" onclick="validateAndProceed('user-part')">Next</button>
                      </div>
                      
                      <div id="bank-part" class="content" role="tabpanel" aria-labelledby="bank-part-trigger">
                          <div class="form-group">
                              <label for="ocbc_acc">OCBC Bank Acc No <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="ocbc_acc" placeholder="Enter acc no" required/>
                          </div>
                          <div class="form-group">
                              <label for="ocbc_name">OCBC Bank Holder Name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="ocbc_name" placeholder="Name" required/>
                          </div>
                          <div class="form-group">
                              <label for="payment_term">Payment Term <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="payment_term" placeholder="Payment Term" required/>
                          </div>
                          <div class="form-group">
                              <label for="payment_due">Payment Due Date <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="payment_due" placeholder="Payment Due Date" required/>
                          </div>
                          <div class="form-group">
                              <label for="credit_limit">Credit Limit (RM) <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="credit_limit" placeholder="RM" required/>
                          </div>
                          <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                          <button class="btn btn-primary" onclick="validateAndProceed('bank-part')">Submit</button>
                      </div>
                      <!--
                      <div id="user-part" class="content" role="tabpanel" aria-labelledby="user-part-trigger">
                          <div class="form-group">
                              <label for="exampleInputFile">File input</label>
                              <div class="input-group">
                                  <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="exampleInputFile" />
                                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                  </div>
                                  <div class="input-group-append">
                                      <span class="input-group-text">Upload</span>
                                  </div>
                              </div>
                          </div>
                          <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </div>-->
                  </div>
              </div>
          </div>
      </div>
  </div>
    <!-- /.content Filtering -->
</div>
<!-- /.content-wrapper -->
<!-- BS-Stepper -->
<script src="../../asset/plugins/bs-stepper/js/bs-stepper.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
});

function validateAndProceed(stepId) {
    // Validate the fields in the current step
    var isValid = validateFields(stepId);

    // If the fields are valid, proceed to the next step
    if (isValid) {
        stepper.next();
    }
}

function validateFields(stepId) {
    // Remove existing error messages
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function (errorMessage) {
        errorMessage.remove();
    });

    // Validate the fields in the current step
    var isValid = true;
    var fields = document.getElementById(stepId).querySelectorAll('[required]');

    for (var i = 0; i < fields.length; i++) {
        if (!fields[i].value) {
            // Display error message next to the input field
            var errorMessage = document.createElement('div');
            errorMessage.className = 'error-message text-danger';
            errorMessage.innerHTML = 'This field is required.';
            fields[i].parentNode.appendChild(errorMessage);

            isValid = false;
        }
    }

    // Add more validation logic as needed

    return isValid;
}
</script>













