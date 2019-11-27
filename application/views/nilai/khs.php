
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>	
        <li><a href="<?php echo $back ?>">Kartu Hasil Studi siswa</a></li>
        <li class="active"><?php echo $button ?> Kartu Hasil Studi siswa</li>
		
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
			
			<?php
			$ci = get_instance(); 
			$ci->load->helper('my_function'); 
			?>
			
			<center>
					<legend>KARTU HASIL STUDI</strong></legend>
					<table>
					   <tr>
							<td><strong>NIS </strong></td><td> : <?php echo $mhs_nis; ?></td>
					   </tr>
					   <tr>
							<td><strong>Nama</strong></td><td> :  <?php echo $mhs_nama; ?></td>
					   </tr>
					   <tr>
							<td><strong>Kelas</strong></td><td> :  <?php echo $mhs_kelas; ?></td>
					   </tr>
					   <tr>
							<td><strong>Tahun akademik (semester)</strong></td><td>&nbsp;:  <?php echo $thn_akad; ?></td>
					   </tr>
					</table>
					<br />
					<table  class="table table-bordered table table-striped">
						<tr>
							<td>NO</td>
							<td>KODE</td>
							<td>MATAPELAJARAN</td>
							<td>LAMA JAM BELAJAR</td>
							<td>NILAI</td> 
							<td>SKOR</td>
						</tr>
						<?php
							$no   			=	0; 
							$jlama_belajar 	=	0; 
							$jSkor			=	0; 
					
						foreach ($mhs_data as $row){  
						 $no++;	
						?>
						   <tr>
								<td> <?php echo $no; ?></td>
								<td> <?php echo $row->kode_matapelajaran; ?></td>
								<td> <?php echo $row->nama_matapelajaran; ?></td>
								<td align="right"> <?php echo $row->lama_belajar; ?></td>
								<td align="center"> <?php echo $row->nilai; ?></td>
								<td align="right"> <?php echo skorNilai($row->nilai,$row->lama_belajar); ?></td>
								<?php
								$jlama_belajar+=$row->lama_belajar;
								$jSkor+=skorNilai($row->nilai,$row->lama_belajar);
								?>
						   </tr>  
						<?php
						}
						?>
						<tr>
								<td colspan="3">Jumlah </td> 
								<td align="right"> <?php echo $jlama_belajar; ?></td>
								<td>&nbsp;</td>
								<td align="right"> <?php echo $jSkor; ?></td>
						</tr>
					</table>
						Indeks Prestasi :  <?php echo number_format($jSkor/$jlama_belajar,2); ?>
			</center>
			 