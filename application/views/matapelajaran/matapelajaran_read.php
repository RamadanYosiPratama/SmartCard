
<section class="content-header">
      <h1>
       SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
         <li><a href="<?php echo $back ?>">MataPelajaran</a></li>
        <li class="active"><?php echo $button ?> MataPelajaran</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
  
			<legend><?php echo $button ?> MataPelajaran</legend>
			
			<a href="<?php echo site_url('matapelajaran/update/'.$kode_matapelajaran) ?>" class="btn btn-primary">Update</a>
		
			<a href="<?php echo site_url('matapelajaran') ?>" class="btn btn-warning">Cancel</a>
			<p></p>
			<table class="table table-striped table-bordered">
				<tr><td>Kode Matapelajaran</td><td><?php echo $kode_matapelajaran; ?></td></tr>
				<tr><td>Nama Matapelajaran</td><td><?php echo $nama_matapelajaran; ?></td></tr>
				<tr><td>Lama Jam Belajar</td><td><?php echo $lama_belajar; ?></td></tr>
					<td>Kelas</td>
					<td><?php echo $nama_kelas; ?></td>
				</tr>
					<tr><td></td><td><a href="<?php echo site_url('matapelajaran') ?>" class="btn btn-default">Cancel</a></td></tr>
			</table>
