<?php $this->getChildBlock("page/preloader"); ?>
<?php $this->getChildBlock("admin/navteacher"); ?>
<?php $this->getChildBlock("page/icon"); ?>
<style type="text/css">
	.bx {
		border: 1px solid red;
	}
</style>
<!-- Main START -->
<main>
<?php $this->getChildBlock("admin/profilemenu"); ?>
<div class="container">
	<h1 class="thin">Supervisor Rating</h1>
	<div id="dashboard">
		<?php $this->getChildBlock("page/alert"); ?>
		<div class="row ">
			<form name="frmSelect" method="GET" action="">
				<div class="input-field col s3">
					<select name="scyear">
						<option value="" disabled selected>Choose your option</option>
						<?php
							foreach( Core::getSingleton("evaluation/evaluation")->getSchoolYear() as $scyear ) {
								?>
									<option value="<?=$scyear?>"><?=$scyear?></option>
								<?php
							}
						?>
					</select>
					<label>School Year</label>
				</div>
				<div class="input-field col s3">
					<select name="sem">
						<option value="" disabled selected>Choose your option</option>
						<?php
							foreach( Core::getSingleton("evaluation/evaluation")->getSemester() as $sem ) {
								?>
								<option value="<?=$sem?>"><?=$sem?></option>
								<?php
							}
						?>
					</select>
					<label>Semester</label>
				</div>
				<div class="input-field col s3">
					<input type="submit" class="btn" name="btnView" value="View">
				</div>
			</form>
		</div>
		<div class="row"> 
			<!-- Latest Tasks START -->
			<div class="col s12 m12">
				<div class="card hoverable">
					<ul class="collection with-header">
						<div class="collection-header primary-color" style="background-color: #546e7a !important;">
							<h5 class="light center" style="color: white;">
								Ratings
							</h5>
						</div>
						<div id="tasks">
							<?php
								$session 			= Core::getSingleton("system/session");
								$request 			= Core::getSingleton("url/request")->getRequest();
								$auth 				= $session->get("auth");
								$accountDb 			= Core::getModel("account/account");
								$accountDataDb 		= Core::getModel("account/accountdata");
								$departmentDb 		= Core::getModel("account/department");
								$evaluationDb 		= Core::getModel("evaluation/evaluation");
								$evaluationDetailsDb = Core::getModel("evaluation/evaluationdetails");
								$evaluatorDb 		= Core::getModel("evaluation/evaluator");

								$sem = Core::getSingleton("evaluation/evaluation")->getSemester()[0];
								$scyear = Core::getSingleton("evaluation/evaluation")->getSchoolYear()[0];

								if( isset($request["sem"]) ) {
									$sem = $request["sem"];
								}

								if( isset($request["scyear"]) ) {
									$scyear = $request["scyear"];
								}

								$evaluation = $evaluationDb->where("account_id", $auth->id)->first();
								$evaluationdetails = $evaluationDetailsDb
									->where("evaluation_id", $evaluation->id)
									->where("school_year", $scyear)
									->where("semester", $sem)
									->get();
								foreach( $evaluationdetails as $ed ) {
									$rs = $evaluatorDb
										->where("account_id" , $ed->evaluator_id)
										->where("type", "Dean")
										->first();
									if( $rs ) {
										break;
									}
								}

								if( isset($rs) ) {
									Core::log( $rs );
									$accountData = $accountDataDb->where("account_id", $rs->account_id)->first();
									$dept = $departmentDb->where("id", $accountData->college_dept_id)->first();
								}
							?>
							<div class="container">
								<div class="row">
								<br>
									<div class="col s6">
										<span><b>Evaluator Name: </b><?=$rs->name?></span>
									</div>
									<div class="col s6">
										<span><b>College/Dept.: <?=$dept->label?></b></span>
									</div>
									<div class="col s6">
										<span><b>Position: </b><?=$rs->type?></span>
									</div>
								</div>
								<hr>
								<?php
											$criteriaDb = Core::getModel("admin/criteria");
											$subCriteriaDb = Core::getModel("admin/subcriteria");
											foreach( $criteriaDb->get() as $criteria ) {
												?>
												<div class="row">
												<div class="col s12">
													
													<h5><?=$criteria->label?></h5>
													<table class="col s6" style="margin-bottom: 15px;">
															<tbody>
													<?php
														foreach( $subCriteriaDb->where("evaluation_criteria_id", $criteria->id)->get() as $subCriteria ) {
															?>
															
																<tr>
																	<td><?=$subCriteria->question?></td>
																	<td>5</td>
																</tr>
															<?php
														}
													?>
													</tbody>
															</table>
												</div>
											</div>
												<?php
											} 
										?>
										
									
								
								<div class="row">
									<div class="input-field col s12 " >
										<i class="material-icons prefix">mode_edit</i>
										<textarea id="icon_prefix2" class="materialize-textarea "></textarea>
										<label for="icon_prefix2">Comments of the Dean / Supervisor</label>
									</div>
								</div>
							</div>

								<div class="row">
									<div class="col s2 offset-s9">
										<p><b>Average Rating:</b> 85</p>
									</div>
								</div>
						</div>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
</main>
<!-- Main END --> 

<?php $this->getChildBlock("page/footer"); ?>

  <!-- Modal Structure -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4 class="thin" style="color: #87a1ad;">Angelou Macabutas's Comment</h4>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
  </div>
<!-- Main END --> 
