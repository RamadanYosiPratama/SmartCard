
<section class="content-header">
      <h1>
         SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">Nilai Permatakpelajaran</a></li>
        <li class="active"><?php echo $button ?> Nilai Permatapelajaran</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
			<
			<legend>Input Nilai Permatapelajaran</legend>	
			<form action="<?php echo $action; ?>" method="post">
			<?php echo validation_errors(); ?>
				<div class="form-group">
					<label for="int">Tahun Akademik (Semester <?php echo form_error('id_thn_akad') ?> )</label>
					<?php 
					
						$query = $this->db->query('SELECT id_thn_akad, semester, 
						                           CONCAT(thn_akad,"/") as ta_sem 
												   FROM thn_akad_semester ORDER BY id_thn_akad DESC');
						$dropdowns = $query->result();
						  
						  foreach($dropdowns as $dropdown) {
									
									if($dropdown->semester == 1){
										$tampilSemester = "Ganjil";
									}
									else{
										$tampilSemester = "Genap";
									}
										
									
									$dropDownList[$dropdown->id_thn_akad] = $dropdown->ta_sem ." ".$tampilSemester;
						  }
						  echo  form_dropdown('id_thn_akad',$dropDownList,'','class="form-control" id="id_thn_akad"'); ?>		
						
						<div class="form-group">
							<label for="char">Kode Matapelajaran <?php echo form_error('kode_matapelajaran') ?></label>
							<input type="text" class="form-control" name="kode_matapelajaran" id="kode_matapelajaran" placeholder="Kode Matapelajaran" value="<?php echo $kode_matapelajaran; ?>" />
						</div>   
				</div>
					
				<button type="submit" class="btn btn-primary">Proses</button> 	   
			</form>
	