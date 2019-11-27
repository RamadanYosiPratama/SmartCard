

<?php
$ci = get_instance(); // Memanggil object utama	  
$ci->load->model('Matapelajaran_model'); 
$ci->load->model('Thn_akad_semester_model'); 
?>
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">Nilai Permatapelajaran</a></li>
        <li class="active"><?php echo $button ?> Nilai Permatapelajaran</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
			<!-- Form KRS-->
<?php
	
	if($list_nilai == null){		
		$thn      = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad);
		$semester = $thn->semester==1;
		

		if($semester == 1){
			$tampilSemester = "Ganjil";
		}
		else{
			$tampilSemester = "Genap";  
		}		
?>	
			<div class="alert alert-danger">
				<strong>MAAF!</strong> tidak ada matapelajaran <?php echo $ci->Matapelajaran_model->get_by_id($kode_matapelajaran)->nama_matapelajaran; ?> di tahun ajaran <?php echo $thn->thn_akad ." (". $tampilSemester .")"; ?>
			</div>	
		<?php
	}
	else{
		?>
			<center>
				<legend>MASUKKAN NILAI AKHIR</legend>
			
			<table>
				<tr>
					<td>Kode Matapelajaran </td> <td>: 
					<?php echo $kode_matapelajaran;?></td>
				</tr>
				<tr>
					<td>Matapelajaran</td><td> : 
					<?php echo $ci->Matapelajaran_model->get_by_id($kode_matapelajaran)->nama_matapelajaran;?></td>
				</tr>
				<tr>
					<td>Lama Jam Belajar</td> <td> : 
					<?php echo $ci->Matapelajaran_model->get_by_id($kode_matapelajaran)->lama_belajar;?></td>
				</tr>
				<?php 
					  $thn      = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad); // Memilih tahun akademik berdasarkan id
					  $semester = $thn->semester==1; // Semester secara default dimulai dari semester 1
					  
					  // Merubah data semester dalam bentuk string
					  if($semester == 1){
						$tampilSemester = "Ganjil";
					  }
					  else{
						$tampilSemester = "Genap";  
					  }
				?> 

				<tr>
					<td>Tahun akademik (semester)</td> <td> : <?php echo $thn->thn_akad ."(". $tampilSemester .")"; ?> </td>
				</tr>
			</table>
			</center>
			<form action="<?php echo $action; ?>" method="post">
				<table  class="table table-bordered table table-striped">
				<tr>
					<td>NO</td>
					<td>NIS</td>
					<td>NAMA</td>
					<td>NILAI</td>
				</tr>
				
				<?php
					$no=0; // Nomor urut dalam menampilkan data 
					
					// Menampilkan data nilai
					foreach ($list_nilai as $row){  
						 $no++;	
				?>
						<tr>   
						   <td><?php echo $no; ?></td>
						   <td><?php echo $row->nis; ?></td>
						   <td><?php echo $row->nama_lengkap; ?></td>						 
							  <input type="hidden" name="id_krs[]"  value="<?php echo $row->id_krs;?>"/>
						   <td><input type="text" name="nilai[]"  value="<?php echo $row->nilai;?>"/></td>						    
						</tr>
				<?php
					}
				?>	
				</table>
				<button type="submit" class="btn btn-primary">Proses</button> 
			</form>
	<?php
		}
	?>	
