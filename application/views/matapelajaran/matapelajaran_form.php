
	<section class="content-header">
      <h1>
       SmartCard Course
        <small>Be creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">Matapelajaran</a></li>
        <li class="active"><?php echo $button ?> Matapelajaran</li>
      </ol>
    </section>

    <section class="content">


      <div class="box">        
        <div class="box-body">
		

		   <legend><?php echo $button ?> Matapelajaran</legend>	
			<form action="<?php echo $action; ?>" method="post">
			<div class="form-group">
				<label for="varchar">Kode Matapelajaran <?php echo form_error('kode_matapelajaran') ?></label>
				<input type="text" class="form-control" name="kode_matapelajaran" id="kode_matapelajaran" placeholder="Kode Matapelajaran" value="<?php echo $kode_matapelajaran; ?>" />
			</div>
			<div class="form-group">
				<label for="varchar">Nama Matapelajaran <?php echo form_error('nama_matapelajaran') ?></label>
				<input type="text" class="form-control" name="nama_matapelajaran" id="nama_matapelajaran" placeholder="Nama Matapelajaran" value="<?php echo $nama_matapelajaran; ?>" />
			</div>
			<div class="form-group">
				<label for="enum">Lama Jam Pelajaran <?php echo form_error('lama_belajar'); ?></label>
				<?php 
					$pilihan = array("" => "-- Pilihan --",
											 "1" => "1",
											 "2" => "2",
											 "3" => "3",
											 "4" => "4",
											 "5" => "5",
											 "6" => "6");
				   echo  form_dropdown('lama_belajar', $pilihan,$lama_belajar, 'class="form-control" id="lama_belajar"'); ?>
			</div>
			<div class="form-group">
				<label for="int">Kelas<?php echo form_error('id_kelas') ?></label>			
				<?php 
					echo combobox('id_kelas','kelas','nama_kelas','id_kelas', $id_kelas);
				?> 	
			</div>
			
			 <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
			<a href="<?php echo site_url('matapelajaran') ?>" class="btn btn-default">Cancel</a>
		</form>
