		<div class="right_col" role="main">
          <div class="" >
            <div class="page-title">
              <div class="title_left" style="width:100%;">
                <h3 style="text-align:center;"><?php echo lang('edit_category'); ?></h3>
              </div>

              <!--<div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>-->
            </div>
			
            <div class="clearfix"></div>
            
			<div class="row" dir="<?php echo $this->loginuser->dir; ?>">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!--<h2>Form Design <small>different form elements</small></h2>-->
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
                    <br />
					<?php
						//echo $admessage;
						//echo form_error('name');
						echo validation_errors();
						$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form-horizontal form-label-left');
						echo form_open_multipart('categories/editcategory/'.$category->cgid, $attributes);
					?>
                    <!--<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">-->
					<?php
						if($this->loginuser->dir == 'rtl') { $label_class = ' col-md-push-6 col-sm-push-6'; $input_class = ' col-md-pull-1 ol-sm-pull-2'; }
						else { $label_class = ''; $input_class = ''; }
					?>

                      <?php foreach($langs as $lang) { ?>                      <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label($lang->lntitle.' <span class="required">*</span>','title['.$lang->lncode.']',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php						  if(isset($cg_ds[$lang->lncode]['title'])) $title = $cg_ds[$lang->lncode]['title'];						  else $title = '';							$data = array(								'type' => 'text',								'name' => 'title['.$lang->lncode.']',								'id' => 'title',								'placeholder' => lang('title'),								'class' => 'form-control col-md-7 col-xs-12',								//'max' => 255,								//'required' => 'required',								'value' => $title							);							echo form_input($data);						?>                        </div>                      </div>					  					  <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label('','desc['.$lang->lncode.']',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php						  						  if(isset($cg_ds[$lang->lncode]['desc'])) $desc = $cg_ds[$lang->lncode]['desc'];						  else $desc = '';							$data = array(								'name' => 'desc['.$lang->lncode.']',								'id' => 'desc',								'placeholder' => lang('desc'),								'class' => 'form-control col-md-7 col-xs-12',								'value' => $desc							);							echo form_textarea($data);						?>                        </div>                      </div>					<?php } ?>
					   <!--<div class="form-group">						<?php							/*$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label(lang('service').' <span class="required">*</span>','service',$data);*/						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php //echo $input_class; ?>">						<?php							/*$ourtypes['RE'] = lang('realestates');														$ourtypes['VH'] = lang('cars');							echo form_dropdown('service', $ourtypes, array('service'=>$category->cgtype), 'id="service" class="form-control" required="required"');*/						?>                        </div>                      </div>-->					  <input type="hidden" name="service" value="<?php echo $category->cgtype; ?>">					  					  <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label(' ','',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php							if(isset($category->cgimg) && $category->cgimg != '' && file_exists($this->config->item('categories_folder').$category->cgimg))							{ 								?><img src="<?php echo base_url().$this->config->item('categories_folder').$category->cgimg; ?>" class="img-responsive" style="max-width:150px;max-height:150px;"/><?php								$data = array(									'oldimg'  => $category->cgimg								);								echo form_hidden($data);							}						?>                        </div>                      </div>					  <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label(lang('image'),'image',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php							$data = array(								'type' => 'file',								'name' => 'img',								'id' => 'img',								'class' => 'form-control col-md-7 col-xs-12',							);							echo form_upload($data);						?>                        </div>                      </div>					  					  <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label(lang('color').' <span class="required">*</span>','color',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php							$data = array(								//'type' => 'text',								'name' => 'color',								'id' => 'color',								'placeholder' => lang('color'),								'class' => 'jscolor {onFineChange:"update(this)"} form-control col-md-7 col-xs-12',																//'max' => 255,								//'required' => 'required',								'value' => $category->cgcolor							);							echo form_input($data);						?>                        </div>                      </div>					  					  <div class="form-group">						<?php							$data = array(								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,							);							echo form_label(' <span class="required">*</span>','color2',$data);						?>                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">						  <?php							$data = array(								//'type' => 'text',								'name' => 'color2',								'id' => 'color2',								'placeholder' => lang('color'),								'class' => 'jscolor {onFineChange:"update(this)"} form-control col-md-7 col-xs-12',																//'max' => 255,								//'required' => 'required',								'value' => $category->cgcolor2							);							echo form_input($data);						?>                        </div>                      </div>
					  <div class="form-group">
                        <?php
							$data = array(
								'class' => 'control-label col-md-3 col-sm-3 col-xs-12'.$label_class,
							);
							echo form_label(lang('active'),'active',$data);
						?>
                        <div class="col-md-6 col-sm-6 col-xs-12 <?php echo $input_class; ?>">
						  <?php
							$data = array(
								'name' => 'active',
								'id' => 'active',
								/*'checked' => 'TRUE',*/
								'class' => 'js-switch',
								'value' => 1
							);
							if($category->cgactive == '1') $data['checked'] = 'TRUE';
							echo form_checkbox($data);
						?>
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
						  <?php																				
							$data = array(
								'name' => 'submit',
								'id' => 'submit',
								'class' => 'btn btn-success',																'style' => 'background-color:#2AA3D6;',
								'value' => 'true',
								'type' => 'submit',
								'content' => lang('edit')
							);
							echo form_button($data);
						?>
                        </div>
                      </div>

                    <?php								
						echo form_close();
					?>
                  </div>
                </div>
              </div>
            </div>
		  </div>
        </div>