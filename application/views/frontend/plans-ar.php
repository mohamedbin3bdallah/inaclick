<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/plans-ar.css">

<div class="ourplans">
   <div class="container">
       <h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
	   <?php
	   if((isset($plans_B) && !empty($plans_B)) || (isset($plans_A) && !empty($plans_A))) {
	   $attributes = array('id' => 'submit_form');

			echo form_open('pay-ar/'.$id, $attributes);

			echo validation_errors();

			if(isset($plans_A) && !empty($plans_A)) { ?>
	   <h3>الاساسي</h3>
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
		<h3>الاضافي</h3>
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

										'value' => 'اطلب',

										'type' => 'submit',

										//'disabled' => 'disabled',

										'content' => 'اطلب'

									);

									echo form_submit($data);

		} echo form_close(); } else { echo '<div class="no_data"><h3>لا توجد خطط للدفع !!!</h3></div>'; } ?>
        
        <div class="bot">
            <h2 class="title">كل خططتنا تشمل </h2>
            <span>لا يوجد رسوم اعداد ولا عقود</span>
            <p>نحن نثق فى عملائنا،  لا يهمنا أي رسوم تسجيل ولا أي اتفاق قانوني</p>
        </div>
        
        <div class="last">
            <div class="pay">
                <p>نقبل طرق الدفع التالية</p>
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/visa.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/master.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/discover.png" alt=""></a> 

            </div>
            <h1 class="visible-lg">ثقة لدى الملايين</h1>
        </div>
   </div>  
</div>