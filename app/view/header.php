<!DOCTYPE HTML>
<head>
<title><?php echo $title;?></title>
<meta charset="utf-8" />
<meta name="copyright" content="Powered by PMC" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="<?php echo site_url();?>/static/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo site_url();?>/static/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo site_url();?>/static/css/docs.css" rel="stylesheet">
    <script type="text/javascript">
        var site_url = '<?php echo site_url();?>';
    </script>
</head>
<body id="">
<header>
    <a href="<?php echo site_url();?>"><img src="<?php echo site_url();?>/static/img/logo.png"></a>
    <div id="menu">
        <ul class="nav nav-pills">
        <li><a href="<?php echo site_url();?>" id="menu-home">首页</a></li>
        <?php if ( ! empty($menu) ) foreach ($menu as $key => $value) {?>
                <li><a href="<?php echo url_convert('topic/tag').'/'.$value['_id'];?>" id="menu-tag-<?php echo $value['_id'];?>"><?php echo $value[name];?></a></li>
        <?php }?>
        <?php if ( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] && $_COOKIE['pmc_superman'] ) { ?>
        <li><a href="<?php echo url_convert('topic/tag_admin');?>">管理</a></li>
        <?php }?>
        </ul>
    </div>
    <div id="info"></div>
</header>

<div id='guide-outer'>
    <div id='guide'>
        <ul class='pills'>
            <?php if ( $_COOKIE['pmc_user_nick'] && $_COOKIE['pmc_user_id'] && ! isset($GLOBALS['close_add_topic_btn']) ) { ?>
                <li class="right"><a class="btn btn-success" href="<?php echo url_convert('topic/add')?>" class="hover">发布消息</a></li>
            <?php } ?>
        </ul>
        <h1><?php echo $notice_title;?></h1>
        <p><?php echo $notice_content;?></p>
    </div>
</div>