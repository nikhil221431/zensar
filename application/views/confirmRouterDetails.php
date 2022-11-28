<style type="text/css">
  .duplicateData {
    background-color: #ccc;
  }
</style>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12">
        <div class="home-tab">
          <div class="tab-content tab-content-basic">
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
              <div class="row">
                <div class="col-lg-12 d-flex flex-column">
                  <div class="row flex-grow">
                    <div class="col-12 grid-margin stretch-card">
                      <div class="card card-rounded">
                        <div class="card-body">
                          <div class="d-sm-flex justify-content-between align-items-start">
                            <div>
                              <h4 class="card-title card-title-dash">Confirm Router Details</h4>
                              <!-- <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p> -->
                            </div>
                          </div>
                          <div class="table-responsive  mt-1">
                            <form class="forms-sample" method="POST" id="confirmation" enctype="multipart/form-data" action="<?php echo site_url('Router/confirmation');?>">
                              <table class="table select-table" id="tblSchoolInfo">
                                <thead>
                                  <tr>
                                    <th>SAPID</th>
                                    <th>Hostname</th>
                                    <th>Loopback</th>
                                    <th>Mac Address</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php 

                                    $duplicateDataCheck = array();
                                    foreach($routerInfo as $key => $value){

                                      $duplicateData = "";
                                      $rInfo = array( 'sapid' => $value->sapid,
                                                      'hostname' => $value->hostname,
                                                      'loopback' => $value->loopback,
                                                      'mac_address' => $value->mac_address);

                                      if(!empty($duplicateDataCheck)){

                                        if (in_array($rInfo, $duplicateDataCheck)){

                                          $duplicateData = "duplicateData";
                                        }
                                        else { array_push($duplicateDataCheck, $rInfo); }
                                      }
                                      else {array_push($duplicateDataCheck, $rInfo);}

                                      $invalidSapId = "";
                                      $invalidHostname = "";
                                      $invalidLoopback = "";
                                      $invalidMacaddress = "";

                                      if($value->sapid == ""){

                                        $invalidSapId = "is-invalid";
                                      }
                                      else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $value->sapid)){

                                        $invalidSapId = "is-invalid";
                                      }
                                      else if(strlen($value->sapid) != 18) {

                                        $invalidSapId = "is-invalid";
                                      }

                                      if($value->hostname == ""){
                                        $invalidHostname = "is-invalid";
                                      }
                                      else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $value->hostname)){

                                        $invalidHostname = "is-invalid";
                                      }
                                      else if(strlen($value->hostname) != 14) {

                                        $invalidHostname = "is-invalid";
                                      }

                                      if($value->loopback == ""){

                                        $invalidLoopback = "is-invalid";
                                      }
                                      else if (!filter_var($value->loopback, FILTER_VALIDATE_IP)) {

                                        $invalidLoopback = "is-invalid";
                                      }

                                      if($value->mac_address == ""){

                                        $invalidMacaddress = "is-invalid";
                                      }
                                      else if(preg_match('/([a-fA-F0-9]{2}[:|\-]?){6}/', $value->mac_address)){

                                        $invalidMacaddress = "is-invalid";
                                      }
                                      else if(strlen($value->mac_address) != 17) {

                                        $invalidMacaddress = "is-invalid";
                                      }

                                      echo  '<tr id="routerDetailRow_'.$value->id.'" class="'.$duplicateData.'">
                                              <td>
                                                <input type="hidden" name="id[]" value="'.$value->id.'">
                                                <input type="text" class="form-control validateFields sapidList '.$invalidSapId.'" name="sapid[]" id="sapid_'.$value->id.'" placeholder="SAP ID" value="'.$value->sapid.'" validateFor="sapid" rowId="'.$value->id.'">
                                              </td>
                                              <td>
                                                <input type="text" class="form-control validateFields hostnameList '.$invalidHostname.'" name="hostname[]" id="hostname_'.$value->id.'" placeholder="HOSTNAME" value="'.$value->hostname.'"  validateFor="hostname" rowId="'.$value->id.'">
                                              </td>
                                              <td>
                                                <input type="text" class="form-control validateFields loopbackList '.$invalidLoopback.'" name="loopback[]" id="loopback_'.$value->id.'" placeholder="Loopback" value="'.$value->loopback.'"  validateFor="loopback" rowId="'.$value->id.'">
                                              </td>
                                              <td>
                                                <input type="text" class="form-control validateFields macaddressList '.$invalidMacaddress.'" name="mac_address[]" id="mac_address_'.$value->id.'" placeholder="Mac Address" value="'.$value->mac_address.'"  validateFor="mac_address" rowId="'.$value->id.'">
                                              </td>
                                              <td>
                                                <button type="button" class="btn btn-outline-link btn-icon-text deleteRouterDetail" routerDetailId="'.$value->id.'">
                                                    <i class="ti-trash"></i>
                                                </button>
                                              </td>
                                            </tr>';
                                    }
                                  ?>
                                </tbody>
                              </table>
                              <button type="submit" class="btn btn-primary me-2">Submit</button>
                              <a href="<?php echo site_url('Router/routerInfo');?>" class="btn btn-light">Cancel</a>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->

<script>
$(document).ready(function(){

  $('#tblSchoolInfo').DataTable( {
    // "pageLength": 500
    "paging": false,
    "ordering": false,
    "info": false,
  });

  $( ".deleteRouterDetail" ).on( "click", function() {

    var routerDetailId = $( this ).attr('routerDetailId');

    if (confirm("Do you want to delete") == true) {

      var form_data = { 
                        routerDetailId           : routerDetailId,
                      };

      $.post( "<?php echo site_url('Router/deleteRouterData');?>" ,form_data,function(message) {

        alert(message.message);

        if(message.output == "TRUE"){

          $("#routerDetailRow_"+routerDetailId).remove();
        }

      }, 'json');
    }
  });

  $(document).on("submit","#confirmation", function (e) {

    let duplicateData = $('.duplicateData').length;
    let invalidData   = $('.is-invalid').length;
    let errorMsg = "";
    if(duplicateData > 0){

      errorMsg += "* Kindly Remove Duplicate Data \n   NOTE : Remove Records In Gray Colour\n";
    }

    if(invalidData > 0){

      errorMsg += "* Kindly Enter Valid Data In Highlighted Fields\n";
    }

    if(errorMsg != ""){
      alert(errorMsg);
      e.preventDefault();
    }
  });

  $(document).on("change", ".validateFields ", function(e){

    let validateFor = $(this).attr("validateFor");
    let rowId = $(this).attr('rowId');

    console.log(validateFor+"    "+rowId);
    if(validateFor == "sapid"){

      validateSapId(rowId);
    }
    else if(validateFor == "hostname"){

      validateHostname(rowId);
    }
    else if(validateFor == "loopback"){

      validateLoopback(rowId);
    }
    else if(validateFor == "mac_address"){

      validateMacaddress(rowId);
    }
  });

  function validateSapId(rowId){

    let sapid = $("#sapid_"+rowId).val();
    var regex = new RegExp("^[0-9a-zA-Z-]+$");
    let hasError = false;

    if(sapid == ""){

      hasError = true;
    }
    else if(!regex.test(sapid)){

      hasError = true;
    }
    else if(sapid.length != 18){

      hasError = true;
    }

    if(hasError){

      $("#sapid_"+rowId).addClass("is-invalid");
    }
    else {

      $("#sapid_"+rowId).removeClass("is-invalid");
    }
  }

  function validateHostname(rowId){

    let hostname = $("#hostname_"+rowId).val();
    var regex = new RegExp("^[0-9a-zA-Z]+$");
    let hasError = false;

    if(hostname == ""){

      hasError = true;
    }
    else if(!regex.test(hostname)){

      hasError = true;
    }
    else if(hostname.length != 14){

      hasError = true;
    }

    if(hasError){

      $("#hostname_"+rowId).addClass("is-invalid");
    }
    else {

      $("#hostname_"+rowId).removeClass("is-invalid");
    }
  }

  function validateLoopback(rowId){

    let loopback = $("#loopback_"+rowId).val();
    var regex = /^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/;
    let hasError = false;

    if(loopback == ""){

      hasError = true;
    }
    else if(!regex.test(loopback)){

      hasError = true;
    }

    if(hasError){

      $("#loopback_"+rowId).addClass("is-invalid");
    }
    else {

      $("#loopback_"+rowId).removeClass("is-invalid");
    }
  }

  function validateMacaddress(rowId){

    let mac_address = $("#mac_address_"+rowId).val();
    var regex = /^([0-9A-F]{2}[:-]){5}([0-9A-F]{2})$/;
    let hasError = false;

    if(mac_address == ""){

      hasError = true;
    }
    else if(!regex.test(mac_address)){

      hasError = true;
    }
    else if(mac_address.length != 17){

      hasError = true;
    }

    if(hasError){

      $("#mac_address_"+rowId).addClass("is-invalid");
    }
    else {

      $("#mac_address_"+rowId).removeClass("is-invalid");
    }
  }
});
</script>