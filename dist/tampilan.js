//TAMPILAN UNTUK INPUT TIPE FILE(UPLOAD)
$(document).ready(function(){
    $('input[type=file]').bootstrapFileInput();
});

//MENAMPILKAN DATAPICKER
$(function(){
    //datepicker pada pegawai
    $("#tgllahir").datepicker({
        language:  'id',
        todayHighlight: 1,
        format:'dd/mm/yyyy'
    });

    $("#tglakhir").datepicker({
        autoclose: 1,
        startDate: '',
        todayHighlight: 1,
        format:'dd/mm/yyyy'
    });
    //datepicker pada member
    $("#tgllaporan").datepicker({
        autoclose: 1,
        format: "MM yyyy",
        //startDate: '-1m',
        viewMode: "months", 
        minViewMode: "months"
    });
//iki nyobo
    $("#tgljadwal").datepicker({
        //autoclose: 1,
        format: "MM yyyy",
        //startDate: '-1m',
        viewMode: "months", 
        minViewMode: "months"
    });

    //datepicker pada pemasukan
    $("#tglpemasukan").datepicker({
        language:  'id',
        autoclose: 1,
        //startDate: '-2d',
        todayHighlight: 1,
        format:'dd/mm/yyyy'
    });


});


//TAMPILAN TABEL
$(document).ready(function() {
    //pada halaman trxmember
    $('#trxmember').dataTable( {
        "paging":   true,
        "ordering": false,
        "info":     true,
        "aLengthMenu": [[7, 30, 50, -1], [7, 30, 50, "All"]]
    } );

    //pada halaman member
    $('#member').dataTable( {
        "paging"   : true,
        "pagingType": "simple",
        "ordering" : false,
        "info"     : true,
        "scrollX": false
    } );

    $('#freecut').dataTable( {
        "paging"   : true,
        "pagingType": "simple",
        "ordering" : false,
        "info"     : true,
        "scrollX": false
    } );
} );


$(function(){
   $('#membertrx').chosen(
    {allow_single_deselect: true,
        no_results_text: "Tidak ditemukan....!",}
   );

   $('#servicesatu').chosen(
    {allow_single_deselect: true,
        no_results_text: "Tidak ditemukan....!",}
   );
    $('#servicedua').chosen(
    {allow_single_deselect: true,
        no_results_text: "Tidak ditemukan....!",}
   );
    $('#servicetiga').chosen(
    {allow_single_deselect: true,
        no_results_text: "Tidak ditemukan....!",}
   );
    $('#serviceempat').chosen(
    {allow_single_deselect: true,
        no_results_text: "Tidak ditemukan....!",}
   );
});

