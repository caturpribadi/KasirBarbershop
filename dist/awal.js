    <!-- Rule input tanggal -->
    <script>
    $(function(){
        $("#tglmember").datepicker({
            language:  'id',
            autoclose: 1,
            todayHighlight: 1,
            startDate: '-2d',
            format:'dd/mm/yyyy'
        });
            });
    </script>
    
    <script>
    $(function(){
        $("#tglpegawai").datepicker({
            language:  'id',
            todayHighlight: 1,
            format:'dd/mm/yyyy'
        });
            });
    </script>

    <script>
        $(document).ready(function() {
            $('#trxmember').dataTable( {
                "paging":   true,
                "ordering": false,
                "info":     true,
                "aLengthMenu": [[7, 30, 50, -1], [7, 30, 50, "All"]]
            } );
        } );
    </script>

        <script>
        $(document).ready(function() {
            $('#member').dataTable( {
                "paging"   : true,
                "pagingType": "simple",
                "ordering" : false,
                "info"     : true,
                "scrollX": false
            } );
        } );
    </script>


      <script type="text/javascript">
   $('#membertrx').chosen(
     {no_results_text: "Tidak ditemukan....!"}
   );
  </script>


  <script>
 $(function()
  {
   $(document).on('click', '.btn-add', function(e)
   {
    e.preventDefault();

    var controlForm = $('.controls:first'),
     currentEntry = $(this).parents('.entry:first'),
     newEntry = $(currentEntry.clone()).appendTo(controlForm);

    newEntry.find('input').val('');
    controlForm.find('.entry:not(:last) .btn-add')
     .removeClass('btn-add').addClass('btn-remove')
     .removeClass('btn-success').addClass('btn-danger')
     .html('<span class="glyphicon glyphicon-minus"></span>');
   }).on('click', '.btn-remove', function(e)
   {
    $(this).parents('.entry:first').remove();

    e.preventDefault();
    return false;
   });
  }
 );
</script>