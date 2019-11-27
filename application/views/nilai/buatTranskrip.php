
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="../admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transkrip Nilai</li>
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
					<legend>TRANKRIP NILAI</legend>
					<table>
						<tr>
							<td>NIS </td> <td> : <?php echo $nis; ?></td>
						</tr>
						<tr>
							<td>Nama </td><td> : <?php echo $nama; ?></td>
						</tr>
						<tr>
							<td>Kelas</td> <td> : <?php echo $kelas; ?></td>
						</tr>
					</table>
					<br />
					<table  class="table table-bordered table table-striped">
					<tr>
						<td>NO</td>
						<td>KODE</td>
						<td>MATAPELAJARAN</td>
						<td align="center">LAMA JAM BELAJAR</td>
						<td align="center">NILAI</td> 
						<td align="center">SKOR</td>
					</tr>
				<?php
					$no   =0; 
					$jlama_belajar=0; 
					$jSkor=0; 
					
					
					foreach ($trans as $row){  
					 $no++;	
				?>
					 <tr>
					   <td><?php echo $no; ?></td>
					   <td><?php echo $row->kode_matapelajaran; ?></td>
					   <td><?php echo $row->nama_matapelajaran; ?></td>
					   <td align="center"><?php echo $row->lama_belajar; ?></td>
					   <td align="center"><?php echo $row->nilai; ?></td>
					   <td align="center"><?php echo skorNilai($row->nilai,$row->lama_belajar); ?></td>
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
						<td align="center"><?php echo $jlama_belajar; ?></td>
						<td>&nbsp;</td>
						<td align="center"><?php echo $jSkor; ?></td>
					  </tr>
					</table>
					Indeks Prestasi : <?php echo number_format($jSkor/$jlama_belajar,2); ?>
			</center>

			 
 