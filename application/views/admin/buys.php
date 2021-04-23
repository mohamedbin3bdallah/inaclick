        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('buys'); ?></h3>
              </div>

              <div class="">
                <div class="col-md-3 col-sm-3 col-xs-5 <?php if($this->loginuser->dir == 'rtl') echo 'col-md-offset-9 col-sm-offset-9 col-xs-offset-7'; else echo 'col-md-offset-2 col-sm-offset-2 col-xs-offset-1'; ?> form-group top_search">
                  <div class="input-group">
					<!--<?php //if(strpos($this->loginuser->privileges, ',cgadd,') !== false) { ?><button type="button" class="btn btn-primary" onclick="location.href = 'categories/add'"><?php //echo lang('add_category'); ?></button><?php //} ?>-->
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
                    <?php if(!empty($buys)) { ?>
					<table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>						  						  <th><?php echo lang('title'); ?></th>						  						  <th><?php echo lang('owner'); ?></th>						  						  <th><?php echo lang('user'); ?></th>						  						  						  <th><?php echo lang('price'); ?></th>						  						  <th><?php echo lang('buy').' '.lang('time'); ?></th>						  						  						  						  
						  <th><?php echo lang('editemployee'); ?></th>
						  <th><?php echo lang('edittime'); ?></th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php foreach($buys as $buy) { ?>
                        <tr>						
						  <td align="center"><?php echo $buy->retitle; ?></td>						  						  <td align="center"><?php echo $employees[$buy->oid]; ?></td>						  						  <td align="center"><?php echo $employees[$buy->bid]; ?></td>						  						  <td align="center"><?php echo $buy->price.' '.$buy->currency; ?></td>						  						  <td align="center"><?php if($buy->buytime != '') { echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $buy->buytime).' , '.date('h:i:s', $buy->buytime); if(date('H', $buy->buytime) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); } ?></td>						  						  						  
						  <td align="center"><?php if(isset($employees[$buy->uid])) echo $employees[$buy->uid]; ?></td>
						  <td align="center"><?php if($buy->time != '') { echo ArabicTools::arabicDate($system->calendar.' Y-m-d', $buy->time).' , '.date('h:i:s', $buy->time); if(date('H', $buy->time) < 12) echo ' '.lang('am'); else echo ' '.lang('pm'); } ?></td>
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