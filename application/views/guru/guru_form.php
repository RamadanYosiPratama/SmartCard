
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">guru</a></li>
        <li class="active"><?php echo $button ?> guru</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
		
			<legend><?php echo $button ?> guru</legend>	
        <form role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
		<input type="hidden"  class="form-control" name="id_guru" id="id_guru" value="<?php echo $id_guru; ?>" />
		<input type="hidden"  class="form-control" name="photo" id="photo" value="<?php echo $photo; ?>" />
	    <div class="form-group">
            <label for="varchar">Nign <?php echo form_error('niGn') ?></label>
            <input type="text" class="form-control" name="niGn" id="niGn" placeholder="NiGn" value="<?php echo $niGn; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama guru <?php echo form_error('nama_guru') ?></label>
            <input type="text" class="form-control" name="nama_guru" id="nama_guru" placeholder="Nama guru" value="<?php echo $nama_guru; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Alamat <?php echo form_error('alamat') ?></label>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
        </div>	    
		<div class="form-group">
		    <label for="varchar">Jenis Kelamin <?php echo form_error('jenis_kelamin') ?></label>
			<?php 
				$pilihan = array("" => "-- Pilihan --","laki-laki" => "Laki-laki", "perempuan" => "Perempuan");
				echo form_dropdown('jenis_kelamin', $pilihan,$jenis_kelamin, 'class="form-control" id="jenis_kelamin"'); 
				echo form_error('jenis_kelamin'); 
			?>	              
		</div>
	    <div class="form-group">
            <label for="varchar">Email <?php echo form_error('email') ?></label>
            <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Telp <?php echo form_error('telp') ?></label>
            <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
        </div>	  
		<div class="form-group">
			<label for="varchar">Photo <?php echo form_error('photo') ?></label>
				<div>
					<?php
						if($photo==""){
							echo"<p class='help-block'>Silahkan upload foto guru </p>";
						}
						else{
					?>
							<div>			
								<img src="./guru/<?php echo $photo; ?>">
							</div><br />
					<?php
						}
					?>
					<input type="file" name="photo" id="photo">							
				</div>
		</div>	
				
	    <button type="submit" class="btn btn-"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('guru') ?>" class="btn btn-default">Cancel</a>
	</form>
    