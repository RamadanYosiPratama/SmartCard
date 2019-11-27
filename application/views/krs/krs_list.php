<!-------------------------------------------------------*/
/* Copyright   : Yosef Murya & Badiyanto                 */
/* Publish     : Penerbit Langit Inspirasi               */
/*-------------------------------------------------------->
<section class="content-header">
      <h1>
        SmartCard Course
        <small>Be Creative and Smart</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>        
        <li class="active"> Kartu Rencana Studi</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">        
        <div class="box-body">
		
			<!-- Form KRS-->
			<center>
				<legend><strong>KARTU RENCANA STUDI</strong></legend>
				<table>
					<tr>
						<td><strong>NIS </strong></td> <td> &nbsp;: <?php echo $nis; ?></td>
					<tr>
					<tr>
						<td><strong>Nama </strong></td><td> &nbsp;: <?php echo $nama_lengkap;?> </td>
					</tr>
					<tr>
						<td><strong>Kelas</strong></td> <td> &nbsp;: <?php echo $kelas;?> </td>
					</tr>
					<tr>
						<td><strong>Tahun akademik(semester) </strong></td> <td> &nbsp;: <?php echo $thn_akad.'&nbsp;('.$semester.')';?> </td>
					</tr>
				</table>
			</center>
			<br />
			<table class="table table-bordered table table-striped" style="margin-bottom: 10px;">
				<tr>
					<th>NO</th>	
					<th>KODE</th>
					<th>MATAKULIAH</th>
					<th>ACTION</th>
				</tr>
				<?php
				  $no=1; // Nomor urut dalam menampilkan data
				  $jumlahSks=0; // Jumlah SKS dimulai dari 0
				  
				  // Menampilkan data KRS
				  foreach($krs_data as $krs)
				  {
				?>
				<tr>
					 <td width="80px"><?php echo $no++; ?></td>
					 <td><?php echo $krs->kode_matapelajaran;?></td>
					 <td><?php echo $krs->nama_matapelajaran; ?></td>
					
					 <td style="text-align:center" width="120px">
						<?php 	
							// Button untuk melakukan edit KRS
							echo anchor(site_url('krs/update/'.$krs->id_krs),
								 '<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>'); 
							echo '&nbsp';
							// Button untuk melakukan delete KRS
							echo anchor(site_url('krs/delete/'.$krs->id_krs),
								 '<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>',
								 'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
						?>
					</td>
				</tr>
				<?php
					}
				?>
					
			  </table>    
			 <?php 
				// Button untuk melakukan create KRS
				echo anchor(site_url('krs/create/'.$nis.'/'.$id_thn_akad),'Create', 'class="btn btn-primary"'); 
			 ?>
			</div>
