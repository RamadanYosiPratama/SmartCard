
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">kelas</a></li>
        <li class="active"><?php echo $button ?> kelas</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
			<!-- Form input dan edit kelas -->
			<legend><?php echo $button ?> kelas</legend>	   
			<form action="<?php echo $action; ?>" method="post">
			<div class="form-group">
					<label for="varchar">ID Kelas<?php echo form_error('id_kelas') ?></label>
					<input type="text" class="form-control" name="id_kelas" id="id_kelas" placeholder="id kelas" value="<?php echo $id_kelas; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Kode kelas<?php echo form_error('kode_kelas') ?></label>
					<input type="text" class="form-control" name="kode_kelas" id="kode_kelas" placeholder="Kode kelas" value="<?php echo $kode_kelas; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Nama Kelas<?php echo form_error('nama_kelas') ?></label>
					<input type="text" class="form-control" name="nama_kelas" id="nama_kelas" placeholder="Nama kelas" value="<?php echo $nama_kelas; ?>" />
				</div>
				<input type="hidden" name="id_kelas" value="<?php echo $id_kelas; ?>" /> 
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
				<a href="<?php echo site_url('kelas') ?>" class="btn btn-default">Cancel</a>
			</form>  
			<!--// Form kelas-->