
<?php
$ci = get_instance(); 
$ci->load->helper('my_function'); 
$ci->load->model('Krs_model'); 
$ci->load->model('siswa_model'); 
$ci->load->model('Matapelajaran_model'); 
$ci->load->model('Thn_akad_semester_model');

$krs             = $ci->Krs_model->get_by_id($id_krs[0]); 
$kode_matapelajaran = $krs->kode_matapelajaran; 
$id_thn_akad     = $krs->id_thn_akad; 
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

    <section class="content">


      <div class="box">        
        <div class="box-body">
		

			<center>
				<legend>MASUKKAN NILAI AKHIR</legend>
				
				<table>
					<tr>
						<td>Kode Matapelajaran </td> 
						<td>: <?php echo $kode_matapelajaran;?></td>
					</tr>
					<tr>
						<td>Matapelajaran</td>
						<td> : <?php echo $ci->Matapelajaran_model->get_by_id($kode_matapelajaran)->nama_matapelajaran;?></td>
					</tr>
					<tr>
						<td>Lama Jam Belajar</td> 
						<td> : <?php echo $ci->Matapelajaran_model->get_by_id($kode_matapelajaran)->lama_belajar;?></td>
					</tr>
					<?php 
						$thn      = $ci->Thn_akad_semester_model->get_by_id($id_thn_akad); // Memanggil data berdasarkan id 	 	 
						$semester = $thn->semester == 1; // Semester ditampilkan dalam bentuk interger yaitu 1 (ganjil dan 2 (genap)
						
						// Merubah data semester dalam bentuk string
						if($semester){							
							$tampilSemester = "Ganjil";
						}
						else{							
							$tampilSemester = "Genap";
						}
					?> 

					<tr>
						<td>Tahun akademik (semester)</td> <td> : <?php echo $thn->thn_akad ." (". $tampilSemester .")"; ?> </td>
					</tr>
				</table>
			</center>
			<div>&nbsp;</div>
				<table  class="table table-bordered table table-striped">
					<tr>
						<td>NO</td>
						<td>NIS</td>
						<td>NAMA LENGKAP</td>
						<td>NILAI</td>
					</tr>
				<?php
					$no=0;
					for ($i=0; $i<sizeof($id_krs); $i++)
					{  
					 $no++;		
				?>
					<tr>  
						<td><?php echo $no; ?></td>
					        <?php $nis = $ci->Krs_model->get_by_id($id_krs[$i])->nis; ?>
					    <td><?php echo $nis; ?></td> 
					    <td><?php echo $ci->siswa_model->get_by_id($nis)->nama_lengkap; ?></td>
					    <td><?php echo $ci->Krs_model->get_by_id($id_krs[$i])->nilai; ?></td>				   
					</tr>
				<?php
					}
				?>	
				</table>