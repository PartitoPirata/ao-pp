<nav class="navbar navbar-default" role="navigation" style="margin-bottom:0;background:#ffffff;border-left:0;border-right:0;border-bottom:1px solid #660000;border-radius:0;">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" target="_blank" href="http://www.partito-pirata.it" style="width:96px;height:48px;background:transparent url(<?php echo $base_url; ?>img/pp-it.png) no-repeat center center;">&nbsp;</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li class="<?php if(!$_GET['file']){ echo 'active';} ?>"><a href="<?php echo $base_url; ?>">AO 2014</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">AREA CONTATTI<b class="caret"></b></a>
        <ul class="dropdown-menu">
          
          <li class="<?php if($_GET['file'] == 'messages'){ echo 'active';} ?>"><a href="<?php echo $base_url; ?>messages/">Messaggi pubblici</a></li>
          <li class="<?php if($_GET['file'] == 'streaming'){ echo 'active';} ?>"><a href="<?php echo $base_url; ?>streaming/">Conferenza stampa<sup><small>STREAM+CHAT</small></sup></a></li>
          <li class="<?php if($_GET['file'] == 'chat'){ echo 'active';} ?>"><a target="_blank" href="<?php echo $base_url; ?>chat/">Conferenza stampa<sup><small>SOLO CHAT</small></sup></a></li>
          
        </ul>
      </li>
      
      <li class="<?php if($_GET['file'] == 'streaming'){ echo 'active';} ?>"><a href="<?php echo $base_url; ?>streaming/">DIRETTA</a></li>
      <li class="<?php if($_GET['file'] == 'board'){ echo 'active';} ?>"><a href="<?php echo $base_url; ?>board/">INTERVENTI</a></li>
      
    </ul>
    <!--
    <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
    -->
  </div><!-- /.navbar-collapse -->
</nav>
