
					<div class="one_colums">
						<div class="tittle_main">
							<h2>SIGN-UP</h2>							
						</div>
								<div class="login_main">
                                                                     <?php echo $this->Form->create('User',array('type' => 'file','action' => 'signup'));?>
									<div class="sign_up">
										<div class="sign_up_tittle">Create a New Account.
										</div>
										<div class="sign_up_inner">
											<div class="sign_up_left">
												<div class="sign_up_name">First Name:
												</div>
												<?php echo $this->Form->input('first_name', array('label'=>"",'type'=>'text','class'=>'validate[required] sign_up_textbox'));?>
											</div>
											<div class="sign_up_right">
												<div class="sign_up_name">Last Name:
												</div>
												<?php echo $this->Form->input('last_name', array('label'=>"",'type'=>'text','class'=>'validate[required] sign_up_textbox'));?>
											</div>
										</div>
										<div class="sign_up_inner">
											<div class="sign_up_left">
												<div class="sign_up_name">Username:
												</div>
                                                                                            <?php echo $this->Form->input('username', array('label'=>"",'type'=>'text','class'=>'validate[required] sign_up_textbox'));?>
												
											</div>
											<div class="sign_up_right">
												<div class="sign_up_name">Password:
												</div>
												<?php echo $this->Form->input('password', array('label'=>"",'type'=>'password','class'=>'validate[required] sign_up_textbox'));?>
											</div>
										</div>
										<div class="sign_up_inner">
											<div class="sign_up_left">
												<div class="sign_up_name">Email:
												</div>
												<?php echo $this->Form->input('email', array('label'=>"",'type'=>'email','class'=>'validate[required] sign_up_textbox'));?>
											</div>
                                                                                    <div class="sign_up_right">
												<div class="sign_up_name">Image:
												</div>
												<?php echo $this->Form->input('profile_image', array('label'=>"",'type'=>'file','class'=>'validate[required] sign_up_textbox'));?>
											</div>
                                                                                    
											
										</div>
                                                                            
                                                                                <!--<div class="sign_up_inner">
											<div class="sign_up_left">
												<div class="sign_up_name">Contact:
												</div>
												<input class="sign_up_textbox" type="text" >
											</div>
                                                                                        
                                                                                        <div class="sign_up_right">
												<div class="sign_up_name">Home town:
												</div>
												<input class="sign_up_textbox" type="text" >
											</div>
											
										</div>-->
                                                                            
										<div class="sign_up_inner">
											<input class="submit_button" value="SUBMIT" type="submit">
										</div>
									</div>
                                                                    
                                                                        <?php echo $this->Form->end(); ?>
								</div>							
					</div>					
				</div>						
			</div>
		</div>