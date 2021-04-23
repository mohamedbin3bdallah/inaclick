<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/plans.css">

<div class="ourplans">
   <div class="container">
       <h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
	   <?php
	   if((isset($plans_B) && !empty($plans_B)) || (isset($plans_A) && !empty($plans_A))) {
	   $attributes = array('id' => 'submit_form');

			echo form_open('pay-en/'.$id, $attributes);

			echo validation_errors();

			if(isset($plans_A) && !empty($plans_A)) { ?>
	   <h3>Basics</h3>
       <div class='plans'>
		<?php foreach($plans_A as $plan_A) { ?>
            <div class="part col-md-4">
                <h3><?php echo $plan_A->pltitle; ?></h3>
                <div>
                    <?php echo htmlspecialchars_decode(stripslashes($plan_A->pldesc)); ?>
                    <p> <Span><?php echo $plan_A->plprice.' '.$system->currency; ?> </Span></p>
					<?php if(in_array('OD',$this->sections) && $this->session->userdata('uid') != FALSE) { ?>
                    <section>
                        <div class="roundedTwo">
                          <input type="checkbox" value="<?php echo $plan_A->plid; ?>" id="rounded<?php echo $plan_A->plid; ?>" name="plans[]" />
                          <label for="rounded<?php echo $plan_A->plid; ?>"></label>
                        </div>
                  </section>
				  <?php } ?>
                </div>
            </div>
		<?php } ?>
        </div>
		<?php } ?>
        
		<?php   if(isset($plans_B) && !empty($plans_B)) { ?>
		<h3>Additions</h3>
		<div class='plans'>
		<?php foreach($plans_B as $plan_B) { ?>
            <div class="part col-md-4">
                <h3><?php echo $plan_B->pltitle; ?></h3>
                <div>
                    <?php echo htmlspecialchars_decode(stripslashes($plan_B->pldesc)); ?>
                    <p> <Span><?php echo $plan_B->plprice.' '.$system->currency; ?> </Span></p>
					<?php if(in_array('OD',$this->sections) && $this->session->userdata('uid') != FALSE) { ?>
                    <section>
                        <div class="roundedTwo">
                          <input type="checkbox" value="<?php echo $plan_B->plid; ?>" id="rounded<?php echo $plan_B->plid; ?>" name="plans[]" />
                          <label for="rounded<?php echo $plan_B->plid; ?>"></label>
                        </div>
                  </section>
				  <?php } ?>
                </div>
            </div>
		<?php } ?>
        </div>
		<?php } ?>
		<?php 
		if(in_array('OD',$this->sections) && $this->session->userdata('uid') != FALSE) { 

									$data = array(

										'name' => 'submit',

										'id' => 'submit',

										'class' => 'btn button',

										'value' => 'Order',

										'type' => 'submit',

										//'disabled' => 'disabled',

										'content' => 'Order'

									);

									echo form_submit($data);

		} echo form_close(); } else { echo '<div class="no_data"><h3>There are no Plans !!!</h3></div>'; } ?>
		
        <div class="bot">
            <h2 class="title">ALL PLANS INCLUDE</h2>
            <span>NO SETUP FEE, NO CONTRACTS</span>
            <p>We trust our clients, we do not charge any registration fee nor any legal agreement</p>
        </div>
        
        <div class="last">
            <div class="pay">
                <p>we accept all of  the following creadit cards</p>
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/visa.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/master.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/discover.png" alt=""></a> 

            </div>
            <h1 class="visible-lg">Trusted By Millions</h1>
        </div>
   </div>  
</div>