<!-- partial -->
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-sm-12">
          <div class="home-tab">
						<?php if(validation_errors()){ ?>
							<div class="alert alert-danger" id="notMsg" role="alert">
								<?php echo validation_errors(); ?>
							</div>
						<?php }
						else if(isset($error)){

							echo '<div class="alert alert-danger" id="notMsg" role="alert">
											'.$error.'
									</div>';
						}?>
            <div class="tab-content tab-content-basic">
              <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                <div class="row">
                  <div class="col-lg-12 d-flex flex-column">
                    <div class="row flex-grow">
                      <div class="col-12 grid-margin stretch-card">
                        <div class="card card-rounded">
													<div class="card-body">
														<h4 class="card-title">Router Information Form</h4>
														<p class="card-description">
															Add Routers
														</p>
														<form class="forms-sample" method="POST" enctype="multipart/form-data" action="<?php echo site_url('Router/createRouter');?>">
                              <div class="form-group">
																<label>Upload</label>
																<input type="file" name="routersDetails" class="file-upload-default">
																<div class="input-group col-xs-12">
																	<input type="text" class="form-control file-upload-info" placeholder="Upload File">
																	<span class="input-group-append">
																	<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
																	</span>
																</div>
															</div>
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
 <!-- content-wrapper ends -->

 <script src="<?php echo base_url('assets/js/file-upload.js');?>"></script>