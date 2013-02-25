<!doctype html>  
<html lang="<?php echo $language['short']; ?>">
    <head>
        <?php
        $charset = 'UTF-8';
        include REALPATH . "/views/html_head_metas.php";
        include REALPATH . "/views/html_head_js_and_css_inclusion.php";
        ?>
        <style>
            .error{
                color: #FF0000;
                float: left;
                font-family: Arial,Helvetica,sans-serif;
                font-size: 11px;
                font-style: normal;
                height: auto;
                padding-top: 5px;
            }
        </style>
    </head>
    <body style="margin: 0;padding: 0;background-color: #FFFFFF; width: 100%">
	  

<!-- <?php if(SHOW_FILE_PATHS_IN_HTML===TRUE){ echo __FILE__;} ?> -->
<div class="center_main" style="width:500px;min-height:300px;max-height:300px;height:300px;">
	<div class="email_resposta_ko" style="width:500px;height:auto;">
	  <p><?php echo $notification_title; ?></p>
	</div>
    <div class="email_resposta_texto" style="width:500px;height:auto;">
	  <p><?php echo $notification_message; ?></p>
	</div>
</div>


</body>
</html>