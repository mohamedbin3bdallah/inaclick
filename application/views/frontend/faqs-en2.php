<!--====================================-->
<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/faq.css">

<div class="faq">
    <div class="container">
        <h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
        <div class="design"></div>
		
		<?php if(isset($faqs) && !empty($faqs)) { ?>
        <div class="text col-md-12 fadeInLeft wow" data-wow-duration='1.8s' data-wow-offset="300">
                <h3>
				<?php foreach($faqs as $faq) { ?>
				<br>
				<span><?php echo $faq->fatitle; ?></span>
				<br>
                <?php echo $faq->fadesc; ?>
                <br>
				<?php } ?>
                </h3>
        </div>
		<?php } ?>
        
    </div>
</div>