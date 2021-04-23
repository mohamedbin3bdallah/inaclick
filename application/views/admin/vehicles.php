        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('cars'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 <?php if($this->loginuser->dir == 'rtl') echo 'col-md-offset-9 col-sm-offset-9 col-xs-offset-7'; else echo 'col-md-offset-2 col-sm-offset-2 col-xs-offset-1'; ?> form-group top_search">
                  <div class="input-group">
					<!--<?php //if(strpos($this->loginuser->privileges, ',vhadd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'vehicles/add'"><?php //echo lang('add_car'); ?></button><?php //} ?>-->
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row" dir="<?php echo $this->loginuser->dir; ?>">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>Button Example <small>Users</small></h2>-->
                    <ul class="nav navbar-<?php if($this->loginuser->dir == 'rtl') echo 'left'; else echo 'right'; ?> panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <!--<p class="text-muted font-13 m-b-30">
                      The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                    </p>-->
                    <?php if(!empty($vehicles)) { ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>						  						  <th><?php echo lang('title'); ?></th>						  						  <th><?php echo lang('category'); ?></th>						  						  <th><?php echo lang('type'); ?></th>						  						  						  <th><?php echo lang('user'); ?></th>						  						  						  <td></td>						  						  <th><?php echo lang('status'); ?></th>						  
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('edittime'); ?></th>
						  <th><?php echo lang('active'); ?></th>
						  <!--<?php //if(strpos($this->loginuser->privileges, ',vhedit,') !== false) { ?><th><?php //echo lang('edit'); ?></th><?php //} ?>-->
						  <?php if(strpos($this->loginuser->privileges, ',vhdelete,') !== false) { ?><th><?php echo lang('delete'); ?></th><?php } ?>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($vehicles as $vehicle) { $status = array('not_available'=>'danger','may_available'=>'warning','available'=>'success'); ?>
                        <tr>						
						  <td align="center"><?php echo $vehicle->vhtitle; ?></td>						  						  <td align="center"><?php echo $vehicle->cgtitle; ?></td>						  						  <td align="center"><?php echo $vehicle->tytitle; ?></td>						  						  						  <td align="center"><?php echo $employees[$vehicle->vheid]; ?></td>						  						  						  						  <td align="center">						  <a class="" href="#" data-toggle="modal" data-target="#open-<?php echo $vehicle->vhid; ?>"><?php echo lang('details'); ?></a>						   <div id="open-<?php echo $vehicle->vhid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">								<div class="modal-dialog modal-lg">									<div class="modal-content">										<div class="modal-header">											<button type="button" class="close" data-dismiss="modal">&times;</button>											<br>											<h3><?php echo $vehicle->vhtitle; ?></h3>        								</div>										<div class="modal-body">											<table id="datatable-buttons" class="table table-striped table-bordered"  dir="<?php echo $this->loginuser->dir; ?>">												<thead>													<tr>														<td><?php echo lang('service'); ?></td>														<td><?php echo lang('images'); ?></td>													</tr>												</thead>												<tbody>													<tr>														<td align="center"><?php echo $vehicle->vhservices; ?></td>														<td align="center">															<?php																if(is_dir($this->config->item('vehicles_folder').$vehicle->vhid))																{																	$imgs = array_diff(scandir($this->config->item('vehicles_folder').$vehicle->vhid), array('.','..'));																	if(!empty($imgs)) { 																		for($i=2;$i<count($imgs)+2;$i++) { 															?>																			<img src="<?php echo base_url().$this->config->item('vehicles_folder').$vehicle->vhid.'/'.$imgs[$i]; ?>" class="img-responsive" style="max-width:150px;max-height:150px;border-radius:15%;"/>																<?php } } } ?>														</td>													</tr>												</tbody>											</table>										</div>									</div>								</div>							</div>						  </td>						  						   <td align="center">								<div class="alert-<?php echo $status[$vehicle->vhstatus]; ?> fade in" role="alert" style="text-align:center;padding:7px;border-top-left-radius:15px;border-bottom-right-radius:15px;color:#fff;">									<strong><?php echo lang($vehicle->vhstatus); ?></strong>								</div>						  </td>
						  <td align="center" id="uid-<?php echo $vehicle->vhid; ?>"><?php if(isset($employees[$vehicle->vhuid])) echo $employees[$vehicle->vhuid]; ?></td>
						  <td align="center" id="time-<?php echo $vehicle->vhid; ?>"><?php if($vehicle->vhtime != '') { echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $vehicle->vhtime).' , '.date('h:i:s', $vehicle->vhtime); if(date('H', $vehicle->vhtime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); } ?></td>
						  <td align="center"><input type="checkbox" class="js-switch activatevehicle" myid="<?php echo $vehicle->vhid; ?>" <?php if($vehicle->vhactive == 1) echo 'checked'; ?> ></td>
						  <!--<?php //if(strpos($this->loginuser->privileges, ',vhedit,') !== false) { ?><td><a href="<?php //echo base_url(); ?>vehicles/edit/<?php //echo $vehicle->vhid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a></td><?php //} ?>-->
						  <?php if(strpos($this->loginuser->privileges, ',vhdelete,') !== false) { ?><td align="center">
							<i id="<?php echo $vehicle->vhid; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php echo $vehicle->vhid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" id="action_buttom" onclick="location.href = 'vehicles/del/<?php echo $realestate->vhid; ?>'" data-dismiss="modal"><?php echo lang('yes'); ?></button>
											<button class="btn btn-success" data-dismiss="modal" aria-hidden="true"><?php echo lang('no'); ?></button>
										</center>
										</div>
									</div>
								</div>
							</div>
						</td><?php } ?>
                        </tr>
					  <?php } ?>
                      </tbody>
                    </table>
					<?php } else echo lang('no_data');?>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- /page content -->