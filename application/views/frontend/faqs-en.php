<link rel="stylesheet" href="<?php echo base_url(); ?>idea2tech/css/faq.css">

<div class="faq">
    <div class="container" id="faq" >
        <h1 class="head"><?php echo $this->pages['title'.$front_lang][$pageid]; ?></h1>
        <div class="design"></div>
        <div class="text col-md-12 fadeInLeft wow" data-wow-duration='1.8s' data-wow-offset="300">
          <?php if(isset($faqs) && !empty($faqs)) { ?>
         <div class="panel-group text" id="test">

		 <?php foreach($faqs as $faq) { ?>
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" data-parent="#test" href="#collapse<?php echo $faq->faid; ?>"><?php echo $faq->fatitle; ?></a>
                    </h4>
                  </div>
                  <div id="collapse<?php echo $faq->faid; ?>" class="panel-collapse collapse <?php if($faq === reset($faqs)) echo 'in' ; ?>">
                    <h3 class="panel-body">
                                <?php echo $faq->fadesc; ?>
                        </h3>
                  </div>
                </div>
		 <?php } ?>

              </div>
		  <?php } ?>
                   
                         
        </div> 
    </div>
</div>