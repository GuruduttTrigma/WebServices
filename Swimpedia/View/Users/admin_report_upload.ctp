<div class='contentTop' style='padding: 0%;'>
    <?php
    echo $this->element('admin_header');
    echo $this->element('admin_sidebar');
    ?>
</div>
<div class="content" style="margin-left: 100px;">
    <div class="contentTop">
        <span class="pageTitle"><span class="icon-screen"></span>Upload Report</span>
        <div class="clear"></div>
    </div>
    <?php $x=$this->Session->flash(); ?>
    <?php if($x){ ?>
    <div class="nNote nSuccess" id="flash">
        <div class="" style="text-align:center" > <?php echo $x; ?></div>
    </div>
    <?php } ?>
    <div class="breadLine">
        <div class="bc">
            <ul id="breadcrumbs" class="breadcrumbs">
                <li style='background:url("<?php echo $this->webroot; ?>img/icons/breadsHome.png") no-repeat scroll 12px 10px transparent'><a style="background:url('<?php echo $this->webroot; ?>img/icons/breadsArrow.png') no-repeat scroll 100% 10px transparent;" href="<?php echo $this->Html->url(array('controller'=>'Users','action'=>'dashboard'));?>"><?php echo __('Dashboard');?></a></li>
                <li class='current'><a><?php echo __('Report Upload');?></a></li>
            </ul>
        </div>
    </div>
    <div class="wrapper">
        <div class="users form">
            <?php echo $this->Form->create('User',array('type'=>'file')); ?>
            <fieldset>
                <div class="widget fluid">
                    <div class="whead">
                        <h6>Upload Report Form</h6>
                        <div class="clear"></div>
                    </div>
                    <?php echo $this->Form->input('id');?>
                    <div class="formRow">
                        <div class="grid3"><label>Select a User:</label></div>
                        <div class="grid9">
                            <select name="data[User][id]" required>
                                <option>---Select a User---</option>
                                <?php foreach($users as $user){
                                $id = $user['User']['id'];
                                $username = $user['User']['name'];
                                ?>
                                <option value='<?php echo $id;?>'>
                                            <?php echo $username; ?>
                                </option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Upload CSV/Excel File:</label></div>
                        <div class="grid9"><input type="file" name="data[User][csv_file]"/></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <div class="grid3"><label>Automatically Send Push:</label></div>
                        <div class="grid9"><input type="checkbox" name="data[auto]"/></div>
                        <div class="clear"></div>
                    </div>
                    <div style='margin-top: 2%;margin-left: 40%;'>
                        <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'admin_report_upload'));?>" onclick='confirm("Are you sure you want to upload this file")'>
                            <button type='submit' class='buttonL bGreen'>Submit</button>
                        </a>
                        <a href="<?php echo $this->Html->url(array('controller'=>'users','action'=>'dashboard'));?>" class="buttonL bSea">
                            Back
                        </a>
                    </div>
                </div>
            </fieldset>

            </form>
        </div>
    </div>