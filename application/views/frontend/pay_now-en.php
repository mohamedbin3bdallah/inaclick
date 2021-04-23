<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/login-reg.css">

<h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
<div class="log">
  <div class="container">
     
	   <?php

		//echo $admessage;

		$attributes = array('id' => 'submit_form', /*'data-parsley-validate' => '', */'class' => 'form col-sm-5 col-xs-12');

		echo form_open('paynow-en', $attributes);

		//echo '<h2 class="title">Register</h2>';

		echo validation_errors();

	  ?>
	  
	  <?php if($this->session->userdata('uid') == FALSE){ ?>
        
		<?php

									$data = array(

										'type' => 'text',

										'name' => 'name',

										'id' => 'name',

										'placeholder' => lang('name'),

										'class' => 'form-control',

										//'max' => 255,

										//'required' => 'required',

										'value' => set_value('name')

									);

									echo form_input($data);

									?>

									<?php

									$data = array(

										'type' => 'email',

										'name' => 'email',

										'id' => 'email',

										'placeholder' => lang('email'),

										'class' => 'form-control',

										//'max' => 255,

										//'required' => 'required',

										'value' => set_value('email')

									);

									echo form_input($data);

									?>

									<?php

									$data = array(

										'type' => 'text',

										'name' => 'mobile',

										'id' => 'mobile',

										'placeholder' => lang('mobile'),

										'class' => 'form-control',

										//'max' => 255,

										//'required' => 'required',

										'value' => set_value('mobile')

									);

									echo form_input($data);

									?>
	  <?php } ?>
								
									<?php

									$data = array(

										'type' => 'text',

										'name' => 'whatsup',

										'id' => 'whatsup',

										'placeholder' => lang('whatsup'),

										'class' => 'form-control',

										//'max' => 255,

										//'required' => 'required',

										'value' => set_value('whatsup')

									);

									echo form_input($data);

									?>
						<?php

							if(!empty($categories))

							{

								foreach($categories as $category)

								{

									$ourtypes[$category->id] = $category->cgtitle;

								}											

								echo form_dropdown('category', $ourtypes, array(), 'id="category" class="form-control" required="required"');

							}

							else echo lang('no_data');

						?>
						 <?php

							$data = array(

								'name' => 'desc',

								'id' => 'desc',

								'placeholder' => lang('desc'),

								'class' => 'form-control',

								'value' => set_value('desc')

							);

							echo form_textarea($data);

						?>
								<?php

									$data = array(

										'name' => 'submit',

										'id' => 'submit',

										'class' => 'btn btn-block',

										'value' => 'Order',

										'type' => 'submit',

										//'disabled' => 'disabled',

										'content' => 'Order Now'

									);

									echo form_submit($data);

									?>
        
      <?php	echo form_close();	?>

  </div>  
</div>