<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/order-ar.css">

<div class="order">
   <div class="container">
       <h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
	   <?php
	   if(isset($orders) && !empty($orders))
	   {
		$status = array('cancel_pay'=>'danger','waiting_pay'=>'warning','success_pay'=>'success');
		$status_lang = array('cancel_pay'=>'لم يتم الدفع','waiting_pay'=>'في الانتظار','success_pay'=>'تم الدفع');
		?>
       <table>
           <tr>
               <th>الخطة</th>
			   <th>رقم الطلب</th>
               <th>الحالة</th>
               <th>التكلفة الكلية</th>
           </tr>
           
		   <?php foreach($orders as $order) { $order->plans = implode(' , ',array_intersect_key($plans, array_flip(explode(',',$order->odplid))));	?>
           <tr>
               <td><?php echo $order->plans; ?></td>
			   <td><?php echo $order->odnumber; ?></td>
               <td><div class="<?php echo $status[$order->odtype]; ?>"><?php echo $status_lang[$order->odtype]; ?></div></td>
               <td><?php echo $order->odprice.' '.$system->currency; ?></td>
           </tr>
		   <?php } ?>
       </table>
	   <?php } else echo '<div class="no_data"><h3>لا توجد طلبات حتى الان !!!</h3></div>'; ?>
	   
	   <?php
	   if(isset($ordersnow) && !empty($ordersnow))
	   {
		$status = array('cancel_pay'=>'danger','waiting_pay'=>'warning','success_pay'=>'success');
		$status_lang = array('cancel_pay'=>'Not Paid','waiting_pay'=>'Waiting','success_pay'=>'Paid');
		?>
       <table>
           <tr>
               <th>الخدمة</th>
			   <th>رقم الطلب</th>
			   <th>الوصف</th>
			   <th>الحالة</th>
               <th>التكلفة الكلية</th>
           </tr>
           
		   <?php foreach($ordersnow as $ordernow) { ?>
           <tr>
               <td><?php echo $ordernow->cgtitle; ?></td>
			   <td><?php echo $ordernow->onnumber; ?></td>
			   <td style="text-align:justify;"><?php echo $ordernow->ondesc; ?></td>
               <td><div class="<?php echo $status[$ordernow->ontype]; ?>"><?php echo $status_lang[$ordernow->ontype]; ?></div></td>
               <td><?php echo $ordernow->onprice.' '.$system->currency; ?></td>
           </tr>
		   <?php } ?>
       </table>
	   <?php } else echo '<div class="no_data"><h3>لا توجد طلبات حالية حتى الان !!!</h3></div>'; ?>

        <div class="last">
            <div class="pay">
                <p>نحن نقبل طرق الدفع التالية</p>
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/visa.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/master.png" alt=""></a> 
                <a href=""><img src="<?php echo base_url(); ?>idea2tech/icons/discover.png" alt=""></a> 

            </div>
            <h1 class="visible-lg">ثقة لدى الملايين</h1>
        </div>
   </div>  
</div>