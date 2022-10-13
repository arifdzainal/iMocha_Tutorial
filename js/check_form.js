// JavaScript Check Form
// Author Harun Bin Yaacob
// 014-6100601
function formkumppengguna()
{
	var ok = true;

	//test nama
	if ( $.trim($("#kodkumpulan").val()) == '')
	{
		alert("Sila masukkan kod kumpulan pengguna.");
		ok = false;
		return;
	}
	
	if(ok)
		document.tambah_kumppengguna.submit();
		
}