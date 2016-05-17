 <?php  echo ""; ?>
  <!-- Right top nav -->
        <div class="topNav">
            <ul class="userNav">
            <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_profile')); ?>" title="Profile" class="screen tool-tip"></a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Sitesettings','action'=>'admin_index')); ?>" title="Setting" class="settings tool-tip"></a></li>
                <li><a href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'admin_logout')); ?>" title="Logout" class="logout tool-tip"></a></li>
            </ul>
           <!-- <a title="" class="iButton"></a>
            <a title="" class="iTop"></a>
            <div class="topSearch">
                <div class="topDropArrow"></div>
                <form action="">
                    <input type="text" placeholder="search..." name="topSearch" />
                    <input type="submit" value="" />
                </form>
            </div>-->
        </div>