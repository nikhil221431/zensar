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
                                <h4 class="card-title card-title-dash">Router Information</h4>
                               <!-- <p class="card-subtitle card-subtitle-dash">You have 50+ new requests</p> -->
                              </div>
                              <div>
                                <a href="<?php echo site_url('Router/createrouter');?>" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                    <i class="mdi mdi-plus-box"></i>Bulk Upload
                                </a>
                                <a href="<?php echo site_url('Router/confirmation');?>" class="btn btn-primary btn-lg text-white mb-0 me-0">
                                    <i class="mdi mdi-plus-box"></i>confirm
                                </a>
                              </div>
                            </div>
                            <div class="table-responsive  mt-1">
                              <table class="table select-table" id="tblSchoolInfo">
                                <thead>
                                  <tr>
                                    <th>Sr No.</th>
                                    <th>SAPID</th>
                                    <th>Hostname</th>
                                    <th>Loopback</th>
                                    <th>Mac Address</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach($routerInfo as $key => $value){

                                            echo    '<tr id="routerDetailRow_'.$value->id.'">
                                                        <td>'.++$key.'</td>
                                                        <td>'.$value->sapid.'</td>
                                                        <td>'.$value->hostname.'</td>
                                                        <td>'.$value->loopback.'</td>
                                                        <td>'.$value->mac_address.'</td>
                                                        <td>
                                                            <button class="btn btn-outline-link btn-icon-text deleteRouterDetail" routerDetailId="'.$value->id.'">
                                                                <i class="ti-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>';
                                        }
                                    ?>
                                </tbody>
                              </table>
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
      "pageLength": 20
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
});
</script>