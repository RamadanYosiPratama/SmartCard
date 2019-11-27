
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
		<!-- Button untuk melakukan update -->
		<a href="<?php echo site_url('guru/update/'.$id_guru) ?>" class="btn btn-primary">Update</a>
		<!-- Button cancel untuk kembali ke halaman dosen list --> 
		<a href="<?php echo site_url('guru') ?>" class="btn btn-warning">Cancel</a>
		<p></p> 
		 <!-- Menampilkan data dosen secara detail -->
        <table class="table table-striped table-bordered">
	    <tr><td>Photo</td><td><img src="../../guru/<?php echo $photo; ?>"</td></tr>
	    <tr><td>NIGN</td><td><?php echo $niGn; ?></td></tr>
	    <tr><td>Nama guru</td><td><?php echo $nama_guru; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>Jenis Kelamin</td><td><?php echo $jenis_kelamin; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Telp</td><td><?php echo $telp; ?></td></tr>	    
	    <tr><td></td><td><a href="<?php echo site_url('guru') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
      