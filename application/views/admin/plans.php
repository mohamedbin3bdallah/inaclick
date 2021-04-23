        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('plans'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 <?php if($this->loginuser->dir == 'rtl') echo 'col-md-offset-9 col-sm-offset-9 col-xs-offset-7'; else echo 'col-md-offset-2 col-sm-offset-2 col-xs-offset-1'; ?> form-group top_search">
                  <div class="input-group">
					<?php if(strpos($this->loginuser->privileges, ',pladd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'plans/add'"><?php echo lang('add_plan'); ?></button><?php } ?>
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
                    <ul class="nav navbar-right panel_toolbox">
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
                    <?php if(!empty($plans)) { $type = array('addition','basic'); ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><?php echo lang('titleen'); ?></th>
						  <th><?php echo lang('titlear'); ?></th>
						  <th><?php echo lang('descen'); ?></th>
						  <th><?php echo lang('descar'); ?></th>						  						  <th><?php echo lang('price'); ?></th>						  						  <th><?php echo lang('type'); ?></th>
						  <?php if(in_array('CG',$this->sections)) { ?><th><?php echo lang('category'); ?></th><?php } ?>
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('edittime'); ?></th>
						  <th><?php echo lang('active'); ?></th>
						  <?php if(strpos($this->loginuser->privileges, ',pledit,') !== false) { ?><th><?php echo lang('edit'); ?></th><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',pldelete,') !== false) { ?><th><?php echo lang('delete'); ?></th><?php } ?>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($plans as $plan) { ?>
                        <tr>
                          <td><?php echo $plan->pltitleen; ?></td>
						  <td><?php echo $plan->pltitlear; ?></td>
						  <td><?php echo htmlspecialchars_decode(stripslashes($plan->pldescen)); ?></td>
						  <td><?php echo htmlspecialchars_decode(stripslashes($plan->pldescar)); ?></td>						  						  <td><?php echo $plan->plprice.' '.$system->currency; ?></td>						  						  <td><?php echo $type[$plan->pltype]; ?></td>
						  <?php if(in_array('CG',$this->sections)) { ?><td><?php echo $plan->category; ?></td><?php } ?>
						  <td><?php echo $employees[$plan->pluid]; ?></td>
						  <td><?php if($plan->pltime != '') { echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $plan->pltime).' , '.date('h:i:s', $plan->pltime); if(date('H', $plan->pltime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); } ?></td>
						  <td><input type="checkbox" <?php if($plan->plactive == 1) echo 'checked'; ?> disabled></td>
						  <?php if(strpos($this->loginuser->privileges, ',pledit,') !== false) { ?><td><a href="<?php echo base_url(); ?>plans/edit/<?php echo $plan->plid; ?>" style="color: green;"><i style="color:green;" class="glyphicon glyphicon-edit"></i></a></td><?php } ?>
						  <?php if(strpos($this->loginuser->privileges, ',pldelete,') !== false) { ?><td>
							<i id="<?php echo $plan->plid; ?>" style="color:red;" class="del glyphicon glyphicon-remove-circle"></i>
							<div id="del-<?php echo $plan->plid; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-sm">
									<div class="modal-content">
										<div class="modal-header">
											<?php echo lang('deletemodal'); ?>
											<br>
        								</div>
										<div class="modal-body">
										<center>
											<button class="btn btn-danger" id="action_buttom" onclick="location.href = 'plans/del/<?php echo $plan->plid; ?>'" data-dismiss="modal"><?php echo lang('yes'); ?></button>
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