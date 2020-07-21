<?php
/**
 * Created by Balqon Media Teknologi.
 * Author: Susanto Wibowo
 * Phone: 085376341110
 * Mail : susanto.wibowoo@gmail.com | bowo@balqon.tech
 * Website : https://balqon.co.id/ OR https://balqon.tech/
 */
$not_access = array("mahasiswa","dosen");
if($this->cek_login()== TRUE AND !in_array($this->baca_session("level"),$not_access)){
$get_data = rtrim($url_system[4],"-");
$nama_file = "excel_mahasiswa_".date("dmY").".xls";
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-type:   application/x-msexcel; charset=utf-8");
header("Content-Disposition: attachment; filename=$nama_file"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
function header_table($field)
{
	$html='<table border="0" width="100%">';
	$html .='<tr>';
	foreach($field as $value):
		$html .='<th>'.strtoupper($value).'</th>';
	endforeach;
	$html .='</tr>';
	return $html;
}

function LoadField($id)
{
	$arr_field = array("TAN"=>"a.tahun_angkatan","JRS"=>"a.id_jurusan","SMT"=>"b.id_semester");
	$field_tbl = "";
	foreach($arr_field as $prefix=>$field):
		if(substr($id,0,3) == $prefix){ $field_tbl=$field; }
	endforeach;
	return $field_tbl;
}

$kondisi_cari = ""; $data_ta='-'; $data_jurusan='-';
// jika kondisi cari is null
if(!empty($get_data)){
$arr_kondisi = explode("-",$get_data);
foreach($arr_kondisi as $id_cari):
	$field = LoadField($id_cari);
	if(substr($id_cari,0,3)=="TAN"){$id_cari=substr($id_cari,-4);} else {$id_cari=$id_cari;}
	if(substr($id_cari,0,3)=="JRS"){ // view jurusan
		$jurusan = $this->data_array("sikad_jurusan","id_jurusan='".$id_cari."'");
		$data_jurusan = $jurusan->jurusan." (".$jurusan->jenjang.")";
	}
	if(substr($id_cari,0,3)=="SMT"){ // view semester
		$ta = $this->data_array("sikad_semester","id_semester='".$id_cari."'");
		$data_ta = $ta->tahun_ajaran." (".$ta->semester.")";
	}
	if(!empty($field)){
		$kondisi_cari.="AND ".$field."='".$id_cari."' ";
	}
endforeach;
}
?>
<style>
body{
	width:750px;
	font-size:12px;
}
table {
	font-size:12px;
}
.hr {
	border-bottom:solid 1px #666666; padding:2px;
}
.spasi {
	padding:8px;
}
.border-head{
	border-top:dashed 1px #333333;
	border-bottom:dashed 1px #333333;
	padding:8px;
}
</style>
<table class="table" width="100%" border="0">
<tr><td colspan="16" align="left">&nbsp;</td></tr>
<tr><td colspan="16" align="left">List Data Mahasiswa</td></tr>
<tr><td colspan="16" align="left">T.A : <?= $data_ta; ?></td></tr>
<tr><td colspan="16" align="left">Jurusan : <?= $data_jurusan; ?></td></tr>
<tr><td colspan="16" align="left">&nbsp;</td></tr>
</table>
<table class="table" width="100%" border="1">
<tr>
	<th width="4%">No</th>
	<th width="10%">NPM</th>
	<th width="10%">Nama</th>
	<th width="10%">Angkatan</th>
    <th width="10%">Jurusan</th>
    <th width="10%">Kelas</th>
    <th width="10%">Tempat Lahir</th>
    <th width="10%">Tgl. Lahir</th>
    <th width="10%">Jenis Kelamin</th>
    <th width="10%">Agama</th>
    <th width="10%">No. HP1</th>
    <th width="10%">No. HP2</th>
    <th width="10%">Tgl. Mulai Kuliah</th>
    <th>Alamat</th>
    <th width="10%">Aktif</th>
    <th width="10%">Keterangan</th>
</tr>
<?php
//$sql = $this->db_array("sikad_mahasiswa",$field="",$where="1 $kondisi_cari ORDER BY id_jurusan,tahun_angkatan,npm");
$sql = $this->db_array("sikad_mahasiswa a, sikad_krs b",$field="a.*",$where="1 AND a.npm=b.npm $kondisi_cari ORDER BY a.id_jurusan,a.tahun_angkatan,a.npm");
$no=0;
foreach($sql as $raw):
$no++;
$arr_kelas = $this->data_array("tbl_kelas","id_kelas='".$raw->id_kelas."'");
$arr_jurusan = $this->data_array("sikad_jurusan","id_jurusan='".$raw->id_jurusan."'");
if($raw->flag_aktif==0){$aktif='Tidak';} else {$aktif='Ya';}
?>
<tr>
	<td><?php echo $no; ?></td>
	<td><?php echo $raw->npm; ?></td>
	<td><?php echo $raw->nama; ?></td>
	<td><?php echo $raw->tahun_angkatan; ?></td>
	<td><?php echo $arr_jurusan->jurusan." (".$arr_jurusan->jenjang.")"; ?></td>
	<td><?php echo $arr_kelas->kelas; ?></td>
	<td><?php echo $raw->tempat_lahir; ?></td>
	<td><?php echo $raw->tgl_lahir; ?></td>
	<td><?php echo $raw->jenis_kelamin; ?></td>
	<td><?php echo $raw->agama; ?></td>
	<td><?php echo $raw->no_hp1; ?></td>
	<td><?php echo $raw->no_hp2; ?></td>
	<td><?php echo $raw->tgl_mulai_kuliah; ?></td>
	<td><?php echo $raw->alamat; ?></td>
	<td><?php echo $aktif; ?></td>
	<td><?php echo $raw->keterangan; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php
}
?>