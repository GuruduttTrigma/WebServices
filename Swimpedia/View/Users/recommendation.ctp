<?php echo $this->element('top-header'); ?>
<div class="row-fluid">       
	  <div class="span12" style="background-color:white;">
      <div style="margin-left:20%;">
          <ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#home">Received</a></li>
    <li><a href="#profile">Given</a></li>
    <li><a href="#messages">Ask for  recommendations </a></li>
    </ul>
     
    <div class="tab-content">
    <div class="tab-pane active" id="home">
    <!-----------------first--------------->
    <h4 style="color:#CC6600;">Manage recommendations you've received</h4>
     <span style="font-size:10px;">(Looking for recommendations you've made? Click here.)</span><hr/>
    <?php foreach($edu as $re): if($re['UserEducation']['user_id']==$user_id){ ?>
    <?php if($re['UserEducation']['edu_school']){ ?>
   <?php echo $this->Html->image("edu.png"); ?> <span style="font-size:16px;">Student at<?php echo $re['UserEducation']['edu_school']; ?></span><br/>
    <span style="font-size:14px;margin-left:10px;">You have <b>no recommendations</b> for this education. <a>[ Ask to be recommended ]</a></span>
    <br/><hr/>
    <?php } ?>
    <?php  } endforeach; ?>
    <?php foreach($work as $re): if($re['UserWorkSince']['user_id']==$user_id){ ?>
    <?php if($re['UserWorkSince']['exp_company_name']){ ?>
    <?php echo $this->Html->image("crown.png"); ?><span style="font-size:16px;"><?php echo $re['UserWorkSince']['exp_title']."&nbsp;at&nbsp;"; ?><?php echo $re['UserWorkSince']['exp_company_name']; ?></span><br/>
    <span style="font-size:14px;margin-left:10px;">You have <b>no recommendations</b> for this education. <a>[ Ask to be recommended ]</a></span>
    <br/><hr/>
    <?php } ?>
    <?php  } endforeach; ?>
    <a><span><i class="icon-plus"></i>add a job</span></a><a><span style="margin-left:18px;"><i class="icon-plus"></i>add a school</span></a>
    <br/>
    <?php echo $this->form->create('Recommendation'); ?>
    <h4 style="color:#CC6600;">Make a recommendation</h4>
    <b>Name:</b><input type="text" name="data[recommendation][first_name]"  style="margin-left:10px;" placeholder="First Name"/><input type="text" name="data[recommendation][last_name]"   style="margin-left:10px;" placeholder="Last Name"/><input type="text" name="data[recommendation][email]"  style="margin-left:10px;" placeholder="Email"/><br/>
    <b style="color:#777777;">Recommend this person as a:</b><br/>
    <input type="radio" name="data[recommendation][type]" value="Colleague"/><b>Colleague:</b> You've worked with them at the same company<br/>
    <input type="radio" name="data[recommendation][type]" value="Service Provider"/><b>Service Provider:</b> You've hired them to provide a service for you or your company<br/>
    <input type="radio" name="data[recommendation][type]" value="Business Partner"/><b>Business Partner:</b> You've worked with them, but not as a client or colleague<br/>
    <input type="radio" name="data[recommendation][type]" value="Student"/><b>Student:</b> You were at school when they were there, as a fellow student or teacher<br/><br/>
    <div align="right" style="margin-right:30%;"><button class="btn btn-warning" type="submit">Continue</button></div><br/><br/>
    </form>
    <div style="width:100%;">
     <div style="width:30%;float:left;">
     <span style="font-size:16px;">Get Recommended</span>
     <p align="justify;" style="font-size:12px;">Users with recommendations are three times as likely to get inquiries through LinkedIn searches. Ask your colleagues to speak up for you — get endorsed.</p>
     </div>
      <div style="width:30%;float:left;margin-left:15%;">
      <a><span style="font-size:16px;">About Recommendations</span></a><br/>
      <p align="justify;" style="font-size:12px;">
    Why get recommended?<br/>
    Who should recommend you?<br/>
    What happened to endorsements?<br/>
    Where are recommendations found?<br/>
</p>
      </div>
    </div>
<!----------------------------end---------------->
    </div>
    <div class="tab-pane" id="profile">
    <!-----------------------second----------------->
   <h4 style="color:#CC6600;"> Manage recommendations you've sent</h4><br/>
You haven't recommended anyone yet.<br/><br/>
Recommending service providers, colleagues, and business partners:
<ul>
<li>Helps them win clients</li>
<li>    Helps them hire and get hired</li>
 <li>   Shares your knowledge with other professionals</li>
 <li>   Strengthens your relationships and your network</li>
</ul>
Now you can recommend professional service providers — even if they aren't Academatch users.
<br/>
    <h4 style="color:#CC6600;">Make a recommendation</h4>
    <b>Name:</b><input type="text" name="f_name"  style="margin-left:10px;" placeholder="First Name"/><input type="text" name="l_name"   style="margin-left:10px;" placeholder="Last Name"/><input type="text" name="email"  style="margin-left:10px;" placeholder="Email"/><br/>
    <b style="color:#777777;">Recommend this person as a:</b><br/>
    <input type="radio" name="colleague"/><b>Colleague:</b> You've worked with them at the same company<br/>
    <input type="radio" name="colleague"/><b>Service Provider:</b> You've hired them to provide a service for you or your company<br/>
    <input type="radio" name="colleague"/><b>Business Partner:</b> You've worked with them, but not as a client or colleague<br/>
    <input type="radio" name="colleague"/><b>Student:</b> You were at school when they were there, as a fellow student or teacher<br/><br/>
    <div align="right" style="margin-right:30%;"><button class="btn btn-warning">Continue</button></div><br/><br/>
<!-------------------------end------------------------------------->
    </div>
    <div class="tab-pane" id="messages">
    <!--------------------third----------------------->
    <h4 style="color:#CC6600; margin-left:30px;">Ask your connections to recommend you</h4>
    <h5><i class="badge badge-info">1</i>&nbsp;What do you want to be recommended for?</h5>
    <select>
    <option>Choose</option>
     <?php foreach($edu as $re): if($re['UserEducation']['user_id']==$user_id){ ?>
     <option><?php echo "Student at&nbsp;".$re['UserEducation']['edu_school']; ?></option>
     <?php } endforeach; ?>
      <?php foreach($work as $re): if($re['UserWorkSince']['user_id']==$user_id){ ?>
      <option><?php echo $re['UserWorkSince']['exp_title']."&nbsp;at&nbsp;"; ?><?php echo $re['UserWorkSince']['exp_company_name']; ?></option>
       <?php } endforeach; ?>
    </select>
     <a><span style="margin-left:18px;"><i class="icon-plus"></i>add a job</span></a><a><span style="margin-left:18px;"><i class="icon-plus"></i>add a school</span></a><br/><hr/>
     <h5><span class="badge badge-info">2</span>&nbsp;Who do you want to ask?</h5><br/>
     <b>Your connections:</b><input type="text"/><br/>
     <span style="font-size:10px;margin-left:150px;">You can add 200 more recipients</span>
     <h5><span class="badge badge-info">3</span>&nbsp;Create your message</h5><br/>
     <div class="control-group">
    <label class="control-label"> <b>From:</b></label>
	<div class="controls">
		<?php echo $first_name; ?> (<span style="margin-left:10px;"><?php echo $email; ?></span>)<br/>
	</div>
  </div>
  <div class="control-group">
    <label class="control-label"> <b>Subject:</b></label>
	<div class="controls">
		<input type="text" placeholder="Can you recommend me?"/>
	</div>
  </div>   
  <div class="control-group">
    <label class="control-label"></label>
	<div class="controls">
		
     <textarea rows="10" cols="20" placeholder = "Write Your Message..........."></textarea><br/>
     <span style="font-size:10px;"><b>Note:</b> Each recipient will receive an individual email. This will not be sent as a group email.</span>
	</div>
  </div>
  <div class="form-actions">
     <button type="submit" name="save" id="update" class="btn btn-info" style="margin-left:40px;">Send</button>
</div>   
     
     
     


    <!-------------end------------------------------------->
    </div>
    </div>
     </div>
    <script>
    $(function () {
    $('#myTab a:first').tab('show');
	    $('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
    })
    })
    </script>
	  </div>
</div>
<?php echo $this->element('footer'); ?>