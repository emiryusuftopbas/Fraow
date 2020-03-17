<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo route('dirname') ?>/assets/stylesheets/bulma.min.css">
    <link rel="stylesheet" href="<?php echo route('dirname') ?>/assets/stylesheets/main.css">
    <link rel="stylesheet" href="<?php echo route('dirname') ?>/assets/stylesheets/croppie.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--   <link rel="stylesheet" href="stylesheets/debug.css"> -->
    <title>froaw</title>
  </head>
  <body>
    
    <div class="bgImage bgAct"></div>
    <section class="hero is-fullheight">
      <div class="hero-head">
        <header class="navbar is-transparent" id="Header">
          <div class="container">
            <div class="navbar-brand">
              <a href="<?php echo route('dirname'); ?>" class="navbar-item">
                <img src="./assets/images/logo.png" alt="Logo">
              </a>
              <span class="navbar-burger burger" data-target="navbarMenuHeroC">
                <span></span>
                <span></span>
                <span></span>
              </span>
            </div>
            <div id="navbarMenuHeroC" class="navbar-menu ">
              <div class="navbar-end">
                <a class="navbar-item has-text-weight-semibold">
                  Analyze
                </a>
                <a class="navbar-item has-text-weight-semibold">
                  statistics
                </a>
                
                <?php if(!(@$_SESSION['loginsession'])){  ?>
                <span class="navbar-item">
                  <a href="#" class="button" id="signinModalButton">
                    <span class="icon">
                      <i class="fa fa-sign-in"></i>
                    </span>
                    <span>Sign In</span>
                  </a>
                </span>
                <?php }else {?>
                
                <nav class="navbar" role="navigation" aria-label="dropdown navigation">
                  <div class="navbar-item has-dropdown" id="userMenuDropdownMain">
                    <a class="navbar-link" id="userMenuDropdownButton">
                      <i class="fa fa-user-circle-o is-size-6" aria-hidden="true"></i>
                    </a>
                    <div class="navbar-dropdown" id="userMenuDropdown">
                      <a href="<?php echo route('dirname'); ?>/profile" class="navbar-item">
                        Profile
                      </a>
                      <a href="<?php echo route('dirname'); ?>/settings" class="navbar-item">
                        Settings
                      </a>
                      <a href="<?php echo route('dirname'); ?>/help" class="navbar-item">
                        Help
                      </a>
                      <hr class="navbar-divider">
                      <a href="<?php echo route('dirname'); ?>/signout" class="navbar-item">
                        Sign out
                      </a>
                    </div>
                  </div>
                </nav>
                
                <?php }?>
                
              </div>
            </div>
          </div>
        </header>
      </div>
      <?php  if(!(@$_SESSION['loginsession'])){ include 'modals.php';}?>